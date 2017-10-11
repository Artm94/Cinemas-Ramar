$(function(){
	$(document).on('click', '.language', function(){
		console.log('hola');
		var lang = $(this).attr('id');
		console.log(lang);
		
		$.post('index.php?r=site/language',{'lang':lang},function(data){
		console.log('do it');
			
		
		location.reload();
		});
	});
});

$(function(){
	$(document).on('click','.fc-day',function(){
		var date = $(this).attr('data-date');
		$.get('index.php?r=event/create', {'date' : date}, function(data){
			$('#modal').modal('show')
			.find('#modalContent')
			.html(data);
		});
	});

	$('#modalButton').click(function(){
		$('#modal').modal('show')
		.find('#modalContent')
		.load($(this).attr('value'));
	});
});