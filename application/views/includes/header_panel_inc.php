<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<a href="<?=$this->config->item('base_uri')?>" class="logo"><img src="public/images/logo.png" alt="www.grundfos.com.ar" width="325" height="103" /></a>

<div class="span-11 fright last">
    &nbsp;
</div>

<div class="menu">
    <ul id="sf-menu" class="sf-menu">
        <li><a href="<?=$this->config->item('base_url')?>" target="_blank">Home</a></li>
        <li><a href="<?=site_url('panel/myaccount')?>" <?php if( $this->uri->segment(2)=="" || $this->uri->segment(2)=="myaccount" ) echo 'class="current"'?>>Mi Cuenta</a></li>
        <li><a href="<?=site_url('panel/products')?>" <?php if( $this->uri->segment(2)=="products") echo 'class="current"'?>>Productos</a></li>
        <li><a href="<?=site_url('panel/contents')?>" <?php if( $this->uri->segment(2)=="contents") echo 'class="current"'?>>Contenidos</a></li>
        <li class="outline"><a href="<?=site_url('panel/index/logout')?>">Salir</a></li>
    </ul>
</div>