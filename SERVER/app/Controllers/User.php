<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class User extends BaseController {

    public function index() {
        
    }

    // return int;
    public function AjaxGetLevel() {
        $SM = new SimpleModel();
        $User = $SM->Find("user", 1);
        echo $User->Level;
    }

}
