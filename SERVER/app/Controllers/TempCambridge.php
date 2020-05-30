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
		
		$ListWord = $SM->Query("select * from wordtemp")->getResult();
		$Count = 0;
		foreach($ListWord as $WordObj){
			$ArrayLines = explode("\n",$WordObj->Mean);

			// /// remove  empty line ===	
			// $ArrayLinesNew = array();
			// $IsDebug = false;
			// for($Index = 0; $Index < count($ArrayLines); $Index++)
			// 	if(strlen($ArrayLines[$Index]) <= 2){ // remove 0, 1, 2
			// 		// remove
			// 		$IsDebug = true;
			// 	}else{
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	}
			// $WordObj->Mean = implode("\n",$ArrayLinesNew);
			// $result = $SM->Update('wordtemp',$WordObj);
			// if($IsDebug)
			// 	Debug($ArrayLines,$ArrayLinesNew);
			

			/// A1, A2, B1, B2, C1, C2  ====
			// if(Contain($ArrayLines[0],"A1")
			// || Contain($ArrayLines[0],"A2")
			// || Contain($ArrayLines[0],"B1")
			// || Contain($ArrayLines[0],"B2")
			// || Contain($ArrayLines[0],"C1")
			// || Contain($ArrayLines[0],"C2")
			// ){
			// 	$ArrayLinesNew = array();
			// 	for($Index = 1; $Index < count($ArrayLines); $Index++)
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	$Count++;

			// 	// Debug($ArrayLines,$ArrayLinesNew);
			// }
			
						

			// /// remove under Vietnamese ===
			// if( Contain($WordObj->Mean, "đồng nghĩa")
			// || Contain($WordObj->Mean, "sánh")
			// ||  Contain($WordObj->Mean, "lập")
			// ||  Contain($WordObj->Mean, "thêm")
			// ||  Contain($WordObj->Mean, "Xem")
			// ||  Contain($WordObj->Mean, "Trái ngược")
			// ||  Contain($WordObj->Mean, "Note:")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsStop = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if(Contain($ArrayLines[$Index], "đồng nghĩa")
			// 		|| Contain($ArrayLines[$Index], "sánh")
			// 		|| Contain($ArrayLines[$Index], "lập")
			// 		|| Contain($ArrayLines[$Index], "thêm")
			// 		|| Contain($ArrayLines[$Index], "Xem")
			// 		|| Contain($ArrayLines[$Index], "Trái ngược")
			// 		|| Contain($ArrayLines[$Index], "Note:")						
			// 		){
			// 			$IsStop = true;
			// 		}

			// 		if(!$IsStop)
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	}
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
				
			// 	Debug($ArrayLines, $ArrayLinesNew);
			// }

			// remove [some thing..] first mean
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
			// 	 Debug($ArrayLines, $ArrayLinesNew);
			// }


			// // // remove [...] in line ===
			// if( Contain($WordObj->Mean, "[")
			// ||  Contain($WordObj->Mean, "]")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsStop = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if( Contain($ArrayLines[$Index], "[")
			// 		|| Contain($ArrayLines[$Index], "]")
			// 		){
			// 			$Line = trim(preg_replace('#\[(.*?)\]#', "", $ArrayLines[$Index]));
			// 			$Line = str_replace("  "," ",$Line);
			// 			$Line = str_replace(" .",".",$Line);
			// 			array_push($ArrayLinesNew, $Line);
			// 		}else{
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 		}	
			// 	}
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
				

			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }


			// // // remove (...) in line ===
			// if( Contain($WordObj->Mean, "(")
			// ||  Contain($WordObj->Mean, ")")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsStop = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if( Contain($ArrayLines[$Index], "(")
			// 		|| Contain($ArrayLines[$Index], ")")
			// 		){
			// 			$Line = trim(preg_replace('#\((.*?)\)#', "", $ArrayLines[$Index]));
			// 			$Line = str_replace("  "," ",$Line);
			// 			$Line = str_replace(" .",".",$Line);
			// 			array_push($ArrayLinesNew, $Line);
			// 		}else{
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 		}	
			// 	}
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
				

			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }

	
			// /// remove iStock/Getty Images Plus ====
			// // remove GettyImages
			// if( Contain($WordObj->Mean, "iStock/Getty Images Plus")
			// ||  Contain($WordObj->Mean, "GettyImages")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsStop = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if( Contain($ArrayLines[$Index], "iStock/Getty Images Plus")
			// 		|| Contain($ArrayLines[$Index], "GettyImages")
			// 		){
			// 			// remove
			// 		}else{
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 		}	
			// 	}
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
				

			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }


			/// remove UK formal; === 
			// if( Contain($WordObj->Mean, "UK formal")
			// ||  Contain($WordObj->Mean, "UK informal")
			// ||  Contain($WordObj->Mean, "UK not standard")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsStop = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if( Contain($ArrayLines[$Index], "UK informal")
			// 		|| Contain($ArrayLines[$Index], "UK formal")
			// 		|| Contain($ArrayLines[$Index], "UK not standard")
			// 		){
			// 			$Line = trim(str_replace("UK informal", "",$ArrayLines[$Index]));
			// 			$Line = trim(str_replace("UK formal", "",$Line));
			// 			$Line = trim(str_replace("UK not standard", "",$Line));

			// 			array_push($ArrayLinesNew, $Line);
			// 		}else{
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 		}	
			// 	}
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);

			// /// remove formal, informal first line === 
			// if( Contain($WordObj->Mean, "formal")
			// ||  Contain($WordObj->Mean, "informal")
			// ){
			// 	$ArrayLinesNew = array();
			// 	$IsDebug = false;
			// 	for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 		if(strtolower(substr($ArrayLines[$Index],0,6))  === "formal"){
			// 			$Line = $ArrayLines[$Index];
			// 			$Line = substr($ArrayLines[$Index],7,strlen($ArrayLines[$Index])-7);
			// 			if(strlen($Line)>0) 
			// 				array_push($ArrayLinesNew,$Line);
			// 				$IsDebug = true;
			// 		}else if(strtolower(substr($ArrayLines[$Index],0,8))  === "informal"){
			// 			$Line = $ArrayLines[$Index];
			// 			$Line = substr($ArrayLines[$Index],9,strlen($ArrayLines[$Index])-9);
			// 			if(strlen($Line)>0) 
			// 				array_push($ArrayLinesNew,$Line);
			// 				$IsDebug = true;
			// 		} else{
			// 			array_push($ArrayLinesNew,$ArrayLines[$Index]);
			// 		}
			// 	}
				
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// 	if($IsDebug)
			// 	Debug($ArrayLines, $ArrayLinesNew);
			// }
			
			// // /// remove UK, US first line
			// $ArrayLinesNew = array();
			// $IsDebug = false;
			// for($Index = 0; $Index < count($ArrayLines); $Index++){
			// 	if(substr($ArrayLines[$Index],0,2) === "UK"
			// 	|| substr($ArrayLines[$Index],0,2) === "US"){
			// 		$LineNew =substr($ArrayLines[$Index],3,strlen($ArrayLines[$Index])-3);
			// 		array_push($ArrayLinesNew,$LineNew);
			// 		$IsDebug = true;
			// 	}else{
			// 		array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 	}					
			// }
			// // update
			// $WordObj->Mean = implode("\n",$ArrayLinesNew);
			// $result = $SM->Update('wordtemp',$WordObj);

			// if($IsDebug)
			// Debug($ArrayLines, $ArrayLinesNew);


		

			// /// get 3 shortest line of Mean ===
			// if(count($ArrayLines) >= 3){		
			// 	$ArrayLinesNew = array();
			// 	$ArrayLinesExample = array();
			// 	array_push($ArrayLinesNew, $ArrayLines[0]); // mean
				
			// 	for($Index = 1; $Index < count($ArrayLines); $Index++){
			// 			array_push($ArrayLinesExample, $ArrayLines[$Index]);
			// 	}
			// 	// sort: short - long
			// 	usort($ArrayLinesExample, function($a, $b) {
			// 		return   strlen($a) - strlen($b);
			// 	});
			// 	$AMOUNT_EXAMPLE_LINE = 3;
			// 	$ArrayLinesExampleNew = array();
			// 	for($Index = 0; $Index < $AMOUNT_EXAMPLE_LINE; $Index++){
			// 		array_push($ArrayLinesExampleNew, $ArrayLinesExample[$Index]);
			// 	}
			// 	$ArrayLinesNew = array_merge($ArrayLinesNew, $ArrayLinesExampleNew);
			// 	// update
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);

			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }

			
			// /// SHORT EXAMPLE (line) BY length Mean ===					
			// $ArrayLinesNew = array();
			// $ArrayLinesExample = array();
			// array_push($ArrayLinesNew, $ArrayLines[0]); // mean
			
			// for($Index = 1; $Index < count($ArrayLines); $Index++){
			// 		array_push($ArrayLinesExample, $ArrayLines[$Index]);
			// }
			// // sort: short - long
			// usort($ArrayLinesExample, function($a, $b) {
			// 	return   strlen($a) - strlen($b);
			// });
			// $ArrayLinesNew = array_merge($ArrayLinesNew, $ArrayLinesExample);
			// // update
			// $WordObj->Mean = implode("\n",$ArrayLinesNew);
			// $result = $SM->Update('wordtemp',$WordObj);

			// // Debug($ArrayLines, $ArrayLinesNew);
			


			/// remove example for LIMIT letters === 
			///  at least 1 example
			// $LIMIT_LENGTH = 205; // letters,space...
			// /// get 3 shortest line of Mean ===	
			// if(strlen($WordObj->Mean) > $LIMIT_LENGTH){		
			// 	$ArrayLinesNew = array();
			// 	$TotalLength = 0;
			// 	// mean
			// 	array_push($ArrayLinesNew, $ArrayLines[0]);
			// 	$TotalLength += strlen($ArrayLines[0]) + 1 /* \n */; 
			// 	// example 1
			// 	if(count($ArrayLines)>=2){
			// 		array_push($ArrayLinesNew, $ArrayLines[1]);
			// 		$TotalLength += strlen($ArrayLines[1]) + 1 /* \n */; 
			// 	}
			// 	if(count($ArrayLines)>=3){
			// 		for($Index = 2; $Index < count($ArrayLines); $Index++){
			// 			if($TotalLength + strlen($ArrayLines[$Index]) <= $LIMIT_LENGTH){
			// 				array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 				$TotalLength += strlen($ArrayLines[$Index]) + 1 /* \n */;
			// 			}
			// 		}
			// 	}
			// 	echo strlen($WordObj->Mean).PHP_EOL;
			// 	echo strlen(implode("\n",$ArrayLinesNew)).PHP_EOL;
			// 	// update
			// 	$WordObj->Mean = implode("\n",$ArrayLinesNew);
			// 	$result = $SM->Update('wordtemp',$WordObj);

			// 	// Debug($ArrayLines, $ArrayLinesNew);
			// }

			/// === replace : end mean by . (dot), add (dot) for some example. ====
			// $ArrayLinesNew = array();
			// $ArrayLines[0] = trim($ArrayLines[0]);
			// $NewMeanLine = "";
			// if($ArrayLines[0][strlen($ArrayLines[0])-1] === "."){
			// 	$Count++;
			// 	// $NewMeanLine = substr($ArrayLines[0],0,strlen($ArrayLines[0])-1);
			// 	// $NewMeanLine.=".";
			// }else{
			// 	// echo $ArrayLines[0].PHP_EOL;
			// 	// $NewMeanLine =$ArrayLines[0];
			// 	// $NewMeanLine.=".";
			// }
			// // $NewMeanLine = ucfirst($NewMeanLine) ;

			// $ArrayLinesNew = array();	
			// array_push($ArrayLinesNew, $ArrayLines[0]); // mean
			// $IsDebug = false;
			// for($Index = 1; $Index < count($ArrayLines); $Index++){
			// 		$Line = trim($ArrayLines[$Index]);
			// 		if(
			// 			$Line[strlen($Line)-1] !== "."
			// 		&& $Line[strlen($Line)-1] !== "?"
			// 		&& $Line[strlen($Line)-1] !== "!"
			// 		&& $Line[strlen($Line)-1] !== "\""
			// 		){
			// 			array_push($ArrayLinesNew, $Line.".");
			// 			$IsDebug = true;
			// 		}else{
			// 			array_push($ArrayLinesNew, $ArrayLines[$Index]);
			// 		}
			// }
			
			// // $WordObj->Mean = implode("\n",$ArrayLinesNew);
			// // $result = $SM->Update('wordtemp',$WordObj);
			// if($IsDebug)
			// Debug($ArrayLines, $ArrayLinesNew);
			
			// /// replace / -> SPACE/SPACE
			// if(Contain($WordObj->Mean,"/")){
			// 	$WordObj->Mean= str_replace("/"," / ",$WordObj->Mean);
			// 	$result = $SM->Update('wordtemp',$WordObj);
			// }



		} // end foreach
		echo $Count;

	} // end function


	


}
