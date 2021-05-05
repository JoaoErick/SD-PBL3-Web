<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Connection;

class ConnectionController extends Controller
{
    public function verifyConnection(){
        $connection = Connection::get()->first();
        return view('home', ['status' => $connection->status]);
    }
}
