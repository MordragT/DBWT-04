<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ZutatenModel;

class ZutatenController extends Controller
{
    protected $model;
    function __construct()
    {
        $this->model = new ZutatenModel();
    }

    public function createView()
    {
        return view('Zutaten.Zutaten', ['zutaten' => $this->model->getZutaten()]);
    }
}
