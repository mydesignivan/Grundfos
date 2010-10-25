<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents contents-width">
    <h1 class="title">Noticias</h1>
    <?php foreach( $list as $row ){
        ?>
        <b><?=$row['titulo']?></b><br/>

        <p class="italic">
            <?=strlen($row['copete'])>0?$row['copete']:$row['cuerpo']?>
        </p>
        <p class="hide">
            <?=$row['cuerpo']?>
        </p>
        <div class="prepend-top">
            <p align="right"><a class="italic" href=""><b>Leer m&aacute;s</b></a>&nbsp;&nbsp;&nbsp;</p>
        </div>
        <div class="separator-h2"></div>
    <? }?>
</div>

