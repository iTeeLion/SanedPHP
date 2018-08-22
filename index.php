<?php 
ini_set('short_open_tag', '1');
include_once 'sanedPHP.class.php';

$TEMPLATE_DIR = 'templates/bs4';
$LANG_FILE = 'lang/ru_RU.php';

$SNDPHP = new sanedPHP;
if($_REQUEST['op'] == 'doscan'){
	$scan = $SNDPHP->makeScan($_REQUEST);
}

include_once $LANG_FILE;
include_once $TEMPLATE_DIR.'/index.php';