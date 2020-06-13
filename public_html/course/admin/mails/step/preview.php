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
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>ステップメール作成</legend>
		<div class="waku">ステップメールをプレビューします。</div>
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
				<td>配信時期</td>
				<td><?php echo sprintf("%01d", $form_data['send_date']);?>日後</td>
			</tr>
			<tr>
				<td>配信時間</td>
				<td>
				<?php echo $form_data['send_time_hour'];?>時<?php echo $form_data['send_time_minute'];?>分
				</td>
			</tr>
			<tr>
				<td>稼働</td>
				<td><?php echo ($form_data['send_flg'] === '0') ? "停止" : "稼働";?></td>
			</tr>
		</table>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="" name="status" >
	<input type="hidden" value="<?php echo $form_data['title'];?>" name="title">
	<input type="hidden" value="<?php echo $form_data['contents'];?>" name="contents">
	<input type="hidden" value="<?php echo $form_data['send_date']; ?>" name="send_date">
	<input type="hidden" value="<?php echo $form_data['send_time_hour']; ?>" name="send_time_hour">
	<input type="hidden" value="<?php echo $form_data['send_time_minute']; ?>" name="send_time_minute">
	<input type="hidden" value="<?php echo $form_data['send_flg']; ?>" name="send_flg">
	<?php if(isset($form_data['id']) && $form_data['id'] !==""):?>
	<input type="hidden" name="id" value="<?php echo $form_data['id'];?>">
	<button type="submit" value="prev_edit" class="btn btn-primary" style="margin-right:5px">ストーリー保存</button>
	<button type="submit" value="edit" class="btn btn-primary" style="margin-right:5px">戻る</button><a class="btn" href="<?php echo URL; ?>/admin/mails/?status=step">キャンセル</a>
	<?php else: ?>
	<button type="submit" value="prev_add" class="btn btn-primary" style="margin-right:5px">ストーリー保存</button>
	<button type="submit" value="edit" class="btn btn-primary" style="margin-right:5px">戻る</button><a class="btn" href="<?php echo URL; ?>/admin/mails/?status=step">キャンセル</a>
	<?php endif;?>
	</div>
</form>
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
