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
    public function view($id);
    public function add($name, $pid);
    public function rename($id, $name);
    public function delete($id);
    public function move($id, $pid, $pos);
    //put your code here
}
