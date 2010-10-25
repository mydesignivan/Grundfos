<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents contents-width">
    <h1 class="title"><?=$info['categorie_name']?></h1>
    <p><?=$info['categorie_content']?></p>
    <br />

<?php
    $n=0;
    foreach( $info['listProducts'] as $row ){
        $n++;
        $css="";
        if( $n==3 ) {
            $css="last";
            $n=0;
        }
?>
    <div class="product-col<?=$css?>">
        <img src="<?=UPLOAD_PATH_PRODUCTS .$info['reference']."/".$row['thumb']?>" alt="<?=$row['thumb']?>" width="<?=$row['thumb_width']?>" height="<?=$row['thumb_height']?>" class="framethumb" />
        <h3><?=$row['product_name']?></h3>
        <p><?=$row['description']?></p>
        <a href="<?=site_url('/productos/leermas/'.$row['reference'])?>">Leer m&aacute;s</a>
    </div>
    <?php }?>

</div>