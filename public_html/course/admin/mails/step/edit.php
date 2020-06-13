<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../../common/element/gnav.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div class="blogs form">
	<form accept-charset="utf-8" method="post" id="BlogEditForm" class="form-horizontal" action="<?php echo URL; ?>/admin/mails/step/index.php">
	<div style="display:none;"><input type="hidden" value="<?php echo $form_data['id'];?>" name="id"></div>
	<fieldset>
		<legend>ステップメール作成</legend>
		<?php
		if (isset($err)) {
			echo '<div class="alert alert-error">';
			foreach ($err as $str) {
				echo $str;
			}
			echo '</div>';
		} elseif (isset($message)) {
			echo '<div class="alert alert-success">';
			echo $message;
			echo '</div>';
		} else {
			echo '<div class="waku"><p>ステップメールを作成します。</p>';
			require_once( '../../../common/element/help_re_text.php' );
			echo '</div>';
		}
		?>
		<div class="control-group">
		<label class="control-label" for="title_id">
			<span class="red">*</span>タイトル</label>
		<div class="controls required">
		<input type="txtarea" id="BlogTitle" value="<?php echo $form_data['title'];?>" class="input-xxlarge" name="title">
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="pro_url_posi">ヘッダー</label>
		<div class="controls">
			<select id="BlogProUrlPosi" class="input-small" name="header_id">
				<option <?php echo ($form_data['header_id'] == "0")? "selected" :"";?> value="0">未選択</option>
		<?php foreach($mailsObj->get_headers_list() as $header): ?>
			<option <?php echo ($header['id'] === $form_data['header_id'])? "selected" :"";?> value="<?php echo $header["id"]; ?>">
				<?php echo mb_substr($header["header"], 0, 64); ?></option>
		<?php endforeach;?>
		</select>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="content_id">
			<span class="red">*</span>記事</label>
		<div class="controls required">
		<textarea id="BlogContent" rows="6" class="input-xxlarge" cols="5" name="contents"><?php echo $form_data['contents'];?></textarea>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="pro_url_posi">フッター</label>
		<div class="controls"><select id="BlogProUrlPosi" class="input-small" name="footer_id">
			<option <?php echo ($form_data['footer_id'] == "0")? "selected" :"";?> value="0">未選択</option>
		<?php foreach($mailsObj->get_footers_list() as $footer): ?>
		<option <?php echo ($footer['id'] === $form_data['footer_id'])? "selected" :"";?> value="<?php echo $footer["id"]; ?>">
			<?php echo mb_substr($footer["footer"], 0, 64); ?></option>
		<?php endforeach;?>
		</select>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="update">配信時期</label>
		<div class="controls required">
		<select id="BlogUpdateDay" class="input-mini" name="send_date">
			<?php for($i=0; $i<=99; $i++): ?>
				<option <?php echo ($i == $form_data['send_date'])? "selected" :"";?> value=<?php echo sprintf("%02d", $i) ?>><?php echo $i; ?></option>
		    <?php endfor; ?>
		</select>日後
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="update">配信時間</label>
		<div class="controls required">
		<select id="BlogUpdateHour" class="input-mini" name="send_time_hour">
			<?php for($h=0; $h<24; $h++): ?>
				<option <?php echo (sprintf("%02d", $h) == $form_data['send_time_hour'])? "selected" :"";?> value=<?php echo sprintf("%02d", $h) ?>><?php echo $h; ?></option>
		    <?php endfor; ?>
		</select>時
		<select id="BlogUpdateMin" class="input-mini" name="send_time_minute">
			<?php for($m=0; $m<60; $m+=10): ?>
				<option <?php echo (sprintf("%02d", $m) == $form_data['send_time_minute'])? "selected" :"";?> value=<?php echo sprintf("%02d", $m) ?>><?php echo $m; ?></option>
		    <?php endfor; ?>
		</select>分
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="update">稼働</label>
		<div class="controls required">
		<select id="BlogUpdateHour" class="input-small" name="send_flg">
			<option value="0" <?php echo ($form_data["send_flg"] == "0") ? "selected" : "";?>>停止</option>
			<option value="1" <?php echo ($form_data["send_flg"] == "1") ? "selected" : "";?>>稼働</option>
		</select>
		</div>
		</div>
		<div class="control-group">
		<div class="controls">
		<span class="red">*</span> がついている項目はかならず入力してください。
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" name="scenario_id" value="<?php echo $form_data['scenario_id'];?>">
	<input type="hidden" name="status" value="">
	<button type="submit" value="edit_done" class="btn btn-primary" style="margin-right:5px">ストーリー保存</button>
	<button type="submit" value="prev" class="btn btn-primary" style="margin-right:5px">プレビュー</button><a class="btn" href="<?php echo URL; ?>/admin/mails/?status=step">キャンセル</a>
	</div>
</form>
</div>
<div>
</div>
</div>
<script>
<!--
$("button[type='submit']").click(function(){
	var value = $(this).val();
	$("input[name='status']").val(value);
});
-->
</script>
</body>
</html>
