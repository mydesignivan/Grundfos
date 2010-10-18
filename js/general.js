$(function(){
    
});

var CV = {
    open : function(){
        var div = $('<div class="form-cv"><div class="top"></div><div class="middle"><div class="align-center"><img src="images/ajax-loader2.gif" alt="Cargando..." width="100" height="100" /></div></div><div class="bottom"></div></div>');
        div.modal({
            opacity  : '50',
            persist  : true,
            position : ['15%',],
            onOpen   : CV._on_open,
            onClose  : CV._on_close
        });
    },
    _on_open : function(dialog){
        dialog.container.show();
        dialog.data.show();

        dialog.overlay.fadeIn('slow', function () {
            $.get(get_url('index/ajax_show_formcv'), function(data){
                dialog.data.find('.middle').html(data);
                dialog.container.animate({height : dialog.data.height()+'px'}, 500);
                $('#btnCancel').click(function(){$.modal.close();});
                dialog.data.find('form').bind('submit', CV._on_submit);
            });
	});
    },

    _on_close : function(dialog){
        dialog.container.animate({height : '24px'}, 300, function(){
            $(this).fadeOut('slow', function(){
                dialog.overlay.fadeOut(200, function(){$.modal.close();})
            })
        });
    },

    _on_submit : function(){
        var status=true;
        var f=$(this);
        var msg="";
        f.find('.required', '.email').each(function(){
            var i = $(this);
            if( !i.val() ){
                msg+='El campo "'+ i.parent().find('label').text().substr(2) +'" es obligatorio.<br />';
                status=false;
            }else{
                if( i.hasClass('email') ){
                    if( /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i.test(i.val())==false ){
                        msg+= 'El email ingresado es incorrecto.<br />';
                    }
                }
            }
        });
        var conterror = $('#simplemodal-data').find('.error');
        if( !status ){
            conterror.html(msg.substr(0, msg.length-6)).show();
            $('#simplemodal-container').css('height', $('#simplemodal-data').height()+"px");
        }else conterror.hide();



        return false;
    }
}