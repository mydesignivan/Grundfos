<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents">
<?php
if( count($info['listProducts'])>0 ){
    $n=0;
    $titlecatold="";
    foreach( $info['listProducts'] as $row ){
        $n++;
        $css="";
        /*if( $n==3 ) {
            $css="last";
            $n=0;
        }*/
?>

<?php if( $titlecatold != $row['categorie_name'] ) {?>
    <div class="clear"></div>
    <h1 class="title"><?=$row['categorie_name']?></h1>
    <p><?=$row['categorie_content']?></p>
    <br />
<?php }?>

    <div class="product-col<?=$css?>">
        <img src="<?=UPLOAD_PATH_PRODUCTS .$row['categorie_reference']."/".$row['thumb']?>" alt="<?=$row['thumb']?>" width="<?=$row['thumb_width']?>" height="<?=$row['thumb_height']?>" class="framethumb" />
        <h3><?=$row['product_name']?></h3>
        <p><?=$row['description']?></p>
        <a href="<?=site_url('/productos/leermas/'.$row['reference'])?>">Leer m&aacute;s</a>
    </div>

<?php 
$titlecatold = $row['categorie_name'];
}

}else{?>

    <div class="align-center"><h4>No hay resultados con "<?=$this->input->post('txtSearch')?>".</h4></div>

<?php }?>

</div>