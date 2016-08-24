<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Route
 *
 * @author user
 */
class Route {
    //put your code here
    private $routes;
    const ROUTES_PATH = "../sys/files/routings.php";
    static private $instance;
    private function __construct(){
        $this->routes = include(self::ROUTES_PATH);
    }
    static public function run($uri=null){
        if(!self::$instance){
            self::$instance = new Route();
        }
        self::$instance->start($uri);
    }
    private function start($uri){
        if(!$uri){
            $uri = $this->parseURI();
        }
        $this->_start($uri);
    }
    private function _start($uri){
         
        foreach($this->routes as $pattern=>$path){
            if(preg_match('~'.$pattern.'~', $uri)){
                $route = preg_replace('~'.$pattern.'~', $path, $uri);
                $params = explode("/",$route);
                $nameController = "Controller".ucfirst(array_shift($params));
                $nameAction = "action".ucfirst(array_shift($params));
                $this->checkController($nameController, $nameAction);
                $controllerObject = new $nameController;
                try{
                    call_user_func_array([$controllerObject,$nameAction], $params);
                } catch (PDOException $ex) {
                   echo "-----".$ex->getMessage(); 
                }
                break;
            }
        }
    }
    private function parseURI(){
        $uri = trim(str_replace($_SERVER['QUERY_STRING'], "", $_SERVER['REQUEST_URI']),"/?");
        if($uri==="3"){
            $uri="tree/view";
        }
        return $uri;
    }
    private function checkController($nameController, $nameAction){
        $file = "../application/controllers/".$nameController.".php";
            if(file_exists($file)){
                require_once $file;
                   if(!method_exists($nameController, $nameAction)){
                       throw new FileException("Ошибка выполнения команды");
                   }
            }else{
                throw new FileException("Ошибка выполнения команды");
            }            
    }
}
