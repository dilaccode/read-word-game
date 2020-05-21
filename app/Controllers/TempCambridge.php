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
		$CambridgeLink = "https://dictionary.cambridge.org/vi/dictionary/english/$WordEmpty->Word";
		echo "<a href='$CambridgeLink' class='w3-btn w3-blue w3-center w3-margin' style='margin-left: 200px !important;'>$WordEmpty->Word</a>";
		// delete no meaning word
		if($AmountRows===0){
			echo "<br><a class='w3-btn w3-red w3-round' style='margin: 50px;'
			href='/TempCambridge/RemoveWord/$WordEmpty->Id'>REMOVE  <span class='w3-xxlarge'>$WordEmpty->Word<span></a>";
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
}
