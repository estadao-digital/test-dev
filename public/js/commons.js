var ajaxCompleteLoad = false;
var maxSizeToResizeAuto = 600

disableAjaxCompleteLoad = function() 
{
    ajaxCompleteLoad = true;
};

enableAjaxCompleteLoad = function() 
{
	ajaxCompleteLoad = false;
};

$(document).ajaxStart(function(){
    if (ajaxCompleteLoad === false)        
    	initLoad();
});

$(document).ajaxStop(function(){
	closeLoad();
});

initLoad = function()
{
    maskHeight = $(document).height();
	maskWidth = $(window).width();
	$('body').append('<div id="pask_modal"></div>');
	$('#pask_modal').css({'width':maskWidth,'height':maskHeight,'position':'absolute','z-index':'9999999','top':'0', 'background-color':'#000'});
	$('#pask_modal').fadeIn(0);	
	$('#pask_modal').fadeTo("fast",0.8);
	
	$('body').append('<div id="load-page"></div>');
	$('#load-page').css({'width':maskWidth,'height':maskHeight,'position':'absolute','z-index':'999999999999999999999999'});
	$('#load-page').fadeIn(0);	
	$('#load-page').fadeTo("fast",0.8);

	$('body').append('<div id="center-load"><img src="'+urlPath+'/images/load.gif" /></div>');

	winH = $(window).height();
	winW = $(window).width();
    $("#center-load").css({'top': 10, 'left': (winW-150)/2,'position':'absolute','z-index':'99999999999999999999'});
	$('html, body').animate({scrollTop: '0px'}, 350);
};

closeLoad = function()
{
	$('#load-page').hide('fast', function(){
		$("#center-load").remove();
		$('#load-page').remove();
		$('#pask_modal').remove();
	});
};

blockPage = function (){
	maskHeight = $(document).height();
	maskWidth = $(window).width();
	$('body').append('<div id="pask_modal_block"></div>');
	$('#pask_modal_block').css({'width':maskWidth,'height':maskHeight,
	'position':'absolute','z-index':'99','top':'0', 'background-color':'#000'});
	$('#pask_modal_block').fadeIn(0);	
	$('#pask_modal_block').fadeTo("slow",0.8);
}

closeBlockPage = function(){
	$('#pask_modal_block').remove();
}

blockPageModal = function (){
	maskHeight = $(document).height();
	maskWidth = $(window).width();
	$('body').append('<div id="pask_modal_block_modal"></div>');
	$('#pask_modal_block_modal').css({'width':maskWidth,'height':maskHeight,
	'position':'absolute','z-index':'99','top':'0', 'background-color':'#000'});
	$('#pask_modal_block_modal').fadeIn(0);	
	$('#pask_modal_block_modal').fadeTo("slow",0.8);
}

closeBlockPageModal = function(){
	$('#pask_modal_block_modal').remove();
}


successDialog = function( width , height , bodyMessage , functionCalbackToCloseParam ){
    constructModalMessage( width , height , "Sucesso" , bodyMessage , functionCalbackToCloseParam )	
}

errorDialog = function( width , height , bodyMessage , functionCalbackToCloseParam ){
	constructModalMessage( width , height , "Erro" , bodyMessage ,  functionCalbackToCloseParam )
}

cautionDialog = function( width , height , bodyMessage , functionCalbackToCloseParam  ){
   constructModalMessage( width , height , "Notificação" , bodyMessage , functionCalbackToCloseParam )
}

confirmationDialog = function( width , height , bodyMessage , functionCalbackToConfirmParam  ){
   constructModalConfirmation( width , height , "Confirmação" , bodyMessage , functionCalbackToConfirmParam )
}

openModalWindow = function( width , height , titleMessage ,bodyMessage ){
   constructModalWindow( width , height , titleMessage , bodyMessage  )
}


constructModalMessage = function( width , height, titleMessage ,bodyMessage , functionCalbackToClose ){
    originalWidth = width
    dialogNameId = 'dialog_messages'
    modalStr='<div id="'+dialogNameId+'" title="'+titleMessage+'" style="z-index:9888888888">'
    modalStr+='<p>'+bodyMessage+'</p>'
    modalStr+='</div>'
   
    $('body').append(modalStr)
    
    $( "#"+dialogNameId ).dialog({
        modal: true,
        width: $(window).width() > maxSizeToResizeAuto ? width : 'auto',
        height: height,
        draggable: false,
        fluid: true,
        position: { my: "center top", at: "center top", of: window },
        show: {
            effect: 'fade',
            duration: 800
        },
        hide: {
            effect: 'fade',
            duration: 600
        }, 
        buttons: {
            Ok: function() {
                    $( this ).remove()
                    $('#'+dialogNameId).remove()
                    closeBlockPage()
                    evalCallBackFunction( functionCalbackToClose )
                }
            },
            close: function() {
                $( this ).remove()
                $('#'+dialogNameId).remove()
                closeBlockPage()
                evalCallBackFunction( functionCalbackToClose )
            }
    });

}

constructModalConfirmation = function( width , height, titleMessage ,bodyMessage , functionCalbackToConfirm ){
    originalWidth = width
    dialogNameId = 'dialog_confirm'
    modalStr='<div id="'+dialogNameId+'" title="'+titleMessage+'" style="z-index:9888888888">'
    modalStr+='<p>'+bodyMessage+'</p>'
    modalStr+='</div>'

    $('body').append(modalStr)
    
    $( "#"+dialogNameId ).dialog({
        modal: true,
        width: $(window).width() > maxSizeToResizeAuto ? width : 'auto',
        height: height,
        draggable: false,
        fluid: true,
        position: { my: "center top", at: "center top", of: window },
        show: {
            effect: 'fade',
            duration: 800
        },
        hide: {
            effect: 'fade',
            duration: 600
        }, 
        buttons: {
                "Confirmo": function() {
                    evalCallBackFunction( functionCalbackToConfirm )
                    $('#'+dialogNameId).remove()
                    closeBlockPage()
                },
                "Cancelar": function() {
                    $('#'+dialogNameId).remove()
                    closeBlockPage()
                }
            },
            close: function() {
                $( this ).remove()
                $('#'+dialogNameId).remove()
                closeBlockPage()
            }
    });
   
    blockPage()
}

constructModalWindow = function( width , height, titleMessage ,bodyMessage , functionCalbackToConfirm ){
    originalWidth = width
    dialogNameId = 'dialog_modal'
    modalStr='<div id="'+dialogNameId+'" title="'+titleMessage+'" style="z-index:98888888">'
    modalStr+= bodyMessage
    modalStr+='</div>'

    $('body').append(modalStr)
    
    $( "#"+dialogNameId ).dialog({
        modal: true,
        width: $(window).width() > maxSizeToResizeAuto ? width : 'auto',
        height: height,
        draggable: false,
        fluid: true,
        position: { position: 'top' },
        show: {
            effect: 'fade',
            duration: 800,
        },
        hide: {
            effect: 'fade',
            duration: 600
        }, 
        close: function() {
                $( this ).remove()
                $('#'+dialogNameId).remove()
                closeBlockPageModal()
            }
    });
    
    blockPageModal()
}


closeModalPage = function(){
    $('#dialog_modal').remove()
    blockPage()
}

evalCallBackFunction = function( functionParam ){
    var closeCallback = eval(functionParam)
}

windowLocation = function(url){
    $(location).attr('href', url)
}

str_pad = function(input, length, string) {
    string = string || '0'; input = input + '';
    return input.length >= length ? input : new Array(length - input.length + 1).join(string) + input;
}

str_replace_recursive = function( findStr , replaceStr ,stringComplete ){
    var regex = new RegExp(findStr, 'g');
    return messageError = stringComplete.replace(regex, replaceStr);
}

resizeModalObserver = function(){
    
    $(window).resize(function() {
        $("#dialog_modal").dialog("option", "position", "center"); 
        $("#dialog_modal").dialog({
            width: $(window).width() > maxSizeToResizeAuto ? originalWidth : 'auto',
        });
        $("#dialog_confirm").dialog("option", "position", "center"); 
        $("#dialog_confirm").dialog({
            width: $(window).width() > maxSizeToResizeAuto ? originalWidth : 'auto',
        });
        $("#dialog_messages").dialog("option", "position", "center"); 
        $("#dialog_messages").dialog({
            width: $(window).width() > maxSizeToResizeAuto ? originalWidth : 'auto',
        });

        winWRes = $(window).width();
        $(".ui-dialog").css( 'left', (winWRes-150)/3 );
    });
    
}

resizeModalObserver();