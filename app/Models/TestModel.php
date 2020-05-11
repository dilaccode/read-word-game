<?php namespace App\Models;

class TestModel
{    
    private $db ;
    function __construct() {
  
    $this->db = \Config\Database::connect();
    
    }
    // /// CRUD
    
    // // Find
    public function FindObj($Table,$Id){
        $result =  (object) $this->db->query("select * from word limit 1")
                ->getRow(1);
                var_dump($result);
                die();
    }
    
}