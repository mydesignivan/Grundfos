<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="contents<?php if( isset($content['childs']) || isset($content['gallery']) ) echo " contents-width"?>">
<?php
if( @$content!='' ){
    if( $content['show_title']==1 ) echo '<h1 class="title">'. $content['title'] .'</h1>';
    $html = @$content['content'];

    $widget = extract_var($html, '{widget}', '{/widget}', true);
    if( count($widget)>0 ){
        echo $html;
        $this->view($widget[0]['val']);
    }else{

        /*$gmap = extract_var($html, '{gmap}', '{/gmap}');
        foreach( $gmap as $row ){
            $html = str_replace($row['tag'], '<iframe width="100%" height="300" style="border:2px solid #ccc; margin-top:20px;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$row['val'].'"></iframe>', $html);
        }*/

        $html = str_replace('{gmap1}', '<iframe width="100%" height="300" style="border:2px solid #ccc" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.ar/maps?f=d&source=s_d&saddr=Almirante Brown&daddr=&hl=es&geocode=FfhqB_4dwErr-w&mra=mr&sll=-33.080305,-68.470037&sspn=0.005574,0.021136&ie=UTF8&ll=-33.068296,-68.465984&spn=0.006295,0.007512&output=embed"></iframe>', $html);
        $html = str_replace('{gmap2}', '<iframe width="100%" height="300" style="border:2px solid #ccc" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com.ar/maps?f=q&amp;source=s_q&amp;hl=es&amp;geocode=&amp;q=Rioja+357,+Godoy+Cruz,+Mendoza&amp;sll=-38.341656,-63.28125&amp;sspn=36.286491,86.044922&amp;ie=UTF8&amp;hq=&amp;hnear=La+Rioja+357,+Mendoza&amp;ll=-32.900126,-68.837632&amp;spn=0.002387,0.005252&amp;z=14&amp;output=embed"></iframe>', $html);

        echo $html;
    }
        
}
?>

</div>


