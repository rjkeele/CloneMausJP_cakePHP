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
<div class="container" id="container">
<div id="content">
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="post" id="TitleEditForm" action="">
<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
<fieldset>
<legend>ヘッダー追加</legend>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str )
	{
		echo $str;
	}
	echo '</div>';
}
elseif(isset( $message )) {
	echo '<div class="alert alert-success">';
	echo $message;
	echo '</div>';
}
else {
	echo '<div class="waku"><p>自動返信メールのテンプレートを作成します。</p>';
	require_once( '../../common/element/help_re_text.php' );
	echo '</div>';
}
?>
<div class="control-group">
<label class="control-label" for="title">
<span class="red">*</span>ヘッダー</label>
<div class="controls required">
<textarea id="HeaderContent" rows="6" class="input-xxlarge" cols="5" name="header"><?php echo $headersObj->show_esc($form_data['header']); ?></textarea>
</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="add_done" name="status">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/headers/">キャンセル</a></div></form>
</div>
</div>
</div>
</body>
</html>
