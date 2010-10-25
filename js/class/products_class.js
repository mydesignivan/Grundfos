var Products = new (function(){

    /* PRIVATE PROPERTIES
     **************************************************************************/
     var _contNode;
     var _working=false;
     var _parent_id=0;

    /* PUBLIC METHODS
     **************************************************************************/
    $(document).ready(function(){
        var tree = $("#treeview").treeview({
            collapsed: false
        });
        $('#treeview').find("span.file, span.folder").css('cursor', 'pointer').click(_mark_item);
        _contNode = tree;
    });

    /* PUBLIC METHODS
     **************************************************************************/
     this.categorie_new = function(){
         if( _working ) return false;

         _Loader.show();
         $('#fieldset-form legend').html('Nueva Categor&iacute;a');
         $('#cont-products').load(get_url('panel/products/ajax_showform_categorie'), function(){
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

             _Loader.hide();
         });
     };

     this.categorie_edit = function(){

     };

     this.categorie_delete = function(){

     };

     this.prueba = function() {
         _exec_tiny();
     };


    /* PRIVATE METHODS
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

    var _mark_item = function(){
        var t = $(this);
        $('#treeview span').removeClass('hover');
        t.addClass('hover');
        _parent_id = t.attr('id').substr(2);
        $('#linkCatEdit, #linkCatDel').show();
    };

    var _addNode = function(){
        var html = "<li class='closed'><span class='folder'>"+$('#txtName').val()+"</span></li>";

        if( _contNode.is('li') && _contNode.find('>ul').length==0 ){
            html = "<ul>"+html+"</ul>";
        }
        else if( _contNode.is('li') && _contNode.find('>ul').length>0 ){
            _contNode = _contNode.find('>ul');
        }

        var newSublist = $(html).appendTo(_contNode);

        tree.treeview({
            add: newSublist
        });
        $("span.file, span.folder", "#example li").css('cursor', 'pointer').click(setClick);
    };
    
    var _exec_tiny = function(){
        TinyMCE_init.width = '98%';
        TinyMCE_init.height = '200px';
        TinyMCE_init.mode = 'exact';
        TinyMCE_init.elements = 'txtContent';
        tinyMCE.init(TinyMCE_init);
    };

    var _on_submit_categories = function() {
        var f = $('#form1');

        _Loader.show();

        var params = {
            txtCategorie : $('#txtCategorie').val(),
            txtContent   : tinyMCE.get('txtContent').getContent(),
            parent_id    : _parent_id
        };

        $.post(f.attr('action'), params, function(data){
            if( !isNaN(data) ){
                $('#treeview ul:first').remove();
                
                $.get(get_url('panel/products/ajax_show_treeview'), function(data){
                    $('#treeview li').append(data).treeview({
                        collapsed: false
                    });
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



})();
