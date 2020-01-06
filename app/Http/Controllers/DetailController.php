<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DetailModel;

class DetailController extends Controller
{
    protected $model;
    protected $auth;
    function __construct()
    {
        $this->model = new DetailModel();
        $this->auth = new AuthController();
    }

    public function createView()
    {
        $this->auth->authenticate();
        $id = isset($_GET['id']) ? $_GET['id'] : 404;
        $produkt = $this->model->getById($id);
        if (empty($produkt)) {
            $id = 404;
        }
        return view("Detail.Detail", ['produkt' => $produkt, 'id' => $id, 'zutaten' => $this->model->getZutatenById($id)]);
    }
}
