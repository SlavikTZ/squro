$(function(){
   var Tree = {
   }
  $('#tree') .on('click', '.Expand', function(){
       var exp = $(this).parent();
       if(exp.hasClass('ExpandOpen')){
           exp.removeClass('ExpandOpen').addClass('ExpandClosed');
       }else if(exp.hasClass('ExpandClosed')){
          exp.removeClass('ExpandClosed').addClass('ExpandOpen');
       }
   });
   $('#tree') .on('click', '.Content', function(el){
       var id = $(this).data('id');
       $.ajax({
         url: 'delete',
         method: 'GET',
         data:{"id":id},
         success: function(res){
             
         },
         error: function(){
             console.log("Ошибка");
         } 
       });
   });
   
});


