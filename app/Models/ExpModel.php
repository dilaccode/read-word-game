<?php namespace App\Models;

use CodeIgniter\Model;

class ExpModel extends Model
{
    protected $table = 'exp';

     /// return int
    public function GetTotalExp(){
        $result =  $this->db->query(
            "select sum(exp) as total from exp")
            ->getRow(1);
        return (int) $result->total;
    }
    public function Add($ObjData){
        $result =  $this->db->query(
        "insert into exp(wordId,exp) value($ObjData->wordId,$ObjData->exp)");
        
    }
}