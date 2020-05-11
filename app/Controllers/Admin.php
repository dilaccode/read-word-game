<?php namespace App\Controllers;

use App\Models\SimpleModel;

class Admin extends BaseController
{
	public function index()
	{
		$SM = new SimpleModel();

		$TotalWords = $SM->Query("select count(*) as Total from Word")
						->getRow(1)->Total;
		$StatsData = array(
			'TotalWords' =>  number_format($TotalWords),
		);

		echo view("Header");
		echo view("Admin/Home");
		echo view("Admin/Stats",$StatsData);
		echo view("Footer");
	}
	public function UpdateWordsLength()
	{
		$SM = new SimpleModel();

		$Result = $SM->Query("update Word set WordLength=length(Word)");
		$Message = $Result->AmountRows === 0 ? "No Word" 
			: "Update Success $Result->AmountRows Word";
		$Data = array(
			'Title' => "Update Words Length",
			'Message'=> $Message,
			'NextActionText'=>"<i class=\"fa fa-arrow-left\"></i> Back To Admin",
			'NextActionLink'=>"/public/Admin",
		  );
		echo view("Header");
		echo view("Message", $Data);
		echo view("Footer");
	}
}
