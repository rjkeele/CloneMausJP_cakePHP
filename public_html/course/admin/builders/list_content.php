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
<h1>コンテンツページ一覧・コンテンツページの作成</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>コンテンツページ　</span>経過日を設定することで、会員の登録日から経過した日数にあわせて表示するページをつくることができます。</p><p style="color:#EE0000;">※コンテンツページをつくった後に、サイドバーの設定をすると会員サイトに表示されます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/tp_contents/">コンテンツページ作成</a>
</div>
<table id="table_id" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">
	<thead>
	<tr>
		<th>タイトル</th>
		<th>表示する経過日</th>
		<th>公開/非公開</th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
if( isset( $contents_data )):
	foreach( $contents_data as $col ):
	?>
	<tr>
	<td><?php echo $col['title']; ?></td>
	<td><?php echo $col['public_date']; ?>日目</td>
	<td><?php echo $col['public'] == 1 ? '<span class="label label-success">公開</span>':'<span class="label label-inverse">非公開</span>'; ?></td>
	<td class="actions">
	<a href="<?php echo URL; ?>/admin/builders/tp_contents/index.php?status=edit&id=<?php echo $col['id'];?>">編集</a>
	<form method="post" style="display:none;" id="del_post_id" name="del_post_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/builders/tp_contents/index.php?status=delete&id=<?php echo $col['id'];?>">
	<input type="hidden" value="POST" name="_method">
	</form>
	<a onclick="if (confirm('ページを削除します。')) { document.forms['del_post_id<?php echo $col['id'];?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
	</td>
	</tr>
	<?php 
	endforeach;
endif;
?>
	</tbody>
</table>
</div>
</div><!--end of row-->
</body>
</html>
