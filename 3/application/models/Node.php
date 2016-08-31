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
    protected function getTable() {
        return "tree";
    }
}
