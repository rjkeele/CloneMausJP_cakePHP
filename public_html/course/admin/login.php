<?php require_once( '../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
</div>
</div>
</div>
</div>
<div class="container">
<h1>ログイン</h1>
<?php echo isset($err['all']) ? '<div class="alert alert-error">'.$err['all'].'</div>' : NULL; ?>
<form name="login" action="" method="post" class="form-horizontal">
	<div class="control-group">
	<label class="control-label">メールアドレス</label>
	<div class="controls">
	<input type="text" name="email" value="<?php echo $form_data['email']; ?>" class="input-xlarge" />
	<?php if( !empty( $err['email'] )) echo '<div style="color:#aa0000">'.$err['email'].'</div>'; ?>
	</div>
	</div>
	
	<div class="control-group">
	<label class="control-label">パスワード</label>
	<div class="controls">
	<input type="password" name="password" value="<?php echo $form_data['password']; ?>" class="input-xlarge" />
	<?php if( !empty( $err['password'] )) echo '<div style="color:#aa0000">'.$err['password'].'</div>'; ?>
	</div>
	</div>

	<div class="form-actions">
	<input type="hidden" name="status" value="login" />
	<input type="submit" class="btn btn-primary" value="ログイン" />
	</div>
</form>
<div>
</div>
</div>
</body>
</html>
