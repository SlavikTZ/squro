<?php include 'table.php' ?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Document1</title>
    </head>
    <body>
        <table border=1 cellspacing="0">
            <?php 
                $table = new Arr(10); 
                $table->viewTable();
            ?>
        </table>

    </body>
</html>