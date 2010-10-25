<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h1 class="title3">Trabaje con Nosotros</h1>
<p>Para trabajar o representar a Bottino Hnos. Subfactory Grundfos env&iacute;e su Curriculum e indique en que zona trabjar.</p>
<div class="error hide"></div>

<form id="form-contact" action="<?=site_url('/index/ajax_send_formcv/')?>" method="post" enctype="multipart/form-data" target="iframeUpload">
    <div class="trow">
        <label class="label" for="txtName">* Nombre</label>
        <input type="text" name="txtName" id="txtName" class="required" />
    </div>
    <div class="trow">
        <label class="label" for="txtEmail">* E-mail</label>
        <input type="text" name="txtEmail" id="txtEmail" class="required email" />
    </div>
    <div class="trow">
        <label class="label" for="txtCV">* Curriculum</label>
        <input type="file" name="txtCV" id="txtCV" size="22" class="required" />
        <label class="clear label">&nbsp;</label>
        <span class="legend">Extensi&oacute;n (.doc / .docx / .pdf) 2MB m&aacute;x.</span>
    </div>
    <div class="trow">
        <label class="label" for="txtComment">Comentario</label>
        <textarea rows="10" cols="20" id="txtComment" name="txtComment"></textarea>
    </div>
    <div class="trow">
        <label class="label">&nbsp;</label>
        <button type="submit">Enviar</button>&nbsp;
        <button type="button" id="btnCancel" class="simplemodal-close">Cancelar</button>
    </div>
    <iframe src="about:blank" id="iframeUpload" name="iframeUpload" width="400" height="100" frameborder="1" style="display:none;float:left; z-index:1000; background-color:#FFFFFF;"></iframe>
</form>
