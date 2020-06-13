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
<h1>アップロード画像一覧・画像アップロード</h1>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
<div class="waku" style="margin-bottom:50px;">
	<p><span class="label label-success">使い方</span></p>
	<p>コンテンツページで使用する画像を管理します。</p>
	<p><i style="margin-top:0px;" class="icon-ok-sign"></i>画像のアップロードと削除ができます。アップロードできる画像は、gif、jpg、pngでファイルサイズは<span class="red">2Mbyteまで</span>です。</p>
	
	<form accept-charset="utf-8" method="post" enctype="multipart/form-data" id="ImgUploadersForm" class="form-inline">
	<input class="input-file" id="ImgUploaders" type="file" name="images">
	<input type="hidden" value="upload_done" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px;">アップロード</button>
	</form>
</div>
<?php if(!empty($img_uploaders_data)):?>
<h2>アップロードされている画像一覧</h2>
<div class="row">
<div class="span10 offset1">
<ul class="thumbnails">
<?php foreach( $img_uploaders_data as $col ): ?>
<?php if($col['thumbnail']): ?>
<li class="span1">
<a href="<?php echo URL.'/'.$col['store_folder'].'/'.$col['store_file']; ?>" class="thumbnail" target="_blank"><img src="<?php echo URL.'/'.$col['store_folder'].'/'.'c-'.$col['thumbnail']; ?>" alt="<?php echo $col['title'];?>"></a>
<form method="post" style="display:none;" id="del_img_uploaders_id<?php echo $col['id'];?>" name="del_img_uploaders_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/builders/index.php?status=upload_delete&id=<?php echo $col['id'];?>">
<input type="hidden" value="POST" name="_method">
</form>
<a onclick="if (confirm('画像を削除します。')) { document.forms['del_img_uploaders_id<?php echo $col['id'];?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
</li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
</div>
</div>
<?php endif; ?>
</div>
</body>
</html>
