<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        /*
        $serverName = "hamakaze";
        $connectionOptions = array(
            "Database" => "HANE2",
            "Uid" => "sa",
            "PWD" => "Ramones1974"
        );

        $conn = \sqlsrv_connect($serverName, $connectionOptions);
        if($conn){
            echo "Connected!";
        }
        */
        return view('welcome');
    }
}
