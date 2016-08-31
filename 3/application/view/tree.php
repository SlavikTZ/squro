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
                <div class="col-md-7">
                    <ul id="tree">
                        <?= $context; ?>  
                    </ul>
                </div>
                <div class="col-md-5">
                    
                    <div class="help"><span class="glyphicon glyphicon-tree-deciduous"></span>Справка</div>
                    <ul>
                        <li>Добавить(Удалить) элемент правая кнопка миши</li>
                        <li>Редактировать элемент двойной щелчек мыши, после чего Enter</li>
                        <li>При перемещении, будет не упорядоченый список элементов(нужно использовать nod sets), можно сделать</li>
                    </ul>
                </div>
            </div>
              <div class="menu">
            <div class="add"><span class="glyphicon glyphicon-plus"></span>Добавить</div>
            <div class="delete"><span class="glyphicon glyphicon-remove"></span>Удалить</div>
        </div>
        </div>
          
       </div>
        
        
<!--       <script src="/3/web/js/jquery.js"></script>-->
<!--       <script src="/3/web/js/jquery-ui.js"></script>-->
<!--       <script src="/3/web/js/bootstrap.min.js"></script>-->
       <!--<script src="/3/web/js/tree.js"></script>-->

    </body>
</html>
