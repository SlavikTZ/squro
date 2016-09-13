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
       $node = new Node($pid);
       $strSQL = "UPDATE `tree` SET `right_key`=`right_key`+2, ".
               "`left_key`= CASE WHEN `left_key`>".$node->right_key.
               " THEN `left_key`+2 ELSE `left_key` END"
                . " WHERE `right_key`>=".$node->right_key;
        $result = $this->db->query($strSQL);
        $newNode = new Node();
        $newNode->parent_id = $node->id;
        $newNode->name = $name;
        $newNode->left_key = $node->right_key;
        $newNode->right_key = $node->right_key+1;
        $newNode->level = $node->level+1;
        $newNode->save();
        return $newNode;
    }
    public function rename($id, $name){
        $node = new Node($id);
        $node->name = $name;
        $node->save();
    }
    public function delete($id){
        $node = new Node($id);
        $strSQL = "DELETE FROM `tree` WHERE  `left_key`>=".$node->left_key
                    ." AND `right_key`<=".$node->right_key;
        $result = $this->db->query($strSQL);
        $new_key = $node->right_key-$node->left_key+1;
        $strSQL = "UPDATE `tree` SET `left_key`= CASE WHEN `left_key` >".$node->left_key
                ." THEN `left_key`-".$new_key." ELSE `left_key` END, `right_key` = "
                ."`right_key`-".$new_key." WHERE `right_key`>".$node->right_key;
        $result = $this->db->query($strSQL);
       
    }
    protected function getTreeSQL() {
        return "SELECT `id`, `parent_id`, `name` FROM `tree` ORDER BY `left_key`";
    }
    public function move($id, $pid, $child=false){
        $node = New Node($id);
        $pNode = New Node($pid);
        
        if($node->left_key<=$pNode->left_key&&$node->right_key>=$pNode->right_key){
            throw new TreeException("Ошибка перемещения ветки");
        }
        
        
        
        if($child){
            $pNode->level +=1;
        }
        if($node->left_key < $pNode->left_key && $node->right_key>$pNode->right_key){
                throw new TreeException("Невозможно переместить данный узел");
           }
        $right_key_near = $pNode->right_key-1;
        $left_key_near = $pNode->left_key;
        $level_up = $pNode->level+1;
        $skew_level = $level_up-$node->level;
        $skew_tree = $node->right_key-$node->left_key+1;
        $skew_edit = $right_key_near-$node->left_key+1;
//        echo "level_up=".$level_up."<br/>";
//        echo "right_key_near=".$right_key_near."<br/>";
//        echo "left_key_near=".$left_key_near."<br/>";
//        echo "skew_level=".$skew_level."<br/>";
//        echo "skew_tree=".$skew_tree."<br/>";
//        echo "skew_edit".$skew_edit."<br/>";
        
        if($right_key_near<$node->right_key){
            $strSQL = "UPDATE `tree`"
                . " SET `right_key` = CASE WHEN `left_key` >=".$node->left_key
                . " THEN `right_key` + ".$skew_edit
                . " ELSE CASE WHEN `right_key` < ".$node->left_key
                . " THEN `right_key` + ".$skew_tree." ELSE `right_key` END END,"
                . " `level` = CASE WHEN `left_key` >= ".$node->left_key." THEN `level` + ".$skew_level." ELSE `level` END,"
                . " `left_key` = CASE WHEN `left_key` >= ".$node->left_key." THEN `left_key`+ ".$skew_edit
                . " ELSE CASE WHEN `left_key` > ".$right_key_near." THEN `left_key` + ".$skew_tree
                . " ELSE `left_key` END END"
                . " WHERE `right_key` > ".$right_key_near." AND `left_key` < ".$node->right_key;
        }else{
            $skew_edit -=$skew_tree; 
            $strSQL = "UPDATE `tree`"
                . " SET `left_key` = CASE WHEN `right_key` <= ".$node->right_key
                . " THEN `left_key` + ".$skew_edit
                . " ELSE CASE WHEN `left_key` > ".$node->right_key
                . " THEN `left_key` - ".$skew_tree." ELSE `left_key` END END,"
                . " `level` = CASE WHEN `right_key` <= ".$node->right_key." THEN `level` + ".$skew_level." ELSE `level` END,"
                . " `right_key` = CASE WHEN `right_key` <= ".$node->right_key." THEN `right_key`+ ".$skew_edit
                . " ELSE CASE WHEN `right_key` <= ".$right_key_near." THEN `right_key` - ".$skew_tree.""
                . " ELSE `right_key` END END"
                . " WHERE `right_key` > ".$node->left_key." AND `left_key` <= ".$right_key_near;
        }
            $this->db->query($strSQL);
            $newNode = new Node($node->id); 
           //$newNode->parent_id=$pNode->id;
           $newNode->parent_id=$pNode->id;
        $newNode->save();
        return "ok";    
    }
    public function test(){
       
    }
    
    
    
}
