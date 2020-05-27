<?php

namespace App\Controllers;

use App\Models\SimpleModel;

class Word extends BaseController {

    public function index() {
         $SM = new SimpleModel();
         
        $WordRandom = $SM->Query("SELECT * FROM word order by RAND() limit 1")
                        ->getRow(0);
        ///
        $Data = array(
            'StartWordId' => $WordRandom->Id,
            "ViewLevelUp" => view("LevelUp"),
        );
        echo view('Word', $Data);
    }


    /// AJAX ==================
    // return JSON Word
    public function AjaxGetWord($WordId) {
        $SM = new SimpleModel();

        // fake
        // for($i= 0; $i<5000;$i++){
        // 	$SM->Query("select sum(length(Mean)) from word");
        // }
        // Word
        $WordObj = $SM->Find("word", $WordId);
        // update view
        $WordObj->View++;
        $SM->Update("word", $WordObj);
        // get next word
        $ListWordMeans = $this->GetListWordMeansRandom($WordObj->Mean, 1);
        $NextWord = count($ListWordMeans) === 1 ? $ListWordMeans[0] : "ability";
        $WordObj->NextWord = $NextWord;
        $WordObj->NextWordId = $SM->Query("select * from word where word='$NextWord'")
                        ->getRow(1)->Id;

        echo json_encode($WordObj);
    }

    // return JSON User
    public function AjaxGetUser($UserId, $WordId) {
        $SM = new SimpleModel();

        // fake
        // for($i= 0; $i<5000;$i++){
        // 	$SM->Query("select sum(length(Mean)) from word");
        // }
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
    public function AjaxReadComplete($UserId, $WordId, $NextWordId) {
        $SM = new SimpleModel();

        // fake
        // for($i= 0; $i<5000;$i++){
        // 	$SM->Query("select sum(length(Mean)) from word");
        // }

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
        echo $this->AjaxGetUser($UserId, $NextWordId);
    }

    /// ============================================
    /// return Mean (sentence) as array (Word,IsExist)
    /// random : X elements
    /// and exist words
    private function GetListWordMeansRandom($Mean, $AmountMeansAllow) {
        $SearchArr = array("(", ")", ".", ",", ";", "  ");
        $ReplaceArr = array(" ", " ", " ", " ", " ", " ");
        // split
        $Mean = str_replace($SearchArr, $ReplaceArr, $Mean);
        $ArrayMean = explode(" ", $Mean);
        $ArrayMeansResult = array();
        foreach ($ArrayMean as $Word) {
            if (strlen($Word) > 0) {
                if ($this->checkWorkExist($Word) && !in_array($Word, $ArrayMeansResult) // for unique
                ) {
                    array_push($ArrayMeansResult, $Word);
                }
            }
        }

        // return randoms array
        $ArrayMeansResultRandom = array();
        if (count($ArrayMeansResult) > $AmountMeansAllow) {
            $ArrayIndex = array_rand($ArrayMeansResult, $AmountMeansAllow);
            if (is_array($ArrayIndex)) {
                foreach ($ArrayIndex as $Index) {
                    array_push($ArrayMeansResultRandom, $ArrayMeansResult[$Index]);
                }
            } else { // 1 item: int
                array_push($ArrayMeansResultRandom, $ArrayMeansResult[$ArrayIndex]);
            }
        } else { // case ; 0, 1, 2, 3, X.... <= $AmountMeansAllow, no need random
            $ArrayMeansResultRandom = $ArrayMeansResult;
        }
        return $ArrayMeansResultRandom;
    }

    /// return TRUE/FALSE
    private function checkWorkExist($Word) {
        $SM = new SimpleModel();
        $WordObj = $SM->Query("select * from word
        where Word='$Word'")->getRow(1);
        return isset($WordObj);
    }
    
    

}
