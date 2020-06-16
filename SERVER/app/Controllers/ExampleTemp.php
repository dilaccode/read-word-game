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

        // get word no example
        $WordObj = $SM->Query("SELECT * FROM `wordtemp` WHERE Id not in (select WordId from wordexample) limit 1")->getRow(0);
        echo "<b>$WordObj->Word</b> >>> ";
        // open link cambridge
        echo "<a class='w3-btn w3-blue' target='_blank' href='https://dictionary.cambridge.org/vi/dictionary/english/$WordObj->Word'>$WordObj->Word</a>";
        echo "<br>";
        // input area
        echo "Add examples here (1 line 1 example):<br>";
        echo "<form>";
        echo "<textarea name=\"Examples\" rows=\"4\" cols=\"50\"></textarea>";
        echo "<br>";
        echo "<input type=\"submit\" value=\"Submit\">";
        echo "</form>";
        // submit and check
        if (isset($_GET['Examples'])) {
            $ListExamples = explode("\n", $_GET['Examples']);
            if (Count($ListExamples) > 0) {
                foreach ($ListExamples as $Example) {
                    $ExampleId = $SM->Add("example", array(
                        'Example' => $Example,
                        'Length' => strlen($Example),
                    ));
                    $SM->Add("wordexample", array(
                        'WordId' => $WordObj->Id,
                        'ExampleId' => $ExampleId,
                    ));
                }
                // validate
                $ListValidate = $SM->Query("select * from example where"
                                . " Id in (select ExampleId from wordexample where WordId = $WordObj->Id)")->getResult();
                echo "<br>";
                foreach ($ListValidate as $Item) {
                    echo $Item->Example . "<br>";
                }
            }
        }
        // refresh next word
        echo "<br>";
        echo "<a class='w3-btn w3-blue' href='/ExampleTemp/Test'>Next</a>";
    }

}
