<?php namespace App\Controllers;

use App\Models\SimpleModel;

class TempCambridge extends BaseController
{
	public function index()
	{
		$SM = new SimpleModel();
	}
	/// send me query: /TempCambridge/GetData?Word=WORDencodeURI&Mean=MEANencodeURI
	public function GetData()
	{		
		$SM = new SimpleModel();

		//
		echo view("Header");
		
		
		$ViewWord = "";
		$AmountRows = -1;
		// process mean
		if(isset($_GET["Word"])){
			$Word = $_GET['Word'];

			$Mean = $_GET['Mean'];
			$Mean = str_replace("'","\'",$Mean);
			$AmountRows = $SM->Query("update wordtemp set Mean = '$Mean' where Word = '$Word'")
			->AmountRows;
			if($AmountRows===0){
				$ViewWord.="<div class='w3-orange' style='padding: 16px;'>
					S / ES detect
					<br>
					<a class='w3-btn w3-red w3-round' style='margin-right: 16px;'
					   href='/TempCambridge/RemoveS/$Word'>REMOVE S </a>

					<a class='w3-btn w3-pink w3-round'
					href='/TempCambridge/RemoveES/$Word'>REMOVE ES </a>
					<br>
					and press Back <- 
				</div>";
			}

			$ViewWord .= "<div class='w3-green ' style='padding: 16px;'>Update $Word, success: $AmountRows</div>";
			// show result
			if(isset($_GET["Word"])){
				$ViewWord .= "<div class='w3-xxlarge w3-margin'>$Word</div>";
				$ViewWord .= "<div class='w3-xlarge w3-margin'>$Mean</div>";
			}
		}	


		// show empty word
		echo "NEXT WORD: <br>";
		$WordEmpty = $SM->Query("select * from wordtemp where length(mean)=0")->getRow(0);
		Debug($WordEmpty);
		$CambridgeLink = "https://dictionary.cambridge.org/vi/dictionary/english/$WordEmpty->Word";
		echo "<a href='$CambridgeLink' class='w3-btn w3-blue w3-center w3-margin' style='margin-left: 200px !important;'>$WordEmpty->Word</a>";
		// delete no meaning word
		if($AmountRows===0){
			echo "<br><a class='w3-btn w3-red w3-round' style='margin: 50px;'
			href='/TempCambridge/RemoveWord/$WordEmpty->Id'>REMOVE  <span class='w3-large'>$WordEmpty->Word<span></a>";
		}
		

		// show after
		echo $ViewWord;

		echo view("Footer");
	}
	public function RemoveS($Word){
		$Word = rawurldecode($Word);
		$SM = new SimpleModel();
		$Word = strtolower($Word); // word no S
		$Result = $SM->Query("update wordtemp set word='$Word' where word='".$Word."s' ");
		echo "Update $Result->AmountRows word"; 
	}

	public function RemoveES($Word){
		$Word = rawurldecode($Word);
		$SM = new SimpleModel();
		$Word = strtolower($Word); // word no S
		$Result = $SM->Query("update wordtemp set word='$Word' where word='".$Word."es' ");
		echo "Update $Result->AmountRows word"; 
	}
	public function RemoveWord($WordId){
		$SM = new SimpleModel();
		// Debug("delete from wordtemp where word='$Word'");
		$Result = $SM->Query("delete from wordtemp where Id=$WordId ");
		echo "Update $Result->AmountRows word"; 
	}

	/// Word Process ====================
	public function Test(){
		$SM = new SimpleModel();
		// $WordObj = $SM->Find("wordtemp", $WordId);

		$ListWord = $SM->Query("select * from wordtemp")->getResult();
		$Count = 0;
		foreach($ListWord as $WordObj){
			$ArrayLines = explode("\n",$WordObj->Mean);
			// remove first empty line 
			// if(strlen($ArrayLines[0]) === 1){ // \n
			// 	$ArrayLinesNew = array();
			// 	for($Index = 1; $Index < count($ArrayLines); $Index++)
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	$Count++;
			// }

			// A1, A2, B1, B2, C1, C2
			// if(Contain($ArrayLines[0],"A1")
			// || Contain($ArrayLines[0],"A2")
			// || Contain($ArrayLines[0],"B1")
			// || Contain($ArrayLines[0],"B2")
			// || Contain($ArrayLines[0],"C1")
			// || Contain($ArrayLines[0],"C2")
			// ){
			// 	echo $ArrayLines[0]."<br>";	

			// 		$ArrayLinesNew = array();
			// 	for($Index = 1; $Index < count($ArrayLines); $Index++)
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	$Count++;
			// }

			
			// if( Contain($WordObj->Mean, "đồng nghĩa")
			// || Contain($WordObj->Mean, "sánh")
			// ||  Contain($WordObj->Mean, "lập")
			// ||  Contain($WordObj->Mean, "thêm")
			// ||  Contain($WordObj->Mean, "Xem")
			// ||  Contain($WordObj->Mean, "[   to infinitive ]")
			// ||  Contain($WordObj->Mean, "[   -ing verb ]")
			// ||  Contain($WordObj->Mean, "[   that ]")
			// ||   Contain($WordObj->Mean, "[   (that) ]")
			// ||   Contain($WordObj->Mean, "[   question word ]")
			// ||   Contain($WordObj->Mean, "[   speech ]")
			// ||   Contain($WordObj->Mean, "[   two objects ]")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsStop = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if(Contain($ArrayLines[$Index], "đồng nghĩa")
			// 		|| Contain($ArrayLines[$Index], "sánh")
			// 		|| Contain($ArrayLines[$Index], "lập")
			// 		|| Contain($ArrayLines[$Index], "thêm")
			// 		|| Contain($ArrayLines[$Index], "Xem")
			// 		|| Contain($ArrayLines[$Index], "[   to infinitive ]")
			// 		|| Contain($ArrayLines[$Index], "[   -ing verb ]")
			// 		|| Contain($ArrayLines[$Index], "[   that ]")
			// 		|| Contain($ArrayLines[$Index], "[   (that) ]")
			// 		|| Contain($ArrayLines[$Index], "[   question word ]")
			// 		|| Contain($ArrayLines[$Index], "[   speech ]")
			// 		|| Contain($ArrayLines[$Index], "[   two objects ]")
			// 		){
			// 			$IsStop = true;
			// 		}

			// 		if(!$IsStop)
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	}
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	// echo $result."<br>".PHP_EOL;
			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }


			// // remove [some thing..]
			// if(Contain($ArrayLines[0],"[")
			// || Contain($ArrayLines[0],"]")
			// ){
			// 		$ArrayLinesNew = array();
			// 	for($Index = 1; $Index < count($ArrayLines); $Index++)
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }

			// // (UK also backcloth, UK  /ˈbæk.klɒθ/ US  /-klɑːθ/)"
			// if(Contain($ArrayLines[0],"(UK")
			// ){
			// 		$ArrayLinesNew = array();
			// 	for($Index = 1; $Index < count($ArrayLines); $Index++)
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	//  Debug($ArrayLines, $ArrayLinesNew);
			// }

			/// remove example: keep 3 example
			if(count($ArrayLines)>=5){
				$ArrayLinesNew = array();
				$AMOUNT_KEEP= 3;
				// mean:
				array_push($ArrayLinesNew, $ArrayLines[0]);
				for($Index = 1; $Index <= $AMOUNT_KEEP; $Index++){
					if($Index<count($ArrayLines))
						array_push($ArrayLinesNew, $ArrayLines[$Index]);
				}
				$WordObj->Mean = implode("\n",$ArrayLinesNew);
				$result = $SM->Update('wordtemp',$WordObj);
				// Debug($ArrayLines, $ArrayLinesNew);
				
			}

			/// Square in line [  ... ]
		}
		echo $Count;
	}


}
