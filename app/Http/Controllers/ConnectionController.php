<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\Interval;

class ConnectionController extends Controller
{
    /**
     * Função responsável por verificar a se a placa está conectada e 
     * exibir essa informação no banco de dados.
     */
    public function verifyConnection(){
        $connection = Connection::get()->first();
        $interval = Interval::get()->first();

        $now = \Carbon\Carbon::now("America/Sao_Paulo");

        $current = strtotime($now);
        
        $updated = $this->updatedTime($interval->time, $connection->updated_at);
        
        $diff = ($updated - $current);

        if($diff < 0){
            $connection->status = false;
            $connection->updated_at = $now;
            $connection->created_at = $now;
        }

        $connection->save();

        $interval = Interval::halfInterval($interval->time);
        $interval = Interval::convertToMilis($interval);

        return view('home', [
            'status' => $connection->status,
            'interval' => $interval
        ]);
    }

    /**
     * Função para calcular a última faixa de tempo que o dispositivo 
     * estaria conectado.
     * @param string      $intervalTime
     * @param string      $updatedAt
     */
    private function updatedTime($intervalTime, $updatedAt)
    {
        $temp = explode(':', $intervalTime);
        $updated = \Carbon\Carbon::parse($updatedAt)->addSeconds((int) $temp[2]);
        $updated = $updated->addMinutes((int) $temp[1]);
        $updated = $updated->addHours((int) $temp[0]);
        $updated = $updated->format('H:i:s');

        return strtotime($updated);
    }
}
