<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents contents-width">
    <h1 class="title"><?=$info['path_section']?></h1>
    <?php if( $info['description']!='' ) {?><p class="clear"><?=$info['description']?></p><?php }?>
    <?=$info['product_content']?>
</div>