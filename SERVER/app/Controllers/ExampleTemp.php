<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class ExampleTemp extends BaseController {

    public function index() {
        ServerHiYou();
    }

    public function Test() {
        echo view("Css");
        echo "<style> body{margin: 50px;}</style>";
        $SM = new SimpleModel();

        
    }

}
