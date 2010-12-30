<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<div id="error" class="error hide">Los datos no pudieron ser guardados.</div>
<div id="success" class="success hide">Los datos fueron guardados con &eacute;xito.</div>

<form id="form1" class="form-products" action="<?=site_url('/panel/contents/ajax_'. (isset($info) ? 'edit' : 'create'));?>" method="post" enctype="application/x-www-form-urlencoded">
    <div class="trow">
        <label class="label">Contenido Padre:</label>
        <span id="txtParentCat"></span>
    </div>
    <div class="trow">
        <label class="label" for="txtTitle">* T&iacute;tulo</label>
        <div class="fleft"><input type="text" name="txtTitle" id="txtTitle" value="<?=@$info['title']?>" /></div>
    </div>
    <div class="trow">
        * Contenido<div class="clear"></div>
        <textarea rows="10" cols="22" id="txtContent" name="txtContent"><?=@$info['content']?></textarea>
    </div>

    <div class="trow">
        Contenido sidebar<br /><div class="clear"></div>
        <textarea rows="10" cols="22" id="txtContentSidebar" name="txtContentSidebar"><?=@$info['content_sidebar']?></textarea>
    </div>

    <div class="trow">
        <div class="fleft">
            <fieldset class="gallery-panel">
                <legend>Galer&iacute;a de Im&aacute;genes</legend>
                <div class="cont">
                    <ul id="gallery-image" <?php if( !isset($info) || (isset($info) && count($info['gallery'])==0) ){?>class="hide"<?php }?>>
            <?php if( isset($info) && count($info['gallery'])>0 ){?>
                <?php foreach( $info['gallery'] as $row ){?>
                        <li>
                            <a href="<?=UPLOAD_PATH_SIDEBAR.$row['image']?>" class="jq-image" rel="group"><img src="<?=UPLOAD_PATH_SIDEBAR.$row['thumb']?>" alt="<?=$row['thumb']?>" width="130" height="90" /></a>
                            <div class="d1 clear">
                                <a href="javascript:void(0)" class="link2 fleft jq-removeimg"><img src="public/images/icon_delete.png" alt="" width="16" height="16" />Quitar</a>
                                <a href="javascript:void(0)" class="fright handle"><img src="public/images/icon_arrow_move2.png" alt="" width="16" height="16" /></a>
                            </div>
                        </li>
                <?php }?>

            <?php }else{?>
                        <li>
                            <a href="" class="jq-image" rel="group"><img src="" alt="" width="" height="" /></a>
                            <div class="d1 clear">
                                <a href="javascript:void(0)" class="link2 fleft jq-removeimg"><img src="public/images/icon_delete.png" alt="" width="16" height="16" />Quitar</a>
                                <a href="javascript:void(0)" class="fright handle"><img src="public/images/icon_arrow_move2.png" alt="" width="16" height="16" /></a>
                            </div>
                        </li>
            <?php }?>
                    </ul>

                </div>
            </fieldset>

            <div class="fleft clear">
                <div class="span-14 last">
                    <input type="file" size="22" name="txtUploadFile" id="txtUploadFile" />&nbsp;
                    <button id="btnUpload" type="button" onclick="PictureGallery.upluad()" class="gallery-panel-upload">Subir</button>&nbsp;
                    <img id="ajax-loader1" src="public/images/ajax-loader4.gif" alt="Loading..." width="43" height="11" class="hide" />
                </div>
                <div class="clear span-10"><label class="label-leyend">M&aacute;ximo 2 megas por foto (gif, jpg, jpeg o png)</label></div>
                <div id="pg-msgerror" class="clear error span-7 hide"></div>
            </div>
        </div>
    </div>

    <input type="hidden" name="content_id" id="content_id" value="<?=@$info['content_id']?>" />
</form>