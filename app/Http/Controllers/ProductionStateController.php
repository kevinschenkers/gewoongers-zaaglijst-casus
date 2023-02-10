<?php

namespace App\Http\Controllers;

class ProductionStateController extends Controller
{
    public function index(): string
    {
        return file_get_contents(storage_path() . "/data/ProductieStaat.json");
    }
}
