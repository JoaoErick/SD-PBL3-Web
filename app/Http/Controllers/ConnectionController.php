<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\Interval;

class ConnectionController extends Controller
{
    public function verifyConnection(){
        $connection = Connection::get()->first();
        $interval = Interval::get()->first();

        $current = strtotime(\Carbon\Carbon::now("America/Sao_Paulo"));

        $temp = explode(':', $interval->time);
        $updated = \Carbon\Carbon::parse($interval->updated_at)->addSeconds((int) $temp[2]);
        $updated = $updated->addMinutes((int) $temp[1]);
        $updated = $updated->addHours((int) $temp[0]);
        $updated = $updated->format('H:i:s');
        
        $updated = strtotime($updated);
        $diff = ($updated - $current);
        if($diff < 0){
            $connection->status = false;
        } else{
            $connection->status = true;
        }
        $connection->save();

        return view('home', ['status' => $connection->status]);
    }
}
