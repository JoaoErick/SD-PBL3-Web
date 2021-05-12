<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connection;
use App\Models\Interval;

class HomeController extends Controller
{
    /**
     * Função responsável por retorna a página principal.
     */
    public function index()
    {
        $connection = Connection::get()->first();
        
        $interval = Interval::get()->first();
        $interval = Interval::halfInterval($interval->time);
        $interval = Interval::convertToMilis($interval);

        return view('home', [
            'status' => $connection->status,
            'interval' => $interval
        ]);
    }
}
