<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div class="row">
<div class="span12">
<h1>トップページ一覧・トップページの作成</h1>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
<div class="waku">
	<p><span class="label label-success">使い方</span></p>
	<p>会員がログインしてすぐのページのコンテンツをつくります。</p>
	<p><i style="margin-top:0px;" class="icon-ok-sign"></i>新規作成、編集ボタンを押すと、トップページの記事が作成できます。
	</p>
</div>
<table cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<td>タイトル</td>
		<td><?php echo $tops_data['title']; ?></td>
	</tr>
	<tr>
		<td style="width:180px;">ディスクリプション</td>
		<td><?php echo $tops_data['description']; ?></td>
	</tr>
	<tr>
		<td>キーワード</td>
		<td><?php echo $tops_data['keyword']; ?></td>
	</tr>
	<tr>
		<td>記事</td>
		<td><?php echo $tops_data['contents']; ?></td>
	</tr>
	<tr>
		<td>公開/非公開</td>
		<td><?php echo $tops_data['public'] == 1 ? '<span class="label label-success">公開</span>':'<span class="label label-inverse">非公開</span>';?> </td>
	</tr>
	</tbody>
</table>
<div id="action-box" class="form-actions">
<?php if(empty($tops_data)): ?>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/tp_tops/">新規作成</a>
<?php else: ?>
	<a class="btn btn-primary" href="<?php echo URL; ?>/admin/builders/tp_tops/index.php?status=edit&id=<?php echo $tops_data['id'];?>" style="margin-right:5px;">編集</a><a class="btn" href="<?php echo URL; ?>/admin/builders/">キャンセル</a></div></form>
<?php endif; ?>
</div>
</div>
</div><!--end of row-->
</body>
</html>
