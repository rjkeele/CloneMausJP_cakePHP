<div class="nav-collapse">
	<ul class="nav">
		<li><a href="<?php echo URL; ?>/admin/mails/">メールツール</a></li>
		<li><a href="<?php echo URL; ?>/admin/settings/">基本設定</a></li>
		<li id="menu2" class="dropdown">
			<a href="#menu2" data-toggle="dropdown" class="dropdown-toggle">
				本文設定
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo URL; ?>/admin/headers/">ヘッダーテンプレート</a></li>
				<li><a href="<?php echo URL; ?>/admin/footers/">フッターテンプレート</a></li>
				<li><a href="<?php echo URL; ?>/admin/bodys/">自動返信メールテンプレート</a></li>
			</ul>
		</li>
		<li id="menu3" class="dropdown">
			<a href="#menu3" data-toggle="dropdown" class="dropdown-toggle">
				会員管理
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo URL; ?>/admin/users/">会員検索</a></li>
				<li><a href="<?php echo URL; ?>/admin/users/?status=add">会員登録・削除</a></li>
				<li><a href="<?php echo URL; ?>/admin/users/?status=password">会員パスワード変更</a></li>
				<li><a href="<?php echo URL; ?>/admin/users/?status=form">登録フォームタグ出力</a></li>
			</ul>
		</li>
		<li><a href="<?php echo URL; ?>/admin/logs/">送信履歴</a></li>
		<li><a href="<?php echo URL; ?>" target="_blank">会員サイトを見る</a></li>
		<li>&nbsp;</li>
		<li><a href="<?php echo URL; ?>/admin/index.php?status=logout">ログアウト</a></li>
	</ul>
</div>
