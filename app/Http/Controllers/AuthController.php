<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AuthModel;

    class AuthController extends Controller
    {
        protected $model;
        function __construct()
        {
            $this->model = new AuthModel();
        }

        public function authenticate()
        {
            session_start();
            $user = isset($_POST['user']) ? $_POST['user'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;

            if (!isset($_SESSION['loginstatus'])) {
                $_SESSION['loginstatus'] = 'abgemeldet';
                unset($_SESSION['typ']);
            }

            if ($user and $password) {
                $userDB = $this->model->getBenutzerByName($user);
                if (!empty($userDB) and password_verify($password, $userDB->Hash)) {
                    $_SESSION['loginstatus'] = 'angemeldet';
                    $_SESSION['typ'] = $this->model->getTyp($user);
                } else {
                    $_SESSION['loginstatus'] = 'loginfehler';
                }
            } else if (isset($_POST['logout']) and $_POST['logout'] == true) {
                $_SESSION['loginstatus'] = 'abgemeldet';
                $_POST['logout'] = false;
                unset($_SESSION['typ']);
            } else if ($_SESSION['loginstatus'] != 'angemeldet') {
                $_SESSION['loginstatus'] = 'abgemeldet';
            }

            if ($_SESSION['loginstatus'] == 'angemeldet') {
                $this->model->setLetzterLogin($_SESSION['user']);
                $typ = $this->model->getTyp($_SESSION['user']);
                if (!empty($typ)) $_SESSION['typ'] = $typ;
            }
        }

        public function login() {
            return true;
        }

        public function showLoginForm()
        {
            /*
            $this->authenticate();
            
            if($_SESSION['loginstatus'] == 'angemeldet') return view("Login.LoginAngemeldet", []);
            elseif($_SESSION['loginstatus'] == 'loginfehler') return view("Login.LoginFehler", []);
            else return view("Login.LoginAbgemeldet", []);
            */
            return view('Login.Login',[]);
        }
    }
