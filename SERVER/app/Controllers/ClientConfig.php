<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class ClientConfig extends BaseController {

    public function index() {
        ServerHiYou();
    }

    public function IsPhone() {
        echo json_encode((object) array(
                    'IsPhone' => IsPhone(),
        ));
    }

}
