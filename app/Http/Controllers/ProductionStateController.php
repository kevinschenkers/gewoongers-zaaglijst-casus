<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductionStateController extends Controller
{
    public function index()
    {
        $productionStates = file_get_contents(storage_path() . "/data/ProductieStaat.json");

        print_r($productionStates);
    }
}
