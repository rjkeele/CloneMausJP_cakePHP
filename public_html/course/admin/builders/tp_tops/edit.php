<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container" id="container">
<div id="content">
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="post" id="ContentsEditForm" class="form-horizontal">
<fieldset>
<legend>トップページ修正</legend>
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
	echo '<div class="waku"><p>トップページを修正します。</p>';
	echo '</div>';
}
?>
<div class="control-group">
<label class="control-label" for="keyword">タイトル</label>
<div class="controls required">
<input type="txt" id="ContentsTitle" value="<?php echo $buildersObj->show_esc($form_data['title']); ?>" class="input-xxlarge" name="title">
</div>
</div>
<div class="control-group">
<label class="control-label" for="description">ディスクリプション</label>
<div class="controls required">
<input type="txt" id="ContentsDescription" value="<?php echo $buildersObj->show_esc($form_data['description']); ?>" class="input-xxlarge" name="description">
</div>
</div>
<div class="control-group">
<label class="control-label" for="keyword">キーワード</label>
<div class="controls required">
<input type="txt" id="ContentsKeyword" value="<?php echo $buildersObj->show_esc($form_data['keyword']); ?>" class="input-xxlarge" name="keyword">
</div>
</div>
<div class="control-group">
<label class="control-label" for="ContentsContent"><span class="red">*</span>トップページ記事</label>
<div class="controls required">
<?php /*** Wrap HTML use jquery.selection.js ***/ ?>
<?php require_once( '../../../common/element/tag_editor_area.php' ); ?>
<textarea id="ContentsContent" rows="20" class="span9" name="contents"><?php echo $form_data['contents']; ?></textarea>
</div>
</div>
<div class="control-group">
<label class="control-label" for="add_br"></label>
<div class="controls">
<label class="checkbox">
<input type="hidden" name="add_br" value="0">
<input id="addBr" type="checkbox" name="add_br" value=1 <?php echo ($form_data['add_br']==1) ? "checked" : NULL; ?>>自動的に&lt;br&nbsp;/&gt;をつける
</label>
</div>
</div>
<div class="control-group">
<label class="control-label" for="preview">簡易プレビュー</label>
<div class="controls">
<div id="preview" class="input-xxlarge" style="text-align:left;padding:4px;border:1px solid #dadada;">ここに記事をプレビューします。</div>
<span class="red fs10">※実際のデザイン表示とは異なります</span>
</div>
</div>
<div class="control-group">
<label class="control-label" for="preview">画像</label>
<div class="controls">
<div id="ajax_img_upload_area" class="input-xxlarge" style="height:120px;overflow:auto;">
<?php require_once("../../../common/element/img_uploaders_area.php"); ?>
</div>
<div id="img_uploaders_form_area" class="input-xxlarge"></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="public">公開</label>
<div class="controls required">
<select id="Public" class="input-small" name="public">
	<option <?php echo (1 == $form_data['public'])? "selected" :"";?> value="1">公開</option>
	<option <?php echo (1 != $form_data['public'])? "selected" :"";?> value="0">非公開</option>
</select>
</div>
</div>
<div class="control-group">
<div class="controls">
<span class="red">*</span> がついている項目はかならず入力してください。
</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
<input type="hidden" value="<?php echo $form_data['url'] ?>" name="url">
<input type="hidden" value="edit_done" name="status">
<input type="hidden" value="top" name="layout">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><button id="PreviewBtn" class="btn btn-primary" style="margin-right:5px;">プレビュー</button><a class="btn" href="<?php echo URL; ?>/admin/builders/?status=top">キャンセル</a></div></form>
<?php require_once('../../../common/element/preview_js.php'); ?>
</div>
</div><!-- end of titles form -->
<?php require_once("../../../common/element/img_uploaders_form.php"); ?>
</div>
</div>
</body>
</html>
