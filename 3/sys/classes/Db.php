<?php

class Db {
    static private $db;
    private function __construct(){
        $db = Register::getSection("db");
        if(file_exists($db['path'].$db['file'])){
            Register::set('base', true);
        }else{
            Register::set('base', false);
        }
        if($db['database']==='sqli3'){
        self::$db = new MySQLite3($db['path'].$db['file']);
        }else{
            //другое подключение 
            }
        }
        
    static function connection(){
        if(!self::$db){
            new Db();
        }
        return self::$db;
    }
   
    public function __destruct(){
    }
    //put your code here
}
