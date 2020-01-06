<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
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

        $produkte = $this->model->getProdukte();
        $optGroups = $this->model->getOptGroups();
        $options = $this->model->getOptions();

        $limitCount = 0;
        $katname = '';

        $limit = isset($_GET['limit']) ? $_GET['limit'] : sizeof($produkte);
        $kat = isset($_GET['kat']) ? $_GET['kat'] : 3;
        $avail = isset($_GET['avail']) ? $_GET['avail'] : 0;
        $vegetarisch = isset($_GET['vegetarisch']) ? $_GET['vegetarisch'] : 0;
        $vegan = isset($_GET['vegan']) ? $_GET['vegan'] : 0;


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
            'avail' => $avail,
            'limitCount' => $limitCount,
            'optGroups' => $optGroups,
            'kat' => $kat,
            'katname' => $katname,
            'vegetarisch' => $vegetarisch,
            'vegan' => $vegan,
        ]);
    }
}
