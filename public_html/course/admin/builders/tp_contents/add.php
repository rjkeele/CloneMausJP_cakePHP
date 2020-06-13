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
<div class="titles form">
<form accept-charset="utf-8" method="post" id="ContentsEditForm" class="form-horizontal">
<fieldset>
<legend>コンテンツページ追加</legend>
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
	echo '<div class="waku"><p>コンテンツページを作成します。</p>';
	echo '</div>';
}
?>
<div class="control-group">
<label class="control-label" for="title"><span class="red">*</span>タイトル</label>
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
<label class="control-label" for="ContentsContent"><span class="red">*</span>記事</label>
<div class="controls required">
<?php require_once( '../../../common/element/tag_editor_area.php' ); ?>
<textarea id="ContentsContent" rows="15" class="span9" name="contents"><?php echo $form_data['contents']; ?></textarea>
</div>
</div>
<div class="control-group">
<label class="control-label" for=""></label>
<div class="controls">
<label class="checkbox">
<input type="hidden" name="add_br" value="0">
<input id="addBr" type="checkbox" name="add_br" value="1" checked="checked">自動的に&lt;br&nbsp;/&gt;をつける
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
<label class="control-label" for="public_date">経過日</label>
<div class="controls required">
<select id="PublicDate" class="input-mini" name="public_date">
<?php for($i=0; $i<=99; $i++): ?>
	<option <?php echo ($i == $form_data['public_date'])? "selected" :"";?> value=<?php echo sprintf("%02d", $i) ?>><?php echo $i; ?></option>
<?php endfor; ?>
</select><span style="padding:4px;">日後に表示</span>
</div>
</div>
<div class="control-group">
<label class="control-label" for="public">公開</label>
<div class="controls required">
<select id="Public" class="input-small" name="public">
	<option value="0">非公開</option>
	<option value="1">公開</option>
</select>
</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="add_done" name="status">
<input type="hidden" value="page" name="layout">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><button id="PreviewBtn" class="btn btn-primary" style="margin-right:5px;">プレビュー</button><a class="btn" href="<?php echo URL; ?>/admin/builders/?status=content">キャンセル</a>
<span class="red">*</span> がついている項目はかならず入力してください。
<?php require_once('../../../common/element/preview_js.php'); ?>
</div>
</form>
<?php require_once("../../../common/element/img_uploaders_form.php"); ?>
<script type="text/javascript">
$(function(){
});
</script>
</div>
</div><!-- end of titles form -->
</div>
</div>
</body>
</html>
