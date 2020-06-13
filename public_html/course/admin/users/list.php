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
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
	<div class="users index">
	<div id="user_search">
	<div class="waku">
	<h2>会員検索</h2>
	<form accept-charset="utf-8" method="post" id="UserSearchUserForm" action="">
	<div style="display:none;"><input type="hidden" value="POST" name="_method"></div>
	<label class="control-label" for="email">メールアドレス</label>
	<input type="text" id="UserUsername" maxlength="50" placeholder="mail@exsample.com" class="input-xlarge" name="email" value="<?php echo $form_data['email']; ?>">
	<label class="control-label" for="name">会員名</label>
	<input type="text" id="UserName" maxlength="50" placeholder="名前" class="input-xlarge" name="name" value="<?php echo $form_data['name']; ?>">
	<label class="control-label" for="username">注文ID</label>
	<input type="text" id="UserUsername" maxlength="50" placeholder="123456" class="input-xlarge" name="order_no" value="<?php echo $form_data['order_no']; ?>">
	<div>
	<input type="hidden" name="status" value="user_search">
	<button type="submit" class="btn btn-primary">検索</button>
	</div>
	</form>
	<h2>全会員データダウンロード</h2>
	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>すべての会員データをCSVファイルでダウンロードできます。</p>
	<form accept-charset="utf-8" method="post" id="UserCsvDownloadForm" action="">
	<input class="btn btn-primary btn-small" type="submit" value="ダウンロード"><br />
	<input type="hidden" name="status" value="user_csv">
	</form>
	</div><!--end of waku-->
	</div>
	<div id="user_search_result">
	<h3>ユーザー検索結果</h3>
	<table id="table_id" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">
	<thead>
		<tr>
			<th>ユーザー名</th>
			<th>メールアドレス</th>
			<th>ステップ配信基準日</th>
			<th>注文No</th>
			<th>状態</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if( isset( $data )):
			foreach( $data as $col ):
			if(!empty($col['send_date'])){$send_date = $usersObj->show_esc( $col['send_date'] );} else {$send_date = '<span class="label label-inverse">未配信</span>';}
		?>
		<tr>
		<td><?php echo $usersObj->show_esc( $col['firstname'].$col['lastname'] ); ?></td>
		<td><?php echo $usersObj->show_esc( $col['email'] ); ?></td>
		<td><?php echo $send_date; ?></td>
		<td><?php echo $usersObj->show_esc( $col['order_no'] ); ?></td>
		<td><?php if( $col['delete_flg'] == 0 ){echo '<span class="label label-success">正常</span>';}elseif( $col['delete_flg'] == 99 ){echo '<span class="label label-important">エラー停止</span>';}else{echo '<span class="label label-inverse">停止</span>';} ?></td>
		<td class="actions">
		<a href="<?php echo URL; ?>/admin/users/?status=edit&id=<?php echo (int)$col['id']; ?>">編集</a>
		<form method="post" style="display:none;" id="post_id<?php echo (int)$col['id']; ?>" name="post_id<?php echo (int)$col['id']; ?>" action="<?php echo URL; ?>/admin/users/?status=user_delete&id=<?php echo (int)$col['id']; ?>"><input type="hidden" value="POST" name="_method"></form>
		<a onclick="if (confirm('会員を削除してよろしいですか？')) { document.post_id<?php echo (int)$col['id']; ?>.submit(); } event.returnValue = false; return false;" href="#">削除</a>
		</td>
		</tr>
		<?php
			endforeach;
		endif;
		?>
	</tbody>
	</table>
	</div><!--end of user_search_result-->
</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
