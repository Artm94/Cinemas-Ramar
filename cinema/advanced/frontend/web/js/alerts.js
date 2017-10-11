function showDangerBox(title, message){
	var modal;
	modal = '<div id="alert-box" class="modal fade danger-notification" data-keyboard="false" data-backdrop="static" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body"> <div class="media"> <div class="media-left"><img src="img/custom_message/danger.png" class="media-object" style="width:60px"></div><div class="media-body"><h4 class="media-heading">'+title+'</h4><p>'+message+'</p></div></div></div><div class="modal-footer danger-footer" style="background: rgb(216,0,39);"><button id="close-box-button" data-dismiss="modal" class="btn button-danger" style="background: white;">Cerrar</button></div></div></div></div>';
	$('body > div').last().after(modal);
	$('#alert-box').modal();
}

function showSucessBox(title, message){
	var modal;
	modal = '<div id="alert-box" class="modal fade sucess-notification" data-keyboard="false" data-backdrop="static" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body"> <div class="media"> <div class="media-left"><img src="img/custom_message/sucess.png" class="media-object" style="width:60px"></div><div class="media-body"><h4 class="media-heading">'+title+'</h4><p>'+message+'</p></div></div></div><div class="modal-footer sucess-footer" style="background: rgb(145,220,90);"><button id="close-box-button" data-dismiss="modal" class="btn button-sucess" style="background: white;">Cerrar</button></div></div></div></div>';
	$('body > div').last().after(modal);
	$('#alert-box').modal();
}

function showWarningBox(title, message){
	var modal;
	modal = '<div id="alert-box" class="modal fade warning-notification" data-keyboard="false" data-backdrop="static" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body"> <div class="media"> <div class="media-left"><img src="img/custom_message/warning.png" class="media-object" style="width:60px"></div><div class="media-body"><h4 class="media-heading">'+title+'</h4><p>'+message+'</p></div></div></div><div class="modal-footer warning-footer" style="background: rgb(255,218,68);"><button id="close-box-button" data-dismiss="modal" class="btn button-warning" style="background: white;">Cerrar</button></div></div></div></div>';
	$('body > div').last().after(modal);
	$('#alert-box').modal();
}

function showInfoBox(title, message){
	var modal;
	modal = '<div id="alert-box" class="modal fade info-notification" data-keyboard="false" data-backdrop="static" role="dialog"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-body"> <div class="media"> <div class="media-left"><img src="img/custom_message/info.png" class="media-object" style="width:60px"></div><div class="media-body"><h4 class="media-heading">'+title+'</h4><p>'+message+'</p></div></div></div><div class="modal-footer info-footer" style="background: rgb(0,109,240);"><button id="close-box-button" data-dismiss="modal" class="btn button-info" style="background: white;">Cerrar</button></div></div></div></div>';
	$('body > div').last().after(modal);
	$('#alert-box').modal();
}

$('body').on('hidden.bs.modal', '#alert-box', function() { 
      $('#alert-box').remove();
});