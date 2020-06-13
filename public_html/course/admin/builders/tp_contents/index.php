<?php
 require_once( '../../../common/config.ini' ); require_once( '../../../common/users.php' ); require_once( '../../../common/builders.php' ); require_once( '../../../common/class_image.php' ); session_start(); $usersObj = new users(); $buildersObj = new builders(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $usersObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $buildersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; (!isset($form_data['title'])) ? $form_data['title'] = '':NULL; (!isset($form_data['description'])) ? $form_data['description'] = '':NULL; (!isset($form_data['keyword'])) ? $form_data['keyword'] = '':NULL; (!isset($form_data['contents'])) ? $form_data['contents'] = '':NULL; (!isset($form_data['public_date'])) ? $form_data['public_date'] = '':NULL; } switch ($form_data['status']) { case 'add_done': $buildersObj->check_input_contents( $form_data ); $err = $buildersObj->get_err(); if( empty( $err )) { $form_data['url'] = 'post-'.date('YmdHis'); $buildersObj->db_add_content( $form_data ); } else { $buildersObj->get_all_img_uploaders( $img_uploaders_data ); require_once( 'add.php'); break; } header( 'Location:'.URL.'/admin/builders/?status=content' ); break; case 'edit': if( $buildersObj->get_content( $form_data['id'], $form_data )) { } $buildersObj->get_all_img_uploaders( $img_uploaders_data ); $form_data['status'] = 'edit'; require_once( 'edit.php'); break; case 'edit_done': $buildersObj->check_input_contents( $form_data ); $err = $buildersObj->get_err(); if( empty( $err )) { $buildersObj->db_edit_content( $form_data ); } else { $buildersObj->get_all_img_uploaders( $img_uploaders_data ); require_once( 'edit.php'); break; } header( 'Location:'.URL.'/admin/builders/?status=content' ); break; case 'delete': $buildersObj->db_delete_content( $form_data['id'] ); $buildersObj->db_delete_sidebars_contents_id( $form_data['id'] ); header( 'Location:'.URL.'/admin/builders/?status=content' ); break; case 'upload_done': $upload_key = 'images'; $img_path1 = 'images'; $img_path2 = date( "Ymd", time() ); $img_path = '../../../'.$img_path1.'/'.$img_path2; if( !is_dir( $img_path )) { if( @mkdir( $img_path )) { } else { $err['upload'] = 'ディレクトリの作成に失敗しました。'; } } $result = $buildersObj->upload( $data, $upload_key, $img_path ); if( $result === TRUE) { $data['title'] = pathinfo( $data['org_file'], PATHINFO_FILENAME ); $data['store_folder'] = $img_path1.'/'.$img_path2; $data['thumbnail'] = 'thum-'.$data['store_file']; $buildersObj->db_add_img_uploaders( $data ); $data['store_folder'] = '../../../'.$data['store_folder']; $buildersObj->make_thumbnail( $data ); } else { $err['upload'] = $result; $buildersObj->get_all_img_uploaders( $img_uploaders_data ); require_once( 'add.php' ); break; } header( 'Location:'.URL.'/admin/builders/tp_contents/' ); break; case 'upload_delete': if($_SERVER["REQUEST_METHOD"] == "POST") { $buildersObj->get_img_uploaders( $form_data['id'], $data ); $data['store_folder'] = '../../../'.$data['store_folder']; $buildersObj->del_img_file( $data ); $buildersObj->db_delete_img_uploaders( $form_data['id'] ); } header( 'Location:'.URL.'/admin/builders/?status=upload' ); break; default: $buildersObj->get_all_img_uploaders( $img_uploaders_data ); $form_data['status'] = 'default'; require_once( 'add.php'); break; } ?>