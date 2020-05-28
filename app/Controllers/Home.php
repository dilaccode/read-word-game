<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Home extends BaseController {

    public function index() {
        echo view("Header");
        echo view("Body");
    }

    public function Start() {
        echo view('Home');
    }

    public function test() {
        Debug(IsMobile(), IsTablet());
    }

}
