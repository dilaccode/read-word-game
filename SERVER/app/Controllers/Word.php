<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Word extends BaseController {

    public function index() {
        ServerHiYou();
    }

    /// get random
    public function StartId() {
        $SM = new SimpleModel();
        $WordRandom = $SM->Query("SELECT * FROM word order by RAND() limit 1")
                ->getRow(0);
        echo json_encode((int) $WordRandom->Id);
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
        $NextWordObj = $this->GetNextWordFromMean($WordObj->Mean);
        $WordObj->NextWord = $NextWordObj->Word;
        $WordObj->NextWordId = $NextWordObj->Id;

        echo json_encode($WordObj);
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
        $NewExp = strlen($WordObj->Mean);
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
        $Exp = strlen($WordObj->Mean); // length of mean

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
        $SearchArr = array("(", ")", ".", ",", ";", "  ", "\n");
        $ReplaceArr = array(" ", " ", " ", " ", " ", " ", "");
        // split
        $Mean = str_replace($SearchArr, $ReplaceArr, $Mean);
        $ArrayMeanWords = array_unique(explode(" ", $Mean));
        $ArrayMeanWordObjs = array();
        foreach ($ArrayMeanWords as $Word) {
            if (strlen($Word) > 0) {
                // check exist
                $Word = str_replace("'", "\'", $Word);
                $WordObj = $SM->Query("select * from word
        where Word='$Word'")->getRow(1);
                $IsWordExist = isset($WordObj);
                //
                if ($IsWordExist) {
                    array_push($ArrayMeanWordObjs, $WordObj);
                }
            }
        }
        // sort by View
        usort($ArrayMeanWordObjs, function($a, $b) {
            return (int) $a->View > (int) $b->View;
        });
        return $ArrayMeanWordObjs[0];
    }

}
