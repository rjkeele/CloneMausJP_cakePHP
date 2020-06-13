<?php
/*
 * install.php
 *
 * date		2013-12-24
 * auther	
 * note		install
 */

define('FNAME_ORG_INI','../common/config_org.ini'); 
define('FNAME_INI','../common/config.ini'); 

function get_data( $data, &$aryData )
{
	$aryData = array();
	foreach($data as $key=>$value) {
		$$key = isset($value) ? htmlspecialchars($value, ENT_QUOTES) : NULL ;
		$reqData[$key] = $$key;
		$aryData = $reqData;
	}
}
if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	get_data($_REQUEST, $form_data);
}
if(empty($form_data['status'])){
	$form_data['status']='';
	$form_data['url']='';
	
	$url='http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
	$url = preg_replace('!/[^/]*$!', '/', $url);
	$url = rtrim($url, '/');
	$url = preg_replace('!/[^/]*$!', '/', $url);
	$url = rtrim($url, '/');
}

echo <<< EOD
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
</head>
<body>
EOD;



if(empty($form_data['status'])):
	echo <<< EOD
<h1>Cyfonsインストール(1/3)</h1>
<p>アプリケーションを設置するアドレスはこちらであっていますか？</p>
<p>　設置するアドレス：{$url}</p>
<p>もし違う場合、上手く自動取得できていない場合は<br>
こちらのフォームに正しく入力して下さい。</p>
<form method="post">
<input type="textarea" name="url" value="{$url}" style="width:250px;">
<input type="hidden" name="status" value="confirm1">
<input type="submit" value="次に進む"><br>
<span style="color:red;font-size:12px;">※入力例　http://exsample.com<br>
　最後にスラッシュはつけないでください。</span>
</form>
EOD;
endif;



if($form_data['status']=='confirm1'):
	$url=$form_data['url'];
	$str = file_get_contents(FNAME_ORG_INI);
	$str2 = str_replace('YOURURL', $url, $str);
	file_put_contents(FNAME_INI, $str2);
	echo <<< EOD
<h1>Cyfonsインストール(2/3)</h1>
<p>データベースの設定をします。</p>
<form method="post">
データベース名<br>
<input type="textarea" name="dbname" style="width:250px;"><br>
ログインユーザー名<br>
<input type="textarea" name="dbuser" style="width:250px;"><br>
ログインパスワード<br>
<input type="textarea" name="dbpassword" style="width:250px;"><br>
mysql名<br>
<input type="textarea" name="mysql" style="width:250px;"><br>
<input type="hidden" name="status" value="confirm2">
<input type="submit" value="次に進む">
</form>
EOD;
endif;

if($form_data['status']=='confirm2'):
	$dbname=$form_data['dbname'];
	$dbuser=$form_data['dbuser'];
	$dbpassword=$form_data['dbpassword'];
	$mysql=$form_data['mysql'];
	$str = file_get_contents(FNAME_INI);
	$str = str_replace('DBNAME', $dbname, $str);
	$str = str_replace('DBUSER', $dbuser, $str);
	$str = str_replace('DBPASSWORD', $dbpassword, $str);
	$str = str_replace('MYSQL', $mysql, $str);
	file_put_contents(FNAME_INI, $str);
	$form_data['status']='sql';
endif;

if($form_data['status']=='sql'):
echo '<h1>Cyfonsインストール(3/3)</h1>';
require_once( '../common/bodys.php' );
$Obj = new bodys();
$sql = "CREATE TABLE IF NOT EXISTS `bodys` (
  `id` int(11) NOT NULL auto_increment,
  `title` text,
  `body` text,
  `type` int(11) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `bodys`<br>";

$sql = "INSERT INTO `bodys` (`id`, `title`, `body`, `type`, `created`, `modified`) VALUES
(1, '登録ありがとうございます。', '%firstname%様\r\n\r\n登録ありがとうございます。\r\nすぐに会員サイトをお使いいただくことができます。\r\n\r\nURL：%url%\r\nパスワード：%password%\r\n\r\n登録情報\r\n会員名\r\n%firstname%%lastname%\r\n\r\n注文ID\r\n%order_no%\r\n\r\n\r\n配信解除はこちらから。\r\nワンクリックで解除されますのでご注意下さい。\r\n%stopurl%\r\n', 0,  NOW(), NULL),
(2, '登録解除されました。', '解除が完了しました。\nこれまでのお付き合いありがとうございました。\nまた機会ありましたらどうぞよろしくお願いします。', 1, NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルにデータを設定しました。 `bodys`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `extra_mails` (
  `id` int(11) NOT NULL auto_increment,
  `scenario_id` int(11) default NULL,
  `title` varchar(200) default NULL,
  `header_id` int(11) default NULL,
  `contents` text,
  `footer_id` int(11) default NULL,
  `send_time` datetime default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`),
  KEY `scenario_id` (`scenario_id`),
  KEY `header_id` (`header_id`),
  KEY `footer_id` (`footer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `extra_mails`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `extra_mail_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` char(14) DEFAULT NULL,
  `extra_mail_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `contents` text NOT NULL,
  `send_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `send_flg` int(11) DEFAULT '0',
  `deleted` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `extra_mail_id` (`extra_mail_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `extra_mail_logs`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `footers` (
  `id` int(11) NOT NULL auto_increment,
  `footer` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `footers`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `headers` (
  `id` int(11) NOT NULL auto_increment,
  `header` text,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `headers`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `scenarios` (
  `id` int(11) NOT NULL auto_increment,
  `scenario` varchar(200) default NULL,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `scenarios`<br>";



$sql = "INSERT INTO `scenarios` (`id`, `scenario`, `created`, `modified`) VALUES
(1, 'シナリオ１', NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルテーブルにデータを設定しました。 `scenarios`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_password` varchar(40) DEFAULT NULL,
  `form_password` varchar(40) DEFAULT NULL,
  `from_email` varchar(100) DEFAULT NULL,
  `name_email` varchar(100) DEFAULT NULL,
  `reply_email` varchar(100) DEFAULT NULL,
  `send_err_num` int(11) DEFAULT '3',
  `send_err` int(11) DEFAULT '0',
  `send_stop` int(11) DEFAULT '0',
  `send_num` int(11) DEFAULT '100',
  `send_interval` int(11) DEFAULT '1',
  `automail_add_admin` int(11) DEFAULT '0',
  `automail_stop_admin` int(11) DEFAULT '0',
  `automail_add_user` int(11) DEFAULT '0',
  `automail_stop_user` int(11) DEFAULT '0',
  `form_order_no` int(11) DEFAULT '0',
  `form_is_password` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `settings`<br>";



$sql = "INSERT INTO `settings` (`id`, `user_password`, `form_password`, `from_email`, `name_email`, `reply_email`, `send_err_num`, `send_err`, `send_stop`, `send_num`, `send_interval`, `automail_add_admin`, `automail_stop_admin`, `automail_add_user`, `automail_stop_user`, `form_order_no`, `form_is_password`, `created`, `modified`) VALUES
(1, 'k8g4t3ng1', '123456789', NULL, NULL, NULL, 3, 0, 0, 1, 3, 0, 0, 1, 1, 0, 1, NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルテーブルにデータを設定しました。 `settings`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `step_mails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scenario_id` int(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `header_id` int(11) DEFAULT NULL,
  `contents` text,
  `footer_id` int(11) DEFAULT NULL,
  `story_no` int(11) DEFAULT NULL,
  `send_flg` int(11) DEFAULT '0',
  `send_date` int(11) DEFAULT '0',
  `send_time` time DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `header_id` (`header_id`),
  KEY `footer_id` (`footer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `step_mails`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `step_mail_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` char(14) DEFAULT NULL,
  `step_mail_id` int(11) DEFAULT NULL,
  `title` varchar(200) NOT NULL,
  `contents` text NOT NULL,
  `story_no` int(11) NOT NULL,
  `send_date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `send_flg` int(11) DEFAULT '0',
  `deleted` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `step_mail_id` (`step_mail_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `step_mail_logs`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `firstname` varchar(100) DEFAULT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `order_no` varchar(100) DEFAULT NULL,
  `data1` int(11) DEFAULT NULL,
  `scenario_id` int(11) DEFAULT NULL,
  `auth` int(11) DEFAULT '0',
  `delete_flg` int(11) DEFAULT '0',
  `deleted` datetime DEFAULT NULL,
  `send_date` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY  (`id`),
  KEY `scenario_id` (`scenario_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
$Obj->db_sql( $sql );
echo "テーブルを作成しました。 `users`<br>";



$sql = "INSERT INTO `users` (`id`, `email`, `password`, `firstname`, `lastname`, `order_no`, `data1`, `scenario_id`, `auth`, `delete_flg`, `deleted`, `send_date`, `created`, `modified`)
VALUES(1, 'admin@admin.admin', '7c4a8d09ca3762af61e59520943dc26494f8941b', 'システム管理者', NULL, NULL, NULL, NULL, 9, 0, NULL, NULL, NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルにデータを設定しました。 `users`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `tp_contents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(400) DEFAULT NULL,
  `keyword` varchar(400) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `contents` text,
  `add_br` int(11) DEFAULT '1',
  `url` varchar(200) DEFAULT NULL,
  `public_date` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_contents`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `tp_img_uploaders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `org_file` varchar(200) DEFAULT NULL,
  `store_file` varchar(200) DEFAULT NULL,
  `store_folder` varchar(200) DEFAULT NULL,
  `thumbnail` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_img_uploaders`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `tp_inquirys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `contents` text NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_inquirys`<br>";



$sql = "INSERT INTO `tp_inquirys` (`id`, `title`, `contents`, `created`, `modified`) VALUES
(1, 'お問い合わせありがとうございました。', 'お問い合わせありがとうございました。\r\n早急にご返信致しますので今しばらくお待ちください。\r\n\r\n送信内容は以下になります。', NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルにデータを設定しました。 `tp_inquirys`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `tp_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `site_name` varchar(200) DEFAULT NULL,
  `head` varchar(400) DEFAULT NULL,
  `css` varchar(400) DEFAULT NULL,
  `top_template` varchar(400) DEFAULT NULL,
  `contents_template` varchar(400) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_settings`<br>";



$sql = "INSERT INTO `tp_settings` (`id`, `site_name`, `head`, `css`, `top_template`, `contents_template`, `created`, `modified`) VALUES
(1, 'サイト名', '&lt;meta name=&quot;author&quot; content=&quot;AUTHOR&quot;&gt;', 'add.css', 'main.php', 'page.php', NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルにデータを設定しました。 `tp_settings`<br>";


$sql = "CREATE TABLE IF NOT EXISTS `tp_sidebars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contents_id` int(11) DEFAULT NULL,
  `side_title_id` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contents_id` (`contents_id`),
  KEY `side_title_id` (`side_title_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_sidebars`<br>";


$sql = "CREATE TABLE IF NOT EXISTS `tp_side_freeareas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contents` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_side_freeareas`<br>";



$sql = "INSERT INTO `tp_side_freeareas` (`id`, `contents`, `created`, `modified`) VALUES
(1, '上部フリーエリア', NOW(), NULL),
(2, '下部フリーエリア', NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルにデータを設定しました。 `tp_side_freeareas`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `tp_side_titles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_side_titles`<br>";



$sql = "CREATE TABLE IF NOT EXISTS `tp_tops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(400) DEFAULT NULL,
  `keyword` varchar(400) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `contents` text,
  `add_br` int(11) DEFAULT '1',
  `url` varchar(200) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2";
$Obj->db_sql( $sql );
echo "テーブルを作成しました `tp_tops`<br>";



$sql = "INSERT INTO `tp_tops` (`id`, `description`, `keyword`, `title`, `contents`, `add_br`, `url`, `public`, `created`, `modified`) VALUES
(1, 'トップページディスクリプション', 'トップページキーワード', 'トップページタイトル', 'トップページの記事です。', 1, 'index', 1, NOW(), NULL)";
$Obj->db_sql( $sql );
echo "テーブルにデータを設定しました。 `tp_tops`<br>";
echo '<p><b>初期設定が完了しました。</b><br>';
echo 'ログインして管理者情報を入力して下さい</p>';
echo '<b>初期設定値</b><br>';
echo 'ID：admin@admin.admin<br>';
echo 'PW：123456</p>';
echo '=><a href="./">管理画面</a>';
endif;



echo '</body>';
echo '</html>';
?>