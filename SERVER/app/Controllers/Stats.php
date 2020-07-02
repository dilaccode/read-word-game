<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Stats extends BaseController {

    public function index() {
//        ServerHiYou();
        $SM = new SimpleModel();
        $ListWords = $SM->Query("Select Word, LearnTime from word order by LearnTime desc")->getResult();
        $AmountRead = $SM->Query("SELECT count(*) as AmountRead FROM `word` WHERE LearnTime>0")->getRow(0)->AmountRead;
        $Data = array(
            "ListWords" => $ListWords,
            "AmountRead" => $AmountRead,
        );
        echo view("Stats/Header");
        echo view("Stats/Word", $Data);
    }

    // return int;
    public function Read() {
        $SM = new SimpleModel();
        $User = $SM->Find("user", 1);
        echo $User->Level;
    }

}
