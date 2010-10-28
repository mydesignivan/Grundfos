var Products = new (function(){

    /* PRIVATE PROPERTIES
     **************************************************************************/
     var _contNode;
     var _working=false;
     var _parent_id=0;
     var _categorie_name='';
     var _ajaxupload_output=false;
     var _ajaxupload_div=false;
     var _ajaxupload_working=false;

    /* PUBLIC METHODS
     **************************************************************************/
    $(document).ready(function(){
        _refresh_treeview();
    });

    /* PUBLIC METHODS
     **************************************************************************/
     this.categorie_new = function(){
         if( _working ) return false;
         _show_form('ajax_form_categorie', 'Nueva Categor&iacute;a', function(){
            _exec_tiny();

            var o = $.extend({}, jQueryValidatorOptDef, {
                rules : {
                    txtCategorie  : 'required'
                },
                submitHandler : _on_submit_categories,
                invalidHandler : function(){
                }
            });
            $('#form1').validate(o);

            $('#txtParentCat').html('<u>'+_categorie_name+'</u>');
         });
         return false;
     };

     this.categorie_delete = function(){

     };

     this.products_edit = function(id){
         if( _working ) return false;
         _show_form('ajax_form_products/'+_parent_id+'/'+id, 'Modificar Producto', _callback_product);
         return false;
     };



     this.mark_items_all = function() {
        $('#tblList tbody input:checkbox').each(function(){
            this.checked = !this.checked;
        });
     };

     this.upload = function(sel){
        if( _ajaxupload_working ) return false;

        var me = $(sel);
        var input = me.find(':file');
        if( !input.val() ) return false;
        var parent = input.parent();
        var ext = input.val().replace(/^([\W\w]*)\./gi, '').toLowerCase();

        if( !(ext && /^(jpg|png|jpeg|gif)$/.test(ext)) ){
            alert('Error: Solo se permiten imagenes');
            return false;
        }

        var inputclone = input.clone(true);

        var form = $('#ajaxupload-form');

        me.find('button')[0].disabled=true;
        me.find('ajaxupload-load').show();

        form.find('input:file').remove();
        input.prependTo(form);
        parent.prepend(inputclone);

        $('#ajaxupload-form iframe').attr('src', '');
        form.submit();

        _ajaxupload_working=true;
        _ajaxupload_div = me;
        return false;
     };


     this.prueba = function() {
         _exec_tiny();
     };



    /* PRIVATE METHODS
     **************************************************************************/
    var _mark_item = function(){
        var t = $(this);
        $('#treeview span').removeClass('hover');
        t.addClass('hover');
        _parent_id = t.attr('id').substr(2);
        _categorie_name = $('#id'+_parent_id).text();
        $('#linkCatEdit, #linkCatDel').show();
        _show_list();
    };

    var _show_list = function(){
       if( _parent_id>0 ){
            _show_form('ajax_list_products/'+_parent_id, 'Listado de productos de: '+_categorie_name, function(){
                $('#btnNew').bind('click', _open_product);
            });
        }
    };

    var _open_product = function(){
        _show_form('ajax_form_products/'+_parent_id, 'Nuevo Producto', _callback_product);
    };

    var _callback_product = function(){
        //Ejecuta el TinyMCE
        _exec_tiny();

        // Configura el Validador
        var rules = {
            txtName         : 'required',
            txtDescription  : 'required',
            txtContent      : 'tinymce_required'
        };

        if( $('#products_id').val()=='' ) rules.txtThumb = 'required';

        var o = $.extend({}, jQueryValidatorOptDef, {
            rules : rules,
            submitHandler : _on_submit_products,
            invalidHandler : function(){}
        });
        $('#form1').validate(o);

        // Muestra la categoria padre
        $('#txtParentCat').html('<u>'+_categorie_name+'</u>');

        // ESTO ES PARA EL UPLOAD SIMPLE
        $('#ajaxupload-form iframe').load(function(){
            if( this.src=="about:blank" ) return false;

            var content = this.contentDocument || this.contentWindow.document;
                content = content.body.innerHTML;

            _ajaxupload_working=false;
            _ajaxupload_div.find('button')[0].disabled=false;
            _ajaxupload_div.find('.ajaxupload-load').hide();
            _ajaxupload_div.find('.valid-error, .ajaxupload-error').hide();

            var result;
            try{
                eval('result = '+content);
            }catch(e){
                alert('ERROR:\n\n'+content);
                return false;
            }

            if( result['status']=="success" ) {
                _ajaxupload_div.find('.ajaxupload-error').hide();
                var output = result['output'][0];

                _ajaxupload_div.find('.ajaxupload-thumb').attr('src', output['href_image_full'])
                                      .attr('alt', output['filename_image'])
                                      .attr('width', output['thumb_width'])
                                      .attr('height', output['thumb_height'])
                                      .show();

                _ajaxupload_output = output;
            }
            else _ajaxupload_div.find('.ajaxupload-error').html(result['error'][0]['message']).show();

            return false;
        });
        //-----
    };

    var _on_submit_categories = function() {
        var f = $('#form1');

        _Loader.show();

        var params = _get_params(f)+'&parent_id='+_parent_id;

        $.post(f.attr('action'), params, function(data){
            if( !isNaN(data) ){
                $('#treeview ul:first').remove();
                
                $.get(get_url('panel/products/ajax_show_treeview'), function(data){
                    $('#treeview li').append(data);
                    _refresh_treeview();
                    f[0].reset();
                    _Loader.hide();
                });
                
            }else{
                alert("ERROR AJAX:\n\n"+data);
                _working=false;
            }
        });

        return false;
    };

    var _on_submit_products = function() {
        var f = $('#form1');

        if( $('#products_id').val()=='' && _ajaxupload_output==false ){
            $('#cont-image-1 .ajaxupload-error').html('Este campo es obligatorio.').show();
            $('#txtThumb').focus();
            return false;
        }

        _Loader.show();

        var params = _get_params(f)+"&json="+JSON.encode({image_thumb : _ajaxupload_output});

        $.post(f.attr('action'), params, function(data){
            _Loader.hide();
            if( data=="ok" ){
                _show_list();
            }else {
                $('#cont-products').scrollTop(0);
                $('#error').show();
                alert("ERROR AJAX:\n\n"+data);
            }
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
            collapsed: false
        });
        tree.find("span.file, span.folder").css('cursor', 'pointer').click(_mark_item);
    };

    var _get_params = function(f){
        return f.serialize().replace('txtContent=', 'txtContent='+tinyMCE.get('txtContent').getContent());
    };

    var _exec_tiny = function(){
        TinyMCE_init.width = '98%';
        TinyMCE_init.height = '200px';
        TinyMCE_init.mode = 'exact';
        TinyMCE_init.elements = 'txtContent';
        tinyMCE.init(TinyMCE_init);
    };

    var _show_form = function(segm, title, callback) {
         _Loader.show();
         $('#fieldset-form legend').html(title);
         $('#cont-products').load(get_url('panel/products/'+segm), function(){
             $('#cont-products').scrollTop(0);             
              callback();
              _Loader.hide();
         });
    };

})();
