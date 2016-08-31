<?php
return [
            '^tree\/?$'=>'tree/view', 
            '^(tree)/([a-z]+)'=>'$1/$2',
            '(3/tree/)([a-z]+)'=>'tree/$2',
             '^$'=>"tree/view",
        ];