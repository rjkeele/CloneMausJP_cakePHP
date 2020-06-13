<?php
require_once('site-config.php');
require_once('authorize.php');
require_once( './common/builders.php' );
session_start();
$buildersObj = new builders();
$buildersObj->get_all_setting( $settings_data );
$data['site_name'] = $settings_data['site_name'];
$data['head'] = $settings_data['head'];
$data['css'] = $settings_data['css'];
$errorMessage = "";
$auth = '';
$userid = '';
$password = '';

if( !$buildersObj->get_all_top( $tops_data ))
{
	echo $err['top'] = "トップページが作成されていません。";
}
else {
	$data['title'] = htmlspecialchars_decode( nl2br( $tops_data['title'] ));
	$data['contents'] = htmlspecialchars_decode( nl2br( $tops_data['contents'] ));
	$data['description'] = $tops_data['description'];
	$data['keyword'] = $tops_data['keyword'];
}


if(!empty($_SESSION["tes_USERID"]) && !empty($_SESSION["tes_PASSWORD"]))
{
	$auth = jdgAuth($_SESSION["tes_USERID"], $_SESSION["tes_PASSWORD"], $reg_date);
	if($auth === AUTH_RES_PASS)
	{
		session_regenerate_id(TRUE);
		header("Location: main.php");
	}else{
		$_SESSION = array();
		@session_destroy();
	}
}
if(!empty($_POST["login"]))
{
	if(!empty($_POST["userid"]) && !empty($_POST["password"]))
	{
		$userid = htmlspecialchars(trim($_POST["userid"]));
		$password = htmlspecialchars(trim($_POST["password"]));
		$auth = jdgAuth($userid, $password, $reg_date);
	}
	
	switch($auth)
	{
	case AUTH_RES_PASS:
		break;
	case AUTH_RES_EXCEPTION:
		$errorMessage = '<p style="color:red;">メールアドレスかパスワードが違います。</p>';
		break;
	default:
		$errorMessage = '<p style="color:red;">メールアドレスを正確に入力してください。</p>';
		break;
	}
	if($auth === AUTH_RES_PASS)
	{
		session_regenerate_id(TRUE);
		$_SESSION["tes_USERID"] = $userid;
		$_SESSION["tes_PASSWORD"] = $password;
		$_SESSION["tes_REG_DATE"] = $reg_date;
		header("Location: main.php");
	}
}
?>
<?php /***** not login *****/ ?>
<!--------------Doctype--------------->
<?php include("_doctype.php"); ?>
<!--------------Header--------------->
<?php include("_header.php"); ?>
<!--------------Content--------------->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>

<div class="heading">
<?php echo '<h2>'.$data['title'].'</h2>'; ?>
<div class="info"></a></div>
</div>
<div class="content">

<!--------------Page original start--------------->
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<fieldset>
<div><?php echo $errorMessage ?></div>
<label for="userid">User ID</label><input type="text" id="userid" name="userid" value="<?php echo $userid; ?>">
<br>
<label for="password">Password</label><input type="password" id="password" name="password" value="<?php echo $password; ?>">
<br>
<label></label><input type="submit" id="login" name="login" value="ログイン"  class="btn btn-primary">
</fieldset>
</form>



<form method="post" action="http://dl-mart.com/course/formadd/">
<fieldset>
<label for="firstname">お名前（姓名）</label>
<input type="text" id="firstname" name="firstname" value=""> <input type="text" id="lastname" name="lastname" value="">
<label for="email">メールアドレス</label>
<input type="text" id="email" name="email" value=""><label></label>
<input name="status" type="hidden" value="LOGIN" />
<input type="submit" id="login" name="login" value=" 登 録 "  class="btn btn-primary">
</fieldset>
</form>





<!--------------Page original end--------------->
</div>
</article>
</div>
</div>

</div>
</div>
</section>
<!--------------Footer--------------->
<?php include("_footer.php");?>