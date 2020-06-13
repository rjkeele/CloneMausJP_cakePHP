<?php require_once( '../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div style="float:right;margin-right:10px;">Ver.<?php echo $ver = $usersObj->get_version(); ?></div>
<h1>お知らせ</h1>
<?php echo "<script type=\"text/javascript\" src=\"http://www.af5.jp/inc/ns.php\"></script>"; ?>
<h2 style="margin-top:50px;">会員サイト構築システムツール選択</h2>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>サイト作成ツール　</span>会員がログインして閲覧するコンテンツをつくることができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL.'/admin/builders/index.php'; ?>">サイト作成ツール</a>
</div>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>メールマガジン発行ツール　</span>会員にメールマガジンを発行することができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL.'/admin/mails/index.php'; ?>">メールマガジン発行ツール</a>
</div>
</div>
</body>
</html>
