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
            $tree = new SimpleTree();
            $optTree = Register::getSection("tree");
            $name = isset($_GET['name']) ? $_GET['name']:$optTree['name'];
            $pid = (int) isset($_GET['pid']) ? $_GET['pid']:$optTree['pid'];
            $id = $tree->add($name, $pid);
            if($this->isAjax()){
                $child = $tree->countChild($pid);
                $data = ['id'=>$id, 'name'=>$name, 'child'=>$child];
                echo json_encode($data);
                return;
            }
            $this->actionView();
        }
        public function actionDelete(){
            
            if(isset($_GET['id'])){
               $id = $_GET['id'];
               $tree = new SimpleTree();
               $pid = $tree->getParent($id);
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
               $tree = new SimpleTree();
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
               $pos = isset($_GET['pos'])&&$_GET['pos']==='sister' ? $_GET['pos']:'child';
               $tree = new SimpleTree();
               $tree->move($id, $pid, $pos);
               $this->actionView();
            }
        }
        public function actionView(){
            $tree = new SimpleTree();
            $context = $tree->view(NULL);
            include '../application/view/tree.php';
        }
}
