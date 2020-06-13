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
	<form accept-charset="utf-8" method="post" id="ExtraMailPre" class="form-horizontal" action="<?php echo URL; ?>/admin/mails/extra/index.php">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>号外メール作成</legend>
		<div class="waku">号外メールをプレビューします。</div>
		<table class="table">
			<colgroup>
			<col class="span2">
			 <col class="span10">
			 </colgroup>
			<tr>
				<td>タイトル</td>
				<td><?php echo $form_data['title'];?></td>
			</tr>
			<?php if ($form_data['header_id'] != "0"): ?>
			<?php foreach($mailsObj->get_headers_list() as $header): ?>
			<?php if ($header['id'] === $form_data['header_id']): ?>
				<input type="hidden" value="<?php echo $header["id"]; ?>" name="header_id">
				<?php $head = $header["header"]; ?>
			<?php endif; ?>
			<?php endforeach;?>
			<?php endif; ?>
			<?php if ($form_data['footer_id'] != "0"): ?>
			<?php foreach($mailsObj->get_footers_list() as $footer): ?>
			<?php if ($footer['id'] === $form_data['footer_id']): ?>
				<input type="hidden" value="<?php echo $footer["id"]; ?>" name="footer_id">
				<?php $foot = $footer["footer"]; ?>
			<?php endif; ?>
			<?php endforeach;?>
			<?php endif; ?>
			<tr>
				<td>記事</td>
				<td>
				<?php if(!empty($head)){echo nl2br($head);echo '<br>';} ?>
				<?php echo nl2br($form_data['contents']);?><br>
				<?php if(!empty($foot)){echo nl2br($foot);echo '<br>';} ?>
				</td>

			</tr>
			<tr>
				<td>配信日時</td>
				<td>
					<?php echo $form_data['send_time_year']."年".$form_data['send_time_month']."月".$form_data['send_time_day'];?>日&nbsp;
					<?php echo $form_data['send_time_hour']."時".$form_data['send_time_minute'];?>分
					</td>
			</tr>
			
		</table>

	</fieldset>
	<div id="action-box" class="form-actions">
	<input type="hidden" name="status" value="">
	<input type="hidden" value="<?php echo $form_data['title'];?>" name="title">
	<input type="hidden" value="<?php echo $form_data['contents'];?>" name="contents">
	<input type="hidden" value="<?php echo $form_data['send_time_year']; ?>" name="send_time_year">
	<input type="hidden" value="<?php echo $form_data['send_time_month']; ?>" name="send_time_month">
	<input type="hidden" value="<?php echo $form_data['send_time_day']; ?>" name="send_time_day">
	<input type="hidden" value="<?php echo $form_data['send_time_hour']; ?>" name="send_time_hour">
	<input type="hidden" value="<?php echo $form_data['send_time_minute']; ?>" name="send_time_minute">
<?php if(isset($form_data['id']) && $form_data['id'] !==""):?>
	<input type="hidden" name="id" value="<?php echo $form_data['id'];?>">
	<button id="send_test" type="submit" value="prev_edit" class="btn btn-primary" style="margin-right:5px">テスト送信</button>
	<button type="submit" value="edit" class="btn btn-primary" style="margin-right:5px">戻る</button><a class="btn" href="<?php echo URL; ?>/admin/mails/?status=extra">キャンセル</a>
	<div style="margin-top:10px">
	<button id="send_spot" type="submit" value="send_edit" class="btn btn-warning btn-large">即時配信</button>
	</div>
<?php else: ?>
	<button id="send_test" type="submit" value="prev_add" class="btn btn-primary" style="margin-right:5px">テスト送信</button>
	<button type="submit" value="edit" class="btn btn-primary" style="margin-right:5px">戻る</button><a class="btn" href="<?php echo URL; ?>/admin/mails/?status=extra">キャンセル</a>
	<div style="margin-top:10px">
	<button id="send_spot" type="submit" value="send_add" class="btn btn-warning btn-large">即時配信</button>
	</div>
<?php endif;?>
	
	</div>
</form>
</div>
<div id="ajaxmess"></div>
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
