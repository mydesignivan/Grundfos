<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?=TITLE_GLOBAL . @$tlp_title;?></title>
    <base href="<?=base_url();?>" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="robots" content="none" />
    <link href="images/favicon.ico" rel="stylesheet icon" type="image/ico" />
<?php
    if( isset($tlp_script) && !empty($tlp_script) ) $tlp_script = '/'.implode('/', $tlp_script);
    //INCLUYE LOS SCRIPT CSS
    echo '<link rel="stylesheet" href="'.site_url('/load/css/initializer_panel'.@$tlp_script).'" type="text/css" media="screen, projection" />'.chr(13);
?>
    <!--[if lt IE 8]><link rel="stylesheet" href="css/blueprint/ie.css" type="text/css" media="screen, projection"/><![endif]-->
    <!--[if IE 6]>
    <link href="css/style_ie6.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <!--[if IE 7]>
    <link href="css/styleIE7.css" rel="stylesheet" type="text/css" />
    <![endif]-->
    <script type="text/javascript" src="<?=site_url("load/js/initializer_panel")?>"></script>
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
    <div class="header-bg2"></div>
    <div class="container">
        <div class="span-24 last header2"> 
        <?php require('includes/header_panel_inc.php')?>
        </div>
        <div class="clear span-24 last main-container">
            <div class="contents">
                <?php
                    if( isset($tlp_title_section) ) echo '<h1 class="title">'.$tlp_title_section.'</h1>';
                    require($tlp_section);
                ?>
            </div>
        </div>
        <div class="clear span-24 last footer"> 
        <?php require('includes/footer_panel_inc.php')?>
        </div>
    </div>
</body>
</html>