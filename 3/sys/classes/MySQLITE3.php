<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MySQLITE3
 *
 * @author user
 */
class MySQLITE3 extends SQLITE3{
    static public function strSQL($strSQL,$params){
        if(isset($params)){
            foreach($params as $key=>$value){
                $pattern = "/:".$key."/";
                $strSQL = preg_replace($pattern, $value[0], $strSQL);
            }
          return $strSQL;      
        }
        return "";
    } 
}
