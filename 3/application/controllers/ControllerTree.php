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
class ControllerTree {
        public function actionAdd(){
            echo "работает";
        }
        public function actionDelete(){

        }
        public function actionCreate(){
            $model = new SimpleTree();
            $name = isset($_GET['name']) ? $_GET['name']:"root";
            $model->create(compact('name'));

        }
        public function actionRemove(){

        }
        public function actionMove(){

        }
        public function actionView(){
            echo 'view';
        }
}
