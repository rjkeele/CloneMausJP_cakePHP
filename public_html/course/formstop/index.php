<?php
require_once( '../common/users.php' );
require_once( '../common/mails.php' );
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
$form_data['email'] = '';

$result = FALSE;
if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$usersObj->get_data($_REQUEST, $form_data);
	if( !empty( $form_data['email'] ))
	{
		$usersObj->check_mailadd( $form_data['email'] );
		$err = $usersObj->get_err();
		if( empty( $err ))
		{
			$id = $usersObj->get_user_id( $form_data['email'] );
			if( !empty( $id ) & !$usersObj->db_is_admin( $id ))
			{
				if( !$settings['send_stop'] )
				{
					$flg = FLG_DELETE;
					$usersObj->db_delflag_user( $flg, $id );
					$result = TRUE;
				}
				else
				{
					$usersObj->db_delete_user( $id );
					$result = TRUE;
				}
				if( $result )
				{
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
					$form_data['status'] = 'STOP';
					$user['email'] = $form_data['email'];
					$mailsObj->send_auto_mail($form_data, $user, $settings);
				}
			}
			else
			{
				$err['email'] = 'メールアドレスが登録されていません。';
			}
		}
	}
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
<?php if( $result == FALSE ): ?>
<div class="heading">
<h2>会員解除</h2>
<div class="info"></a></div>
</div>
<div class="content">
<?php
if( !$settings['send_stop'] ): ?>
<p>解除すると会員メールが届かなくなりますのでご注意ください。</p>
<?php endif; ?>
<form method="post" name="send_stop" action="">
	<fieldset>
	<label for="email">メールアドレス</label>
	<input type="text" id="email" name="email" value="<?php echo $form_data['email']; ?>"><br>
	<?php echo (!empty($err['email'])) ? '<div style="color:red;">'.$err['email'].'</div>':NULL;?>
	<a onclick="if (confirm('会員解除してよろしいですか？')) { document.send_stop.submit(); } event.returnValue = false; return false;" href="#" class="btn btn-danger">会員解除</a>
	</fieldset>
</form>
<?php else: ?>
<div class="heading">
<h2>会員解除完了</h2>
<div class="info"></a></div>
</div>
<div class="content">
<p>会員の解除が完了しました。<br>
これまでのお付き合いをありがとうございました。</p>
<?php if( $settings['automail_stop_user'] ): ?>
<p><?php echo $user['email'] ?>に解除完了メールを送信しましたのでご確認下さい。</p>
<?php endif; ?>
<?php endif; ?>
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