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
<div class="container">
<div class="users form">
	<form accept-charset="utf-8" method="post" id="UserEditForm" class="form-horizontal" action="">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>会員サイト基本設定</legend>
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
	echo '<div class="waku">会員サイトの基本設定をします。</div>';
}
?>
		<div class="control-group">
		<label class="control-label" for="site_name"><span class="red">*</span>サイト名</label>
		<div class="controls required">
		<input type="txt" id="SiteName" value="<?php echo $buildersObj->show_esc($form_data['site_name']); ?>" class="input-large" name="site_name">
		<?php if( !empty( $err['site_name'] )) {
			echo '<div class="red fs12">'.$err['site_name'].'</div>';
		} else {
			echo '<div class="green fs12">サイト名を入力します。&lt;title&gt;に入ります。</div>';
		}?>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="head">ヘッダーカスタム設定</label>
		<div class="controls required">
		<textarea id="Head" rows="6" class="input-xxlarge" cols="5" name="head"><?php echo $form_data['head']; ?></textarea>
		<div class="green fs12">&lt;head&gt;部分へそのまま追加します。</div>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="css">CSSカスタム設定</label>
		<div class="controls required">
		<input type="txt" id="Css" value="<?php echo $buildersObj->show_esc($form_data['css']); ?>" class="input-large" name="css">
		<div class="green fs12">CSSファイルを追加します。</div>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="top_template"><span class="red">*</span>トップページテンプレートファイル設定</label>
		<div class="controls required">
		<input type="txt" id="TopTemplate" value="<?php echo $buildersObj->show_esc($form_data['top_template']); ?>" class="input-large" name="top_template">
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="contents_template"><span class="red">*</span>コンテンツページテンプレートファイル設定</label>
		<div class="controls required">
		<input type="txt" id="ContentsTemplate" value="<?php echo $buildersObj->show_esc($form_data['contents_template']); ?>" class="input-large" name="contents_template">
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
	<input type="hidden" value="edit" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px">保存</button><a class="btn" href="<?php echo URL; ?>/admin/builders/">キャンセル</a>
	<span class="red">*</span> がついている項目はかならず入力してください。
	</div>
	</form>
</div>
</body>
</html>
