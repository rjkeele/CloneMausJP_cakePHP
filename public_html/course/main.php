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

if( !$buildersObj->get_all_top( $tops_data ))
{
	echo $err['top'] = "トップページが作成されていません。";
}
else {
	$data['description'] = $tops_data['description'];
	$data['keyword'] = $tops_data['keyword'];
	$data['title'] = htmlspecialchars_decode($tops_data['title']);
	if($tops_data['add_br']==1){
		$data['contents'] = $buildersObj->br_replace($tops_data['contents']);
	}else{
		$data['contents'] = htmlspecialchars_decode($tops_data['contents']);
	}
}
if( !$buildersObj->get_all_sidebar( $sidebars_data ))
{
	$err['sidebar'] = "サイドバーが作成されていません。";
}
else {
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	$freearea_upper = htmlspecialchars_decode($side_freeareas_data[0]['contents']);
	$freearea_lower = htmlspecialchars_decode($side_freeareas_data[1]['contents']);
}
include("./template/".$settings_data['top_template']);
?>