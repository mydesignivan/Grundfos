<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php if( $this->session->flashdata('status')=="success" ){?>
<div class="success">
    Los datos han sido guardados con &eacute;xito.
</div>
<?php }elseif( $this->session->flashdata('status')=="error" ){?>
<div class="error">
    Los datos no han podido ser guardados.
</div>
<?php }?>

<form id="form1" class="form-myaccount" action="<?=site_url('/panel/myaccount/save');?>" method="post" enctype="application/x-www-form-urlencoded">
    <div class="trow">
        <label class="label" for="txtEmailContact">* Email Cont&aacute;ctenos</label>
        <div class="fleft"><input type="text" name="txtEmailContact" id="txtEmailContact" value="<?=$info['email_contact']?>" /></div>
    </div>
    <div class="trow">
        <label class="label" for="txtEmailSolCap">* Email Solicitud de Capacitaci&oacute;n</label>
        <div class="fleft"><input type="text" name="txtEmailSolCap" id="txtEmailSolCap" value="<?=$info['email_solcap']?>" /></div>
    </div>
    <div class="trow">
        <label class="label" for="txtEmailCV">* Email Curriculum</label>
        <div class="fleft"><input type="text" name="txtEmailCV" id="txtEmailCV" value="<?=$info['email_cv']?>" /></div>
    </div>
    <div class="trow">
        <label for="txtInfo" class="label">Contrase&ntilde;a</label>
        <button type="button" onclick="Account.showcontapass(this);" class="button">Modificar</button>
    </div>
    <div id="contPass" class="clear hide">
        <div class="trow">
            <label for="txtPassOld" class="label">* Contrase&ntilde;a actual</label>
            <div class="fleft"><input type="password" name="txtPassOld" id="txtPassOld" /></div>
        </div>
        <div class="trow">
            <label for="txtPassNew" class="label">* Nueva contrase&ntilde;a</label>
            <div class="fleft"><input type="password" name="txtPassNew" id="txtPassNew" /></div>
        </div>
        <div class="trow">
            <label for="txtConfirmPass" class="label">* Repetir Contrase&ntilde;a</label>
            <div class="fleft"><input type="password" name="txtConfirmPass" id="txtConfirmPass" /></div>
        </div>
    </div>

    <div class="trow align-center"><button type="submit">Guardar</button></div>
</form>