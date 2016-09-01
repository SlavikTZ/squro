$(function(){
   var Tree = {
       triger: function(){
           var exp = $(this).parent();
               if(exp.hasClass('ExpandOpen')){
                   exp.removeClass('ExpandOpen').addClass('ExpandClosed');
               }else if(exp.hasClass('ExpandClosed')){
                  exp.removeClass('ExpandClosed').addClass('ExpandOpen');
              }
        },
         deleteNode: function(){
            
        },
        addDropElement: function(event){
            el = $(this);
            el.addClass('drop');
        }
   }
 //Раскрыть закрыть узлы   
    $('#tree') .on('click', '.Expand', Tree.triger);
 
    // Редактировать узел
   $('#tree') .on('dblclick', 'div.Content', function(el){
       var id = $(this).data('id');
       var context = $(this).text();
       $(this).replaceWith("<input class = 'Content' data-id='"+id+"' data-context ='"+context+"' value = '"+ context+"'>");
       $('input.Content').focus();
   });
     
    $('#tree') .on('keypress', 'input.Content', function(el){
       if(el.which===13){
           var obj = $(this)
           var id = obj.data('id');
           var context = obj.val();
           $.ajax({
                     url: 'tree/rename',
                     method: 'GET',
                     data:{"id":id, name:context},
                     success: function(res){
                          obj.replaceWith("<div class = 'Content' data-id='"+id+"'>"+ context+"</div>");
                     },
                     error: function(){
                         console.log("Ошибка");
                     } 
           });
        }  
   });
   
   $('#tree') .on('blur', 'input.Content', function(el){
       var obj = $(this)
       var id = obj.data('id');
       var context = obj.data('context');
       obj.replaceWith("<div class = 'Content' data-id='"+id+"'>"+ context+"</div>");
   });

        //Добавить, удалить, переместить
   $('#tree').on('mousedown','div.Content', function(event){
       if(!event){
           event = window.event;
           alert('window');
       }
            if(event.button==2){
                event.stopPropagation();
                window.oncontextmenu = (function(event){
                    return false;
                });
                
                var obj = $(this);
                obj.css({position:"relative"});
                var id = obj.id;
                $(".menu").appendTo(obj).css({display:"block"});
            }else if((event.witch===1)&&event.ctrlKey){
                var node = $(this).parent();
                node.addClass('move');
                if(node.hasClass('ExpandOpen')){
                    node.toggleClass("ExpandOpen ExpandClosed");
                    
                }
                node.children('.Expand').remove();
                node.draggable({
                                containment:'#tree',
                                revert:true,
                                stop:function(event, ui){
                                    var node = $(this);
                                    node.prepend("<div class='Expand'");
                                    node.removeClass('move');
                                },
                              });
                $('move').trigger('mosemove');
                $('.Content').droppable({hoverClasss:"drop-el"});
            }
   });
 
    $('#tree').on('click','div.add', function(event){
           var obj = $(this).parent()
                            .css({display:'none'})
                            .parent()
                            .css({position:"static"});
           var id = obj.data('id');
           $.ajax({
                     url: 'tree/add',
                     method: 'GET',
                     data:{pid:id},
                     success: function(res){
                         var expand = obj.parent();
                            if(expand.hasClass('ExpandClosed')){
                                expand.addClass('ExpandOpen').removeClass('ExpandClosed');
                            }
                         data = JSON.parse(res);
                          console.log();
                         if(!obj.next('.child').size()){
                             $("<ul class='child'></ul>").insertAfter(obj);
                             obj.parent().removeClass('ExpandLeaf').addClass('ExpandOpen');
                         }
                         obj.next(".child").append("<li class='Node ExpandLeaf'><div class='Expand'>"+
                                 "</div><input class = 'Content' data-id='"+data.id+
                                 "' data-context ='"+data.name+"' value = '"+ data.name+"'></li>");
                                $('input.Content').focus();
                     },
                     error: function(){
                         console.log("Ошибка");
                     }
            });   
   });
   
   $('#tree').on('click','div.delete', function(event){
                var modal = $(this).parent();
                var obj = modal.parent().css({position:"static"});
                modal.css({display:'none'}).appendTo($("body"));
           
           $.ajax({
                     url: 'tree/delete',
                     method: 'GET',
                     data:{id:obj.data('id')},
                     success: function(res){
                       var node = obj.parent();
                       var ulChild = node.parent();
                         if(res==0){
                             parentNode = ulChild.parent();
                             parentNode.removeClass("ExpandOpen").addClass("ExpandLeaf");
                             ulChild.remove();
                         }
                         node.remove();
                     },
                     error: function(){
                         console.log("Ошибка");
                     }
         });   
   });
   
   
});


