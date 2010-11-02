var Contents = new (function(){

    /* PRIVATE PROPERTIES
     **************************************************************************/
     var _working=false;
     var _parent_id=0;
     var _content_name='';
     var _formchange=false;
     var _j=0;

    /* PUBLIC METHODS
     **************************************************************************/
    $(document).ready(function(){
        _refresh_treeview();
    });

    /* PUBLIC METHODS
     **************************************************************************/
     this.content_new = function(){
         if( _working ) return false;
         _show_form('ajax_show_form', 'Nuevo Contenido', _callback_content);
         return false;
     };

     this.content_delete = function(){
        if( confirm('¿Confirma la eliminación?\n'+_content_name) ){
            _Loader.show();
            $.post(get_url('panel/contents/ajax_del/'+_parent_id), function(data){
                if( data!="ok" ) alert("ERROR AJAX:\n\n"+data);
                else {
                    _show_treeview();
                    _clear();
                }
            });
        }
        return false;
     };

     this.prueba = function() {
     };



    /* PRIVATE METHODS
     **************************************************************************/
    var _mark_item = function(){
        if( _working ) return false;
        if( _formchange ){
            if( confirm('¿Desea guardar las modificaciones?') ){
                $("#form1").submit();
                return false;
            }else _formchange=false;
        }

        var t = $(this);
        $('#treeview span').removeClass('hover');
        t.addClass('hover');
        _parent_id = t.attr('id').substr(2);
        _content_name = $('#id'+_parent_id).text();
        $('#linkCatDel').show();
        _show_content();

        return false;
    };

    var _callback_content = function(){
        //Ejecuta el TinyMCE
        _exec_tiny();

        // Configura el Validador
        var rules = {
            txtTitle        : 'required',
            txtContent      : 'tinymce_required'
        };

        var o = $.extend({}, jQueryValidatorOptDef, {
            rules : rules,
            submitHandler : _on_submit_content,
            invalidHandler : function(){}
        });
        $('#form1').validate(o);

        // Esto es para la galeria de imagen
        PictureGallery.initializer({
            sel_input      : '#txtUploadFile',
            sel_button     : '#btnUpload',
            sel_ajaxloader : '#ajax-loader1',
            sel_gallery    : '#gallery-image',
            sel_msgerror   : '#pg-msgerror',
            action         : baseURI+'panel/contents/ajax_upload_gallery',
            href_remove    : baseURI+'panel/contents/ajax_upload_delete',
            defined_size   : {
                width  : 130,
                height : 58
            },
            callback       : function(){
                $('a.jq-image').fancybox();
            }
        });

        // Muestra la categoria padre
        $('#txtParentCat').html('<u>'+_content_name+'</u>');

        $('#form1').find('input:text, input:file, textarea').bind('change', function(){_formchange=true});
        _j=0;

        // Set FancyBox
        $('a.jq-image').fancybox();
    };

    var _on_submit_content = function() {
        var f = $('#form1');

        _Loader.show();

        var params = _get_params(f)+'&parent_id='+_parent_id;
        var data={gallery:{}};
        data.gallery.images_new = PictureGallery.get_images_new();
        if( $('#content_id').val() ) {
            data.gallery.images_del = PictureGallery.get_images_del();
            data.gallery.images_order = PictureGallery.get_orders();
        }
        params+='&json='+JSON.encode(data);

        var a = _parent_id;
        var b = _content_name;
        $.post(f.attr('action'), params, function(data){
            if( data=="ok" ){
                _show_treeview(function(){
                    $('#error').hide();$('#success').show();
                    if( !$('#content_id').val() ){
                        _content_name = $('#txtTitle').val();
                        _parent_id = a;
                        $('#form1 input:text, #form1 textarea').val('');
                        tinyMCE.get('txtContent').setContent('');
                    }else{                        
                        _content_name = b;
                    }
                });
            }else{
                $('#success').hide();$('#error').show();
                alert("ERROR AJAX:\n\n"+data);
                _working=false;
            }
             $('#cont-products').scrollTop(0);
        });

        return false;
    };

    /* PRIVATE FUNCTIONS (HELPERS)
     **************************************************************************/
    var _Loader={
        show : function() {
            $('#cont-products').css('opacity', '0.5');
            $('#busy').show();
            _working=true;

        },
        hide : function() {
            $('#cont-products').css('opacity', '1');
            $('#busy').hide();
            _working=false;
        }
    };

    var _refresh_treeview = function(){
        var tree = $("#treeview").treeview({
            collapsed: true
        });
        tree.find("span.file, span.folder").css('cursor', 'pointer').click(_mark_item);
        tree.find('.hitarea:first').trigger('click');

        _parent_id=0;
        _content_name = tree.find('span:first').text();

        var a = $('#treeview ul');
        a.sortable({
            stop : function(){
                _working = true;
                a.sortable( "option", "disabled", true );

                var initorder = $(this).find('li:first').attr('id').substr(2);

                var arr = $(this).sortable("toArray");

                _set_order('ajax_order', arr, initorder, function(){
                    a.sortable( "option", "disabled", false );
                });
            }
        }).disableSelection();

    };

    var _get_params = function(f){
        var a = f.serialize().split('&');
        for( var i=0; i<=a.length-1; i++ ){
            if( /^txtContent=/.test(a[i])) {
                a[i] = "txtContent="+tinyMCE.get('txtContent').getContent();
                break;
            }
        }
        return a.join('&');
    };

    var _exec_tiny = function(j){
        TinyMCE_init.width = '98%';
        TinyMCE_init.height = '200px';
        TinyMCE_init.mode = 'exact';
        TinyMCE_init.elements = 'txtContent';
        TinyMCE_init.handle_node_change_callback = function(){
            _j++;
            if( _j>1 ) _formchange=true;
        }
        tinyMCE.init(TinyMCE_init);
    };

    var _show_treeview = function(callback){
        $('#treeview ul:first').remove();

        $.get(get_url('panel/contents/ajax_show_treeview'), function(data){
            $('#treeview li').append(data);

            _refresh_treeview();
            
            if( typeof(callback)=="function" ) callback();

            _Loader.hide();
            _formchange=false;
        });

    };

    var _show_form = function(segm, title, callback) {
         _Loader.show();
         $('#fieldset-form legend').html(title);
         $('#cont-products').load(get_url('panel/contents/'+segm), function(){
             $('#cont-products').scrollTop(0);             
              callback();
              _Loader.hide();
         });
    };

    var _clear = function(){
        $('#cont-products').empty();
        $('#fieldset-form legend').html('Contenidos');
    };

    var _set_order = function(func, arr, initorder, callback){
        $.post('panel/contents/'+func, {rows : JSON.encode(arr), initorder : initorder}, function(data){
            _working = false;
            if( data!="success" ) alert('ERROR AJAX:\n\n'+data);
            else {
                if( typeof(callback)=="function" ) callback();
            }
        });
    };

    var _show_content = function(){
        _show_form('ajax_show_form/'+_parent_id, 'Modificar Contenido', _callback_content);
        return false;
    };

})();
