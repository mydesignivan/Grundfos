<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="error" class="error hide"></div>

<form id="form1" class="form-products" action="<?=site_url('/panel/products/ajax_products_'. (isset($info) ? 'edit' : 'create'));?>" method="post" enctype="application/x-www-form-urlencoded">
    <div class="trow">
        <label class="label">Categor&iacute;a Padre:</label>
        <span id="txtParentCat"></span>
    </div>
    <div class="trow">
        <label class="label" for="txtName">* Nombre Producto</label>
        <div class="fleft"><input type="text" name="txtName" id="txtName" value="<?=@$info['product_name']?>" /></div>
    </div>
    <div class="trow">
        <label class="label" for="txtThumb">* Im&aacute;gen</label>
<?php
$src = isset($info) ? UPLOAD_PATH_PRODUCTS . @$info['thumb'] : '';
?>
        <div id="cont-image-1" class="span-13 last">
            <img src="<?=$src?>" alt="<?=@$info['thumb']?>" width="<?=@$info['thumb_width']?>" height="<?=@$info['thumb_height']?>" class="ajaxupload-thumb fleft framethumb <?php if( $src=='' ) echo 'hide'?>" />
            <div class="clear span-13 last">
                <input type="file" id="txtThumb" name="txtThumb" class="ajaxupload-input" size="20" />&nbsp;
                <button type="button" onclick="Products.upload('#cont-image-1');">Subir</button>
                <img src="images/ajax-loader4.gif" alt="Loading..." width="43" height="11" class="hide ajaxupload-load" />
                <div class="ajaxupload-error clear error span-7 hide" style="margin-top:10px"></div>
            </div>
        </div>
        <input type="hidden" name="image_thumb_old" value="<?=$src?>" />
    </div>
    <div class="trow">
        <label class="label" for="txtDescription">* Breve Descripci&oacute;n</label>
        <div class="fleft"><textarea rows="10" cols="22" id="txtDescription" name="txtDescription"><?=@$info['description']?></textarea></div>
    </div>
    <div class="trow">
        * Contenido<br />
        <textarea rows="10" cols="22" id="txtContent" name="txtContent"><?=@$info['product_content']?></textarea>
    </div>

    <div class="trow align-center"><button type="submit">Guardar</button></div>
    <input type="hidden" name="products_id" id="products_id" value="<?=@$info['products_id']?>" />
    <input type="hidden" name="categorie_reference" value="<?=$reference?>" />
</form>

<form id="ajaxupload-form" action="<?=site_url('/panel/products/ajax_upload_products')?>" method="post" enctype="multipart/form-data" target="ifr" class="hide">
    <iframe name="ifr" id="ifr" src="about:blank" frameborder="1" style="width:800px; height: 100px; border: 1px solid red;"></iframe>
</form>