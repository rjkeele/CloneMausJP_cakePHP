<?php
 require_once( '../../../common/config.ini' ); require_once( '../../../common/users.php' ); require_once( '../../../common/builders.php' ); session_start(); $usersObj = new users(); $buildersObj = new builders(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $usersObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $buildersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; } switch ($form_data['status']) { case 'edit': $buildersObj->check_input_site_name( $form_data ); $err = $buildersObj->get_err(); if( empty( $err )) { $buildersObj->db_edit_setting( $form_data ); $message = '設定を更新しました。'; } require_once( 'edit.php'); break; case 'delete': $buildersObj->db_delete_setting( $form_data['id'] ); header( 'Location:'.URL.'/admin/settings/' ); break; default: if( !$buildersObj->get_all_setting( $form_data )) { $buildersObj->db_set_setting(); if( $buildersObj->get_all_setting( $form_data )) { $message = "初期設定しました。"; } else { $err['all'] = "設定情報にエラーが見つかりました。恐れ入りますがもう一度設定をして下さい。"; $buildersObj->db_all_delete_setting(); } } $form_data['status'] = 'default'; require_once( 'edit.php'); break; } ?>