<?php if ( !defined( 'ABSPATH' ) ) exit();

foreach (glob( OVAEM_PLUGIN_PATH.'/widgets/*.php' ) as $filename){
	require_once $filename;

}


 ?>