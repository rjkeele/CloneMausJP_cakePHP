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
<h1>ステップメール・号外メール一覧</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>ステップメール　</span>会員の登録日から起算して何日目に第何話という風に番号順にメールを配信することができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/mails/?status=step">ステップメール</a>
</div>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>号外メール　</span>即時送信したり日時を指定してメールを配信することができます。</p>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/mails/?status=extra">号外メール</a>
</div>
</div>
</body>
</html>
