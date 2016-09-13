<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="/3/web/css/new.css">
        <link rel="stylesheet" href="/3/web/css/bootstrap.min.css">
        <title>Tree</title>
         <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    </head>
    <body>
       <div class="wripper">
         <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <ul id="tree">
                        <?= $context; ?>  
                    </ul>
                </div>
                <div class="col-md-5">
                    <div>Код написан от начала до конца полностью. В серверной части используется патерн MVC</div>
                    <div class="help"><span class="glyphicon glyphicon-tree-deciduous"></span>Справка</div>
                    <ul>
                        <li>Добавить(Удалить) элемент правая кнопка мышки</li>
                        <li>Редактировать элемент двойной щелчек мыши, после чего Enter</li>
                        <li>При перемещении CTRL+левая кнопка мышки</li>
                    </ul>
                    <div></div>
                </div>
            </div>
              <div class="menu">
            <div class="add"><span class="glyphicon glyphicon-plus"></span>Добавить</div>
            <div class="delete"><span class="glyphicon glyphicon-remove"></span>Удалить</div>
        </div>
        </div>
          
       </div>
        
        
       <script src="/3/web/js/jquery.js"></script>
       <script src="/3/web/js/jquery-ui.js"></script>
       <script src="/3/web/js/bootstrap.min.js"></script>
       <script src="/3/web/js/tree.js"></script>

    </body>
</html>
