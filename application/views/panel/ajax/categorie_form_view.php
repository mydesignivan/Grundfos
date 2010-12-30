<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="error" class="error hide">Los datos no pudieron ser guardados.</div>
<div id="success" class="success hide">Los datos fueron guardados con &eacute;xito.</div>

<form id="form1" class="form-categories" action="<?=site_url('/panel/products/ajax_categories_'. (isset($info) ? 'edit' : 'create'));?>" method="post" enctype="application/x-www-form-urlencoded">
<?php if( !isset($info) ){?>
    <div class="trow">
        <label class="label">Categor&iacute;a Padre:</label>
        <span id="txtParentCat"></span>
    </div>
<?php }?>
    <div class="trow">
        <label class="label" for="txtCategorie">* Nombre Categor&iacute;a</label>
        <div class="fleft"><input type="text" name="txtCategorie" id="txtCategorie" value="<?=@$info['categorie_name']?>" /></div>
    </div>
    <div class="trow">
        Contenido<br /><div class="clear"></div>
        <textarea rows="10" cols="22" id="txtContent" name="txtContent"><?=@$info['categorie_content']?></textarea>
    </div>

    <div class="trow">
        <label class="label" for="optBannerShowYes">* Mostrar en banner</label>
        <div class="fleft"><label><input type="radio" id="optBannerShowYes" name="optBannerShow" value="1" <?php if( @$info['banner']==1 ) echo 'checked="checked"'?> /> Si</label> - <label><input type="radio" id="optBannerShowNo" name="optBannerShow" value="0" <?php if( !isset($info['banner']) || @$info['banner']==0 ) echo 'checked="checked"'?> /> No</label></div>
    </div>
    <div id="divContBanner" class="trow <?php if( @$info['banner']==0 ) echo'hide'?>">
        <label class="label" for="txtBannerThumb">* Im&aacute;gen banner</label>
<?php
$src = "";
if( isset($info) ){
    if( !empty($info['banner_thumb']) ) $src = UPLOAD_PATH_BANNER . $info['banner_thumb'];
}
?>
        <div id="cont-image-1" class="span-13 last">
            <img src="<?=$src?>" alt="<?=@$info['thumb']?>" width="<?=@$info['banner_thumb_width']?>" height="<?=@$info['banner_thumb_height']?>" class="ajaxupload-thumb fleft framethumb <?php if( $src=='' ) echo 'hide'?>" />
            <div class="clear span-13 last">
                <input type="file" id="txtBannerThumb" name="txtBannerThumb" class="ajaxupload-input" size="20" />&nbsp;
                <button type="button" onclick="Products.upload('#cont-image-1');">Subir</button>
                <img src="public/images/ajax-loader4.gif" alt="Loading..." width="43" height="11" class="hide ajaxupload-load" />
                <div class="ajaxupload-error clear error span-7 hide" style="margin-top:10px"></div>
            </div>
        </div>
        <input type="hidden" name="image_thumb_old" id="image_thumb_old" value="<?=$src?>" />
    </div>

    <input type="hidden" name="categories_id" id="categories_id" value="<?=@$info['categories_id']?>" />
</form>
<form id="ajaxupload-form" action="<?=site_url('/panel/products/ajax_upload_banner')?>" method="post" enctype="multipart/form-data" target="ifr" class="hide">
    <iframe name="ifr" id="ifr" src="about:blank" frameborder="1" style="width:800px; height: 100px; border: 1px solid red;"></iframe>
</form>