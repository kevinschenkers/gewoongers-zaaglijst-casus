<?php

namespace App\Http\Controllers;

class ProductionStateController extends Controller
{
    protected string $productiestaat;

    public function __construct()
    {
        $this->productiestaat = file_get_contents(storage_path() . "/data/ProductieStaat.json");
    }

    public function index(): string
    {

        $givenData = collect(json_decode($this->productiestaat));
        $data = $givenData->pluck('saw');
        return $data;

        return $this->productiestaat;
    }

    public function solution()
    {
        $givenData = collect(json_decode($this->productiestaat));

        $data = $givenData->pluck('saw');

        $solution = [];

        foreach ($data as $ps) {

            foreach ($ps as $key => $value) {

                if (!isset($ps->profielkleur)) {
                    continue;
                }

                if ($key === "profielkleur") {
                    continue;
                }

                $profielkleur = $ps->profielkleur->title;

                if (!isset($solution[$profielkleur])) {
                    $solution[$profielkleur] = [];
                }

                preg_match_all("/g\d+/", $key, $matches);
                $codes = $matches[0];

                foreach ($codes as $code) {

                    if (!isset($solution[$profielkleur][$code])) {
                        $solution[$profielkleur][$code] = [];
                    }

                    $solution[$profielkleur][$code][] = [
                        "t_length" => $value->value,
                        "t_count" => $value->amount
                    ];

                }

            }

        }


        $new_solution = [];
        foreach ($solution as $key => $value) {

            if (!isset($new_solution[$key])) {
                $new_solution[$key] = [];
            }

            foreach ($value as $item => $data) {

                if (!isset($new_solution[$key][$item])) {
                    $new_solution[$key][$item] = [];
                }

                $result = array_reduce($data, function ($solved, $length) {

                    if (!isset($solved[$length['t_length']])) {
                        $solved[$length['t_length']] = 0;
                    }

                    $solved[$length['t_length']] += $length['t_count'];

                    return $solved;
                }, []);

                foreach ($result as $length => $amount) {
                    $new_solution[$key][$item][] = [
                        'length' => $length,
                        'amount' => $amount
                    ];

                }

            }

        }

        return $new_solution;
    }

}
