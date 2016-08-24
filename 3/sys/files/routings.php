<?php
return [
             '([a-z]+)/([a-z]+)((/([0-9a-z]+))+)'=>'$1/$2$3',
             '([a-z]+)/([a-z]+)'=>'$1/$2',
             'test'=>'test/test',
             '([a-z]+)'=>'$1/index',
             '^$'=>"index/index",
        ];