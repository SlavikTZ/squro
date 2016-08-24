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
class Tree extends Model{
    
    public function __construct() {
        parent::__construct();
    }
    public function create($params){
        $data = Register::getSection('db');
        if(file_exists($data['path'].$data['file'])){
         $strSQL = "CREATE TABLE IF NOT EXISTS `tree` (
                        `id` INTEGER INTEGER PRIMARY KEY NOT NULL,
                        `name` TEXT DEFAULT NULL,
                        `left_key` INTEGER NOT NULL,
                        `right_key` INTEGER NOT NULL,
                        `level` INTEGER NOT NULL)";
         $this->db->exec($strSQL);
         $strSQL = "INSERT INTO `tree`(`id`, `name`, 
                                        `left_key`, `right_key`, `level`) 
                                     VALUES(1, :name, 1, 2, 1)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
        }
    }
}