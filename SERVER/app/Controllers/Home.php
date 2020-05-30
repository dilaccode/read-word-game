<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Home extends BaseController {

    public function index() {
        ServerHiYou();
        echo view("DevelopmentAlert");
    }
}
