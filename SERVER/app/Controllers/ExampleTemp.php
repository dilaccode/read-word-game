<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class ExampleTemp extends BaseController {

    public function index() {
        ServerHiYou();
    }

    public function Test() {
        $SM = new SimpleModel();
        $List = $SM->Query("Select * from example"
                        . " WHERE IsWork=0"
                        . " limit 500")
                ->getResult();
        $Count = 0;
        foreach ($List as $Example) {
            $Total = $SM->Query("Select count(*) as Total from wordexample"
                                    . " where ExampleId = $Example->Id")
                            ->getRow(0)->Total;
            $Example->CountUse = $Total;
            $Example->IsWork = 1;
            $Count += (int) $SM->Update('example', $Example);
        }

        // 
        echo $Count . PHP_EOL;

//        Debug($SM->Query("Select count(*) as Total from wordtemp where IsWork=1")->getRow(0)->Total);
    //
    }

}
