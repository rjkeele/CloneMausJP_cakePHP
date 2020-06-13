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
<h1>登録メール一覧・メールの作成</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>号外メール　</span>即時送信したり日時を指定してメールを配信することができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/mails/extra/">号外メール作成</a>
</div>
<table cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<th>No</th>
		<th>タイトル</th>
		<th>配信日</th>
		<th>配信時間</th>
		<th>&nbsp;</th>
	</tr>
	<?php
if( isset( $extra_mails_data ))
{
	$cnt = 0;
	foreach( $extra_mails_data as $col ):
		$cnt++; 
		$is_success = $logsObj->check_extra_mail_log($col['id'], 1);
		$is_on = $logsObj->check_extra_mail_log($col['id'], 99);
	?>
	<tr>
		<td><?php echo $cnt;?></td>
		<td><?php echo $col['title'];?></td>
		<td><?php echo $col['send_date'];?></td>
		<td><?php echo $col['send_time'];?></td>
		<td class="actions">
	<?php if($is_on){echo '<span class="label label-important">送信中</span>';}elseif($is_success){echo '<span class="label label-success">送信済</span>';}else{echo '<a href="'.URL.'/admin/mails/extra/index.php?status=edit&id='.$col['id'].'">編集</a>';} ?>
		<form method="post" style="display:none;" id="del_post_id" name="del_post_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/mails/extra/index.php?status=delete&id=<?php echo $col['id'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('メールを削除します。')) { document.forms['del_post_id<?php echo $col['id'];?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		</td>
	</tr>
	<?php 
	endforeach;
};?>
	</tbody>
</table>
</div>
</body>
</html>
