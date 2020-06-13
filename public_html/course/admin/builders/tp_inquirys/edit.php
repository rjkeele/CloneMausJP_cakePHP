<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container" id="container">
<div id="content">
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="post" id="InquirysEditForm" action="">
<fieldset>
<legend>自動返信メール編集</legend>
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
	echo '<div class="waku"><p>自動返信メールのタイトルと本文を編集します。</p></div>';
}
?>
<div class="control-group">
<label class="control-label" for="title">
<span class="red">*</span>タイトル</label>
<div class="controls required">
<input id="TitleInquiry" class="input-xxlarge" type="txtarea" name="title" value="<?php echo $buildersObj->show_esc($form_data['title']); ?>">
</div>
<label class="control-label" for="contents">
<span class="red">*</span>本文</label>
<div class="controls required">
<textarea id="ContentsInquiry" rows="6" class="input-xxlarge" cols="5" name="contents"><?php echo $buildersObj->show_esc($form_data['contents']); ?></textarea>
</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="edit_done" name="status">
<input type="hidden" value="<?php echo $form_data['id']; ?>" name="id">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys/">キャンセル</a></div></form>
</div>
</div>
</div>
</body>
</html>
