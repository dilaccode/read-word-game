<?php namespace App\Controllers;

use App\Models\SimpleModel;

class Home extends BaseController
{
	public function index()
	{
		$SM = new SimpleModel();

		// Words
		$Amount = 3;
		$AmountForceLearn = 1;
		$AmountRandom = $Amount - $AmountForceLearn;

		/// ALL SHORT WORD FIRST
		// $ListLowSeeWords = $SM->Query("select * from Word 
		// order by LearnTime, WordLength limit $Amount")

		/// get min length, min learn time
		$MinWordLength = $SM->Query("select WordLength as Min from word
		order by LearnTime, WordLength limit 1")->getRow(1)->Min;
		$MaxWordLength = $MinWordLength + 4;

		$ListWordsForceLearn = $SM->Query("select * from Word 
		where WordLength = $MinWordLength
		order by RAND() limit $AmountForceLearn")
		->getResult();
		
		$ListWordsRandom = $SM->Query("select * from Word 
		where (WordLength >= $MinWordLength AND WordLength <= $MaxWordLength)
		order by RAND() limit $AmountRandom")
        ->getResult();

		// Exp
		$TotalExp = $SM->Query("select sum(Exp) as Total from Exp")
		->getRow(1)->Total;

		$Data = array(
			'ListWords'=> array_merge($ListWordsForceLearn,$ListWordsRandom),
			'TotalExp' => $TotalExp,
		);
		
		// print_r($Data);die();

		echo view('Header');
		echo view('Home',$Data);
		echo view('Footer');
	}
}
