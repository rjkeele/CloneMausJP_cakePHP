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
<h1>会員サイト作成ツール</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>トップページ　</span>会員がログインしてすぐのページのコンテンツをつくることができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/?status=top">トップページ作成</a>
</div>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>コンテンツページ　</span>経過日を設定することで、会員の登録日から経過した日数にあわせて表示するページをつくることができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/?status=content">コンテンツページ作成</a>
</div>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>各種設定　</span>ページで使う画像をアップロードすることができます。またサイドバーのページ並び替え、見出しを設定することができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/?status=upload">画像アップロード</a>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/?status=sidebar">サイドバー並び替え・見出し設定</a>
</div>
</div>
</body>
</html>
