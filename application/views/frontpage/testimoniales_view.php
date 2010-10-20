<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents">
    <h1 class="title">Testimoniales</h1>
    <?php foreach( $list as $row ){
        echo $row['testimonio'];
        echo '<p class="color1 italic"><br /><b>'.$row['autor'].'</b><br />'.$row['cargo'].' <br />'.$row['empresa'].'</p><div class="separator-h2"></div>';
    }?>
</div>
