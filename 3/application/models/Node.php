<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Node
 *
 * @author user
 */
class Node extends Object{
    public function __construct($id=null) {
        parent::__construct($id);
    }
    public function getCountChildren(){
        $strSQL = "SELECT COUNT(`id`) AS num FROM `{$this->_tableName}` WHERE `parent_id`={$this->id}";
        $result = $this->db->query($strSQL);
        $count = $result->fetchArray(SQLITE3_ASSOC);
        return $count['num'];
    }
    protected function getTable() {
        return "tree";
    }
}
