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
        $timestamp = \Carbon\Carbon::now("America/Sao_Paulo")->format('Y-m-d');
        $historics = Historic::where("created_at", "like", "%".$timestamp."%")->orderBy('id', 'desc')->get();

        return view('historic.index', compact('historics'));
    }
}
