<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historic;

class HistoricController extends Controller
{
    /*
    * Função que retorna a página de histórico.
    */
    public function index(){
        $historics = Historic::orderBy('id', 'desc')->get();
        return view('historic.index', compact('historics'));
    }

    /**
     * Função para atualização o histórico.
     */
    public function refresh()
    {
        $historics = Historic::orderBy('id', 'desc')->get();
        return view('historic.index', compact('historics'));
    }
}
