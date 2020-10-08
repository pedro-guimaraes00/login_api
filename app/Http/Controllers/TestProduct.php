<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestProduct extends Controller
{

    public function __construct() {
        $this->middleware("auth:api");
    }

    public function index() {

        //Array simulando para testar API

        return response()->json(
            [
                "id"=> 1,
                "name"=>"Geladeira"
            ],
            [
                "id" => 2,
                "name"=>"microondas"
            ],
            [
                "id" => 3,
                "name" => "sofá"
            ],
            [
                "id" => 4,
                "name" => "notebook"
            ]);
    }
}
