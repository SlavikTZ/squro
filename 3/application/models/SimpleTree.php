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
    public function create($params){
         $data = Register::getSection('db');
        if(!Register::get('base', 'system')){
         $strSQL = "CREATE TABLE IF NOT EXISTS `tree` (
                        `id` INTEGER INTEGER PRIMARY KEY NOT NULL,
                        `parent_id` INTEGER DEFAULT NULL,
                        `name` TEXT DEFAULT NULL)";
         $this->db->exec($strSQL);
         $strSQL = "INSERT INTO `tree`(`id`, `parent_id`, 
                                        `name`) 
                                     VALUES(1, NULL, :name)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
        }
    }
    public function view($params){
        
    }
    public function add($params){
        
    }
    public function rename($params){
        
    }
    public function delete($params){
        
    }
    public function move($params){
        
    }
}
