<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 *
 * @author user
 */
abstract class Model{
    protected $db;
    
    public function __construct(){
      $this->db=Db::Connection(); 
    }
    public function __destruct(){
        $this->db->close();
    }
    //put your code here
}
