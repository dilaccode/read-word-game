<?php namespace App\Controllers;

use App\Models\SimpleModel;

class Word extends BaseController
{
	public function index()	{
		
	}

	/// GET StrWordsViewed : word1_word2_word3, _ split
	public function View($Word='empty',$Parent = "")
	{
		$Word = rawurldecode($Word);
		$Parent = rawurldecode($Parent);

		$SM = new SimpleModel();
	
		$WordObj =  $this->GetWord($Word);

		$Len = strlen($WordObj->Word);
		$ClassWordSize = 'w3-jumbo';
		if($Len>=7) $ClassWordSize = 'w3-xxxlarge';
		if($Len>=10) $ClassWordSize = 'w3-xxlarge';
		if($Len>=13) $ClassWordSize = 'w3-xlarge';
		
		$IsChildPage = strlen($Parent) > 0;
		$ClassWordColor = $IsChildPage ? "w3-text-green" : 'w3-text-blue';
		// list words init random: for anti random many time > differ
		$ListWordMeansInit = GETDataUrlToArray("ListWordMeansInit");
			// fist time = empty list
		if(count($ListWordMeansInit)===0){
			$ListWordMeansInit = $this->GetListWordMeansRandom($WordObj->Mean);
		}
		$WordObj->ListWordMeans = $ListWordMeansInit;
		$UrlGETDataListWordMeansInit = ArrayToGETDataUrl("ListWordMeansInit",$ListWordMeansInit);		
		// list words viewed (child page)
		$ListWordsViewed = GETDataUrlToArray("ListWordsViewed");
		if($IsChildPage){
			array_push($ListWordsViewed,$Word);
		}
		$UrlGETDataListWordsViewed = ArrayToGETDataUrl("ListWordsViewed",$ListWordsViewed);		
		// process viewed (parent page)	
		$ArrayWordMeansStatus = array();
		foreach($WordObj->ListWordMeans as $WordMean){
			$WordMeanStatus = (object)array(
				'Word' => $WordMean,
				"IsViewed" => FALSE,
			);
			if(in_array($WordMeanStatus->Word,$ListWordsViewed)){
				$WordMeanStatus->IsViewed = TRUE;
			}
			array_push($ArrayWordMeansStatus,$WordMeanStatus);
		}
		$WordObj->ArrayWordMeansStatus = $ArrayWordMeansStatus;
		// percent viewed / exp
			// calculate percent
		$PercentNew = count($ArrayWordMeansStatus) === 0 ? 0
			: round(count($ListWordsViewed)/count($ArrayWordMeansStatus)*100,0);
			// override Percent for child page
		$PercentCurrent = isset($_GET['PercentCurrent']) ? $_GET['PercentCurrent'] : 0;
			// exp
		$Exp = Count($ListWordsViewed) * RATE_VIEW_WORD_EXP;
		$IsEmptyWordMeans = count($WordObj->ListWordMeans) === 0;
		$IsLearnSucess = !$IsChildPage && (int) $PercentNew === 100
						 || $IsEmptyWordMeans;
		if($IsLearnSucess){
			$SM->Add('Exp',(object)array(
				'WordId'=> $WordObj->Id,
				'Exp'=> $Exp,
			));
			// update learn time
			$WordObjForUpdate = $SM->Find("Word",$WordObj->Id);
			$WordObjForUpdate->LearnTime++;
			$SM->Update("Word",$WordObjForUpdate);
		}
		// markup select word
		if(!$IsChildPage){
			$ShowIndex = 1;
				// for anti replace inside word: replace part/ sign
				// format: word.$ReplaceSign > <new>.$ReplaceSign
			$SPACE=" ";
			$DOT=".";
			$COMMA=",";
			$RIGHT_ROUND_BRACKET=")";
			$ArrayReplace = array($SPACE,$DOT,$COMMA,$RIGHT_ROUND_BRACKET);
				// end
				// fix bug "an<SPACE>" replace "<span<SPACE>...
				// -> by replace "an" first
			if(in_array("an",$WordObj->ListWordMeans)){
				$WordObj->Mean = str_replace("an$SPACE",
						"<span class='show$ShowIndex WordMark'>$WordMeanStatus->Word</span>$SPACE",$WordObj->Mean);
			}
			foreach($WordObj->ArrayWordMeansStatus as $WordMeanStatus){
				if(!$WordMeanStatus->IsViewed 
					&& $WordMeanStatus->Word !== "an" // fix bug "an<SPACE>"
				){
					foreach($ArrayReplace as $ReplaceSign){
						$WordObj->Mean = str_replace($WordMeanStatus->Word.$ReplaceSign,
						"<span class='show$ShowIndex WordMark'>$WordMeanStatus->Word</span>$ReplaceSign",$WordObj->Mean);
						
					}
					$ShowIndex++;
				}
			}
		}
		//
		$Data= array(
			'WordObj'=> $WordObj,
			'ClassWordSize'=> $ClassWordSize,
			'IsChildPage' => $IsChildPage,
			'Parent' => $Parent,
			'ClassWordColor'=> $ClassWordColor,
			'UrlGETDataListWordsViewed' => $UrlGETDataListWordsViewed,
			'UrlGETDataListWordMeansInit' => $UrlGETDataListWordMeansInit,
			'PercentCurrent'=>$PercentCurrent,
			'PercentNew' => $PercentNew,
						// skip calculate Percent child page
			'IsLearnSucess' => $IsLearnSucess,
			'Exp' => $Exp,
		);
	
		// var_dump($Data);die();
		
		echo view('Header');
		echo view('Word',$Data);
		echo view('Footer');
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
    private function GetListWordMeansRandom($Mean){
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
		$AmountMeansAllow = 3;
		if(count($ArrayMeansResult) > $AmountMeansAllow){
			$ArrayIndex = array_rand($ArrayMeansResult, $AmountMeansAllow);
			foreach ( $ArrayIndex as $Index){
				array_push($ArrayMeansResultRandom, $ArrayMeansResult[$Index]);
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
