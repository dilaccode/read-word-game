<?php namespace App\Models;

use CodeIgniter\Model;

class WordModel extends Model
{
    protected $table = 'word';

    public function getWords()
    {
        return $this->findAll();
    }
    public function GetWord($word){
        $wordObj = (object) $this->where('word', $word)
                   ->first();
        // update stat
        $wordObj->count++;
        $result = $this->db->query("update word set count=$wordObj->count
        where id=$wordObj->id");  
        // process mean to array mark exist status
        $wordObj->meanArrayStatus=$this->GetExistWordsStatus($wordObj->mean);
        //
        return $wordObj;
    }
    /// return mean (sentence) as array (word,isExist)
    public function GetExistWordsStatus($mean){
        $searchArr = array("(",")",".",",",";","  ");
        $replaceArr = array(" "," "," "," "," "," ");
        // split
        $mean = str_replace($searchArr,$replaceArr,$mean);
        $meanArr = explode(" ",$mean);
        $meanArrResult = array();
        foreach($meanArr as $Word){
            if(strlen($Word)>0){
                array_push($meanArrResult,(object)array(
                    'word'=>$Word,
                    'isExist' => $this->checkWorkExist($Word),
                ));
            }
        }
        return $meanArrResult;
    }
    /// return TRUE/FALSE
    private function checkWorkExist($word){
        $wordObj =  $this->db->query("select * from word
        where word='$word'")->getRow(1);
        return isset($wordObj);
    }
    public function GetLowSeeWords($amount=3){
        return $this->db->query("select word,count from word 
        where count = (select min(count) from word)
        ORDER BY RAND() limit $amount")
        ->getResult();
    }
    
    
}