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
            $tree->add(compact('name', 'pid'));
            $this->actionView();
        }
        public function actionDelete(){

        }
        //public function actionCreate(){
        //    $tree = new SimpleTree();
        //    $name = isset($_GET['name']) ? $_GET['name']:"Корень";
        //    $tree->create(compact('name'));

        //}
        public function actionRemove(){
            
        }
        public function actionMove(){

        }
        public function actionView(){
            $tree = new SimpleTree();
            $context = $tree->view(NULL);
            include '../application/view/tree.php';
        }
}
