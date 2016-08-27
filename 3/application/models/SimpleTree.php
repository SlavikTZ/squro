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
class SimpleTree extends Model implements iTree{
    public function __construct() {
        parent::__construct();
        if(!Register::get('base', 'system')){
            $this->createBase(['name'=>"Корень"]);
        }
    }
    private function createBase($params){
         $strSQL = "CREATE TABLE IF NOT EXISTS `tree` (
                        `id` INTEGER INTEGER PRIMARY KEY NOT NULL,
                        `parent_id` INTEGER NOT NULL,
                        `name` TEXT DEFAULT NULL)";
         $this->db->exec($strSQL);
         $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, 
                                        `name`) 
                                     VALUES(1, 0, :name)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
        
    }
    public function view($params){
        $tree = $this->getTree();
        return $this->getHTML($tree);
    }
    public function add($params){
       
        $max_id = $this->maxId()+1;
        $this->testId($params['pid']);
       $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, `name`) 
                                     VALUES(:id, :parent_id, :name)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":id", $max_id, SQLITE3_INTEGER);
         $stmt->bindValue(":parent_id", (int)$params['pid'], SQLITE3_INTEGER);
         $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
         return $max_id;
    }
    public function rename($params){
        $this->testId($params['id']);
        $strSQL = "UPDATE `tree` SET `name`= :name WHERE `id` = {$params['id']}";
        $stmt = $this->db->prepare($strSQL);
        $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
        $result = $stmt->execute();
        $stmt->close();
        return true;
        
    }
    public function delete($params){
        $id = (int)$params['id'];
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
    public function move($params){
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
    private function getTree(){
        $strSQL = "SELECT `id`, `parent_id`, `name` From `tree`";
        if(@!$result = $this->db->query($strSQL)){
                throw new BaseException("Таблица не создана");
            }
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $temp[$row['id']]['name']=$row['name'];
            $temp[$row['id']]['id']=$row['id'];
            if($row['parent_id']<>0){
                $temp[$row['parent_id']]['child'][$row['id']] = &$temp[$row['id']];
                
            }else{
                $tree[$row['id']]=&$temp[$row['id']];
                $tree[$row['id']]['root']='1';
            }
        }
        return $tree;
    }
    public function __destruct(){
        
    }
    private function getHTML($tree){
        $str = "";
        foreach($tree as $node){
            $str.=$this->getNode($node);
        }
        return $str;
    }
    private function getNode($node){
        ob_start();
        include "../application/template/test.php";
        return ob_get_clean();
    }
    private function testId($id){
        $strSQL = "SELECT `id` FROM `tree` WHERE `id`={$id}";
        $result = $this->db->query($strSQL);
        $id = $result->fetchArray(SQLITE3_ASSOC);
        if(!isset($id['id'])){
            throw new TreeException('Нет такого id');
        }
    }
    private function maxId(){
        $strSQL = "SELECT MAX(`id`) As max FROM `tree`";
        $result = $this->db->query($strSQL);
        $id = $result->fetchArray(SQLITE3_ASSOC);
        return $id['max'];
    }
    private function getParent($id){
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
}
