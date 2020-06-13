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
	<form accept-charset="utf-8" method="post" id="UserEditForm" class="form-horizontal" action="">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>基本設定</legend>
<?php
if( isset( $err['all'] ))
{
	echo '<div class="alert alert-error">';
	echo '<div style="color:#aa0000">'.$err['all'].'</div>';
	echo '</div>';
}
elseif(isset( $message )) {
	echo '<div class="alert alert-success">';
	echo $message;
	echo '</div>';
}
else {
	echo '<div class="waku">メール送信の基本設定をします。</div>';
}
?>
		<div class="control-group">
		<label class="control-label" for="title_id">送信者名</label>
		<div class="controls required">
		<input type="txt" id="NameEmail" value="<?php echo $settingsObj->show_esc($form_data['firstname']); ?>" class="input-large" name="firstname">
		<?php if( !empty( $err['firstname'] )) {
			echo '<div class="red fs12">'.$err['firstname'].'</div>';
		} else {
			echo '<div class="green fs12">管理者名を入力します。メールの送信者になります。</div>';
		}?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">送信元メールアドレス</label>
		<div class="controls required">
		<?php echo $settingsObj->show_esc($form_data['email']); ?>
		<div class="green fs12">管理者情報で設定します。</div>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="send_err_num">送信エラー回数</label>
		<div class="controls required">
		<select id="SendErrNum" class="input-small" name="send_err_num">
		<option <?php if( $form_data['send_err_num'] ==  1 ) echo 'selected="selected"'; ?> value="1">1</option>
		<option <?php if( $form_data['send_err_num'] ==  2 ) echo 'selected="selected"'; ?> value="2">2</option>
		<option <?php if( $form_data['send_err_num'] ==  3 ) echo 'selected="selected"'; ?> value="3">3</option>
		<option <?php if( $form_data['send_err_num'] ==  5 ) echo 'selected="selected"'; ?> value="5">5</option>
		<option <?php if( $form_data['send_err_num'] == 10 ) echo 'selected="selected"'; ?> value="10">10</option>
		</select>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="title_id">送信エラー時処理</label>
		<div class="controls">
		<label class="radio">
		<input type="radio" name="send_err" id="sendErr1" value="0" <?php if($form_data['send_err'] == 0) echo "checked"; ?>>エラー停止
		</label>
		<label class="radio">
		<input type="radio" name="send_err" id="sendErr2" value="1" <?php if($form_data['send_err'] == 1) echo "checked"; ?>>削除
		</label>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">自主解除時処理</label>
		<div class="controls">
		<label class="radio">
		<input type="radio" name="send_stop" id="sendStop1" value="0" <?php if($form_data['send_stop'] == 0) echo "checked"; ?>>停止
		</label>
		<label class="radio">
		<input type="radio" name="send_stop" id="sendStop2" value="1" <?php if($form_data['send_stop'] == 1) echo "checked"; ?>>削除
		</label>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">一斉送信数</label>
		<div class="controls required">
		<select id="SendNum" class="input-small" name="send_num">
		<option <?php if( $form_data['send_num'] == 1 ) echo 'selected="selected"'; ?> value="1">1</option>
		<option <?php if( $form_data['send_num'] == 3 ) echo 'selected="selected"'; ?> value="3">3</option>
		<option <?php if( $form_data['send_num'] == 10 ) echo 'selected="selected"'; ?> value="10">10</option>
		<option <?php if( $form_data['send_num'] == 50 ) echo 'selected="selected"'; ?> value="50">50</option>
		<option <?php if( $form_data['send_num'] == 100 ) echo 'selected="selected"'; ?> value="100">100</option>
		<option <?php if( $form_data['send_num'] == 200 ) echo 'selected="selected"'; ?> value="200">200</option>
		<option <?php if( $form_data['send_num'] == 300 ) echo 'selected="selected"'; ?> value="300">300</option>
		<option <?php if( $form_data['send_num'] == 500 ) echo 'selected="selected"'; ?> value="500">500</option>
		<option <?php if( $form_data['send_num'] == 1000 ) echo 'selected="selected"'; ?> value="1000">1000</option>
		<option <?php if( $form_data['send_num'] == 1500 ) echo 'selected="selected"'; ?> value="1500">1500</option>
		<option <?php if( $form_data['send_num'] == 2000 ) echo 'selected="selected"'; ?> value="2000">2000</option>
		<option <?php if( $form_data['send_num'] == 10000 ) echo 'selected="selected"'; ?> value="10000">10000</option>
		<option <?php if( $form_data['send_num'] == 50000 ) echo 'selected="selected"'; ?> value="50000">50000</option>

		</select>通
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">送信インターバル</label>
		<div class="controls required">
		<select id="SendInterval" class="input-small" name="send_interval">
		<option <?php if( $form_data['send_interval'] ==  1 ) echo 'selected="selected"'; ?> value="1">1</option>
		<option <?php if( $form_data['send_interval'] ==  2 ) echo 'selected="selected"'; ?> value="2">2</option>
		<option <?php if( $form_data['send_interval'] ==  3 ) echo 'selected="selected"'; ?> value="3">3</option>
		<option <?php if( $form_data['send_interval'] ==  4 ) echo 'selected="selected"'; ?> value="4">4</option>
		<option <?php if( $form_data['send_interval'] ==  5 ) echo 'selected="selected"'; ?> value="5">5</option>
		<option <?php if( $form_data['send_interval'] ==  6 ) echo 'selected="selected"'; ?> value="6">6</option>
		<option <?php if( $form_data['send_interval'] ==  7 ) echo 'selected="selected"'; ?> value="7">7</option>
		<option <?php if( $form_data['send_interval'] ==  8 ) echo 'selected="selected"'; ?> value="8">8</option>
		<option <?php if( $form_data['send_interval'] ==  9 ) echo 'selected="selected"'; ?> value="9">9</option>
		<option <?php if( $form_data['send_interval'] == 10 ) echo 'selected="selected"'; ?> value="10">10</option>
		</select>秒
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="optionsCheckbox">自動返信（管理者）</label>
		<div class="controls">
		<label class="checkbox" for="AutomailAddAdmin">
		<input type="hidden" name="automail_add_admin" value="0">
		<input type="checkbox" name="automail_add_admin" id="AutomailAddAdmin" value="1" <?php if($form_data['automail_add_admin'] == 1) echo "checked"; ?>>登録時
		</label>
		<label class="checkbox" for="AutomailStopAdmin">
		<input type="hidden" name="automail_stop_admin" value="0">
		<input type="checkbox" name="automail_stop_admin" id="AutomailStopAdmin" value="1" <?php if($form_data['automail_stop_admin'] == 1) echo "checked"; ?>>解除時
		</label>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="optionsCheckbox">自動返信（会員）</label>
		<div class="controls">
		<label class="checkbox" for="AutomailAddUser">
		<input type="hidden" name="automail_add_user" value="0">
		<input type="checkbox" name="automail_add_user" id="AutomailAddUser" value="1" <?php if($form_data['automail_add_user'] == 1) echo "checked"; ?>>登録時
		</label>
		<label class="checkbox" for="AutomailStopUser">
		<input type="hidden" name="automail_stop_user" value="0">
		<input type="checkbox" name="automail_stop_user" id="AutomailStopUser" value="1" <?php if($form_data['automail_stop_user'] == 1) echo "checked"; ?>>解除時
		</label>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="optionsCheckbox">登録フォーム注文ID</label>
		<div class="controls">
		<label class="checkbox" for="FormOrderNo">
		<input type="hidden" name="form_order_no" value="0">
		<input type="checkbox" name="form_order_no" id="FormOrderNo" value="1" <?php if($form_data['form_order_no'] == 1) echo "checked"; ?>>表示する
		</label>
		</label>
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
	<input type="hidden" value="<?php echo $form_data['admin_id'] ?>" name="admin_id">
	<input type="hidden" value="<?php echo $form_data['user_password'] ?>" name="user_password">
	<input type="hidden" value="<?php echo $form_data['form_password'] ?>" name="form_password">
	<input type="hidden" value="<?php echo $form_data['email'] ?>" name="email">
	<input type="hidden" value="<?php echo $form_data['form_is_password'] ?>" name="form_is_password">
	<input type="hidden" value="edit" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px">保存</button><a class="btn" href="<?php echo URL; ?>/admin/">キャンセル</a>
	</div>
	</form>
</div>
</body>
</html>
