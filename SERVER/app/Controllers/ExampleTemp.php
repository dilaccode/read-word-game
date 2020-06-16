<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class ExampleTemp extends BaseController {

    public function index() {
        ServerHiYou();
    }

    public function Test() {
        $SM = new SimpleModel();
        $List = $SM->Query("Select * from wordTemp"
                        . " where id > 10000 AND IsWork = 0"
                        . " limit 500")
                ->getResult();
        $Count = 0;
        foreach ($List as $Word) {
            $ListExample = explode("\n", $Word->Mean);
            $MeanNoExample = $ListExample[0];
            $Word->Mean = trim($MeanNoExample);
            $Word->IsWork = 1;
            $Result = $SM->Update("wordtemp", $Word);
            for ($Index = 1; $Index < count($ListExample); $Index++) {
                $Example = trim($ListExample[$Index]);
                $SM->Add("example", array(
                    'Example' => $Example,
                    'Length' => strlen($Example),
                ));
                $Count++;
                //
                echo $Count . " | " . strlen($Example) . " | " . $Example . PHP_EOL;
            }
        }
        $Total = $SM->Query("Select count(*) as Total from wordtemp where IsWork=0")
                        ->getRow(0)->Total;
        echo "Done $Count examples" . PHP_EOL;
        echo "Remain $Total / 5136 words";
    }

}
