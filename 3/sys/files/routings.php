<?php
return [
             '(tree)/([a-z]+)((/([0-9a-z]+))+)'=>'$1/$2$3',
             '(tree)/([a-z]+)'=>'$1/$2',
             '^$'=>"tree/view",
        ];