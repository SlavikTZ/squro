<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControllerTree
 *
 * @author Slavik
 */
class ControllerTree extends Controller{
        public function actionAdd(){
            $tree = new NestedTree();
            $optTree = Register::getSection("tree");
            $name = isset($_GET['name']) ? $_GET['name']:$optTree['name'];
            $pid = (int) isset($_GET['pid']) ? $_GET['pid']:$optTree['pid'];
            $node = $tree->add($name, $pid);
            
            if($this->isAjax()){
                $child = $node->getCountChildren($pid);
                $data = ['id'=>$node->id, 'name'=>$name];
                echo json_encode($data);
                return;
            }else{
                $this->actionView();
            }
            
        }
        public function actionDelete(){
            
            if(isset($_GET['id'])){
               $id = $_GET['id'];
               $tree = new NestedTree();
               //$pid = $tree->getParent($id);
               $tree->delete($id);
               if($this->isAjax()){
                   echo $tree->countChild($pid);
                   return;
                   }
                $this->actionView();
            }
            return false;
        }
        //public function actionCreate(){
        //    $tree = new SimpleTree();
        //    $name = isset($_GET['name']) ? $_GET['name']:"Корень";
        //    $tree->create(compact('name'));

        //}
        public function actionRename(){
            if(isset($_GET['id'])&&isset($_GET['name'])){
               $id = $_GET['id'];
               $name = $_GET['name'];
               $tree = new NestedTree();
               $tree->rename($id, $name);
                   
                   if($this->isAjax()){
                       return;
                   }
                $this->actionView();
            }
            
        }
        public function actionMove(){
            if(isset($_GET['id'])&&isset($_GET['pid'])){
               $pid = $_GET['pid'];
               $id = $_GET['id'];
               if(isset($_GET['pos'])&&$_GET['pos']==='child'){
                   $child=true;
               }else{
                   $child=false;
               }
               $tree = new NestedTree();
               $result = $tree->move($id, $pid, $child);
                if($this->isAjax()){
                   echo $result;
                   return;
                }
               $this->actionView();
            }
        }
        public function actionView(){
            $tree = new NestedTree();
            $context = $tree->view(NULL);
            //Напишу клас представления, которому передается файл представления и данные дерева
            include '../application/view/tree.php';
        }
        public function actionTest(){
//            $newNode = new Node();
//            $newNode->parent_id=1;
//            $newNode->name="Новый элемент";
//            $newNode->left_key = 2;
//            $newNode->right_key = 2;
//            $newNode->level = 2;
//            
//            $newNode->save();
        }
}
