<?php
    error_reporting(E_ALL);
    class ArrExeption extends Exception{};
    
    class Arr{
        private $_arr;
        public function __construct($arr) {
            if(is_array($arr)){
                foreach($arr as $key=>$value){
                    $this->_arr[$key]=$value;
                }
            }else if(is_nan($arr)||$arr!==0){
                for($i=0; $i<$arr; $i++){
                    $this->_arr[$i]=$i;
                }
            }else{
                throw new ArrException("Error");
            }
        }
       public function viewTable($numCol=7){
           $str = "<tr>";
           $i=1;
           print_r($this->_arr);
           foreach($this->_arr as $value){
               if($i%$numCol){
                   $str+="</tr><tr>";
               }
               $str+="<td>".$value."</td>";
           }
           $str += "</tr>";
           echo $str;
       }
    }
