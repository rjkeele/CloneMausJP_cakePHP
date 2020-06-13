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
	<h1>配信履歴</h1>
	<div id="log_search_result">
	<?php if( isset( $data )): ?>
	<table cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<th>メールアドレス</th>
			<th>配信種類</th>
			<th>ストーリNo</th>
			<th>配信日時</th>
			<th>配信状態</th>
		</tr>
		<tr>
			<td><?php echo $data['email']; ?></td>
			<td><?php if( !empty( $data['story_no'] )){echo "ステップメール";}else{echo "号外メール";} ?></td>
			<td><?php echo $data['story_no']; ?></td>
			<td><?php echo $data['send_date']; ?></td>
			<td><?php echo $data['send_flg']; ?></td>
		</tr>
	</tbody>
	</table>
	<table cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<th>タイトル</th>
		</tr>
		<tr>
			<td><?php echo $data['title']; ?></td>
		</tr>
	</tbody>
	</table>
	<table cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<th>メール本文</th>
		</tr>
		<tr>
		<td><?php echo nl2br( $logsObj->show_esc( $data['contents'] )); ?></td>
		</tr>
	</tbody>
	</table>
	<?php endif; ?>
	<div class="form-actions">
	<a class="btn" href="<?php echo URL; ?>/admin/logs/">戻る</a>
	</div>
</div>
</div>
</div>
</body>
</html>
