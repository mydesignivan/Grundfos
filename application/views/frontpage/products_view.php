<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents contents-width">
    <h1 class="title"><?=$info['categorie_name']?></h1>
    <p><?=$info['categorie_content']?></p>
    <br />

<?php
    $n=0;
    for( $i=0; $i<count($info['listProducts']); $i++ ){
        $row = $info['listProducts'][$i];
        $n++;
        $css="";
        if( $n==3 || $i==count($info['listProducts'])-1 ) {
            $css=" product-col-last";
        }
?>
    <div class="product-col<?=$css?>">
        <img src="<?=UPLOAD_PATH_PRODUCTS .$row['thumb']?>" alt="<?=$row['thumb']?>" width="<?=$row['thumb_width']?>" height="<?=$row['thumb_height']?>" class="framethumb" />
        <h3><?=$row['product_name']?></h3>
        <p><?=$row['description']?></p>
        <a href="<?=site_url('/productos/leermas/'.$row['reference'])?>">Leer m&aacute;s</a>
    </div>
    <?php
        if( $n==3 ) {
            $n=0;
            echo '<div class="clear"></div>';
        }
    }?>

</div>