<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents contents-width">
    <h1 class="title"><?=$info['path_section']?></h1>
    <img src="<?=UPLOAD_PATH_PRODUCTS.$info['thumb']?>" alt="<?=$info['thumb']?>" width="<?=$info['thumb_width']?>" height="<?=$info['thumb_height']?>" class="framethumb" style="float:left; margin-right: 40px;" />
    <?=$info['product_content']?>
</div>