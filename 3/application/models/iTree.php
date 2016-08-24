<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author user
 */
interface iTree {
    public function create($params);
    public function view($params);
    public function add($params);
    public function rename($params);
    public function delete($params);
    public function move($params);
    //put your code here
}
