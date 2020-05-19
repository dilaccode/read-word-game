<?php namespace App\Controllers;

use App\Models\SimpleModel;

class Word extends BaseController
{
	public function index()	{ }

	public function View($Word='empty')
	{
	
		$SM = new SimpleModel();

		$Word = rawurldecode($Word);
	
		$WordObj =  $this->GetWord($Word);

		$Len = strlen($WordObj->Word);
		$ClassWordSize = 'w3-jumbo';
		if($Len>=7) $ClassWordSize = 'w3-xxxlarge';
		if($Len>=10) $ClassWordSize = 'w3-xxlarge';
		if($Len>=13) $ClassWordSize = 'w3-xlarge';

		$CssMeanFontSize = 'font-size: 35px !important;';
		$TotalMeanWords = Count(explode(" ",$WordObj->Mean));
		if($TotalMeanWords>=20) // 20-3x words
			$CssMeanFontSize = 'font-size: 30px !important;';
		if($TotalMeanWords>=31) // 3x-55 words
			$CssMeanFontSize = 'font-size: 22px !important;';
		
		// get next word
		$ListWordMeans = $this->GetListWordMeansRandom($WordObj->Mean, 1);
		$NextWord = count($ListWordMeans) >=1 ? $ListWordMeans[0] : "None";

		// User
		$User = $SM->Find("user", 1);
		$Levels = GetGameLevels($User->Level + 1);
		$User->ThisLevelTotalExp = $Levels[$User->Level + 1]->Exp;
		$User->CurrentExp = $User->TotalExp - $Levels[$User->Level]->TotalExp; 
		$User->CurrentPercent = round($User->CurrentExp / $User->ThisLevelTotalExp * 100, 1); 

		$NewExp = strlen($WordObj->Mean);
		$User->NewPercent = round(($User->CurrentExp + $NewExp) / $User->ThisLevelTotalExp * 100, 1);
		//
		$Data= array(
			'WordObj'=> $WordObj,
			'ClassWordSize'=> $ClassWordSize,
			'CssMeanFontSize' => $CssMeanFontSize,
			'NextWord' => $NextWord,
			//
			'User' => $User,

		);
	
		// var_dump($Data);die();
		
		echo view('Header');
		echo view('Word',$Data);
		echo view('Footer');
	}
	public function Player(){

		$Word = "test";
		
		$SM = new SimpleModel();
	
		$WordObj =  $this->GetWord($Word);
		
		// get next word
		$ListWordMeans = $this->GetListWordMeansRandom($WordObj->Mean, 1);
		$NextWord = count($ListWordMeans) >=1 ? $ListWordMeans[0] : "None";

		
		//
		$Data= array(
			'WordObj'=> $WordObj,
			'NextWord' => $NextWord,
			//
		);

		echo view('Header');
		echo view('WordPlayer', $Data);
		echo view('Footer');

		
	}
	/// AJAX ==================
	// return JSON
	//	array( WordObj, User)
	public function AjaxGetWord($WordId){
		$SM = new SimpleModel();

		for($i= 0; $i<5000;$i++){
			$SM->Query("select sum(length(Mean)) from word");
		}
		// Word
		$WordObj = $SM->Find("word", $WordId);

		// User
		
		// User
		$User = $SM->Find("user", 1);
		$Levels = GetGameLevels($User->Level + 1);
		$User->ThisLevelTotalExp = $Levels[$User->Level + 1]->Exp;
		$User->CurrentExp = $User->TotalExp - $Levels[$User->Level]->TotalExp; 
		$User->CurrentPercent = round($User->CurrentExp / $User->ThisLevelTotalExp * 100, 1); 

		$NewExp = strlen($WordObj->Mean);
		$User->NewPercent = round(($User->CurrentExp + $NewExp) / $User->ThisLevelTotalExp * 100, 1);

		echo json_encode(array($WordObj, $User));
	}
	public function AjaxReadComplete($UserId, $WordId){
		$SM = new SimpleModel();

		$WordObj = $SM->Find('word', $WordId);
		$User = $SM->Find('user', $UserId);
		$Exp =  strlen($WordObj->Mean); // length of mean

		$User->TotalExp += $Exp;
			// check level up
		$ListLevels = GetGameLevels($User->Level + 2);
		$NewLevel = $User->Level;
		for($Level = $User->Level; $Level <= $User->Level + 2; $Level++){
			if($User->TotalExp /* new */ >= $ListLevels[$Level]->TotalExp){
				$NewLevel = $Level;
			}
		}
		$User->Level = $NewLevel;
		$SM->Update("user",$User);

		// update learn time
		$WordObj->LearnTime++;
		$SM->Update("word",$WordObj);
	}

	/// ============================================
	/// WORD
	private function GetWord($Word){
		$Word = rawurldecode($Word);

		$SM = new SimpleModel();

		$WordObj = $SM->Query("select * from word where Word='$Word'")
			->getRow(1);
        // update stat
		$WordObj->View++;
		$SM->Update("word",$WordObj);
        //
        return $WordObj;
    }
	/// return Mean (sentence) as array (Word,IsExist)
	/// random : X elements
	/// and exist words
    private function GetListWordMeansRandom($Mean, $AmountMeansAllow){
        $SearchArr = array("(",")",".",",",";","  ");
        $ReplaceArr = array(" "," "," "," "," "," ");
        // split
        $Mean = str_replace($SearchArr,$ReplaceArr,$Mean);
		$ArrayMean = explode(" ",$Mean);
		$ArrayMeansResult = array();
        foreach($ArrayMean as $Word){			
            if(strlen($Word)>0){
				if($this->checkWorkExist($Word)
					&& !in_array($Word,$ArrayMeansResult) // for unique
				){
                	array_push($ArrayMeansResult, $Word);
				}
            }
		}
		
		// return randoms array
		$ArrayMeansResultRandom = array();
		if(count($ArrayMeansResult) > $AmountMeansAllow){
			$ArrayIndex = array_rand($ArrayMeansResult, $AmountMeansAllow);
			if(is_array($ArrayIndex)){
				foreach ( $ArrayIndex as $Index){
					array_push($ArrayMeansResultRandom, $ArrayMeansResult[$Index]);
				}
			}else{ // 1 item: int
				array_push($ArrayMeansResultRandom, $ArrayMeansResult[$ArrayIndex]);
			}
		}else{ // case ; 0, 1, 2, 3, X.... <= $AmountMeansAllow, no need random
			$ArrayMeansResultRandom = $ArrayMeansResult;
		}
        return $ArrayMeansResultRandom;
    }
    /// return TRUE/FALSE
    private function checkWorkExist($Word){
		$SM = new SimpleModel();
        $WordObj =  $SM->Query("select * from word
        where Word='$Word'")->getRow(1);
        return isset($WordObj);
    }
	
}
