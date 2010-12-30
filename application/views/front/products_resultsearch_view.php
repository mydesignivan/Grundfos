<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents">
<?php
if( count($info['listProducts'])>0 ){
    $n=0;$i=0;
    $titlecatold="";

    for( $i=0; $i<count($info['listProducts']); $i++ ){
        $row = $info['listProducts'][$i];
        $css="";
    ?>

    <?php if( $titlecatold != $row['categorie_name'] ) {
            $n=0;
    ?>
        <h1 class="title clear"><?=$row['categorie_name']?></h1>
        <p><?=$row['categorie_content']?></p>
        <br />
    <?php }?>


<?php
        $n++;
        if( $n==5 || $i==count($info['listProducts'])-1 || ($n>1 && $info['listProducts'][$i+1]['categorie_name']!=$titlecatold) ) {
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
        if( $n==5 ) {
            $n=0;
            echo '<div class="clear"></div>';
        }

$titlecatold = $row['categorie_name'];
}

}else{?>

    <div class="align-center"><h4>No hay resultados con "<?=$this->input->post('txtSearch')?>".</h4></div>

<?php }?>

</div>