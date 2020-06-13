<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div id="content">
<div class="titles index">
<h2>登録時自動返信</h2>
<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p style="margin-top:20px;">登録フォームから会員登録した時の自動返信メールを設定します。</p>
<p style="margin-top:0;"><i style="margin-top:0px;" class="icon-ok-sign"></i>右端にある「編集」で編集できます。</p>
<?php require( '../../common/element/help_re_text.php' ); ?>
</div>
<?php
if(isset( $message_add )) {
	echo '<div class="alert alert-success">';
	echo $message_add;
	echo '</div>';
}
?>
<table cellspacing="0" cellpadding="0">
<thead>
<tr>
<th style="width:30%;">タイトル</th>
<th>本文</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
if( isset( $data_add ))
{
	$cnt = $start;
	foreach( $data_add as $col )
	{
		$cnt++;
		$body = nl2br( mb_substr($col['body'], 0, 10000 ));
		$url = URL;
		echo <<< EOD
<tr>
<td>{$col['title']}</td>
<td>{$body}</td>
<td class="actions">
<a href="{$url}/admin/bodys/index.php?status=edit&id={$col['id']}">編集</a>
</td>
</tr>
EOD;
	}
}
?>
</tbody>
</table>
</div>
<div class="titles index" style="margin-top:50px;">
<h2>解除時自動返信</h2>
<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p style="margin-top:20px;">会員解除した時の自動送信メールを設定します。</p>
<p style="margin-top:0;"><i style="margin-top:0px;" class="icon-ok-sign"></i>右端にある「編集」で編集できます。</p>
<?php require( '../../common/element/help_re_text.php' ); ?>
</div>
<?php
if(isset( $message_delete )) {
	echo '<div class="alert alert-success">';
	echo $message_delete;
	echo '</div>';
}
?>
<table cellspacing="0" cellpadding="0">
<thead>
<tr>
<th style="width:30%;">タイトル</th>
<th>本文</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
if( isset( $data_delete ))
{
	$cnt = $start;
	foreach( $data_delete as $col )
	{
		$cnt++;
		$body = nl2br( mb_substr($col['body'], 0, 10000 ));
		$url = URL;
		echo <<< EOD
<tr>
<td>{$col['title']}</td>
	<td>{$body}</td>
<td class="actions">
<a href="{$url}/admin/bodys/index.php?status=edit&id={$col['id']}">編集</a>
</td>
</tr>
EOD;
	}
}
?>
</tbody>
</table>
</div>
</div>
</div>
</body>
</html>
