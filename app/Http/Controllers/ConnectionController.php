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

        $temp = explode(':', $interval->time);
        $updated = \Carbon\Carbon::parse($connection->updated_at)->addSeconds((int) $temp[2]);
        $updated = $updated->addMinutes((int) $temp[1]);
        $updated = $updated->addHours((int) $temp[0]);
        $updated = $updated->format('H:i:s');
        
        $updated = strtotime($updated);
        $diff = ($updated - $current);

        if($diff < 0){
            $connection->status = false;
            $connection->updated_at = $now;
            $connection->created_at = $now;
        }

        $connection->save();

        return view('home', ['status' => $connection->status]);
    }
}
