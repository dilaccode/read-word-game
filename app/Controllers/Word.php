<?php namespace App\Controllers;

use App\Models\SimpleModel;

class Word extends BaseController
{
	public function index()	{ }

	/// GET StrWordsViewed : word1_word2_word3, _ split
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
		// var_dump($TotalMeanWords);
		if($TotalMeanWords>=20) // 20-3x words
			$CssMeanFontSize = 'font-size: 30px !important;';
		if($TotalMeanWords>=35) // 3x-55 words
			$CssMeanFontSize = 'font-size: 22px !important;';
		
		// get next word
		$ListWordMeans = $this->GetListWordMeansRandom($WordObj->Mean, 1);
		$NextWord = count($ListWordMeans) >=1 ? $ListWordMeans[0] : "None";

		// markup select word
		$MeanLength = strlen($WordObj->Mean);
		$WordObj->MeanAnimation = "";
		for($Index = 0; $Index < $MeanLength; $Index++){
			$Letter = $WordObj->Mean[$Index];
			$WordObj->MeanAnimation .= "<span class='select$Index'>$Letter</span>";
		}

		//
		$Data= array(
			'WordObj'=> $WordObj,
			'ClassWordSize'=> $ClassWordSize,
			'CssMeanFontSize' => $CssMeanFontSize,
			'TotalMeanLetters' => $TotalMeanLetters,
			'NextWord' => $NextWord,
		);
	
		// var_dump($Data);die();
		
		echo view('Header');
		echo view('Word',$Data);
		echo view('Footer');
	}
	/// AJAX ==================
	public function AjaxReadComplete($WordId){
		$SM = new SimpleModel();

		$WordObj = $SM->Find('Word',$WordId);

		$SM->Add('Exp',(object)array(
			'WordId'=> $WordId,
			'Exp'=> strlen($WordObj->Mean), // length of mean
		));
		// update learn time
		$WordObj->LearnTime++;
		$SM->Update("Word",$WordObj);
	}

	/// ============================================
	/// WORD
	private function GetWord($Word){
		$Word = rawurldecode($Word);

		$SM = new SimpleModel();

		$WordObj = $SM->Query("select * from Word where Word='$Word'")
			->getRow(1);
        // update stat
		$WordObj->View++;
		$SM->Update("Word",$WordObj);
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
        $WordObj =  $SM->Query("select * from Word
        where Word='$Word'")->getRow(1);
        return isset($WordObj);
    }
	
}
