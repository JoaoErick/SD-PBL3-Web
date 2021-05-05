<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connection;

class HomeController extends Controller
{
    /*
    * Função que retorna a página principal.
    */
    public function index()
    {
        $connection = Connection::get()->first();
        return view('home', ['status' => $connection->status]);
    }
}
