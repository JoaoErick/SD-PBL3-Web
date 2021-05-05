<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Interval;

class IntervalController extends Controller
{
    public function index(){
        $interval = Interval::get()->first();
        return view('interval.index', ['interval' => $this->formatInterval($interval->time)]);
    }

    public function setInterval(Request $request){
        $interval = Interval::get()->first();

        $interval->time = $request->time;
        $interval->updated_at = \Carbon\Carbon::now("America/Sao_Paulo");
        $interval->created_at = \Carbon\Carbon::now("America/Sao_Paulo");
        $interval->save();

        return redirect()->back()->with('success','Intervalo alterado com sucesso!');
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
}
