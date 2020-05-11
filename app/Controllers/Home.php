<?php namespace App\Controllers;

use App\Models\SimpleModel;
use App\Models\WordModel;

class Home extends BaseController
{
	public function index()
	{
		$SM = new SimpleModel();

		// Words
		$Amount = 3;
		$ListLowSeeWords = $SM->Query("select Word,Count from Word 
        where Count = (select min(Count) from Word)
        ORDER BY RAND() limit $Amount")
        ->getResult();

		// Exp
		$TotalExp = $SM->Query("select sum(Exp) as Total from Exp")
		->getRow(1)->Total;

		$Data = array(
			'LowSeeWords'=> $ListLowSeeWords,
			'TotalExp' => $TotalExp,
		);
		
		// print_r($Data);die();

		echo view('Header');
		echo view('Home',$Data);
		echo view('Footer');
	}

	/// GET StrChildViewed : word1_word2_word3, _ split
	public function Word($Word='empty',$Parent = "")
	{
		$SM = new SimpleModel();
	
		$WordObj =  $this->GetWord($Word);

		$Len = strlen($WordObj->Word);
		$ClassWordSize = 'w3-jumbo';
		if($Len>=7) $ClassWordSize = 'w3-xxxlarge';
		if($Len>=10) $ClassWordSize = 'w3-xxlarge';
		if($Len>=13) $ClassWordSize = 'w3-xlarge';
		
		$IsChildPage = strlen($Parent) > 0;
		$ClassWordColor = $IsChildPage ? "w3-text-green" : 'w3-text-blue';
		// list child viewed		
		$ListChildViewed = array();
		$StrChildViewed = "";
		if(isset($_GET['StrChildViewed'])) 
			$StrChildViewed = $_GET['StrChildViewed'];
		if(strlen($StrChildViewed)>0)
			$ListChildViewed = explode("_",$StrChildViewed);
		if($IsChildPage && !in_array($Word,$ListChildViewed)){
			array_push($ListChildViewed,$Word);
		}
		$StrChildViewedNew = implode("_",$ListChildViewed);		
		// process viewed (parent page)	
		$MeanArrayStatusNEW = array();
		foreach($WordObj->MeanArrayStatus as $WordMeanStatus){
			$WordMeanStatus->IsViewed = FALSE;
			if(in_array($WordMeanStatus->Word,$ListChildViewed)){
				$WordMeanStatus->IsViewed = TRUE;
			}
			array_push($MeanArrayStatusNEW,$WordMeanStatus);
		}
		$WordObj->MeanArrayStatus = $MeanArrayStatusNEW;
		// percent viewed / exp
			// unique Word
		$ArrayMeanStatusExistUnique = array();
		foreach($WordObj->MeanArrayStatus as $WordMeanStatus){
			$ArrayUniqueTemp = array_column($ArrayMeanStatusExistUnique,"Word");
			if(!in_array($WordMeanStatus->Word,$ArrayUniqueTemp)){
                array_push($ArrayMeanStatusExistUnique,$WordMeanStatus);
			}
		}
			// calculate percent
		$CountChildExist=0;
		$Percent = 0;
		foreach($ArrayMeanStatusExistUnique as $WordMeanStatus){
			if($WordMeanStatus->IsExist) $CountChildExist++;
		}
		if($CountChildExist>0){
			$Percent = round(Count($ListChildViewed)/$CountChildExist*100,0);
		}
			// override Percent for child page
		$Percent = $IsChildPage ? $_GET['Percent'] : $Percent;
			// exp
		$Exp = Count($ListChildViewed) * RATE_VIEW_WORD_EXP;
		$IsLearnSucess = !$IsChildPage && (int) $Percent === 100;
		if($IsLearnSucess){
			$SM->AddObj('Exp',(object)array(
				'WordId'=> $WordObj->Id,
				'Exp'=> $Exp,
			));
		}
		//
		$Data= array(
			'WordObj'=> $WordObj,
			'ClassWordSize'=> $ClassWordSize,
			'IsChildPage' => $IsChildPage,
			'Parent' => $Parent,
			'ClassWordColor'=> $ClassWordColor,
			'StrChildViewedNew' => $StrChildViewedNew,
			'Percent' => $Percent,
						// skip calculate Percent child page
			'IsLearnSucess' => $IsLearnSucess,
			'Exp' => $Exp,
		);
		//	

		// var_dump($Data);die();
		
		echo view('Header');
		echo view('Word',$Data);
		echo view('Footer');
	}

	/// ============================================
	/// WORD
	private function GetWord($Word){
		$SM = new SimpleModel();

		$WordObj = $SM->Query("select * from Word where Word='$Word'")
			->getRow(1);
        // update stat
		$WordObj->Count++;
		$SM->UpdateObj("Word",$WordObj);
        // process Mean to array mark exist status
        $WordObj->MeanArrayStatus=$this->GetExistWordsStatus($WordObj->Mean);
        //
        return $WordObj;
    }
    /// return Mean (sentence) as array (Word,IsExist)
    private function GetExistWordsStatus($Mean){
        $SearchArr = array("(",")",".",",",";","  ");
        $ReplaceArr = array(" "," "," "," "," "," ");
        // split
        $Mean = str_replace($SearchArr,$ReplaceArr,$Mean);
        $MeanArr = explode(" ",$Mean);
        $MeanArrResult = array();
        foreach($MeanArr as $Word){
            if(strlen($Word)>0){
                array_push($MeanArrResult,(object)array(
                    'Word'=>$Word,
                    'IsExist' => $this->checkWorkExist($Word),
                ));
            }
        }
        return $MeanArrResult;
    }
    /// return TRUE/FALSE
    private function checkWorkExist($Word){
		$SM = new SimpleModel();
        $WordObj =  $SM->Query("select * from Word
        where Word='$Word'")->getRow(1);
        return isset($WordObj);
    }
	
}
