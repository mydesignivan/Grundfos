<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?=$this->config->item('base_uri')?>" class="logo"><img src="images/logo.png" alt="www.grundfos.com.ar" width="325" height="103" /></a>

<div class="span-11 fright last">
    <div class="cont-links">
        <div class="links">
            -&nbsp;<a href="javascript:void(CV.open())">TRABAJE CON NOSOTROS</a>&nbsp;-&nbsp;<a href="<?=site_url('/contacto/')?>" <?php if( $this->uri->segment(1)=="contacto" ) echo 'class="current"'?>>CONTACTO</a>&nbsp;-&nbsp;<a href="<?=site_url('/donde-estamos/')?>">DONDE ESTAMOS</a>&nbsp;
        </div>
    </div>
    <div class="cont-search">
        <form id="form-search" action="<?=site_url('/search/');?>" method="post" enctype="application/x-www-form-urlencoded">
            <div class="input-search"><input type="text" name="txtSearch" value="BUSCAR" onblur="set_input(event, 'BUSCAR')" onfocus="clear_input(event)" /></div>
            <a href="javascript:void($('#form-search').submit())" class="fleft"><img src="images/icon-search.png" alt="" width="21" height="21" /></a>
        </form>
    </div>
</div>
<div class="banner">
    
</div>
<div class="menu">
    <?=$listMenu?>
</div>