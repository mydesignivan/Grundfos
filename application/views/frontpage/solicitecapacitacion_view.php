<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<form id="form1" class="form-solcap" action="<?=site_url('/index/send_formcapacitacion');?>" method="post" enctype="application/x-www-form-urlencoded">
    <div class="trow">
        <label class="label" for="txtCompany">* Compa&ntilde;&iacute;a</label>
        <div class="fleft"><input type="text" name="txtCompany" id="txtCompany" /></div>
    </div>
    <div class="trow align-center"><button type="submit">Enviar</button></div>
</form>