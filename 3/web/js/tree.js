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
   }
  $('#tree') .on('click', '.Expand', Tree.triger);
   $('#tree') .on('dblclick', 'div.Content', function(el){
       var id = $(this).data('id');
       var context = $(this).text();
       $(this).replaceWith("<input class = 'Content' data-id='"+id+"' data-context ='"+context+"' value = '"+ context+"'>");
       $('input.Content').focus();
//       $.ajax({
//         url: 'delete',
//         method: 'GET',
//         data:{"id":id},
//         success: function(res){
//
//         },
//         error: function(){
//             console.log("Ошибка");
//         } 
//       });
   });
   
   $('#tree') .on('keypress', 'input.Content', function(el){
       if(el.which===13){
           var obj = $(this)
           var id = obj.data('id');
           var context = obj.val();
           $.ajax({
                     url: 'rename',
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
   
   $('#tree').on('mousedown','div.Content', function(event){
            if(event.button==2)
            {
                event.stopPropagation();
                window.oncontextmenu = (function(event){
                    return false;
                });
                var obj = $(this);
                obj.css({position:"relative"});
                var id = obj.id;
                $(".menu").appendTo(obj).css({display:"block"});
            }
   });
   $('#tree').on('click','div.add', function(event){
           var obj = $(this).parent()
                            .css({display:'none'})
                            .parent()
                            .css({position:"static"});
           var id = obj.data('id');
           $.ajax({
                     url: 'add',
                     method: 'GET',
                     data:{pid:id},
                     success: function(res){
                         var expand = obj.parent();
                            if(expand.hasClass('ExpandClosed')){
                                expand.addClass('ExpandOpen').removeClass('ExpandClosed');
                            }
                         data = JSON.parse(res);
                         if(data.child===1){
                             $("<ul class='child'></ul>").insertAfter(obj);
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
           var obj = $(this).parent()
                            .css({display:'none'})
                            .parent()
                            .css({position:"static"});
           var id = obj.data('id');
           $.ajax({
                     url: 'delete',
                     method: 'GET',
                     data:{id:id},
                     success: function(res){
                         var leaf = obj.parent();
                         if(leaf)
                        
                     },
                     error: function(){
                         console.log("Ошибка");
                     }
         });   
   });
});


