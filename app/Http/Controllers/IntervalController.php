<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interval;
use PhpMqtt\Client\Facades\MQTT;

class IntervalController extends Controller
{
    public function index(){
        $interval = Interval::get()->first();
        return view('interval.index', ['interval' => $this->formatInterval($interval->time)]);
    }

    public function setInterval(Request $request){
        $interval = Interval::get()->first();

        $intervalPublish = $this->formatIntervalToPublish($request->time);

        $this->publish('intervalOutTopic', $intervalPublish);

        $status = $this->validateSetInterval();

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

    public function sync()
    {
        $interval = Interval::get()->first();
        $interval = $this->formatIntervalToPublish($interval->time);

        $this->publish('syncOutTopic', $interval);

        return redirect()->back()->with('success','Intervalo sincronizado com sucesso!');
    }

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
    private function validateSetInterval()
    {
        $mqtt = MQTT::connection();

        $mqtt->subscribe('intervalInTopic', function (string $topic, string $message, bool $retained) use ($mqtt) {
            $this->message = $message;
            
            $mqtt->interrupt();
        }, 0);

        $mqtt->loop(true);
        $mqtt->disconnect();

        return $this->message;
    }
}
