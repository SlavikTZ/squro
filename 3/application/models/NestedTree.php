<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tree
 *
 * @author Slavik
 */
class NestedTree  extends Tree{
    
     public function __construct() {
       parent::__construct();
    }
    protected function createBase($name){
        $data = Register::getSection('db');
        if(file_exists($data['path'].$data['file'])){
         $strSQL = "CREATE TABLE IF NOT EXISTS `tree` (
                        `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
                        `parent_id` INTEGER NOT NULL,
                        `name` TEXT DEFAULT NULL,
                        `left_key` INTEGER NOT NULL,
                        `right_key` INTEGER NOT NULL,
                        `level` INTEGER NOT NULL)";
         $this->db->exec($strSQL);
         $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, `name`,
                                        `left_key`, `right_key`, `level`) 
                                     VALUES(1, 0, :name, 1, 2, 1)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":name", $name, SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
        }
    }
    
    public function add($name, $pid){
        if($node = new Node($pid)){
            throw new TreeException("Нет элемента с ключом {$pid}");
        }
        
//        $strSQL = "UPDATE `tree` SET `left_key`=`left_key`+2,"
//                . "`right_key`=`right_key`+2 WHERE `left_key`>{$node->right_key}";
//        
//        $strSQL[1] = "UPDATE `tree` SET `right_key` = `right_key` + 2 "
//                . "WHERE `right_key`>=:right_key AND `left_key`<:right_key";
//        $paramRequest[1] = $paramRequest[0];
        $newNode = new Node();
    }
    public function rename($id, $name){
        
    }
    public function delete($id){
        
    }
    public function move($id, $pid, $pos=Null){
        
    }
    private function getNode($id){
        
    }
    public function test(){
       
    }    
    
    
    
}
