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
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>ステップメール　</span>会員の登録日から起算して何日目に第何話という風に番号順にメールを配信することができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/mails/step/">ステップメール作成</a>
</div>
<table cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<th>ストーリNo</th>
		<th>タイトル</th>
		<th>配信時期</th>
		<th>配信時間</th>
		<th>稼働</th>
		<th>&nbsp;</th>
	</tr>
	<?php
if( isset( $step_mails_data ))
{
	foreach( $step_mails_data as $col ):
	?>
		<tr>
		<td><?php echo $col['story_no'];?></td>
		<td><?php echo $col['title'];?></td>
		<td><?php echo $col['send_date'];?>日目</td>
		<td><?php echo $col['send_time'];?></td>
		<td><?php echo $col['send_flg'] == 1 ? '<span class="label label-success">稼働中</span>':'<span class="label label-inverse">停止</span>';?> </td>
		<td class="actions">
		<a href="<?php echo URL; ?>/admin/mails/step/index.php?status=edit&id=<?php echo $col['id'];?>">編集</a>
		<form method="post" style="display:none;" id="del_post_id" name="del_post_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/mails/step/index.php?status=delete&id=<?php echo $col['id'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('メールを削除します。')) { document.forms['del_post_id<?php echo $col['id'];?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		</td>
	</tr>
	<?php 
	endforeach;
};
?>
	</tbody>
</table>
</body>
</html>
