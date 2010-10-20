<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?=TITLE_GLOBAL . @$tlp_title;?></title>
    <base href="<?=base_url();?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="<?=META_DESCRIPTION_GLOBAL . @$tlp_meta_description;?>" />
    <meta name="keywords" content="<?=META_KEYWORDS_GLOBAL . @$tlp_meta_keywords;?>" />
    <meta name="robots" content="index,follow" />
    <link href="images/favicon.ico" rel="stylesheet icon" type="image/ico" />
<?php
    $class_num_header = isset($tlp_script) && in_array('plugins_easyslider', $tlp_script) ? 1 : 2;
    
    if( isset($tlp_script) && !empty($tlp_script) ) $tlp_script = '/'.implode('/', $tlp_script);
    //INCLUYE LOS SCRIPT CSS
    echo '<link rel="stylesheet" href="'.site_url('/load/css/initializer/plugins_simplemodal'.@$tlp_script).'" type="text/css" media="screen, projection" />'.chr(13);
?>
    <!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"/><![endif]-->
    <!--[if IE 6]>
    <link href="css/style_ie6.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 7]>
    <link href="css/style_ie7.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript" src="<?=site_url("load/js/initializer/plugins_simplemodal")?>"></script>
<?php
    //INCLUYE LOS SCRIPT JS
    if( isset($tlp_script) ) echo '<script type="text/javascript" src="'. site_url('load/js'.@$tlp_script).'"></script>'.chr(13);
?>
    <!--[if IE 6]>
    <script type="text/javascript">var IE6UPDATE_OPTIONS={icons_path:"js/plugins/ie6update/ie6update/images/"}</script>
    <script type="text/javascript" src="js/plugins/ie6update/ie6update/ie6update.js"></script>
    <script type="text/javascript" src="js/helpers/DD_belatedPNG.js"></script>
    <![endif]-->
</head>
<body>
    <div class="header-bg<?=$class_num_header?>"></div>
    <div class="container">
        <div class="span-24 last header<?=$class_num_header?>"> 
        <?php require('includes/header_inc.php')?>
        </div>
        <div class="clear span-24 last main-container">
        <?php
            require($tlp_section);
            if( isset($content['childs']) ) require('includes/sidebar_inc.php');
        ?>
        </div>
        <div class="clear span-24 last footer"> 
        <?php require('includes/footer_inc.php')?>
        </div>
    </div>
</body>
</html>