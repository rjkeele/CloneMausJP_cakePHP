<?php
require_once( '../common/users.php' );
require_once( '../common/mails.php' );
require_once( '../common/bodys.php' );
require_once( '../common/builders.php' );

$usersObj = new users();
$mailsObj = new mails();
$buildersObj = new builders();
$settings = $usersObj->get_settings();
$password = $settings['form_password'];
$buildersObj->get_all_setting( $tp_settings_data );
$data['title'] = '';
$data['head'] = $tp_settings_data['head'];
$data['css'] = $tp_settings_data['css'];
$data['site_name'] = $tp_settings_data['site_name'];
	
if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$usersObj->get_data($_REQUEST, $form_data);
	$status = $form_data['status'];
}

(!isset($status)) ? $status = '':NULL;

switch( $status )
{
case 'UNLOCK':
	if( strcmp( $password, $form_data['pw'] ) == 0 )
	{
		$status = 'LOGIN';
		$form_data['firstname'] = '';
		$form_data['lastname'] = '';
		$form_data['email'] = '';
		$form_data['order_no'] = '';
	}
	else
	{
		$status = 'UNLOCK';
	}
	break;
case 'LOGIN':
	$usersObj->check_mailadd( $form_data['email'] );
	$usersObj->check_word_count( $form_data['firstname'], 32 );
	$usersObj->check_word_count( $form_data['lastname'], 32 );
	if( !empty( $form_data['order_no'] ))
		$usersObj->check_order_no( $form_data['order_no'], 32 );
	$err = $usersObj->get_err();
	if( empty( $err ))
	{
		$user_cnt = $usersObj->get_user_cnt( $form_data['email'] );
		if( $user_cnt > 0 )
		{
			$err['email'] = 'すでに登録されています。';
		}
		else
		{
			$user['email'] = $form_data['email'];
			$user['password'] = $settings['user_password'];
			$user['firstname'] = $form_data['firstname'];
			$user['lastname'] = $form_data['lastname'];
			$user['order_no'] = $form_data['order_no'];
			$user['scenario_id'] = SCENARIOS_ID;
			$user['auth'] = USER_ROLL;
			$user['delete_flg'] = FLG_NORMAL;
			$status = $usersObj->add_user( $user );
			if( $status )
			{
				$status = 'DONE';
				if( $settings['automail_add_admin'] & $settings['automail_add_user'] )
				{
					$form_data['send_settings'] = 0;
				}
				elseif( $settings['automail_add_admin'] )
				{
					$form_data['send_settings'] = 1;
				}
				elseif( $settings['automail_add_user'] )
				{
					$form_data['send_settings'] = 2;
				}
				$form_data['status'] = '';
				$mailsObj->send_auto_mail($form_data, $user, $settings);
			}
			else {
				$status = 'LOGIN';
			}
		}
	}
	break;
default:
	if( $settings['form_is_password'] == 1 )
	{
		$status = 'UNLOCK';
	}
	else {
		$status = 'LOGIN';
	}
	break;
}
?>
<?php include( '../_doctype.php'); ?>
<?php include( '../_header.php'); ?>

<!--------------Content--------------->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>
<?php switch( $status ): ?>
<?php case 'UNLOCK': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">パスワードを入力して登録画面を開きます。</h2>
<div class="info"></a></div>
</div>
<div class="content">
<form action="" method="POST">
<fieldset>
<label class="semifom">パスワード</label>
<input name="pw" id="pw" type="password" />
<label></label>
<input name="status" type="hidden" value="UNLOCK" />
<input name="action" type="submit" value="送信" class="btn btn-primary" />
</fieldset>
</form>
<?php break; ?>
<?php case 'LOGIN': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">会員登録</h2>
<div class="info"></a></div>
</div>
<div class="content">
<form method="post" action="">
	<fieldset>
	<label for="firstname">お名前</label>
	<span style="margin-right:5px;vertical-align: middle;">姓</span><input type="text" id="firstname" name="firstname" value="<?php echo $form_data['firstname']; ?>"><span style="margin:0 5px 0 10px;vertical-align:middle;">名</span><input type="text" id="lastname" name="lastname" value="<?php echo $form_data['lastname']; ?>">
	<?php echo (!empty($err['name'])) ? '<div style="color:red;">'.$err['name'].'</div>':NULL;?>
	<br>
	<label for="email">メールアドレス</label><input type="text" id="email" name="email" value="<?php echo $form_data['email']; ?>">
	<?php echo (!empty($err['email'])) ? '<div style="color:red;">'.$err['email'].'</div>':NULL;?>
<?php if( !empty($settings['form_order_no'] )): ?>
	<br>
	<label for="order_no">注文No</label><input type="text" id="order_no" name="order_no" value="<?php echo $form_data['order_no']; ?>">
	<?php echo (!empty($err['order_no'])) ? '<div style="color:red;">'.$err['order_no'].'</div>':NULL;?>
<?php endif; ?>
	<br>
	<label></label>
	<input name="status" type="hidden" value="LOGIN" />
	<input type="submit" id="login" name="login" value="登録"  class="btn btn-primary">
	</fieldset>
</form>
<?php break; ?>
<?php case 'DONE': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">会員登録完了</h2>
<div class="info"></a></div>
</div>
<div class="content">
<p>会員登録が完了しました。<br>
この度はお申し込みをありがとうございました。</p>
<?php if( $settings['automail_add_user'] ): ?>
<p><?php echo $user['email'] ?>に登録完了メールを送信しましたのでご確認下さい。</p>
<?php endif; ?>
<p>今後退会される時は、配信されるメール内の配信解除用リンクをクリックするか<br>
解除フォームからメールアドレスを送信すると退会することができます。</p>
<?php break; ?>
<?php default: ?>
<?php break; ?>
<?php endswitch; ?>
<!--------------Page original end--------------->
</div>
</article>
</div>
</div>
</div>
</div>
</section>
<!--------------Footer--------------->
<?php include( '../_footer.php' ); ?>