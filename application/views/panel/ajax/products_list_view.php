<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="error" class="error hide">El producto no ha podido ser eliminado</div>

<div class="trow">
    <button type="button" onclick="Products.products_new()">Nuevo</button>
<?php if( count($List)>0 ) {?>
    <button type="button" onclick="Products.products_del()">Eliminar Seleccionados</button>
<?php }?>
</div>

<?php if( count($List)>0 ) {?>
<table id="tblList" cellpadding="0" cellspacing="0" class="table-products">
    <thead>
        <tr>
            <td class="cell1"><input type="checkbox" onclick="Products.mark_items_all()" /></td>
            <td class="cell2">Nombre Producto</td>
            <td class="cell3">Descripci&oacute;n</td>
            <td class="cell4">Orden</td>
            <td class="cell5">Modificar</td>
            <td class="cell6">Eliminar</td>
        </tr>
    </thead>
    <tbody>
<?php 
    $n=0;
    foreach( $List as $row ) {
        $class = $n%2 ? 'class="row-even"' : '';
?>
        <tr id="tr<?=$row['products_id']?>" <?=$class?>>
            <td class="cell1"><input type="checkbox" value="<?=$row['products_id']?>" /></td>
            <td class="cell2"><a href="javascript:void(Products.products_edit(<?=$row['products_id']?>))"><?=$row['product_name']?></a></td>
            <td class="cell3"><?=$row['description']?></td>
            <td class="cell4"><a href="javascript:void(0)" class="handle"><img src="images/icon_arrow_move.png" alt="" width="16" alt="16" /></a></td>
            <td class="cell5"><a href="javascript:void(Products.products_edit(<?=$row['products_id']?>))"><img src="images/icon_edit.png" alt="" width="16" alt="16" /><span>Modificar</span></a></td>
            <td class="cell6"><a href="javascript:void(Products.products_del(<?=$row['products_id']?>))"><img src="images/icon_delete.png" alt="" width="16" alt="16" /><span>Eliminar</span></a></td>
        </tr>
<?php }?>
    </tbody>
</table>
<?php }else{?>
<div class="align-center"><br /><br /><br /><br /><h4>No hay productos.</h4></div>
<?php }?>