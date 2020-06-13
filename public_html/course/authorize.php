<?php
require_once( './common/users.php' );
define('AUTH_RES_PASS',0);
define('AUTH_RES_EXCEPTION', 99);
define('AUTH_RES_MAIL', 999);

function jdgAuth($userid, $pass, &$reg_date)
{
	$ret = AUTH_RES_EXCEPTION;
	$usersObj = new users();
	$usersObj->check_mailadd($userid);
	$err = $usersObj->get_err();
	if(!empty($err)){
		return AUTH_RES_MAIL;
	}
	$usersObj->db_login( $userid, $pass, $auth=USER_ROLL, $user );
	if(!empty($user))
	{
		if(!empty($user['send_date']))
		{
			$reg_date = date('Y/m/d', strtotime( $user['send_date'] ));
		}
		else {
			$reg_date = date('Y/m/d', strtotime( "+1 day" ));
		}
		$ret = AUTH_RES_PASS;
	}
	return $ret;
}

function isAuthAlive(){
	$ret = false;
	if(isset($_SESSION["tes_USERID"]) && isset($_SESSION["tes_PASSWORD"]))
	{
		if(jdgAuth($_SESSION["tes_USERID"], $_SESSION["tes_PASSWORD"], $dummy) == AUTH_RES_PASS)
		{
			$ret = true;
		}
	}
	return $ret;
}
