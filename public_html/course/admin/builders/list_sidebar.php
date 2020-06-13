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
<h1>サイドバーの設定</h1>
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
else {
	echo '<div class="waku"><p>サイドバーを設定します。</p>';
	echo '</div>';
}
?>

<table id="" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
	<thead>
	<tr>
		<th class="span10">上部フリーエリア</th>
		<th class="span1">&nbsp;</th>
		<th class="span1">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( isset( $side_freeareas_data )):
		foreach( $side_freeareas_data as $col ):
			if($col['id'] == 1):
	?>
	<tr>
		<td>
		<form method="post" id="edit_freearea_id1" name="edit_freearea_id1" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=1" style="margin:0">
		<textarea id="edit_freearea_id1" rows="6" class="input-xxlarge" cols="5" name="contents"><?php echo $col['contents']; ?></textarea>
		<input type="hidden" value="POST" name="_method">
		</form>
		</td>
		<td>
		<a onclick="document.forms['edit_freearea_id1'].submit(); event.returnValue = false; return false;" href="#">更新</a>
		</td>
		<td>
		<form method="post" style="display:none;" id="del_freearea_id1" name="del_freearea_id1" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_delete&id=1">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('上部フリーエリアを削除します。')) { document.forms['del_freearea_id1'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		</td>
	</tr>
	<?php 
			endif;
		endforeach;
	endif;
	?>
	</tbody>
</table>
<div class="waku" style="margin-bottom:20px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>見出し　</span>見出しを追加できます。表示位置に数字を入れるとその順番で並び替えます。空白にすると末尾に追加します。</p>
	<form accept-charset="utf-8" method="post" id="SideTitlesAddForm" class="form-inline">
	<label class="control-label" for="description">表示位置</label>
	<input type="txt" id="SidebarsPosition" value="<?php echo $buildersObj->show_esc($form_data['position']); ?>" class="input-mini" name="position" placeholder="1">
	<label class="control-label" for="description">見出し</label>
	<input type="txt" id="SideTitlesTitle" value="<?php echo $buildersObj->show_esc($form_data['title']); ?>" class="input-xlarge" name="title" placeholder="見出しタイトル">
	<input type="hidden" value="side_titles_add_done" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px;">見出し追加</button>
	</form>
</div>
<table id="" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
	<thead>
	<tr>
		<th class="span6">見出し・タイトル</th>
		<th class="span2">表示する位置</th>
		<th class="span2">公開/非公開</th>
		<th class="span1">&nbsp;</th>
		<th class="span1">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( isset( $sidebars_data )):
		foreach( $sidebars_data as $col ):
			if(!empty($col['contents_title']) || !empty($col['side_titles_title'])):
	?>
	<tr>
		<td>
<?php echo $col['contents_title']; echo $col['side_titles_title']; echo ($col['side_titles_title']) ? '<span class="label label-info" style="margin-left:8px;">見出し</span>': NULL; ?>
		</td>
		
		<td>
		<form method="post" id="edit_position_id<?php echo $col['id'];?>" name="edit_position_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/builders/index.php?status=side_position_edit&contents_id=<?php echo $col['contents_id'];?>&side_title_id=<?php echo $col['side_title_id'];?>&id=<?php echo $col['id'];?>" style="margin:0">
		<input type="txt" id="SideContentsPosition" value="<?php echo $col['position']; ?>" class="input-mini" name="position" style="margin:0">
		</form>
		</td>
		<td>
		<?php if($col['contents_public'] || $col['side_titles_public']){echo '<span class="label label-success">公開</span>';}else{echo '<span class="label label-inverse">非公開</span>';}?>
		</td>
		<td>
		<a onclick="document.forms['edit_position_id<?php echo $col['id'];?>'].submit(); event.returnValue = false; return false;" href="#">更新</a>
		</td>
		<td>
		<?php if(!empty($col['side_titles_title'])): ?>
		<form method="post" style="display:none;" id="del_sidebars_id<?php echo $col['id'] ?>" name="del_sidebars_id<?php echo $col['id'] ?>" action="<?php echo URL; ?>/admin/builders/index.php?status=sidebars_delete&&side_title_id=<?php echo $col['side_title_id'];?>&id=<?php echo $col['id'] ?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('見出しを削除します。')) { document.forms['del_sidebars_id<?php echo $col['id'] ?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		<?php endif; ?>
		</td>
		
	</tr>
	<?php 
			endif;
		endforeach;
	endif;
	?>
	</tbody>
</table>
<table id="" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">
	<thead>
	<tr>
		<th class="span10">下部フリーエリア</th>
		<th class="span1">&nbsp;</th>
		<th class="span1">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( isset( $side_freeareas_data )):
		foreach( $side_freeareas_data as $col ):
			if($col['id'] == 2):
	?>
	<tr>
		<td>
		<form method="post" id="edit_freearea_id2" name="edit_freearea_id2" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=2" style="margin:0">
		<textarea id="edit_freearea_id2" rows="6" class="input-xxlarge" cols="5" name="contents"><?php echo $col['contents']; ?></textarea>
		<input type="hidden" value="POST" name="_method">
		</form>
		</td>
		<td>
		<a onclick="document.forms['edit_freearea_id2'].submit(); event.returnValue = false; return false;" href="#">更新</a>
		</td>
		<td>
		<form method="post" style="display:none;" id="del_freearea_id2" name="del_freearea_id2" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_delete&id=2">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('下部フリーエリアを削除します。')) { document.forms['del_freearea_id2'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		</td>
	</tr>
	<?php 
			endif;
		endforeach;
	endif;
	?>
	</tbody>
</table>
</body>
</html>
