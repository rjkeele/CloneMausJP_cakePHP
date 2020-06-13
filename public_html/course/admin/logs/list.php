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
	<h1>ステップメール配信履歴</h1>
	<div id="user_search_result">
	<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p><span class="fs24">１．</span>期間を決めて履歴削除できます。</p>
<div class="titles form">
<form accept-charset="utf-8" method="post" id="LogForm" action="">
<fieldset>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str )
	{
		echo $str;
	}
	echo '</div>';
}
elseif(isset( $message )) {
	echo '<div class="alert alert-success">';
	echo $message;
	echo '</div>';
}
?>
<div class="control-group">
<div class="controls required">
<select id="term" class="input-small" name="term">
<option value="90">3ヶ月</option>
<option value="60">2ヶ月</option>
<option value="30">1ヶ月</option>
<option value="0">全期間</option>
</select>　以前の履歴を削除
</div>
</div>
</fieldset>
<input type="hidden" value="log_delete_flg" name="status">
<button type="submit" class="btn btn-primary" onclick="if (confirm('履歴を削除してよろしいですか？')) { document.LogForm.submit(); } event.returnValue = false; return false;" href="#">履歴削除</button>
</form>
</div>
</div>
	<table id="table_id" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th style="width:30px;">配信<br>状態</th>
			<th style="width:40px;">配信<br>完了数</th>
			<th style="width:55px;">配信<br>エラー数</th>
			<th style="width:70px;">ストーリNo</th>
			<th>タイトル</th>
			<th>配信開始日時</th>
		</tr>
	</thead>
	<tbody>
<?php
if( isset( $data )):
	foreach( $data as $col ):
?>
		<tr>
			<td><?php if(!empty($col['on'])){echo '<span class="label label-important">送信中</span>';}else{echo '<span class="label label-success">送信済</span>';} ?></td>
			<td style="text-align:right;padding: 5px 20px;"><?php echo (int)$col['done']; ?></td>
			<td style="text-align:right;padding: 5px 20px;"><?php echo (int)$col['err']; ?></td>
			<td style="text-align:right;padding: 5px 20px;"><?php echo (int)$col['story_no']; ?></td>
			<td><?php echo $logsObj->show_esc( $col['title'] ); ?></td>
			<td><?php echo $col['send_date']; ?></td>
		</tr>
<?php
	endforeach;
endif;
?>
	</tbody>
	</table>
	</div>
</div>
</div>
</body>
</html>
