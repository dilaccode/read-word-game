<?php namespace App\Controllers;

use App\Models\SimpleModel;
use App\Models\TestModel;

class Home extends BaseController
{
	public function index()
	{
		$SM = new SimpleModel();

		$TM = new TestModel();
		$TM->FindObj("Word",NULL);die();

		// Words
		$Amount = 3;
		$ListLowSeeWords = $SM->Query("select * from Word 
		order by LearnTime, WordLength limit $Amount")
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
}
