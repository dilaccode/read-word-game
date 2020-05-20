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
		// show empty word
		$SM = new SimpleModel();
		$WordEmpty = $SM->Query("select Word from wordtemp where length(mean)=0")->getRow(0);
		$CambridgeLink = "https://dictionary.cambridge.org/vi/dictionary/english/$WordEmpty->Word";
		echo "<a href='$CambridgeLink' class='w3-btn w3-blue w3-center w3-margin' style='margin-left: 200px !important;'>$WordEmpty->Word</a>";
		//
		echo view("Header");
		echo view ("TempCambridge", $_GET);
		echo view("Footer");
	}
}
