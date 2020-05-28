<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Home extends BaseController {

    public function index() {
        echo view("Header");
        echo view("Body");
        $this->JavascriptVar();
    }

    public function Start() {
        echo view('Home');
    }

    public function test() {
        Debug(IsMobile(), IsTablet());
    }

//    GLOBAL VAR JAVASCRIPT
    private function JavascriptVar() {
        echo view("JavascriptVar", array(
            "ArrayVar" => array(
                "IsPhone" => IsPhone(),
            ),
        ));
    }

}
