<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php if( $this->session->flashdata('status_sendmail')=="ok" ){?>
<div class="success">
    Muchas gracias por comunicarse, en breve estaremos en contacto.
</div>
<?php }elseif( $this->session->flashdata('status_sendmail')=="error" ){?>
<div class="error">
    El formuarlio no ha podido ser enviado, porfavor, intentelo nuevamente.
</div>
<?php }?>

<div class="contents">
<?=$content?>
</div>

<form id="form1" class="form-contact" action="<?=site_url('/contacto/send');?>" method="post" enctype="application/x-www-form-urlencoded">
    <div class="span-10">
        <div class="trow">
            <label class="label" for="txtCompany">* Compa&ntilde;&iacute;a</label>
            <input type="text" name="txtCompany" id="txtCompany" />
        </div>
        <div class="trow">
            <label class="label" for="txtName">* Nombre</label>
            <input type="text" name="txtName" id="txtName" />
        </div>
        <div class="trow">
            <label class="label" for="txtAddress">* Direcci&oacute;n</label>
            <input type="text" name="txtAddress" id="txtAddress" />
        </div>
        <div class="trow">
            <label class="label" for="txtCity">* Ciudad</label>
            <input type="text" name="txtCity" id="txtCity" />
        </div>
        <div class="trow">
            <label class="label" for="txtPC">* C&oacute;digo Postal</label>
            <input type="text"  name="txtPC" id="txtPC" />
        </div>
        <div class="trow">
            <label class="label" for="cboCountry">* Pa&iacute;s</label>
            <?php echo form_dropdown('cboCountry', $listCountry, '', 'id="cboCountry" onchange="Account.show_states(this)"');?>
        </div>
        <div class="trow hide">
            <label class="label" for="cboState">* Provincia</label>
            <select name="cboState" id="cboState">
                <option value="">Seleccione una provincia</option>
            </select>
        </div>
    </div>
    <div class="span-10 last">
        <div class="trow">
            <label class="label" for="txtEmail">* E-Mail</label>
            <input type="text" name="txtEmail" id="txtEmail" />
        </div>
        <div class="trow">
            <label class="label" for="txtPhoneCode">* Telefono</label>
            <input type="text" name="txtPhoneCode" id="txtPhoneCode" class="input-code" />
            <input type="text" name="txtPhoneNum" id="txtPhoneNum" class="input-num" />
        </div>
        <div class="trow">
            <label class="label" for="txtFaxCode">Fax</label>
            <input type="text" name="txtFaxCode" id="txtFaxCode" class="input-code" />
            <input type="text" name="txtFaxNum" id="txtFaxNum" class="input-num" />
        </div>
        <div class="trow">
            <label class="label" for="txtTema">Tema</label>
            <input type="text" name="txtTema" id="txtTema" />
        </div>
        <div class="trow">
            <label class="label" for="txtMessage">* Mensaje</label>
            <textarea id="txtMessage" name="txtMessage" rows="5" cols="22"></textarea>
        </div>
    </div>
    <div class="trow align-center">
        <button type="submit">Enviar</button>
    </div>
</form>