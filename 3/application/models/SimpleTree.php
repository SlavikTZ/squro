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
    private $arr =[];
    public function __construct() {
        parent::__construct();
        if(!Register::get('base', 'system')){
            $this->createBase(['name'=>"Корень"]);
        }
        $this->getTree();
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
        debug($this->arr);
    }
    public function add($params){
        $strSQL = "SELECT MAX(`id`) As max FROM `tree`";
        $result = $this->db->query($strSQL);
        $id = $result->fetchArray(SQLITE3_ASSOC);
        
       $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, `name`) 
                                     VALUES(:id, :parent_id, :name)";
         $stmt = $this->db->prepare($strSQL);
         var_dump($params);
         $stmt->bindValue(":id", (int)$id['max']+1, SQLITE3_INTEGER);
         $stmt->bindValue(":parent_id", (int)$params['pid'], SQLITE3_INTEGER);
         $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
    }
    public function rename($params){
        
    }
    public function delete($params){
        
    }
    public function move($params){
        
    }
    private function getTree(){
        $strSQL = "SELECT `id`, `parent_id`, `name` From `tree`";
        if(@!$result = $this->db->query($strSQL)){
                throw new BaseException("Таблица не создана");
            }
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $temp[$row['id']]['name']=$row['name'];
            if($row['parent_id']<>0){
                $temp[$row['parent_id']]['child'][$row['id']] = &$temp[$row['id']];
                
            }else{
                $this->arr[$row['id']]=&$temp[$row['id']];
            }
        }
    }
    public function __destruct(){
        
    }
}