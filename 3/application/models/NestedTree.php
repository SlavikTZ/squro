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
class NestedTree  extends SimpleTree{
    
     public function __construct() {
        parent::__construct();
        if(!Register::get('base', 'system')){
            $this->createBase("Корень");
        }
    }
    public function create($name){
        $data = Register::getSection('db');
        if(file_exists($data['path'].$data['file'])){
         $strSQL = "CREATE TABLE IF NOT EXISTS `tree` (
                        `id` INTEGER INTEGER PRIMARY KEY NOT NULL,
                        `parent_id` INTEGER NOT NULL,
                        `name` TEXT DEFAULT NULL,
                        `left_key` INTEGER NOT NULL,
                        `right_key` INTEGER NOT NULL,
                        `level` INTEGER NOT NULL)";
         $this->db->exec($strSQL);
         $strSQL = "INSERT INTO `tree`(`id`, `name`, `parent_id` 
                                        `left_key`, `right_key`, `level`) 
                                     VALUES(1, 0, :name, 1, 2, 1)";
         $stmt = $this->db->prepare($strSQL);
         $stmt->bindValue(":name", $params['name'], SQLITE3_TEXT);
         $result = $stmt->execute();
         $stmt->close();
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
   private function getHTML(){
       
   }
    public function add($name, $pid){
        
    }
    public function rename($id, $name){
        
    }
    public function delete($id){
        
    }
    public function move($id, $pid, $pos=Null){
        
    }
    
    
    
    
    
}
