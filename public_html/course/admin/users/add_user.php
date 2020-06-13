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
<div id="content">
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
	<div class="users index">
	
	<h2>会員登録・送信停止</h2>
	<div class="waku">
	<p><span class="label label-success">使い方</span></p>
	<p><span class="fs24">１．</span>テキストエリアにリストを入力します。</p>
	<div id="home" class="tab-pane active">
	
	<form accept-charset="utf-8" method="post" id="userTxtImport" class="form-vertical" action="">
	<div style="display:none;"><input type="hidden" value="POST" name="_method"></div>
	<div class="controls">
	<textarea id="UserLines" cols="30" rows="6" class="input-xxlarge" name="lines"></textarea>
	</div>
	<?php
	if( !empty( $result ))
	{
		echo '<div>';
		echo '全'.$result['cnt_text'].'件中'.$result['cnt_success'].'件の処理をしました。';
		echo '</div>';
		if( !empty( $result['err'] ))
		{
			echo '<div class="alert alert-error">';
			foreach( $result['err'] as $err )
			{
				echo (isset($err['massage'])) ? $err['massage'] : NULL ;
				echo (isset($err['data'])) ? $err['data'] : NULL ;
				echo '<br />';
			}
			echo '</div>';
		}
		elseif( $result['status'] == 0 && $result['cnt_success'] > 0 )
		{
			echo '<div class="alert alert-success">';
			echo '正常に登録されました。';
			echo '</div>';
		}
		elseif( $result['status'] == 1 && $result['cnt_success'] > 0 )
		{
			echo '<div class="alert alert-success">';
			echo '送信停止にしました。';
			echo '</div>';
		}
	}
	?>
	<p><span style="font-weight:bold;">「性」「名」「メールアドレス」</span>を<span style="font-weight:bold;color:#990000;">「タブ区切り」</span>で入力して「会員情報修正」ボタンを押してください。<br>
	複数登録は改行で区切って入力してください。<br>
	通常はExcelで３列をコピー・ペーストするだけでタブ区切りと改行になります。<br>
	一回に最大１０００リストまで登録出来ます。</p>
	<p style="font-weight:bold">例１</p>
<pre>
佐藤	健太	kenta@example.com
田中	大輔	daisuke@example.com
</pre>
	<p style="font-weight:bold">例２</p>
<pre>
佐藤	kenta@example.com
田中	daisuke@example.com
</pre>
	<p style="font-weight:bold">例３</p>
<pre>
kenta@example.com
daisuke@example.com
</pre>
	<div class="control-group">
	<p style="margin-top:30px;"><span class="fs24">２．</span>登録か送信停止を選択します。</p>
	<div class="controls">
	<label class="radio">
	<input type="radio" name="options" id="optionsRadios1" value="0" checked>登録
	</label>
	<label class="radio">
	<input type="radio" name="options" id="optionsRadios2" value="1">停止
	</label>
	</div>
	</div>
	<div class="submit">
	<p style="margin-top:30px;"><span class="fs24">３．</span>「会員情報修正」ボタンを押して会員情報を修正します。</p>
	<input type="hidden" value="user_add" name="status">
	<input type="submit" value="会員情報修正" class="btn btn-primary">
	</div>
	</form>
	</div><!--end of home-->
	</div><!--end of waku-->
</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
