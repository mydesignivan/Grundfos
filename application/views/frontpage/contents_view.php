<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents<?php if( isset($content['childs']) || isset($content['gallery']) ) echo " contents-width"?>">
<?php
if( @$content!='' ){
    if( $content['show_title']==1 ) echo '<h1 class="title">'. $content['title'] .'</h1>';
    $html = @$content['content'];
    $var = extract_var($html, '{', '}');
    echo $html;

    foreach( $var as $val){
        $this->view('frontpage/'.$val.'_view');
    }
        
}
?>

</div>