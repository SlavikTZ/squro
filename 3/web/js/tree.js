var debug = function debug(o){
    console.log(var_dump(o));
}
function classOf(o){
    if(o===null){
        return "Null";
    }else if(o===undefined){
        return "Undefined";
    }else{
      return typeof o;
    }
}
var isArray = function(o){
    return typeof o==="object"&&Object.prototype.toString.call(o)==="[object Array]";
}
function var_dump(o, tab){
    var str = "";
    var type=typeof o;
        if(tab===undefined){
            tab="";
        }
    if(type==="object"){    
        str += "\n"+tab+"{";
            for(prop in o){
                if(typeof o[prop]==="object"){               
                   var tmpTab = tab+"  ";
                   str+="\n  "+tab+prop+":";
                   str+=var_dump(o[prop], tmpTab);
                   str +=",";
                }else{
                    str += "\n  "+tab+prop+": "+o[prop]+",";
                }
            }
            str = str.substr(0,str.length-1);
            str += "\n"+tab+"}";
            return str;
    }else if(type === 'Array'){
        str+="["
        for(var i =0; i<o.length; i++){
            str+=o[i]+", ";
        }
        str+="],";
    }else{
        return o.toString();
    }
}


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
            if(event.which===3){
                event.stopPropagation();
                window.oncontextmenu = (function(event){
                    return false;
                });
                
                var obj = $(this);
                obj.css({position:"relative"});
                var id = obj.id;
                $(".menu").appendTo(obj).css({display:"block"});
                
            }else if((event.which===1)&&event.ctrlKey){
                var node = $(this).parent();
                if(node.hasClass("IsRoot")) return;
                var parentNode = node.parent();
                var tree = $("#tree");
                var memoryNode;
                    if(parentNode.children().length===1){
                        memoryNode=parentNode.parent().removeClass('ExpandClosed ExpandOpen').addClass('ExpandLeaf');
                        node.parent().remove();
                        memoryNode.attr({"data-memory":"child"});
                    }else{
                          if((memoryNode=node.prev()).length!==0){
                            memoryNode.attr({"data-memory":"prev"});
                          }else if((memoryNode= node.next()).length!==0){
                            memoryNode.attr({"data-memory":"next"});
                          }
                    }
                    memoryNode.addClass('memory');
                    var avatar = $('<div class="move">'+node.children('.Content').text()+'</div>');
                    node.appendTo("body").addClass('drag');
                    avatar.appendTo("#tree");
                    var top = parseInt(event.pageY-tree.offset().top-avatar.height()/2);
                    var left = parseInt(event.pageX-tree.offset().left-avatar.width()/2);
                    avatar.css({"left":left,"top":top});
            }
   });
   
   $('#tree').on("mousemove",".move", function(event){
        var avatar = $(this);
        var tree = $("#tree");
        var top = parseInt(event.pageY-tree.offset().top-avatar.height()/2);
        var left = parseInt(event.pageX-tree.offset().left-avatar.width()/2);
        avatar.css({"left":left, "top":top});
        avatar.hide();
        var node = $(document.elementFromPoint(event.clientX, event.clientY));
        avatar.show();
        var idDropCurrent = node.data("id");
        var idDropPrev = avatar.data("id");
            if(node.hasClass("Content")){
                if(idDropCurrent===idDropPrev){
                    
                }else{
                    var prevNode = $("#id"+idDropPrev);
                        if(prevNode.length===1){
                           prevNode.removeClass('hov').removeAttr("id");
                        }
                    avatar.data('id',idDropCurrent);
                    node.addClass('hov');
                    node.attr("id","id"+idDropCurrent);
                }
            }else{
                var prevNode = $("#id"+idDropPrev);
                        if(prevNode.length===1){
                           prevNode.removeClass('hov').removeAttr("id");
                        }
                    avatar.removeData('id');
            }
   });
   
   $('#tree').on("mouseup",".move", function(event){
       var avatar = $(this);
       var pid = avatar.data("id"); 
       var parentContent = $("#id"+pid).removeClass('hov');
       $('.move').remove();
       var memoryNode = $('.memory').removeClass('memory');
       
        //Вернуть всё в исходное состояние    
           if(parentContent.length!==1){
               var node = $(".drag").removeClass('drag');
               if(memoryNode.data('memory')==='child'){
                   memoryNode.addClass('ExpandOpen')
                             .removeClass('ExpandLeaf')
                             .append("<ul class='child'></ul>");
                   memoryNode.children('.child').append(node);
               }else if(memoryNode.data('memory')==='prev'){
                   memoryNode.after(node);
               }else if(memoryNode.data('memory')==='next'){
                   memoryNode.before(node);
               }
               memoryNode.removeAttr('data-memory');
               return;
           }
        //перенести ветку
        memoryNode.removeData('memory');
        var node = $('.drag');
        var id = node.children(".Content").data("id");
        $.ajax({
                     url: 'tree/move',
                     method: 'GET',
                     data:{id:id,pid:pid},
                     success: function(res){
                         if(res==="ok"){
                             var parentNode = parentContent.parent();
                               if(parentNode.children('.child').length===0){
                                    parentNode.append($("<ul class='child'></ul>"))
                                              .removeClass("ExpandLeaf")
                                              .addClass("ExpandOpen");

                               }
                               node.appendTo(parentNode.children('.child')).removeClass('drag');
                        }
                     },
                     error: function(){
                         console.log("Ошибка");
                     }
            });   
        
        
        
        
        
       
       
       
           
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


