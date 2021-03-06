<?php

namespace App\Http\Controllers;

use App\Models\Alarm;
use Illuminate\Http\Request;
use App\Models\Interval;
use PhpMqtt\Client\Facades\MQTT;

class IntervalController extends Controller
{
    /**
     * Função Responsável por retornar a página de ajustes com os dados
     * do banco de dados.
     */
    public function index(){
        $interval = Interval::get()->first();
        $alarm = Alarm::get()->first();

        return view('interval.index', [
            'interval' => $this->formatInterval($interval->time),
            'alarmMode' => $alarm->mode
        ]);
    }

    /**
     * Função responsável por alterar o intervalo para a verificação de
     * conexão.
     * @param Request      $request
     */
    public function setInterval(Request $request){
        $interval = Interval::get()->first();

        $intervalPublish = $this->formatIntervalToPublish($request->time);

        $this->publish('intervalOutTopic', $intervalPublish);

        $status = $this->validatePublish('intervalInTopic');

        if($status == "success"){
            $interval->time = $request->time;
            $interval->updated_at = \Carbon\Carbon::now("America/Sao_Paulo");
            $interval->created_at = \Carbon\Carbon::now("America/Sao_Paulo");
            $interval->save();

            return redirect()->back()->with('success','Intervalo alterado com sucesso!');
        } else {
            return redirect()->back()->with("error", "Falha ao executar a ação!");
        }
    }

    /**
     * Função responsável por alterar o modo do alarme.
     * @param Request      $request
     */
    public function alarmMode(Request $request)
    {
        $alarm = Alarm::get()->first();

        if($request->mode == null){ //Modo Acidente
            $alarm->mode = false;
            $alarmMode = 0;
            
        } else {//Modo Furto
            $alarm->mode = true;
            $alarmMode = 1;
        }

        $this->publish('alarmOutTopic', $alarmMode);

        $status = $this->validatePublish('alarmInTopic');

        if($status == "success"){
            $alarm->save();
        } 
        
        return redirect()->back();
    }

        /**
     * Função responsável por sincronizar o intervalo e o modo do alarme
     * que estão salvos no banco de dados com a placa.
     */
    public function sync()
    {
        $interval = Interval::get()->first();
        $alarm = Alarm::get()->first();

        $interval = $this->formatIntervalToPublish($interval->time);

        if($alarm->mode){ //Modo Acidente
            $alarmMode = 1;
            
        } else {//Modo Furto
            $alarmMode = 0;
        }

        $this->publish('syncIntervalOutTopic', $interval);
        $this->publish('syncAlarmOutTopic', $alarmMode);

        return redirect()->back()->with('success','Sincronização realizada com sucesso!');
    }

    /**
     * Função responsável por formatar o tempo que é exibido na página de
     * ajustes
     * @param string      $time
     * @return string
     */
    private function formatInterval($time){

        $temp = explode(':', $time);

        if($temp[0] == "00" && $temp[1] == "00") {
            $interval = $temp[2].' segundo(s)';
        } else if($temp[0] == "00" && $temp[2] == "00"){
            $interval = $temp[1].' minuto(s)';
        } else if($temp[1] == "00" && $temp[2] == "00") {
            $interval = $temp[0].' hora(s)';
        } else if($temp[0] == "00"){
            $interval = $temp[1].' minuto(s) e '.$temp[2].' segundo(s)';
        } else if($temp[1] == "00"){
            $interval = $temp[0].' hora(s) e '.$temp[2].' segundo(s)';
        } else if($temp[2] == "00"){
            $interval = $temp[0].' hora(s) e '.$temp[1].' minuto(s)';
        } else{
            $interval = $temp[0].' hora(s), '.$temp[1].' minuto(s) e '.$temp[2].' segundo(s)';
        }

        return $interval;
    }

    /**
     * Função responsável por formatar o intervalo que será publicado.
     * @param string      $interval
     * @return string
     */
    private function formatIntervalToPublish($interval)
    {
        $temp = explode(":", $interval);
            
        if (count($temp) == 3){
            $intervalFormated = $temp[0]."h".$temp[1]."m".$temp[2]."s";
        } else if (count($temp) == 2) {
            $intervalFormated = $temp[0]."h".$temp[1]."m"."00s";
        }

        return $intervalFormated;
    }

    /**
     * Função responsável por publicar o intervalo de verificação de conexão para o tópico.
     * @param string      $intervalPublish
     */
    private function publish($topic ,$intervalPublish)
    {
        $mqtt = MQTT::connection();
        $mqtt->publish($topic, '{"value": '.$intervalPublish.',}');
    }

    /**
     * Função responsável por validar se a ação foi realizada com sucesso.
     * @return string
     */
    private function validatePublish($topic)
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe($topic, function (string $topic, string $message, bool $retained) use ($mqtt) {
            $this->message = $message;
            
            $mqtt->interrupt();
        }, 0);

        $mqtt->loop(true);
        $mqtt->disconnect();

        return $this->message;
    }
}
