<?php
return [
            '^tree\/?$'=>'tree/view', 
            '(3/)?(tree/)?(tree/)?([a-z]+)'=>'tree/$4',
             '^$'=>"tree/view",
        ];