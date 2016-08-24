<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Register
 *
 * @author user
 */
class Register {
    const FILE = "../sys/files/settings.ini";
    static private $settings = array();
    private function __construct(){
        
    }
    static public function init(){
        if(!file_exists(self::FILE)){
            throw new FileException("settings.ini not found");
        }
        self::$settings = parse_ini_file(self::FILE,true);
    }
    static public function get($key,$section){
        return self::$settings[$section][$key];
    }
    static public function getSection($section){
        return self::$settings[$section];
    }
    static public function set($key, $value, $section="system"){
        self::$settings[$section][$key]=$value;
    }
    static public function echoSettings(){
        print_r(self::$settings);
    }
}
