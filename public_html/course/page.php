<?php
require_once('site-config.php');
require_once('authorize.php');
require_once( './common/builders.php' );
session_start();

if(isAuthAlive() == true)
{
	session_regenerate_id(TRUE);
	$buildersObj = new builders();
	$buildersObj->get_all_setting( $settings_data );
	$data['site_name'] = $settings_data['site_name'];
	$data['head'] = $settings_data['head'];
	$data['css'] = $settings_data['css'];
}
else {
	$_SESSION = array();
	@session_destroy();
	header("Location:index.php");
}

if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	$buildersObj->get_data($_REQUEST, $form_data);
	$buildersObj->get_all_sidebar( $sidebars_data );
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	$buildersObj->get_content( $form_data['page'], $contents_data );

	$data['description'] = $contents_data['description'];
	$data['keyword'] = $contents_data['keyword'];
	$data['title'] = htmlspecialchars_decode($contents_data['title']);
	if($contents_data['add_br']==1){
		$data['contents'] = $buildersObj->br_replace($contents_data['contents']);
	}else{
		$data['contents'] = htmlspecialchars_decode($contents_data['contents']);
	}
	$freearea_upper = htmlspecialchars_decode($side_freeareas_data[0]['contents']);
	$freearea_lower = htmlspecialchars_decode($side_freeareas_data[1]['contents']);
}
include("./template/".$settings_data['contents_template']);
?>