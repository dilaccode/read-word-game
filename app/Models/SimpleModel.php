<?php namespace App\Models;

use CodeIgniter\Model;

class SimpleModel extends Model
{    
    
    // /// CRUD
    
    // // Find
    public function FindObj($Table,$Id){
        return (object) $this->db->query("select * from $Table where id=$Id")
                ->getRow(1);
    }
    // Add, return: success: id, fail: 0
    public function AddObj($Table,$Obj){
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
    public function UpdateObj($Table,$Obj){
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
        return $this->db->mysqli->affected_rows;
    }
    // // Delete
    public function DeleteObj($Table,$Id){
        $Sql = "delete from $Table where id=$Id";
        $this->db->query($Sql);
        return $this->db->mysqli->affected_rows;
    }
    
    /// --------------
    /// Return query result, ->getResult(), ->getRow(X),
    public function Query($sql){
        return $this->db->query($sql);
    }
}