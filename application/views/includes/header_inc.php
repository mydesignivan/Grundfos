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
<?php if( $class_num_header==1 ){?>
<div class="banner">
    <div id="slider">
        <ul>
            <li>
                <h1 class="title2">Aumento de presi&oacute;n</h1>
                <p class="text">Modelos: línea CR – CRN- CRT- CM – CHN – CHI –CHIE - Hidros – Grupos de presión Nb – Nq-dn - CRE</p>
                <img src="images/banner/aumentodepresion-producto-slider.png" alt="" width="132" height="175" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Achique pluvial y residual</h1>
                <p class="text">Modelos: KP /AP – DW.</p>
                <img src="images/banner/achique-pluvialyresidual-slider.png" alt="" width="208" height="151" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Aguas subterraneas</h1>
                <p class="text">Modelos: SP A, SP, SP-G  - SP- SPN-SPG -SQ – SQE -SQ Flex – MS – MMS - MP1 / SPE-NE </p>
                <img src="images/banner/aguassubterraneas-slider.png" alt="" width="177" height="99" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Calefaccion refrigeraci&oacute;n</h1>
                <p class="text">Modelos: UP / UPS / UPSD /UPN / UPB / UPE/ TP / TPD / TPE /CLM/ CDM</p>
                <img src="images/banner/calefaccion-refrigeracion.png" alt="" width="183" height="162" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Dosificaci&oacute;n</h1>
                <p class="text">Modelos: DMI – DME – DMS – Sistemas de control y desinfecci&oacute;n</p>
                <img src="images/banner/dosificacion-productos-slider.png" alt="" width="234" height="127" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Energ&iacute;a renovable</h1>
                <p class="text">Modelos: SQ Flex solar – e&oacute;lico </p>
                <img src="images/banner/energia-renovable-slider.png" alt="" width="203" height="164" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Equipos contra incendios</h1>
                <p class="text">Modelos: bombas según norma NFPA20</p>
                <img src="images/banner/equipos-contra-incendios-slider.png" alt="" width="186" height="126" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Productos DAB - Bombas perif&eacute;ricas</h1>
                <p class="text">KPA - KPF - KPS – KP</p>
                <img src="images/banner/productos-dab-slider.png" alt="" width="168" height="141" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Protecciones</h1>
                <p class="text">Modelos: MP204 – LIQ TEC – MP100 – Control R100</p>
                <img src="images/banner/protecciones-slider.png" alt="" width="208" height="135" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Sanitarias lobulares</h1>
                <p class="text">Modelos: euro hygia contra maxa maxana sipla  Y Novalobe</p>
                <img src="images/banner/sanitarias-lobulares-slider.png" alt="" width="183" height="164" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Tratamiento efluentes</h1>
                <p class="text">Modelos: euro hygia contra maxa maxana sipla  Y Novalobe</p>
                <img src="images/banner/tratamiento-efluentes-slider.png" alt="" width="152" height="168" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
            <li>
                <h1 class="title2">Uso domestico</h1>
                <p class="text">Modelos: UPA – MQ – CM</p>
                <img src="images/banner/uso-domestico-slider.png" alt="" width="211" height="155" class="image" />
                <button type="button" class="button-vermas">Ver mas</button>
            </li>
        </ul>
    </div>
</div>
<?php }?>
<div class="menu">
    <?=$listMenu?>
</div>