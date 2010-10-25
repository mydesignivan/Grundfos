<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="sidebar">
<?php
if( is_array($info['childs']) ){?>
    <ul class="menu-sidebar">
<?php
    foreach( $info['childs'] as $row ){
        $class = $row['reference']==@$info['categorie_reference'] || $row['reference']==@$info['reference'] ? 'class="current"' : '';
?>
        <li><a href="<?=site_url('productos/'.$row['reference'])?>" <?=$class?>><?=$row['categorie_name']?></a></li>
    <?php }?>
    </ul>
<?php }?>
</div>