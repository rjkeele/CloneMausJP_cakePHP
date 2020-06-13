<?php
 require_once( '../../../common/config.ini' ); require_once( '../../../common/users.php' ); require_once( '../../../common/mails.php' ); require_once( '../../../common/headers.php' ); require_once( '../../../common/footers.php' ); require_once( '../../../common/settings.php' ); session_start(); $usersObj = new users(); $mailsObj = new mails(); $headersObj = new headers(); $footersObj = new footers(); $settingsObj = new settings(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $userObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $mailsObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; (!isset($form_data['title'])) ? $form_data['title'] = '':NULL; (!isset($form_data['header_id'])) ? $form_data['header_id'] = '':NULL; (!isset($form_data['contents'])) ? $form_data['contents'] = '':NULL; (!isset($form_data['footer_id'])) ? $form_data['footer_id'] = '':NULL; (!isset($form_data['send_time'])) ? $form_data['send_time'] = '':NULL; (!isset($form_data['send_time_hour'])) ? $form_data['send_time_hour'] = '':NULL; (!isset($form_data['send_time_minute'])) ? $form_data['send_time_minute'] = '':NULL; } switch ($form_data['status']) { case 'add': $mailsObj->check_input_mails( $form_data ); $err = $mailsObj->get_err(); if(empty( $err )){ $mailsObj->db_add_stepmail($form_data); } else { require_once( 'add.php'); break; } header( 'Location:'.URL.'/admin/mails/?status=step' ); break; case 'edit': if(!isset($form_data['send_time_hour']) || $form_data['send_time_hour'] === "") { $mailsObj->get_stepmail($form_data['id'], $form_data); $send_time = $mailsObj->get_send_time_split($form_data['send_time']); $form_data['send_time_hour'] = $send_time['hour']; $form_data['send_time_minute'] = $send_time['minute']; $form_data['status'] = 'edit'; } require_once( 'edit.php'); break; case 'edit_done': $mailsObj->check_input_mails( $form_data ); $err = $mailsObj->get_err(); if(empty( $err )){ $mailsObj->db_edit_stepmail($form_data); } else { require_once( 'edit.php'); break; } header( 'Location:'.URL.'/admin/mails/?status=step' ); break; case 'delete': $status = $form_data['status']; $mailsObj->get_stepmail($form_data['id'], $form_data); $form_data['status'] = $status; $mailsObj->db_delete_stepmail($form_data); header( 'Location:'.URL.'/admin/mails/?status=step' ); break; case 'prev': $mailsObj->check_input_mails( $form_data ); $err = $mailsObj->get_err(); if(empty( $err )){ require_once( 'preview.php'); break; } else { if(isset($form_data['id']) && $form_data['id'] !== "") { require_once( 'edit.php'); } else { require_once( 'add.php'); } break; } case 'prev_add' : $settingsObj->get_all_setting($setting); $mailsObj->db_add_stepmail($form_data); header( 'Location:'.URL.'/admin/mails/?status=step' ); break; case 'prev_edit': $settingsObj->get_all_setting($setting); $mailsObj->db_edit_stepmail($form_data); header( 'Location:'.URL.'/admin/mails/?status=step' ); break; default: $data = $mailsObj->get_last_story_no( 1 ); $form_data['send_date'] = $data['send_date']+1; $form_data['status'] = 'default'; require_once( 'add.php'); break; } ?>