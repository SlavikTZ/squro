<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/3/web/css/new.css">
        <link rel="stylesheet" href="/3/web/css/bootstrap.min.css">
        <title>Tree</title>
    </head>
    <body>
       <div class="wripper">
         <div class="container">
            <div class="row">
                <div class="col-md-9">
                    <ul id="tree">
                        <?= $context; ?>  
                    </ul>
                </div>
                <div class="col-md-3">
                    <span class="glyphicon glyphicon-user"></span>
                </div>
            </div>
        </div>
       </div>
        
        
       <script src="/3/web/js/jquery.js"></script>
       <script src="/3/web/js/bootstrap.min.js"></script>
       <script src ="/3/web/js/tree.js"></script>
    </body>
</html>
