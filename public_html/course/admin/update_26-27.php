<?php
/*
 * update_26-27.php
 *
 * date		2013-12-27
 * auther	
 * note		update 0.26 to 0.27
 * 			db add settings.form_is_password
 *			ini add URLADD, FNAME_FORM
 */

define('FNAME_ORG_INI','../common/config_org.ini'); 
define('FNAME_INI','../common/config.ini'); 
require_once('../common/main.php');
$Obj = new main();
$version = $Obj->get_version();
$update_ini_txt="\r\ndefine( 'URLADD',  URL . '/formadd/' );\r\ndefine( 'FNAME_FORM','form.php' );\r\n";
$ng_txt='URLADD';

function get_data( $data, &$aryData )
{
	$aryData = array();
	foreach($data as $key=>$value) {
		$$key = isset($value) ? htmlspecialchars($value, ENT_QUOTES) : NULL ;
		$reqData[$key] = $$key;
		$aryData = $reqData;
	}
}

if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	get_data($_REQUEST, $form_data);
}

if(empty($form_data['status'])){
	$form_data['status']='';
}

echo <<< EOD
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
EOD;


if(empty($form_data['status'])){
	echo <<< EOD
<h1>Cyfonsシステムアップデート(1/3)</h1>
<p>Ver.0.26から0.27へバージョンアップします。</p>
<p>よろしければ「次に進む」をクリックしてください。</p>
<form method="post">
<input type="hidden" name="status" value="confirm1">
<input type="submit" value="次に進む">
</form>
EOD;
}else{
	if($version != '0.27'){/* ftp upload ng */
		echo <<< EOD
<h1>Cyfonsシステムアップデート(1/3)</h1>
<p>このプログラムはVer.0.26から0.27へのバージョンアップ対象となります。</p>
<p><span style="color:red;font-weight:bold;">お使いのシステムはバージョンアップ対象ではありません。</span></p>
<p>プログラムを終了します。</p>
EOD;
		return;
	}
}

if($form_data['status']=='confirm1'){
echo '<h1>Cyfonsシステムアップデート(2/3)</h1>';
	if( file_exists( FNAME_INI )){
		$str = file_get_contents(FNAME_INI);
		if(!strstr($str,$ng_txt)) {
			$str = rtrim($str);
			$str = rtrim($str,'?>');
			$str.= $update_ini_txt;
			file_put_contents(FNAME_INI, $str);
			echo <<< EOD
<p>設定ファイル（config.ini）を修正しました。</p>
<p>続いてデータベースに追加設定をします。</p>
<form method="post">
<input type="hidden" name="status" value="confirm2">
<input type="submit" value="次に進む">
</form>
EOD;
		} else {
			echo "<p>すでにアップデートされています。</p>";
			return;
		}
	} else {
		echo "<p>設定ファイルが存在しません。</p>";
	}
	return;
}

if($form_data['status']=='confirm2'):
echo '<h1>Cyfonsシステムアップデート(3/3)</h1>';
$sql = "ALTER TABLE `settings` ADD `form_is_password` INT NOT NULL DEFAULT '1' AFTER `form_order_no`";
$Obj->db_sql( $sql );
echo "<p>テーブルにカラムを追加しました。 `settings.form_is_password`</p>";
echo '<p><b>アップデートが完了しました。</b></p>';
echo '<p>現在のバージョンは'.$version.'です。</p>';
echo '<p>ログインして下さい</p>';
echo '=><a href="./">管理画面</a>';
endif;

echo '</body>';
echo '</html>';
?>