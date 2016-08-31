<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Object
 *
 * @author user
 */
abstract class Object extends Model{
    //Доделать: нужно сделать запрос, чтобы получить названия столбцов из базы
    protected $_lablesTable = [];
    protected $_valuesTable = [];
    protected $_types = [
                           "INTEGER"=>SQLITE3_INTEGER,
                           "TEXT"=>SQLITE3_TEXT
                        ];
    protected $_tableName;
    abstract protected function getTable();
    public function __construct($id){
        parent::__construct();
        $this->_tableName=$this->getTable();
        $this->_getLabels();
        if($id){
            if(!$this->_select($id)){
                return null;
            }else{
            }
        }else{
            $this->_valuesTable['id']=null;
        }
        
    }
    public function __get($name){
        if(array_key_exists($name, $this->_lablesTable)){
            return  $this->_valuesTable[$name];
        }else{
            new ObjectException("Ошибка объекта");
        }
    }
    public function __set($name, $value) {
        if(array_key_exists($name, $this->_lablesTable)){
            $this->_valuesTable[$name]=$value;
        }else{
            new ObjectException("Ошибка объекта");
        }
    }
    private function _getLabels(){
        $strSQL = "PRAGMA table_info(`{$this->_tableName}`)";
        $result = $this->db->query($strSQL);
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $this->_lablesTable[$row['name']]=$row['type'];
        }
        
    }
    public function save(){
        if($this->id===null){
            $this->_insert();
        }
    }
    private function _insert(){
        $strSQL = "INSERT INTO `{$this->_tableName}`(";
        
            foreach ($this->_lablesTable as $key=>$value){
                $strSQL .= "`".$key."`, ";
            }
            
            $strSQL = substr($strSQL, 0, strlen($strSQL)-2)
                            .") VALUES(NULL";
            
            foreach ($this->_lablesTable as $key=>$value){
                if($key!=='id') $strSQL .= ", :".$key;
            }
            $strSQL .= ")";
            $stmt = $this->db->prepare($strSQL);
            foreach($this->_valuesTable as $key=>$value){
                if($key!=='id'){
                   $stmt->bindValue(":".$key, $value, $this->_types[$this->_lablesTable[$key]]); 
                } 
            }
             if(!$result=$stmt->execute()){
                    throw new Exception("Ошибка базы данных");
            }
            
            $strSQL = "SELECT LAST_INSERT_ID()";
            debug($this->db->query($strSQL));
    }
    private function _update(){
        
    }
    private function _select($id){
        $strSQL = "SELECT * FROM `{$this->_tableName}` WHERE id={$id}";
        $result = $this->db->query($strSQL);
        if(!$result){
            return false;
        }
        while($columns = $result->fetchArray(SQLITE3_ASSOC)){
            foreach($columns as $column=>$value){
                $this->_valuesTable[$column]=$value;
            }
        }
    }
}
