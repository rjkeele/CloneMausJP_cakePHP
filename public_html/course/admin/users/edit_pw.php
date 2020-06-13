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
	<h2>会員サイトログインパスワードの設定</h2>
	<div class="waku">
	<p><span class="label label-success">使い方</span></p>
	<p><span class=""></span>現在の会員サイトログインパスワードは「<span style="font-weight:bold;"><?php echo $settings['user_password']; ?></span>」です。</p>
<?php
if(isset($err)){ echo '<div class="alert alert-error">';foreach($err as $str){ echo $str.'<br>'; }echo '</div>'; }
if(isset($message)){ echo '<div class="alert alert-success">'.$message.'</div>'; }
?>
	<form accept-charset="utf-8" method="post" id="UserPassword" name="UserPassword" action="">
	<label class="control-label" for="email">パスワード</label>
	<input type="text" id="UserUsername" maxlength="50" class="input-xlarge" name="user_password" value="<?php echo $settings['user_password']; ?>">
	<input type="hidden" name="status" value="user_password">
	<div><a onclick="if (confirm('すべての会員のパスワードを変更します。')) { document.UserPassword.submit(); } event.returnValue = false; return false;" href="#" class="btn btn-primary">パスワード一括変更</a></div>
	</form>
</div>
<div id="content" style="margin-top:50px;">
	<h2>会員登録フォームパスワードの設定</h2>
	<div class="waku">
	<p><span class="label label-success">使い方</span></p>
	<p><span class=""></span>会員登録フォームのログインパスワードは「<span style="font-weight:bold;"><?php echo $settings['form_password']; ?></span>」です。</p>
<?php
if(isset($err1)){ echo '<div class="alert alert-error">';foreach($err1 as $str){ echo $str.'<br>'; }echo '</div>'; }
if(isset($message1)){ echo '<div class="alert alert-success">'.$message1.'</div>'; }
?>
	<form accept-charset="utf-8" method="post" id="FormPassword" name="FormPassword" action="">
	<label class="control-label" for="email">パスワード</label>
	<input type="text" id="UserUsername" maxlength="50" class="input-xlarge" name="form_password" value="<?php echo $settings['form_password']; ?>">
	<label class="control-label" for="optionsCheckbox">登録フォームパスワード制限</label>
	<label class="checkbox" for="FormIsPassword">
	<input type="hidden" name="form_is_password" value="0">
	<input type="checkbox" name="form_is_password" id="FormIsPassword" value="1" <?php if($settings['form_is_password'] == 1) echo "checked"; ?>>制限する
	</label>
	</label>
	<input type="hidden" name="status" value="form_password">
	<div><a onclick="if (confirm('会員フォームパスワードを変更します。')) { document.FormPassword.submit(); } event.returnValue = false; return false;" href="#" class="btn btn-primary">パスワード変更</a></div>
	</form>
</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
