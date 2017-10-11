$(function(){

  $(document).on('click','.language', function(){
	  console.log('hola');
     var lang = $(this).attr('id');
     $.post('index.php?r=site/language', {'lang':lang},function(data){
    location.reload();  
  });
}); 




    $(document).on('click','.fc-day',function(){
        var date = $(this).attr('data-date');
        
        $.get('index.php?r=event/create',{'date':date},function(data){
                $('#modal').modal('show')
                .find('#modalContent')
                .html(data);
        });
        
        
    });


$('#modalButton').click(function(){
    //get the click of the create button.
    $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
});
});