<?php
 require_once( dirname(__FILE__).'/main.php' ); class settings extends main { protected $err; function db_set_setting() { $user_password = $this->make_password(); $form_password = $this->make_password(); $now = $this->get_now_date(); try { $sql = "INSERT INTO `settings` (
						`id`, `user_password`, `form_password`, `from_email`, `name_email`, `reply_email`, `send_err_num`, `send_err`, `send_stop`, `send_num`, `send_interval`, `automail_add_admin`, `automail_stop_admin`, `automail_add_user`, `automail_stop_user`, `created`, `modified`
			)
					VALUES (
						NULL, :user_password, :form_password, NULL, NULL, NULL, '3', '0', '0', '100', '1', '0', '0', '0', '0', :created, NULL
					);"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':user_password', $user_password ); $this->stmt->bindValue( ':form_password', $form_password ); $this->stmt->bindValue( ':created', $now ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_add_setting( $data ) { $now = $this->get_now_date(); try { $sql = "INSERT INTO `settings` (`setting`, `created`) VALUES (:setting, :created)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':setting', $data['setting'] ); $this->stmt->bindValue( ':created', $now ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_make_setting( $form_data, $data ) { if( empty( $form_data['name_email'] )){ $form_data['name_email'] = $data['name_email']; } } function db_edit_setting( $data ) { $now = $this->get_now_date(); try { $sql = "UPDATE `settings` 
				SET `user_password` = :user_password, `form_password` = :form_password, `send_err_num` = :send_err_num, `send_err` = :send_err, `send_stop` = :send_stop, `send_num` = :send_num, `send_interval` = :send_interval, `automail_add_admin` = :automail_add_admin, `automail_stop_admin` = :automail_stop_admin, `automail_add_user` = :automail_add_user, `automail_stop_user` = :automail_stop_user, `form_order_no` = :form_order_no, `form_is_password` = :form_is_password, `modified` = :modified 
				WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':user_password', $data['user_password'], PDO::PARAM_STR ); $this->stmt->bindValue( ':form_password', $data['form_password'], PDO::PARAM_STR ); $this->stmt->bindValue( ':send_err_num', $data['send_err_num'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_err', $data['send_err'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_stop', $data['send_stop'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_num', $data['send_num'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_interval', $data['send_interval'], PDO::PARAM_INT ); $this->stmt->bindValue( ':automail_add_admin', $data['automail_add_admin'], PDO::PARAM_INT ); $this->stmt->bindValue( ':automail_stop_admin', $data['automail_stop_admin'], PDO::PARAM_INT ); $this->stmt->bindValue( ':automail_add_user', $data['automail_add_user'], PDO::PARAM_INT ); $this->stmt->bindValue( ':automail_stop_user', $data['automail_stop_user'], PDO::PARAM_INT ); $this->stmt->bindValue( ':form_order_no', $data['form_order_no'], PDO::PARAM_INT ); $this->stmt->bindValue( ':form_is_password', $data['form_is_password'], PDO::PARAM_INT ); $this->stmt->bindValue( ':modified', $now); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_setting( $id ) { $now = $this->get_now_date(); try { $sql = "DELETE FROM `settings`
					WHERE `settings`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_all_delete_setting() { try { $sql = "TRUNCATE TABLE `settings`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_setting( &$data ) { $result = FALSE; $this->db_all_setting(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = TRUE; } return $result; } private function db_all_setting() { try { $sql = "SELECT * FROM `settings`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_setting( $id, &$data ) { $result = false; $this->db_setting( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_setting( $id ) { try { $sql = "SELECT * FROM `settings` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function check_mailadd( $mail ) { if( !preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail ) ) { $this->err['email1'] = 'メールアドレスが間違っています。'; } } function check_pw( $pw ) { if( !preg_match( "/^([a-zA-Z0-9]+)([a-zA-Z0-9\._-]{5,32})$/", $pw ) ) { $this->err['password'] = 'パスワードは半角6文字以上で入力してください。'; } } function check_word_count( $name, $num ) { if( mb_strlen($name,"UTF-8") < 2 || mb_strlen($name,"UTF-8") > $num ) { $this->err['firstname'] = '名前を正確に入力してください。'; } } function get_err() { return $this->err; } } ?>