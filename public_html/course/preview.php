<?php
require_once( './common/config.ini' );
require_once( './common/builders.php' );
session_start();

	$buildersObj = new builders();
	$buildersObj->get_all_setting( $settings_data );
	$data['site_name'] = $settings_data['site_name'];
	$data['head'] = $settings_data['head'];
	$data['css'] = $settings_data['css'];
	$_SESSION['tes_REG_DATE'] = date('Y/m/d', strtotime( "-3600 day" ));

if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	$buildersObj->get_data($_REQUEST, $form_data);
	$buildersObj->get_all_sidebar( $sidebars_data );
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	$data['description'] = '';
	$data['keyword'] = '';
	$data['contents'] = $form_data['contents'];
	$data['title'] = htmlspecialchars_decode($form_data['title']);
	if($form_data['add_br']==1){
		$data['contents'] = $buildersObj->br_replace($data['contents']);
	}else{
		$data['contents'] = htmlspecialchars_decode($data['contents']);
	}
	$freearea_upper = htmlspecialchars_decode($side_freeareas_data[0]['contents']);
	$freearea_lower = htmlspecialchars_decode($side_freeareas_data[1]['contents']);
}
if( $form_data['layout'] == 'top' )
{
	include("./template/".$settings_data['top_template']);
}
elseif( $form_data['layout'] == 'page' ){
	include("./template/".$settings_data['contents_template']);
}
?>