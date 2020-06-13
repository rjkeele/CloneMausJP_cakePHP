<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div class="users form">
	<form accept-charset="utf-8" method="post" id="AdminEditForm" class="form-horizontal" action="">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>管理者情報修正</legend>
		<?php
		if( isset( $err['password'] ))
		{
		echo '<div class="alert alert-error">';
		echo $err['password'];
		echo '</div>';
		} elseif(isset( $message ))
		{
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
		} else {
			echo '<div class="waku">管理者のログインメールアドレス(ID)とパスワードを設定します。<br />メールアドレスは送信元メールアドレスとして使用されます。</div>';
		}
		?>
		<div class="control-group">
		<label class="control-label" for="title_id"><span class="red">*</span>メールアドレス（ID）</label>
		<div class="controls required">
		<input type="txtarea" id="Email" value="<?php echo $form_data['email']; ?>" class="input-xlarge" name="email">
		<?php if( !empty( $err['email'] )) echo '<div class="green fs12">'.$err['email'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">パスワード</label>
		<div class="controls required">
		<input type="password" id="Pass1" value="<?php echo $form_data['password1']; ?>" class="input-xlarge" name="password1">
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">パスワード再入力</label>
		<div class="controls required">
		<input type="password" id="Pass2" value="<?php echo $form_data['password2']; ?>" class="input-xlarge" name="password2">
		</div>
		</div>
		<div class="control-group">
		<div class="controls">
		<span class="red">*</span> がついている項目はかならず入力してください。
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
	<input type="hidden" value="admin_edit" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px">保存</button><a class="btn" href="<?php echo URL; ?>/admin/">キャンセル</a>
	</div>
	</form>
</div>
</body>
</html>
