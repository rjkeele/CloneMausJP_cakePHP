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
<form accept-charset="utf-8" method="post" id="UserEditForm" class="form-horizontal" action="<?php echo URL; ?>/admin/users/">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>会員情報修正</legend>
		<?php
		if(isset( $message ))
		{
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
		} else {
		echo '<div class="waku">ユーザー情報を変更します。</div>';
		}
		?>
		<div class="control-group">
		<label class="control-label" for="title_id">配信状態</label>
		<div class="controls required">
		<select id="SendNum" class="input-small" name="delete_flg">
		<option <?php if( $data['delete_flg'] == 0 ) echo 'selected="selected"'; ?> value="0">正常</option>
		<option <?php if( $data['delete_flg'] == 1 ) echo 'selected="selected"'; ?> value="1">停止</option>
		<option <?php if( $data['delete_flg'] == 99 ) echo 'selected="selected"'; ?> value="99">エラー停止</option>
		</select>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">配信済ストーリNo</label>
		<div class="controls required">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc( $data['story_no'] ); ?></span>
		<input type="hidden" value="<?php echo $usersObj->show_esc($data['story_no']); ?>" name="story_no">
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">最終配信日時</label>
		<div class="controls required">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc( $data['send_date'] ); ?></span>
		<input type="hidden" value="<?php echo $usersObj->show_esc($data['send_date']); ?>" name="send_date">
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">ステップ配信基準日</label>
		<div class="controls required">
		<input type="hidden" value="<?php echo $data['send_date'] ?>" name="created">
		<?php if(!empty($data['send_date'])){$send_date = $usersObj->show_esc( $data['send_date'] );} else {$send_date = '<span class="label label-inverse">未配信</span>';} ?>
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $send_date; ?></span>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">登録日</label>
		<div class="controls required">
		<input type="hidden" value="<?php echo $data['created'] ?>" name="created">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc( $data['created'] ); ?></span>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id"><span class="red">*</span>メールアドレス</label>
		<div class="controls required">
		<input type="txtarea" id="Email" value="<?php echo $usersObj->show_esc($data['email']); ?>" class="input-xlarge" name="email">
		<?php if( !empty( $err['email'] )) echo '<div class="red fs12">'.$err['email'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="name"><span class="red">*</span>名前</label>
		<div class="controls required">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;">姓</span><input type="txtarea" id="FName" value="<?php echo $usersObj->show_esc($data['firstname']); ?>" class="input-large" name="firstname">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;">名</span><input type="txtarea" id="LName" value="<?php echo $usersObj->show_esc($data['lastname']); ?>" class="input-large" name="lastname">
		<?php if( !empty( $err['name'] )) echo '<div class="red fs12">'.$err['name'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">注文ID</label>
		<div class="controls required">
		<input type="txtarea" id="BlogTitle" value="<?php echo $usersObj->show_esc($data['order_no']); ?>" class="input-xlarge" name="order_no">
		</div>
		</div>
		<div class="control-group">
		<div class="controls">
		<span class="red">*</span> がついている項目はかならず入力してください。
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo (int)$data['id'] ?>" name="id">
	<input type="hidden" value="user_edit" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px">保存</button><a class="btn" href="<?php echo URL; ?>/admin/users/">キャンセル</a>
	</div>
	</form>
</div>
</body>
</html>
