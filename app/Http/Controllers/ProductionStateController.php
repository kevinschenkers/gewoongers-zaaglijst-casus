<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionStateController extends Controller
{
    public function index()
    {
        $productionStates = json_decode(file_get_contents(storage_path() . "/data/ProductieStaat.json"));

        echo "<pre>";
        print_r($productionStates);
    }
}
