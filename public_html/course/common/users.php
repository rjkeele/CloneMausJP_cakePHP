<?php
 require_once( dirname(__FILE__).'/main.php' ); class users extends main { private $user; private $err; function db_login( $email, $password, $auth, &$user ) { $result = FALSE; $this->db_check_login( $email, $password, $auth ); $result = $this->stmt->fetchAll(); $cnt = count($result); if($cnt == 1) { $data = $result[0]; $user['id'] = $data['id']; $user['email'] = $email; $user['password'] = $password; $user['auth'] = $auth; $user['send_date'] = $data['send_date']; $user['created'] = $data['created']; $user['modified'] = $data['modified']; $result = TRUE; } return $result; } private function db_check_login( $email, $password, $auth ) { try { $sql = "SELECT id, send_date, created, modified
					FROM `users`
					WHERE `email` = :email
					AND `password` = :password
					AND `auth` = :auth
					AND `delete_flg` = '0'"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ":email", $email, PDO::PARAM_STR ); $this->stmt->bindValue( ":password", $password, PDO::PARAM_STR ); $this->stmt->bindValue( ":auth", $auth, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function set_auth_session( $data ) { $_SESSION['id'] = $data['id']; $_SESSION['email'] = $data['email']; $_SESSION['password'] = $data['password']; if(isset($data['auth'])) $_SESSION['auth'] = $data['auth']; if(isset($data['created'])) $_SESSION['created'] = $data['created']; } function get_auth_session( $session, &$user ) { $result = FALSE; if( isset($session['email']) && isset($session['password']) ) { $user['id'] = (int)$session['id']; $user['email'] = htmlspecialchars( $session['email'], ENT_QUOTES ); $user['password'] = htmlspecialchars( $session['password'], ENT_QUOTES ); $user['auth'] = (int)$session['auth']; $user['created'] = htmlspecialchars( $session['created'], ENT_QUOTES ); $result = TRUE; } return $result; } function check_mailadd( $mail ) { if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail ) ) { $this->err['email'] = 'メールアドレスが間違っています。'; } } function check_pw( $pw ) { if( !preg_match( "/^([a-zA-Z0-9]+)([a-zA-Z0-9\._-]{5,32})$/", $pw ) ) { $this->err['password'] = 'パスワードは半角6文字以上で入力してください。'; } } function check_double_pw( $pw1, $pw2 ) { if( $pw1 !== $pw2 ) { $this->err['password2'] = 'パスワードを正しく入力してください。'; } } function check_word_count( $name, $num ) { if( mb_strlen($name,"UTF-8") < 1 || mb_strlen($name,"UTF-8") > $num ) { $this->err['name'] = '正確に入力してください。'; } } function check_order_no( $str, $num ) { if( mb_strlen($str,"UTF-8") < 1 || mb_strlen($str,"UTF-8") > $num ) { $this->err['order_no'] = '注文Noを正確に入力して下さい。'; } } function check_login() { if( $this->check_input( 'email', 'password' ) ) { $this->err['all'] = '入力項目に漏れがあります。'; } } function redeclare_email( $email ) { $result = TRUE; $stmt = $this->db_serach_login_name( $email ); $row = $stmt->fetchAll(); $cnt = count($row); if($cnt >= 1) { $result = FALSE; $this->err['email'] ='すでに登録されています。'; } return $result; } private function db_serach_login_name( $email ) { try { $this->stmt = $this->pdo->prepare( "SELECT * FROM users WHERE `email` = :email AND `delete_flg` = '0' AND `auth` != '9'" ); $this->stmt->bindValue( ":email", $email ); $this->stmt->execute(); return $this->stmt; } catch(PDOException $e){ die($e->getMessage()); } } function get_err() { $err = $this->err; $this->err = ''; return $err; } function search_email_name_order( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE `email` LIKE :email
					AND (`firstname` LIKE :name OR `lastname` LIKE :name)
					AND `order_no` LIKE :order_no
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email','%'.$form_data['email'].'%' ); $stmt->bindValue( ':name','%'.$form_data['name'].'%' ); $stmt->bindValue( ':order_no','%'.$form_data['order_no'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function search_email_name( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE `email` LIKE :email
					AND (`firstname` LIKE :name OR `lastname` LIKE :name)
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email','%'.$form_data['email'].'%' ); $stmt->bindValue( ':name','%'.$form_data['name'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function search_email_order( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE `email` LIKE :email
					AND `order_no` LIKE :order_no
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email','%'.$form_data['email'].'%' ); $stmt->bindValue( ':name','%'.$form_data['name'].'%' ); $stmt->bindValue( ':order_no','%'.$form_data['order_no'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function search_email( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE `email` LIKE :email
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email','%'.$form_data['email'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function search_name_order( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE (`firstname` LIKE :name OR `lastname` LIKE :name)
					AND `order_no` LIKE :order_no
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':name','%'.$form_data['name'].'%' ); $stmt->bindValue( ':order_no','%'.$form_data['order_no'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function search_name( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE (`firstname` LIKE :name1 OR `lastname` LIKE :name2)
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':name1','%'.$form_data['name'].'%' ); $stmt->bindValue( ':name2','%'.$form_data['name'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function search_order( $form_data, &$data ) { $result = FALSE; try { $sql = 'SELECT *
					FROM `users`
					WHERE `order_no` LIKE :order_no
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':order_no','%'.$form_data['order_no'].'%' ); $stmt->bindValue( ':scenario_id',$form_data['scenario_id'] ); $stmt->bindValue( ':auth',$form_data['auth'] ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } catch(PDOException $e){ die($e->getMessage()); } } function db_set_user( $id ) { $result = FALSE; try { $stmt = $this->pdo->prepare( 'SELECT * FROM `users` WHERE id = :id' ); $stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $stmt->execute(); $row = $stmt->fetchObject(); } catch(PDOException $e){ die($e->getMessage()); } if( count($row) == 1 ) { $this->user['id'] = $row->id; $this->user['email'] = $row->email; $this->user['password'] = $row->password; $this->user['firstname'] = $row->firstname; $this->user['lastname'] = $row->lastname; $this->user['order_no'] = $row->order_no; $this->user['scenario_id'] = $row->scenario_id; $this->user['auth'] = $row->auth; $this->user['delete_flg'] = $row->delete_flg; $this->user['deleted'] = $row->deleted; $this->user['send_date'] = $row->send_date; $this->user['created'] = $row->created; $this->user['modified'] = $row->modified; $result = TRUE; } return $result; } function db_get_user() { return $this->user; } function count_users( $scenario_id ) { $this->db_count_users( $scenario_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); return $cnt; } private function db_count_users( $scenario_id ) { try { $this->stmt = $this->pdo->prepare( 'SELECT * FROM `users` WHERE `scenario_id` = :scenario_id AND `auth` !=9' ); $this->stmt->bindValue( ':scenario_id', $scenario_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_user_id( $email ) { $result = FALSE; $this->db_get_user_id( $email ); $row = $this->stmt->fetchAll(); if( count($row) == 1 ) { $result = $row[0]['id']; } return $result; } private function db_get_user_id( $email ) { try { $this->stmt = $this->pdo->prepare( 'SELECT `id` FROM `users` WHERE `email` = :email AND `delete_flg` != 1 AND `auth` != 9' ); $this->stmt->bindValue( ':email', $email, PDO::PARAM_STR ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_user_cnt( $email ) { $result = FALSE; $this->db_get_user_cnt( $email ); $row = $this->stmt->fetchAll(); return count($row); } private function db_get_user_cnt( $email ) { try { $this->stmt = $this->pdo->prepare( 'SELECT `id` FROM `users` WHERE `email` = :email AND `delete_flg` != 1 AND `auth` != 9' ); $this->stmt->bindValue( ':email', $email, PDO::PARAM_STR ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_settings() { $result = FALSE; $this->db_get_settings(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if( count($row) == 1 ) { $result = $row[0]; } return $result; } private function db_get_settings() { try { $this->stmt = $this->pdo->prepare( 'SELECT * FROM `settings`' ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_update_setting_user_password( $data, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `settings`
					SET `user_password`=:user_password , `modified`=:modified
		    		WHERE `id` = :id'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':user_password',$data['user_password'] ); $stmt->bindValue( ':modified',$now ); $stmt->bindValue( ':id',$id,PDO::PARAM_INT ); $stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_update_all_password( $data ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `users`
					SET `password`=:password, `modified`=:modified
		    		WHERE `auth` !=9
					AND `delete_flg` =0'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':password',$data['user_password'] ); $stmt->bindValue( ':modified',$now ); $stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_update_setting_form_password( $data, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `settings`
					SET `form_password`=:form_password,`form_is_password`=:form_is_password , `modified`=:modified
		    		WHERE `id` = :id'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':form_password',$data['form_password'] ); $stmt->bindValue( ':form_is_password',$data['form_is_password'] ); $stmt->bindValue( ':modified',$now ); $stmt->bindValue( ':id',$id,PDO::PARAM_INT ); $stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } private function db_add_user( $data ) { $result = FALSE; $now = $this->get_now_date(); try { $sql = 'INSERT INTO `users` (
					`email`, `password`, `firstname`, `lastname`, `order_no`, `scenario_id`, `auth`, `delete_flg`, `created`)
					VALUES (
					:email, :password, :firstname, :lastname, :order_no, :scenario_id, :auth, :delete_flg, :created)'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email', $data['email'], PDO::PARAM_STR ); $stmt->bindValue( ':password', $data['password'], PDO::PARAM_STR ); $stmt->bindValue( ':firstname', $data['firstname'], PDO::PARAM_STR ); $stmt->bindValue( ':lastname', $data['lastname'], PDO::PARAM_STR ); $stmt->bindValue( ':order_no', $data['order_no'], PDO::PARAM_STR ); $stmt->bindValue( ':scenario_id', $data['scenario_id'], PDO::PARAM_INT ); $stmt->bindValue( ':auth', $data['auth'], PDO::PARAM_INT ); $stmt->bindValue( ':delete_flg', $data['delete_flg'], PDO::PARAM_INT ); $stmt->bindValue( ':created',$now, PDO::PARAM_STR ); $stmt->execute(); $result = TRUE; } catch( PDOException $e ){ die( $e->getMessage() ); } return $result; } function db_update_admin( $data, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `users`
					SET `email`=:email,`password`=:password, `modified`=:modified
		    		WHERE `id` = :id'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email', $data['email'] ); $stmt->bindValue( ':password', $data['password'] ); $stmt->bindValue( ':modified', $now ); $stmt->bindValue( ':id', $id ); $stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_update_admin_name( $name, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `users`
					SET `firstname`=:firstname,`modified`=:modified
		    		WHERE `id` = :id'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':firstname', $name ); $stmt->bindValue( ':modified', $now ); $stmt->bindValue( ':id', $id ); $stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function add_user( $data ) { $result = FALSE; $result = $this->db_add_user( $data ); return $result; } function db_update_users( $data, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `users`
					SET `email`=:email, `firstname`=:firstname,`lastname`=:lastname, `order_no`=:order_no, `delete_flg`=:delete_flg, `modified`=:modified
		    		WHERE `id` = :id'; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':email', $data['email'] ); $stmt->bindValue( ':firstname', $data['firstname'] ); $stmt->bindValue( ':lastname', $data['lastname'] ); $stmt->bindValue( ':order_no', $data['order_no'] ); $stmt->bindValue( ':delete_flg',$data['delete_flg'] ); $stmt->bindValue( ':modified', $now ); $stmt->bindValue( ':id', $id ); $stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delflag_user( $flg, $id ) { $now = $this->get_now_date(); try { $stmt = $this->pdo->prepare( 'UPDATE `users` SET `delete_flg` = :flg,`deleted`=:deleted WHERE `id` =:id AND `auth` != 9' ); $stmt->bindParam( ':flg', $flg ); $stmt->bindParam( ':deleted', $now ); $stmt->bindValue( ':id', $id ); $stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function update_users_send_date( $flg ) { if($flg) { $sql = 'UPDATE `users` SET `send_date` = now(),`modified`= now() WHERE `send_date` IS NULL AND `auth` != 9'; } else { $sql = 'UPDATE `users` SET `send_date` = NULL,`modified`= now() WHERE `send_date` IS NOT NULL AND `auth` != 9'; } try { $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_is_admin( $id ) { try { $stmt = $this->pdo->prepare( 'SELECT COUNT(*) FROM `users` WHERE `id` = :id AND `auth` = 9' ); $stmt->bindValue( ':id', $id ); $stmt->execute(); $row = $stmt->fetchColumn(); return $row; } catch(PDOException $e){ die($e->getMessage()); } } function make_stop_url( $scenario_id=NULL, $email ) { $email = urlencode( $email ); $scenario_id = SCENARIOS_ID; $url = URL .'/formstop/?scenario_id='.$scenario_id.'&email='. $email; return $url; } function db_delete_user( $id ) { try { $stmt = $this->pdo->prepare( 'DELETE FROM `users` WHERE `id` = :id AND `auth` != 9' ); $stmt->bindValue( ':id', $id ); $stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_all_user( &$data, $start=0, $num=998 ) { $result = FALSE; $this->db_all_user( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_user( $start, $num ) { try { $sql = "SELECT * FROM `users` WHERE `auth` !=9 ORDER BY `users`.`created` DESC LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function set_formadd( $form_order_no ) { $file = '../../template/'.FNAME_FORM; $str = @file_get_contents( $file ); $url = URL.'/formadd/'; $str = preg_replace( '/<!--FORM_URL-->/is', $url, $str ); if( $form_order_no ) { $str = preg_replace( '/<!--FORM_ORDER_NO-->/is', "\r\n", $str ); $str = preg_replace( '/<!--END_FORM_ORDER_NO-->/is', '', $str ); $str = preg_replace( '/\r\n\r\n|\r\r|\n\n|\t/', "", $str ); } else { $str = preg_replace( '/<!--FORM_ORDER_NO-->(.*)<!--END_FORM_ORDER_NO-->/is', '', $str ); $str = preg_replace( '/\r\n\r\n|\r\r|\n\n|\t/', '', $str ); } return $str; } function txtImport( $data ) { $this->db_is_scenario( $data['scenario_id'] ); $row = $this->stmt->fetchAll(); if( count( $row ) != 1 ) { $err['all'] = "属するシナリオがありません。"; return; } $csvSuccessCnt = 0; $cnt_users = $this->count_users( $data['scenario_id'] ); $max = 999 - (int)$cnt_users; $lines = $data['lines']; $arr = $this->txt2arr( $data['lines'] ); foreach($arr as $line){ $this->err = array(); $record = explode("\t",trim ($line)); mb_language('Japanese'); $record_cnt = count( $record ); if( $record_cnt == 3 ) { $data1 = mb_convert_encoding(html_entity_decode($record[0]), 'UTF-8', 'auto'); $data2 = mb_convert_encoding(html_entity_decode($record[1]), 'UTF-8', 'auto'); $data3 = mb_convert_encoding(html_entity_decode($record[2]), 'UTF-8', 'auto'); $this->check_word_count( $data1, 32 ); $this->check_word_count( $data2, 32 ); $this->check_mailadd( $data3 ); if( empty( $this->err )) { $user['firstname'] = $data1; $user['lastname'] = $data2; $user['email'] = $data3; $user['order_no'] = ''; } else { $result['err'][]['massage'] = '入力データが間違っています。'; $result['err'][]['data'] = $data1; $result['err'][]['data'] = $data2; $result['err'][]['data'] = $data3; break; } } elseif( $record_cnt == 2 ) { $data1 = mb_convert_encoding(html_entity_decode($record[0]), 'UTF-8', 'auto'); $data2 = mb_convert_encoding(html_entity_decode($record[1]), 'UTF-8', 'auto'); $this->check_word_count( $data1, 32 ); $this->check_mailadd( $data2 ); if( empty( $this->err )) { $user['firstname'] = $data1; $user['email'] = $data2; $user['lastname'] = ''; $user['order_no'] = ''; } else { $result['err'][]['massage'] = '入力データが間違っています。'; $result['err'][]['data'] = $data1; $result['err'][]['data'] = $data2; break; } } elseif( $record_cnt == 1 ) { $data1 = mb_convert_encoding(html_entity_decode($record[0]), 'UTF-8', 'auto'); $this->check_mailadd( $data1 ); if( empty( $this->err )) { $user['email'] = $data1; $user['firstname'] = ''; $user['lastname'] = ''; $user['order_no'] = ''; } else { $result['err'][]['massage'] = '入力データが間違っています。'; $result['err'][]['data'] = $data1; break; } } $user['password'] = $data['user_password']; $user['scenario_id'] = $data['scenario_id']; $user['auth'] = USER_ROLL; $user['delete_flg'] = FLG_NORMAL; switch( $data['options'] ) { case '0': if( $this->redeclare_email( $user['email'] ) ) { if( $this->db_add_user( $user )){ $csvSuccessCnt++; } } else { $result['err'][]['massage'] = 'すでに登録されています。'; $result['err'][]['data'] = $user['email']; } break; case '1': if( !$this->redeclare_email( $user['email'] ) ) { $id = $this->get_user_id( $user['email'] ); if( !empty( $id )) { $this->db_delflag_user( FLG_DELETE, $id ); $csvSuccessCnt++; } } else { $result['err'][]['massage'] = '登録されていません。'; $result['err'][]['data'] = $user['email']; } break; default; break; } if($csvSuccessCnt >= $max){ break; } } $result['status'] = $data['options']; $result['cnt_text'] = count( $arr ); $result['cnt_success'] = $csvSuccessCnt; return $result; } private function db_is_scenario( $scenario_id ) { try { $sql = "SELECT * FROM `scenarios` WHERE `id` = :scenario_id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':scenario_id', $scenario_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } private function txt2arr( $lines ) { $array = explode("\n", $lines); $array = array_map('trim', $array); $array = array_filter($array, 'strlen'); $array = array_values($array); return $array; } function get_send_date( $id, &$data ) { $result = FALSE; $this->db_get_send_date( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row[0]; $result = TRUE; } return $result; } private function db_get_send_date( $id ) { try { $sql = "SELECT `send_date`, `story_no`
					FROM `step_mail_logs`
					WHERE `user_id` =:id
					ORDER BY `send_date` DESC
					LIMIT 0 , 1"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_users_csv( $data=null ) { $line = '姓,名,メールアドレス,注文ID,状態(通常:0/停止:1/エラー:99),登録日,送信開始日'."\n"; for( $i = 0 ; $i < count( $data ); $i++ ) { $line.= $data[$i]['firstname'].','.$data[$i]['lastname'].','.$data[$i]['email'].','.$data[$i]['order_no'].','.$data[$i]['delete_flg'].','.$data[$i]['created'].','.$data[$i]['send_date']."\n"; } $file = "users_list_".date( "Ymd-His" ).'.csv'; $csv_data = mb_convert_encoding( $line, "sjis-win", 'utf-8' ); header("Content-Type: application/octet-stream"); header("Content-Disposition: attachment; filename={$file}"); echo($csv_data); } } ?>