<?php
require_once('site-config.php');
require_once('authorize.php');
require_once( './common/builders.php' );
session_start();
if(isAuthAlive() == true){
	session_regenerate_id(TRUE);
	$buildersObj = new builders();
	$buildersObj->get_all_setting($settings_data);
	$data['site_name'] = $settings_data['site_name'];
	$data['head'] = $settings_data['head'];
	$data['css'] = $settings_data['css'];
	$id = htmlspecialchars($_SESSION['tes_USERID']);
}else{
	$_SESSION = array();
	@session_destroy();
	header("Location:index.php");
}
if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	$buildersObj->get_data($_REQUEST, $form_data);
	$data['title'] = 'お問い合わせ';
	
	$buildersObj->get_all_sidebar( $sidebars_data );
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	$freearea_upper = htmlspecialchars_decode(nl2br($side_freeareas_data[0]['contents']));
	$freearea_lower = htmlspecialchars_decode(nl2br($side_freeareas_data[1]['contents']));
}
?>
<!--------------Doctype--------------->
<?php include("_doctype.php"); ?>
<!--------------Header--------------->
<?php include("_header.php"); ?>

<!--------------Content--------------->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">

<div id="main-content" class="col-2-3">
<div class="wrap-col">
<article>
<div class="heading">
<h2><?php echo $data['title'] ?></h2>
<div class="info"></a></div>
</div>
<div class="content">

<!--------------Page original start--------------->
<form name="registform" action="contactmail.php" method="POST" onsubmit="return checkform()">

	<div class="control-group">
	    <label>お名前（苗字のみでok）</label>
		<input type="text" name="お名前" id="familyname" value="" placeholder="お名前" class="span6"/>
	</div>

	<div class="control-group">
	    <label>メールアドレス</label>
		<input type="text" name="Email" id="Email" value="<?php echo $id;?>" placeholder="Email" class="span6" /><br />
		<input type="text" name="確認用Email" id="_check_from" value="<?php echo $id;?>" placeholder="確認用Email（コピペできません）" class="span6" onPaste="return false"/>
	</div>

	<div class="control-group">
	    <label>お問い合わせ件名</label>
		<input type="text" name="お問い合わせ件名" id="mailttl" value="" placeholder="お問い合わせ件名をお願いします" class="span6" /><br />
	</div>

	<div class="control-group">
	    <label>お問い合わせ内容</label>
		<textarea name="お問い合わせ内容" id="comment" rows="8" class="span6"></textarea>
	</div>


	<button type="submit" name="submit" class="btn btn-primary">確　認</button>
	<button type="reset" name="reset" class="btn" style="margin-left:5px;">リセット</button>

</form>
<!--------------Page original end--------------->
</div>
</article>
</div>
</div>

<!--------------sidebar pagelist start--------------->
<?php include("_sidebar.php"); ?>

<!--------------Page original end--------------->
</div>
</div>
</section>

<!--------------Footer--------------->
<?php include("_footer.php"); ?>

<script type="text/javascript">
var validation = $("form")
	.exValidation({
		firstValidate: true,
		rules: {
			familyname: "chkrequired",
			Email: "chkrequired chkemail",
			_check_from: "chkrequired chkemail chkretype-Email",
			mailttl: "chkrequired",
			comment: "chkrequired"
		},
		stepValidation: true
	});
var selectable = $('#pref').selectable({
	callback: function() {
		validation.laterCall('#pref');
	}
});
</script>
