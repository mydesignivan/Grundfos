<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="sidebar">
<?php if( isset($content['childs']) ) {?>
    <ul class="menu-sidebar">
<?php
    $segs = $this->uri->segment_array();
    $lastSeg = $segs[count($segs)];
    if( $content['lastchild'] ) array_pop($segs);
    $baseurl = implode('/', $segs);
    foreach( $content['childs'] as $row ){
        $class = $row['reference']==$lastSeg ? 'class="current"' : '';
?>
        <li><a href="<?=site_url($baseurl.'/'.$row['reference'])?>" <?=$class?>><?=$row['title']?></a></li>
    <?php }?>
    </ul>
<?php }?>
<br />
<?=$content['content_sidebar']."<br />"?>
<?php if( isset($content['gallery']) ){
if( count($content['gallery'])>1 ){?>

    <div id="gallery" class="ad-gallery">
        <div class="ad-image-wrapper"></div>
        <div class="ad-nav">
            <div class="ad-thumbs">
                <ul class="ad-thumb-list">
            <?php
            $n=-1;
            foreach( $content['gallery'] as $row ){$n++;?>
                    <li><a href="<?=UPLOAD_PATH_SIDEBAR.$row['image']?>"><img src="<?=UPLOAD_PATH_SIDEBAR.$row['thumb']?>" alt="<?=$row['thumb']?>" class="image<?=$n?>" /></a></li>
            <?php }?>
                </ul>
            </div>
        </div>
    </div>

<?php }else{
    $row = $content['gallery'][0];
?>
    <img src="<?=UPLOAD_PATH_SIDEBAR.$row['image']?>" alt="<?=$row['image']?>" width="<?=$row['width']?>" height="<?=$row['height']?>" />
<?php }
}?>

</div>