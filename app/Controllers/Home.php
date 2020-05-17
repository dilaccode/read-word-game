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
		$MinWord = $SM->Query("select LearnTime as MinLearn, WordLength as MinLength from word
		order by LearnTime, WordLength limit 1")->getRow(1);
		$MinWord->MaxLength = $MinWord->MinLength + 4;

		$ListWordsForceLearn = $SM->Query("select * from Word 
		where LearnTime = $MinWord->MinLearn AND WordLength = $MinWord->MinLength 
		order by RAND() limit $AmountForceLearn")
		->getResult();
		
		$ListWordsRandom = $SM->Query("select * from Word 
		where (WordLength >= $MinWord->MinLength AND WordLength <= $MinWord->MaxLength)
		order by RAND() limit $AmountRandom")
        ->getResult();

		// Exp
		$User = $SM->Find("User", 1);

		$Data = array(
			'ListWords'=> array_merge($ListWordsForceLearn,$ListWordsRandom),
			'User' => $User,
		);
		
		// print_r($Data);die();

		echo view('Header');
		echo view('Home',$Data);
		echo view('Footer');
	}
}
