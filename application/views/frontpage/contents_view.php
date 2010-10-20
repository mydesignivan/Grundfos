<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents<?php if( isset($content['childs']) ) echo " contents-width"?>">
<?php
$html = @$content['content'];
$var = extract_var($html, '{', '}');
echo $html;

foreach( $var as $val){
    $this->view('frontpage/'.$val.'_view');
}

?>
</div>