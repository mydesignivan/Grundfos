<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 				'rb');
define('FOPEN_READ_WRITE',			'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 	'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 			'ab');
define('FOPEN_READ_WRITE_CREATE', 		'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 		'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',	'x+b');


/*
|--------------------------------------------------------------------------
| NOMBRE DE LAS TABLAS (BASE DE DATO)
|--------------------------------------------------------------------------
*/
define('TBL_USERS',                       'users');
define('TBL_CONTENTS',                    'contents');
define('TBL_LIST_COUNTRY',                'list_country');
define('TBL_LIST_STATES',                 'list_states');
define('TBL_TESTIMONIALES',               'testimoniales');
define('TBL_NOTICIAS',                    'noticias');
define('TBL_GALLERY_CONTENTS',            'gallery_contents');
define('TBL_CATEGORIES',                  'categories');
define('TBL_PRODUCTS',                    'products');

/*
|--------------------------------------------------------------------------
| MENSAJES DE ERROR PARA UPLOAD
|--------------------------------------------------------------------------
*/
define('ERR_UPLOAD_NOTUPLOAD', 'El archivo no ha podido llegar al servidor.');
define('ERR_UPLOAD_MAXSIZE', 'El tamaño del archivo debe ser menor a {size} MB.');
define('ERR_UPLOAD_FILETYPE', 'El tipo de archivo es incompatible.');

/*
|--------------------------------------------------------------------------
| EMAIL FORM CONTACTO
|--------------------------------------------------------------------------
*/
$msg = '
    <b>Compa&ntilde;&iacute;a:</b> {company}<br />
    <b>Nombre:</b> {name}<br />
    <b>Direcci&oacute;n:</b> {address}<br />
    <b>Ciudad:</b> {city}<br />
    <b>C&oacute;digo Postal:</b> {postcode}<br />
    <b>Pa&iacute;s:</b> {country}<br />
    <b>Provincia:</b> {state}<br />
    <b>E-Mail:</b> {email}<br />
    <b>Telefono:</b> {phone}<br />
    <b>Fax:</b> {fax}<br />
    <b>Tema:</b> {theme}
    <b>Mensaje:</b><br />{message}
';
define('EMAIL_CONTACT_SUBJECT', 'Formulario de Contacto');
define('EMAIL_CONTACT_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| EMAIL FORM SOLICITE CAPACITACION
|--------------------------------------------------------------------------
*/
$msg = '
    <b>Compa&ntilde;&iacute;a:</b> {company}<br />
    <b>Nombre:</b> {name}<br />
    <b>Direcci&oacute;n:</b> {address}<br />
    <b>Ciudad:</b> {city}<br />
    <b>C&oacute;digo Postal:</b> {postcode}<br />
    <b>Pa&iacute;s:</b> {country}<br />
    <b>Provincia:</b> {state}<br />
    <b>E-Mail:</b> {email}<br />
    <b>Telefono:</b> {phone}<br />
    <b>Fax:</b> {fax}<br />
    <b>Tema:</b> {theme}
    <b>Mensaje:</b><br />{message}
';
define('EMAIL_SOLCAP_SUBJECT', 'Solicitud de capacitación');
define('EMAIL_SOLCAP_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| EMAIL FORM CV
|--------------------------------------------------------------------------
*/
$msg = '
    <b>Nombre:</b> {name}<br />
    <b>E-Mail:</b> {email}<br />
    <b>Comentario:</b><br />
    {comment}
';
define('EMAIL_CV_SUBJECT', 'Grundfos - Curriculum Vitae');
define('EMAIL_CV_MESSAGE', $msg);

/*
|--------------------------------------------------------------------------
| UPLOAD FILE
|--------------------------------------------------------------------------
*/
define('UPLOAD_FILETYPE', 'gif|jpg|png');
define('UPLOAD_MAXSIZE', 2048); //Expresado en Kylobytes

define('UPLOAD_PATH_PRODUCTS', './uploads/products/');
define('UPLOAD_PATH_SIDEBAR', './uploads/sidebar/');
define('UPLOAD_PATH_BANNER', './uploads/banner/');
define('UPLOAD_PATH_CV', './uploads/cv/');

define('IMAGESIZE_WIDTH_THUMB_PRODUCTS', 141);
define('IMAGESIZE_HEIGHT_THUMB_PRODUCTS', 108);
define('IMAGESIZE_WIDTH_FULL_PRODUCTS', 320);
define('IMAGESIZE_HEIGHT_FULL_PRODUCTS', 260);

define('IMAGESIZE_WIDTH_THUMB_SIDEBAR', 150);
define('IMAGESIZE_HEIGHT_THUMB_SIDEBAR', 100);
define('IMAGESIZE_WIDTH_FULL_SIDEBAR', 320);
define('IMAGESIZE_HEIGHT_FULL_SIDEBAR', 260);

define('IMAGESIZE_WIDTH_THUMB_BANNER', 234);
define('IMAGESIZE_HEIGHT_THUMB_BANNER', 175);


/*
|--------------------------------------------------------------------------
| TITULOS DE CADA SECCION
|--------------------------------------------------------------------------
*/
define('TITLE_GLOBAL', 'Bottino Hnos Subfactory Grundfos'); // Titulo para todas las secciones
define('TITLE_INDEX', '');
define('TITLE_EMPRESA', ' - Empresa');
define('TITLE_PRODUCTOS', ' - Productos');
define('TITLE_SERVICIOS', ' - Servicios');
define('TITLE_TESTIMONIALES', ' - Testimoniales');
define('TITLE_CONTACTO', ' - Contacto');
define('TITLE_DONDESTAMOS', ' Donde Estamos');
define('TITLE_NOTICIAS', ' Noticias');



/*
|--------------------------------------------------------------------------
| META - Palabras Claves y Descripcion de la web
|--------------------------------------------------------------------------
*/
define('META_KEYWORDS_GLOBAL', '');
define('META_KEYWORDS_INDEX', '');
define('META_KEYWORDS_EMPRESA', '');
define('META_KEYWORDS_PRODUCTOS', '');
define('META_KEYWORDS_SERVICIOS', '');
define('META_KEYWORDS_TESTIMONIALES', '');
define('META_KEYWORDS_CONTACTO', '');
define('META_KEYWORDS_DONDESTAMOS', '');
define('META_KEYWORDS_NOTICIAS', '');

define('META_DESCRIPTION_GLOBAL', '');
define('META_DESCRIPTION_INDEX', '');
define('META_DESCRIPTION_EMPRESA', '');
define('META_DESCRIPTION_PRODUCTOS', '');
define('META_DESCRIPTION_SERVICIOS', '');
define('META_DESCRIPTION_TESTIMONIALES', '');
define('META_DESCRIPTION_CONTACTO', '');
define('META_DESCRIPTION_DONDESTAMOS', '');
define('META_DESCRIPTION_NOTICIAS', '');

/*
|--------------------------------------------------------------------------
| CONFIGURACION GENERAL
|--------------------------------------------------------------------------
*/
define('CACHE_TIME', 5);
define('LANG', 1);


/* End of file constants.php */
/* Location: ./system/application/config/constants.php */