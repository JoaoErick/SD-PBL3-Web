<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*
    * Função que retorna a página principal.
    */
    public function index()
    {
        return view('home');
    }
}
