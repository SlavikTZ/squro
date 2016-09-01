<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Tree
 *
 * @author user
 */
abstract class Tree extends Model implements iTree{
    public function __construct() {
        parent::__construct();
        if(!Register::get('base', 'system')){
            $this->createBase("Корень");
        }
    }
    abstract protected function createBase($name);
    public function view($id=null){
        $tree = $this->getTree();
        return $this->getHTML($tree);
    }
    protected function getTree(){
        $strSQL = $this->getTreeSQL();
        if(@!$result = $this->db->query($strSQL)){
                throw new BaseException("Таблица не создана");
            }
        while($row = $result->fetchArray(SQLITE3_ASSOC)){
            $temp[$row['id']]['name']=$row['name'];
            $temp[$row['id']]['id']=$row['id'];
            if($row['parent_id']<>0){
                $temp[$row['parent_id']]['child'][$row['id']] = &$temp[$row['id']];
                
            }else{
                $tree[$row['id']]=&$temp[$row['id']];
                $tree[$row['id']]['root']='1';
            }
        }
        return $tree;
    }
    abstract protected function getTreeSQL();
    protected function getHTML($tree){
        $str = "";
        foreach($tree as $node){
            $str.=$this->echoNode($node);
        }
        return $str;
    }
    protected function echoNode($node){
        ob_start();
        include "../application/template/test.php";
        return ob_get_clean();
    }
}
