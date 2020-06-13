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
<div class="users form">
	<form class="form-horizontal">
	<fieldset>
		<legend>登録フォームタグ</legend>
<?php
if( isset( $err['all'] ))
{
	echo '<div class="alert alert-error">';
	echo '<div style="color:#aa0000">'.$err['all'].'</div>';
	echo '</div>';
}
else {
	echo '<div class="waku">下のHTMLタグをコピーして、設置したいブログやサイトに張り付けて使用してください。</div>';
}
?>
		<div class="control-group">
		<label class="control-label" for="form_html">登録フォーム<br>貼り付け用タグ</label>
		<div class="controls">
		<textarea name="form_html" id="FormHtml" class="input-xxlarge" rows="10" cols="10"><?php echo $form_data['form_html']; ?></textarea>
		</label>
		</div>
		</div>
	</fieldset>
	</form>
</div>
</body>
</html>
