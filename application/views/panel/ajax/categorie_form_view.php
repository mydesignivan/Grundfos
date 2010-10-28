<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form id="form1" class="form-categories" action="<?=site_url('/panel/products/ajax_categories_'. (isset($info) ? 'edit' : 'create'));?>" method="post" enctype="application/x-www-form-urlencoded">
    <div class="trow">
        <label class="label">Categor&iacute;a Padre:</label>
        <span id="txtParentCat"></span>
    </div>
    <div class="trow">
        <label class="label" for="txtCategorie">* Nombre Categor&iacute;a</label>
        <div class="fleft"><input type="text" name="txtCategorie" id="txtCategorie" value="<?=@$info['categorie_name']?>" /></div>
    </div>
    <div class="trow">
        Contenido<br />
        <textarea rows="10" cols="22" id="txtContent" name="txtContent" />
    </div>

    <div class="trow align-center"><button type="submit">Guardar</button></div>
    <input type="hidden" name="id" value="" />
</form>