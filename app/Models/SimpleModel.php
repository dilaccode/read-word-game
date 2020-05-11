<?php namespace App\Models;

class SimpleModel
{    
    private $db;
    function __construct() {
        $this->db = \Config\Database::connect();
    }

    // /// CRUD
    // // Find
    public function Find($Table,$Id){
        return (object) $this->db->query("select * from $Table where id=$Id")
                ->getRow(1);
    }
    // Add, return: success: id, fail: 0
    public function Add($Table,$Obj){
        $ListKey = array();
        $ListValue = array();
        foreach ($Obj as $Key => $Value) {
            array_push($ListKey,$Key);
            if(is_string($Value)){
                $Value = str_replace("'","\'",$Value);
            }
            array_push($ListValue,"'$Value'");
        }
        $SqlKey = implode(",",$ListKey);
        $SqlValue = implode(",",$ListValue);
        $Sql = "insert into $Table($SqlKey) value($SqlValue)";
        $this->db->query($Sql);
        return $this->db->mysqli->insert_id;
    }
    // // Update
    /// Should update original object: get from database and modify is right
    public function Update($Table,$Obj){
        $Obj = (object)$Obj;
        $Id=$Obj->Id;
        unset($Obj->Id);
        $TotalFields = count(get_object_vars($Obj));
        $CountField = 1;
        $Sql = "update $Table set ";
        foreach ($Obj as $Key => $Value) {
            if(is_string($Value)){
                $Value = str_replace("'","\'",$Value);
            }
            $Sql.= $CountField <= $TotalFields - 1 ? "$Key='$Value',":"$Key='$Value'";
            $CountField++;
        }
        $Sql.= " where id=$Id";
        $this->db->query($Sql);
        // fix bug; remove Id after update object / & reference zzzz.ple
        $Obj->Id = $Id;
        //
        return $this->db->mysqli->affected_rows;
    }
    // // Delete
    public function Delete($Table,$Id){
        $Sql = "delete from $Table where id=$Id";
        $this->db->query($Sql);
        return $this->db->mysqli->affected_rows;
    }
    
    /// --------------
    /// Return query result, 
    ///     ->getResult(), ->getRow(X),
    ///     Add:
    ///         ->AmountRows (affected_rows)
    //          ->AddId (insert_id)
    public function Query($sql){
        $result =  $this->db->query($sql);
        $result->AmountRows = $this->db->mysqli->affected_rows;
        $result->AddId = $this->db->mysqli->insert_id;
        return $result;
    }
}