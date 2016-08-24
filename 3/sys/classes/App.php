<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
final class App{
    private $_path = array("application" =>"../application",
                            "controller"=>"../application/controllers",
                            "model"=>"../application/models",
                            "core"=> "../sys/classes",
                            "lib"=>"../lib",
                            );
    public function __construct(){
        $this->init();
    }
    private function init(){
        error_reporting(E_ALL|E_STRICT);
        spl_autoload_register([$this,"requireClass"]);
        try{
            Register::init();
            Route::run();
        } catch(FileException $ex){
                echo $ex->getMessage();
            }
            catch (Exception $ex) {
                echo $ex->getMessage();
        }
    }
    private function requireClass($className){
        
        foreach($this->_path as $dir){
          $file =  $dir."/".$className.".php";
            if(file_exists($file)){
                require_once $file;
                return;
            }
        }
        
        
        //throw new Exception("Проверте путь к класу ".$className);
    }
}
