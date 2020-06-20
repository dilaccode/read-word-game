<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Admin extends BaseController {

    public function index() {
        $SM = new SimpleModel();

        $TotalWords = $SM->Query("select count(*) as Total from Word")
                        ->getRow(1)->Total;
        $ListWordsLengthCount = $SM->Query("select WordLength,count(WordLength) as Count from Word
		group by WordLength")->getResult();
        $StatsData = array(
            'TotalWords' => number_format($TotalWords),
            'ListWordsLengthCount' => $ListWordsLengthCount,
        );

        echo view("Css");
        echo view("Admin/Home");
        echo view("Admin/Stats", $StatsData);
    }

    public function UpdateExamplesLength() {
        $SM = new SimpleModel();

        $Result = $SM->Query("update example set Length=length(Example)");
        $Message = $Result->AmountRows === 0 ? "No Word" : "Update Success $Result->AmountRows Word";
        $Data = array(
            'Title' => "Update Examples Length",
            'Message' => $Message,
            'NextActionText' => "<i class=\"fa fa-arrow-left\"></i> Back To Admin",
            'NextActionLink' => "/Admin",
        );

        echo view("Css");
        echo view("Message", $Data);
    }

    public function UpdateWordsLength() {
        $SM = new SimpleModel();

        $Result = $SM->Query("update Word set WordLength=length(Word)");
        $Message = $Result->AmountRows === 0 ? "No Word" : "Update Success $Result->AmountRows Word";
        $Data = array(
            'Title' => "Update Words Length",
            'Message' => $Message,
            'NextActionText' => "<i class=\"fa fa-arrow-left\"></i> Back To Admin",
            'NextActionLink' => "/Admin",
        );

        echo view("Css");
        echo view("Message", $Data);
    }

    public function ResetData() {
        $SM = new SimpleModel();

        $Result = $SM->Query("update user set TotalExp=0, Level=0 where Id=1");
        $ResultUser = $Result->AmountRows === 0 ? "No User" : "Update Success $Result->AmountRows Users";

        $Result = $SM->Query("update word set LearnTime=0, View=0");
        $ResultWord = $Result->AmountRows === 0 ? "No Word" : "Update Success $Result->AmountRows Words";

        $Message = $ResultUser . "<br>" . $ResultWord;
        $Data = array(
            'Title' => "Reset Data",
            'Message' => $Message,
            'NextActionText' => "<i class=\"fa fa-arrow-left\"></i> Back To Admin",
            'NextActionLink' => "/Admin",
        );

        echo view("Css");
        echo view("Message", $Data);
    }

    public function Test() {
        $ret = shell_exec("ls /var/www/html 2>&1");
        var_dump($ret);
    }

}
