<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<h1 class="title">Trabaje con Nosotros</h1>
<p>Para trabajar o representar a Bottino Hnos. Subfactory Grundfos env&iacute;e su Curriculum e indique en que zona trabjar.</p>
<div class="error hide"></div>

<form id="form-contact" action="" method="post">
    <div class="trow">
        <label class="label" for="txtNombre">* Nombre</label>
        <input type="text" name="txtNombre" id="txtNombre" class="required" />
    </div>
    <div class="trow">
        <label class="label" for="txtEmail">* E-mail</label>
        <input type="text" name="txtEmail" id="txtEmail" class="required email" />
    </div>
    <div class="trow">
        <label class="label" for="txtCV">* Curriculum</label>
        <input type="file" name="txtCV" id="txtCV" size="22" class="required" /><br />
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
</form>
