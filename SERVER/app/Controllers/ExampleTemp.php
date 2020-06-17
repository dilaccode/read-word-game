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
    }

    // copy all page , i will process it to example (sentence)
    public function InputExample() {
        echo view("Css");
        echo "<style> body{margin: 25px;}</style>";
        $SM = new SimpleModel();


        echo '<form action="" method="post">
  Add data here:
  <br>
  <textarea name="data" style="margin: 0px; width: 553px; height: 117px;"></textarea>
  <br>
  <input type="submit" value="Submit">
</form>';

        //
        if (isset($_POST['data'])) {
            $Data = $_POST['data'];
            $ListData = explode("\n", $Data);
            $ListData1 = array();
            foreach ($ListData as $Line) {
                $ListLine = explode(".", $Line);
                if (count($ListLine) >= 1) {
                    foreach ($ListLine as $Line1) {
                        $Line1Process = trim($Line1);
                        // replace strange chars/ to standard
                        $Line1Process = str_replace('‘', '\'', $Line1Process);
                        $Line1Process = str_replace('’', '\'', $Line1Process);
                        $Line1Process = str_replace('"', '\'', $Line1Process);
                        $Line1Process = str_replace('“', '\'', $Line1Process);
                        $Line1Process = str_replace('”', '\'', $Line1Process);
                        // replace short for
                        $Line1Process = str_replace("'m", ' am', $Line1Process);
                        $Line1Process = str_replace("'s", ' is', $Line1Process);
                        $Line1Process = str_replace("can't", 'can not', $Line1Process);
                        $Line1Process = str_replace("n't", ' not', $Line1Process);
                        $Line1Process = str_replace("'ve", ' have', $Line1Process);
                        $Line1Process = str_replace("'re", ' are', $Line1Process);
                        $Line1Process = str_replace("'ll", ' will', $Line1Process);
                        // remove ( begin
                        if ($Line1Process[0] === "(" && substr_count($Line1Process, "(") === 1) {
                            $Line1Process[0] = " ";
                            $Line1Process = trim($Line1Process);
                        }
                        // remove quote begin-end
                        if ($Line1Process[0] === "'" && $Line1Process[strlen($Line1Process) - 1] === "'") {
                            $Line1Process[0] = " ";
                            $Line1Process[strlen($Line1Process) - 1] = " ";
                            $Line1Process = trim($Line1Process);
                        }
                        // remove 1 quote begin (error)
                        if ($Line1Process[0] === "'" && substr_count($Line1Process, "'") === 1) {
                            $Line1Process[0] = " ";
                            $Line1Process = trim($Line1Process);
                        }
                        // remove 1 quote end (error)
                        if ($Line1Process[strlen($Line1Process) - 1] === "'" && substr_count($Line1Process, "'") === 1) {
                            $Line1Process[strlen($Line1Process) - 1] = " ";
                            $Line1Process = trim($Line1Process);
                        }
                        // remove 3, 5 quote (error 1 quote)
                        if (substr_count($Line1Process, "'") === 3 || substr_count($Line1Process, "'") === 5) {
                            $Line1Process = "";
                        }
                        // remove < 2 words line
                        if (substr_count($Line1Process, " ") <= 1) {
                            $Line1Process = "";
                        }
                        // add dot
                        if ($Line1Process[strlen($Line1Process) - 1] !== "." && $Line1Process[strlen($Line1Process) - 1] !== "!" && $Line1Process[strlen($Line1Process) - 1] !== "?") {
                            $Line1Process .= ".";
                        }
                        // remove length >100
                        if (strlen($Line1Process) > 10 && strlen($Line1Process) < 100) {
                            array_push($ListData1, $Line1Process);
                        }
                    }
                }
            }
            // unique
            $ListData1 = array_unique($ListData1);
            // insert table
            $SQL = "insert into example1(Example) values ";
            for ($Index = 0; $Index < count($ListData1); $Index++) {
                $Example = $ListData1[$Index];
                if (strlen($Example) > 0) {
                    echo $Index . " " . $Example . "<br>";
                    $Example = str_replace("'", "\'", $Example);
                    if ($Index < count($ListData1) - 1) {
                        $SQL .= "('$Example'),";
                    } else {
                        $SQL .= "('$Example');";
                    }
                }
            }
            //
            $Result = $SM->Query($SQL);
            echo "<br><br>insert success " . $Result->AmountRows;
        }
    }

}
