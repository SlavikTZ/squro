<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SimpleTree
 *
 * @author Slavik
 */
class SimpleTree extends Tree{
    public function __construct() {
        parent::__construct();
    }
    protected function createBase($name){
         $strSQL = "CREATE TABLE IF NOT EXISTS `tree` (
                        `id` INTEGER INTEGER PRIMARY KEY NOT NULL,
                        `parent_id` INTEGER NOT NULL,
                        `name` TEXT DEFAULT NULL)";
         $this->db->exec($strSQL);
         $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, 
                                        `name`) 
                                     VALUES(1, 0, :name)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":name", $name, SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
        
    }

    public function add($name, $pid){
       
        $max_id = $this->maxId()+1;
        $this->testId($pid);
       $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, `name`) 
                                     VALUES(:id, :parent_id, :name)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":id", $max_id, SQLITE3_INTEGER);
         $stmt->bindValue(":parent_id", (int)$pid, SQLITE3_INTEGER);
         $stmt->bindValue(":name", $name, SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
         return $max_id;
    }
    public function rename($id, $name){
        
        $this->testId($id);
        $strSQL = "UPDATE `tree` SET `name`= :name WHERE `id` = {$id}";
        $stmt = $this->db->prepare($strSQL);
        $stmt->bindValue(":name", $name, SQLITE3_TEXT);
        $result = $stmt->execute();
        $stmt->close();
        return true;
        
    }
    public function delete($id){
        if($id===1){
            return true;
        }
        $this->testId($id);
        $this->deleteLists($id);
        return true;
    }
    private function deleteLists($id){
        $strSQL = "SELECT `id` FROM `tree` WHERE `parent_id` = ".$id;
        $result = $this->db->query($strSQL);
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $this->deleteLists($row['id']);
        }
        $strSQL = "DELETE FROM `tree` WHERE `id` = {$id}";
        $this->db->query($strSQL);
        
    }
    //недостаток данного дерева, поэтому нужно использовать nodeset
    public function move($id, $pid, $pos){
        extract($params); 
        if($id===1 && !$this->testId($id) && !$this->testId($pid)){
            throw new TreeException('Перемещение не возможно');
        }
        if($pos==='sister'){
            if($id>$pid){
                debug($params);
                $max_id = $this->maxId()+1;
                $sister = $pid;
                $pid = $this->getParent($sister);
                debug($pid);
                //$strSQL = "UPDATE `tree` SET `id`= ".$max_id." WHERE `id`={$id}";
                //$this->db->query($strSQL);
                //$strSQL = "UPDATE `tree` SET `id`= `id`+1 WHERE `id`>".($pid+1)." AND "."`id`<=".$id;
                //$this->db->query($strSQL);
                //$strSQL = "UPDATE `tree` SET `id`= ".($pid+1)."`id` WHERE `id`=".$max_id;
                //$this->db->query($strSQL);
                return true;
             }else{
                 
             }
        }else{
            $strSQL = "UPDATE `tree` SET `parent_id`= {$params['pid']} WHERE `id` = {$params['id']}";
            $this->db->query($strSQL);
            return true;
            
        }
        
        
    }
    protected function testId($id){
        $strSQL = "SELECT `id` FROM `tree` WHERE `id`={$id}";
        $result = $this->db->query($strSQL);
        $id = $result->fetchArray(SQLITE3_ASSOC);
        if(!isset($id['id'])){
            throw new TreeException('Нет такого id');
        }
    }
    protected function maxId(){
        $strSQL = "SELECT MAX(`id`) As max FROM `tree`";
        $result = $this->db->query($strSQL);
        $id = $result->fetchArray(SQLITE3_ASSOC);
        return $id['max'];
    }
    public function getParent($id){
        if($id==1){
            return 0;
        }
        $strSQL = "SELECT `parent_id` FROM `tree` WHERE id={$id}";
        $result = $this->db->query($strSQL);
        $pid = $result->fetchArray(SQLITE3_ASSOC);
        return $pid['parent_id'];
    }
    public function countChild($pid){
        $strSQL = "SELECT COUNT(`id`) AS num FROM `tree` WHERE `parent_id`={$pid}";
        $result = $this->db->query($strSQL);
        $count = $result->fetchArray(SQLITE3_ASSOC);
        return $count['num'];
        
    }
    protected function getTreeSQL() {
        return "SELECT `id`, `parent_id`, `name` FROM `tree`";
    }
}
