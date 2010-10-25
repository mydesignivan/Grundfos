var Products = new (function(){

    /* PRIVATE PROPERTIES
     **************************************************************************/
     var _contNode;

    /* PUBLIC METHODS
     **************************************************************************/
    $(document).ready(function(){
        var tree = $("#treeview").treeview({
            collapsed: true
        });
        _contNode = tree;
    });

    /* PUBLIC METHODS
     **************************************************************************/
     this.categorie_open = function(type){
         $('#cont-products').load(get_url('panel/products/ajax_showform_categorie'));

     };

    /* PRIVATE METHODS
     **************************************************************************/
    var _setClick = function(){
        _contNode = $(this);
        if( _contNode.is('span') ) _contNode = _contNode.parent();
        $("#example li span").css({
            backgroundColor : 'transparent',
            color           : '#000'
        });
        _contNode.find('>span').css({
            backgroundColor : 'blue',
            color           : '#fff'
        });
    }

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
    }


})();
