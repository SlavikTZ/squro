<?php
error_reporting(E_ALL);
$arr = range(0,12);
$arr['x']="";
$arr['y']="1";
$arr['7']="";
function getTable($arr, $numColumn=7){
    if(is_array($arr)&&($count = count($arr))!==0){
        $rows = ceil($count/$numColumn);
        $str = "<table border=1>\n";
        $str .= "\t<tr>";
        $i=0;
            foreach($arr as $value){
                $i++;
                $tmp = ($value!=="") ? $value:"";
                $str .="\n\t\t<td>".$tmp."</td>";
                    if($i%$numColumn===0){
                        $str .="\n\t</tr>\n\t<tr>";
                    }   
                
                
            }
            for($i; $i<$rows*$numColumn; $i++){
                $str .="\n\t\t<td class=\"notArr\"></td>";
            }
        $str.="\n\t</tr>\n</table>";
        return $str;
    }
}?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>1</title>
        <style>
            td{
                //border: 1px solid black;
                padding: 25px;
            }
            td.notArr{
                background: red;
            }
        </style>
    </head>
    <body>
        <?= getTable($arr); ?>    
    </body>
</html>



