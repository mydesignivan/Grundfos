<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<fieldset class="fieldset-categories">
    <legend>Categor&iacute;as</legend>

    <div class="cont-treeview">
        <ul id="treeview" class="filetree">
            <li><span id="id0" class='folder'>Contenidos</span>
                <?=$treeview?>
            </li>
        </ul>
    </div>

    <div class="clear">
        <a href="javascript:void(Contents.content_new())" class="link-img"><img src="images/icon-new.png" alt="" width="16" height="16" /> Nuevo</a>
        <a id="linkCatDel" href="javascript:void(Contents.cotnent_delete())" class="link-img hide"><img src="images/icon-delete.png" alt="" width="16" height="16" /> Eliminar</a>
    </div>
</fieldset>
<fieldset id="fieldset-form" class="fieldset-form">
    <legend>Contenidos</legend>
    <div id="cont-products" class="cont-products"></div>
    <div id="busy" class="busy"></div>
</fieldset>