<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Word extends BaseController {

    public function index() {
        ServerHiYou();
    }

    /// get random
    public function StartId() {
        echo json_encode(1);
    }

    // return JSON Word
    public function GetWord($WordId) {
        $SM = new SimpleModel();
        // Word
        $WordObj = $SM->Find("word", $WordId);
        // update view
        $WordObj->View++;
        $SM->Update("word", $WordObj);
        // get next word
        // temp for map (scenario)
        $MapObj = $SM->Query("Select * from map where WordId = $WordId")->getRow(0);
        $IsRandomFromMean = true;
        // case 1: run map
        $IsMap = isset($MapObj);
        if ($IsMap) {
            $MaxMapWordId = $SM->Query("Select * from map ORDER by Id DESC limit 1")->getRow(0)->WordId;
            if ((int) $WordId !== (int) $MaxMapWordId) {
                $NextMapObj = $SM->Query("Select * from map where Id > $MapObj->Id")->GetRow(0);
                $NextWordObj = $SM->Find("word", $NextMapObj->WordId);
                $IsRandomFromMean = false;
            }
        }
        // case 2: run from mean
        if ($IsRandomFromMean) {
            $NextWordObj = $this->GetNextWordFromMean($WordObj->Mean);
        }
        // case 3: no word from mean | no any word > random 1 word
        if (empty($NextWordObj)) {
            $NextWordObj = $SM->Query("select * from word order by RAND() limit 1")->GetRow(0);
        }

        $WordObj->NextWord = $NextWordObj->Word;
        $WordObj->NextWordId = $NextWordObj->Id;
        $WordObj->ListExamples = $this->GetListExampleStr($WordObj);


        echo json_encode($WordObj);
    }

    private function GetListExampleStr($WordObj) {
        $SM = new SimpleModel();
        $ListExamples = $SM->Query("select * from example where"
                        . " Id in (select ExampleId from wordexample where WordId = $WordObj->Id)")
                ->getResult();
        $ListExamplesStr = array();

        $LIMIT_LENGTH = 150;
        if (count($ListExamples) >= 1) {
            array_push($ListExamplesStr, $ListExamples[0]->Example);
            $CurrentLength = strlen($WordObj->Mean) + strlen($ListExamples[0]->Example);
            // limit length
            for ($Index = 1; $Index < count($ListExamples); $Index ++) {
                $ExampleLength = strlen($ListExamples[$Index]->Example);
                if ($CurrentLength + $ExampleLength < $LIMIT_LENGTH) {
                    array_push($ListExamplesStr, $ListExamples[$Index]->Example);
                    $CurrentLength += $ExampleLength;
                }
            }
        }
        return $ListExamplesStr;
    }

    // return JSON User
    public function GetUser($UserId, $WordId) {
        $SM = new SimpleModel();
        // Word
        $WordObj = $SM->Find("word", $WordId);
        // User
        $User = $SM->Find("user", $UserId);
        $Levels = GetGameLevels($User->Level + 1);
        $User->ThisLevelTotalExp = $Levels[$User->Level + 1]->Exp;
        $User->CurrentExp = $User->TotalExp - $Levels[$User->Level]->TotalExp;
        // 
        $ListExamples = $this->GetListExampleStr($WordObj);
        $NewExp = strlen($WordObj->Mean . implode("", $ListExamples));
        $User->NewExp = $User->CurrentExp + $NewExp;
        $User->CurrentPercent = round($User->CurrentExp / $User->ThisLevelTotalExp * 100, 1);
        $User->NewPercent = round($User->NewExp / $User->ThisLevelTotalExp * 100, 1);

        echo json_encode($User);
    }

    // return JSON User: store exp for next word
    public function ReadComplete($UserId, $WordId, $NextWordId) {
        $SM = new SimpleModel();
        //
        $WordObj = $SM->Find('word', $WordId);
        $User = $SM->Find('user', $UserId);

        $ListExamples = $this->GetListExampleStr($WordObj);
        $Exp = strlen($WordObj->Mean . implode("", $ListExamples));
        $User->TotalExp += $Exp;
        // check level up
        $ListLevels = GetGameLevels($User->Level + 2);
        $NewLevel = $User->Level;
        for ($Level = $User->Level; $Level <= $User->Level + 2; $Level++) {
            if ($User->TotalExp /* new */ >= $ListLevels[$Level]->TotalExp) {
                $NewLevel = $Level;
            }
        }
        $User->Level = $NewLevel;
        $SM->Update("user", $User);

        // update learn time
        $WordObj->LearnTime++;
        $SM->Update("word", $WordObj);

        // user data for next word (after update)
        echo $this->GetUser($UserId, $NextWordId);
    }

    /// ============================================
    /// return Next Word (obj) from Mean (str)
    private function GetNextWordFromMean($Mean) {
        $SM = new SimpleModel();
        $SearchArr = array("(", ")", ".", ",", ";", "  ", "\n", "\"", "'");
        $ReplaceArr = array(" ", " ", " ", " ", " ", " ", "", "", " ");
        // split
        $Mean = str_replace($SearchArr, $ReplaceArr, $Mean);
        $ArrayMeanWords = array_unique(explode(" ", $Mean));
        $ArrayMeanWordObjs = array();
        foreach ($ArrayMeanWords as $Word) {
            $Word = trim($Word);
            if (strlen($Word) > 0) {
                // check exist
                $Word = str_replace("'", "\'", $Word); // for SQL
                /// CONDITION FILTER
                // ...s
                $ConditionS = "";
                if ($Word[strlen($Word) - 1] === "s") {
                    $WordNoS = substr($Word, 0, strlen($Word) - 1);
                    $ConditionS = " OR Word='$WordNoS'";
                }
                // ...es
                $ConditionES = "";
                if (substr($Word, strlen($Word) - 2, 2) === "es") {
                    $WordNoES = substr($Word, 0, strlen($Word) - 2);
                    $ConditionES = " OR Word='$WordNoES'";
                }
                // ...ies > y
                $ConditionIES = "";
                if (substr($Word, strlen($Word) - 3, 3) === "ies") {
                    $WordNoIES = substr($Word, 0, strlen($Word) - 3);
                    $WordNoIES .= "y";
                    $ConditionIES = " OR Word='$WordNoIES'";
                }
                // ...ed > <none>, ed > e, ied > y
                $ConditionED = "";
                if (substr($Word, strlen($Word) - 2, 2) === "ed") {
                    $WordNoED = substr($Word, 0, strlen($Word) - 2);
                    $WordNoEDWithE = $WordNoED . "e"; // ex: stored > store
                    $ConditionED = " OR Word='$WordNoED'";
                    $ConditionED .= " OR Word='$WordNoEDWithE'";
                    //
                    if ($WordNoED[strlen($WordNoED) - 1] === "i") {
                        $WordNoEDWithIED = substr($WordNoED, 0, strlen($WordNoED) - 1);
                        $WordNoEDWithIED .= "y";
                        $ConditionED .= " OR Word='$WordNoEDWithIED'";
                    }
                }
                // ...ing
                $ConditionING = "";
                if (substr($Word, strlen($Word) - 3, 3) === "ing") {
                    $WordNoING = substr($Word, 0, strlen($Word) - 3);
                    $WordNoINGWithE = $WordNoING . "e";
                    $ConditionING = " OR Word='$WordNoING'";
                    $ConditionING .= " OR Word='$WordNoINGWithE'";
                }
                // ...est
                $ConditionEST = "";
                if (substr($Word, strlen($Word) - 3, 3) === "est") {
                    $WordNoEST = substr($Word, 0, strlen($Word) - 3);
                    $WordNoESTWithE = $WordNoEST . "e";
                    $ConditionEST = " OR Word='$WordNoEST'";
                    $ConditionEST .= " OR Word='$WordNoESTWithE'";
                }
                // ...er
                $ConditionER = "";
                if (substr($Word, strlen($Word) - 2, 2) === "er") {
                    $WordNoER = substr($Word, 0, strlen($Word) - 2);
                    $WordNoERWithE = $WordNoER . "e";
                    $ConditionER = " OR Word='$WordNoER'";
                    $ConditionER .= " OR Word='$WordNoERWithE'";
                }
                /// QUERY
                $Sql = "select * from word where Word='$Word'";
                $Sql .= $ConditionS . $ConditionES . $ConditionIES
                        . $ConditionED
                        . $ConditionING
                        . $ConditionEST . $ConditionER;
                $WordObj = $SM->Query($Sql)->getRow(0);
                $IsWordExist = isset($WordObj);
                if ($IsWordExist) {
                    array_push($ArrayMeanWordObjs, $WordObj);
                }
            }
        }
        // sort by View
        usort($ArrayMeanWordObjs, function($a, $b) {
            return (int) $a->View > (int) $b->View;
        });
        
//        // TEST DEBUG
//        echo count($ArrayMeanWordObjs) . PHP_EOL;
//        foreach ($ArrayMeanWordObjs as $Test) {
//            echo $Test->Word . PHP_EOL;
//        }
//        // END TEST DEBUG

        return $ArrayMeanWordObjs[0];
    }

}
