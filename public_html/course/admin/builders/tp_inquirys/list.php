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
<div id="content">
<div class="titles index">
<h2>登録時自動返信</h2>
<div class="waku">
<p style="margin-top:10px;">会員サイトお問い合わせフォームの自動返信メールを設定します。</p>
<p style="margin-top:0;"><i style="margin-top:0px;" class="icon-ok-sign"></i>右端にある「編集」で編集できます。</p>
</div>
<?php
if(isset( $err['inquirys_data'] )) {
	echo '<div class="alert alert-success">';
	echo $err['inquirys_data'];
	echo '</div>';
}
?>
<table cellspacing="0" cellpadding="0">
<thead>
<tr>
<th style="width:30%;">タイトル</th>
<th>本文</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<tr>
<td><?php echo $inquirys_data['title']; ?></td>
<td><?php echo nl2br(mb_substr($inquirys_data['contents'],0,10000)); ?></td>
<td class="actions">
<a href="<?php echo URL;?>/admin/builders/tp_inquirys/index.php?status=edit&id=<?php echo $inquirys_data['id'];?>">編集</a>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</body>
</html>
