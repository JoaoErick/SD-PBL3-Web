<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historic;

class HistoricController extends Controller
{
    /**
     * Função responsável por retorna a página de histórico.
     */
    public function index(){
        $currentDate = \Carbon\Carbon::now("America/Sao_Paulo")->format('Y-m-d');
        $arrayHistoric = [];
        $historicsAll = Historic::get();

        $currentTimeInSeconds = $this->convertToSeconds(\Carbon\Carbon::now("America/Sao_Paulo")->format('H:i:s'));

        /* Caso o evento esteja dentro do limite de 24 horas, ele será mostrado na tabela de histórico. */
        foreach($historicsAll as $historic){
            if(date_diff(date_create(\Carbon\Carbon::parse($historic->created_at)->format('Y-m-d')), date_create($currentDate))->days == 1){
                $historicTimeInSeconds = $this->convertToSeconds(\Carbon\Carbon::parse($historic->created_at)->format('H:i:s'));
                if($currentTimeInSeconds - $historicTimeInSeconds <= 0){
                    array_push($arrayHistoric, $historic);
                }
            } else if(date_diff(date_create(\Carbon\Carbon::parse($historic->created_at)->format('Y-m-d')), date_create($currentDate))->days == 0){
                array_push($arrayHistoric, $historic);
            }
        }
        return view('historic.index', ['historics' => $arrayHistoric]);
    }

    /**
     * Função para retornar o horário que foi passado em segundos.
     * @param string       $schedule
     */
    private static function convertToSeconds($schedule)
    {
        $str_time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $schedule);

        sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);

        return ($hours * 3600 + $minutes * 60 + $seconds);
    }
}
