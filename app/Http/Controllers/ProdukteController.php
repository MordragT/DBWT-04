<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\ProdukteModel;
use stdClass;

class ProdukteController extends Controller
{
    protected $model;
    function __construct()
    {
        $this->model = new ProdukteModel();
    }

    public function createView()
    {
        $kat = isset($_GET['kat']) ? $_GET['kat'] : 3;
        $avail = isset($_GET['avail']) ? $_GET['avail'] : null;
        $vegetarisch = isset($_GET['vegetarisch']) ? $_GET['vegetarisch'] : false;
        $vegan = isset($_GET['vegan']) ? $_GET['vegan'] : false;

        $produkte = $this->model->getProdukte($vegan, $vegetarisch);
        $optGroups = $this->model->getOptGroups();
        $options = $this->model->getOptions();

        $limitCount = 0;
        $katname = '';

        $limit = isset($_GET['limit']) ? $_GET['limit'] : sizeof($produkte);



        foreach ($optGroups as $optGroup) {
            $iterator = 0;
            $optGroup->options = new stdClass();
            foreach ($options as $option) {
                if ($optGroup->ID == $option->Kategorien_ID) {
                    $optGroup->options->$iterator = $option;
                    ++$iterator;
                }
            }
        }
        return view("Produkte.Produkte", [
            'produkte' => $produkte,
            'limit' => $limit,
            'limitCount' => $limitCount,
            'optGroups' => $optGroups,
            'kat' => $kat,
            'katname' => $katname,
            'avail' => $avail,
            'vegetarisch' => $vegetarisch,
            'vegan' => $vegan,
        ]);
    }
}
