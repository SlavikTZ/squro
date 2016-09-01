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
    static private $numConection =0;
    public function __construct(){
      $this->db=Db::Connection();
      self::$numConection++;
    }
    public function __destruct()
    {
        self::$numConection--;
        if(self::$numConection===0){
            $this->db->close();
        }
    }
    //put your code here
}
