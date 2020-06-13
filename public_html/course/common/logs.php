<?php
 require_once(dirname(__FILE__).'/main.php'); class logs extends main { function db_add_step_mail_log( $data, $user_id ) { $now = $this->get_now_date(); try { $sql = "INSERT INTO `step_mail_logs`
					(`group_id`, `step_mail_id`, `title`, `contents`, `story_no`, `send_date`, `user_id`, `send_flg`, `created` ) 
					VALUES ( :group_id, :step_mail_id, :title, :contents, :story_no, :send_date, :user_id, :send_flg, :created )"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $data['group_id'] ); $this->stmt->bindValue( ':step_mail_id', $data['id'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':story_no', $data['story_no'] ); $this->stmt->bindValue( ':send_date', $data['send_date'] ); $this->stmt->bindValue( ':user_id', $user_id ); $this->stmt->bindValue( ':send_flg', $data['send_flg'] ); $this->stmt->bindValue( ':created', $now ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_update_step_mail_log( $data, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `step_mail_logs`
					SET `send_date`=:send_date,`send_flg`=:send_flg, `modified`=:modified
		    		WHERE `id` = :id'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':send_date', $data['send_date'] ); $this->stmt->bindValue( ':send_flg', $data['send_flg'] ); $this->stmt->bindValue( ':modified', $now ); $this->stmt->bindValue( ':id', $id ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_flg_step_log( $term ) { try { $sql = 'UPDATE `step_mail_logs`
					SET `deleted`=NOW()
					WHERE TO_DAYS(NOW()) - TO_DAYS(`created`) >= :term
					AND `deleted` IS NULL'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':term', $term ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_flg_extra_log( $term ) { try { $sql = 'UPDATE `extra_mail_logs`
					SET `deleted`=NOW()
					WHERE TO_DAYS(NOW()) - TO_DAYS(`created`) >= :term
					AND `deleted` IS NULL'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':term', $term ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_step_log( $term ) { try { $sql = 'DELETE FROM step_mail_logs
					WHERE TO_DAYS(NOW()) - TO_DAYS(`created`) >= :term'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':term', $term ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_extra_log( $term ) { try { $sql = 'DELETE FROM extra_mail_logs
					WHERE TO_DAYS(NOW()) - TO_DAYS(`created`) >= :term'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':term', $term ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_step_mail_log( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_step_mail_log( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_step_mail_log( $start, $num ) { try { $sql = "SELECT  TA.id, TA.group_id, TA.story_no, TA.title, TA.send_date, TA.send_flg
					FROM step_mail_logs AS TA LEFT JOIN users AS TC ON TA.user_id = TC.id
					WHERE TA.deleted IS NULL
					GROUP BY TA.`group_id`
					ORDER BY `send_date` DESC 
					LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_step_mail_log( $id, &$data ) { $result = false; $this->db_step_mail_log( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_step_mail_log( $id ) { try { $sql = "SELECT TA.*, TB.`email`
					FROM `step_mail_logs` AS TA LEFT JOIN `users` AS TB ON TA.`user_id` = TB.`id`
					WHERE TA.`id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_add_extra_mail_log( $data, $user_id ) { $now = $this->get_now_date(); try { $sql = "INSERT INTO `extra_mail_logs` (
		    `group_id`, `extra_mail_id`, `title`, `contents`, `send_date`, `user_id`,
		    `send_flg`, `created`) VALUES ( :group_id, :extra_mail_id, :title, :contents, 
		    :send_date, :user_id,
		    :send_flg, :created)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $data['group_id'] ); $this->stmt->bindValue( ':extra_mail_id', $data['id'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':send_date', $data['send_date'] ); $this->stmt->bindValue( ':user_id', $user_id ); $this->stmt->bindValue( ':send_flg', $data['send_flg'] ); $this->stmt->bindValue( ':created', $now ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_update_extra_mail_log( $data, $id ) { $now = $this->get_now_date(); try { $sql = 'UPDATE `extra_mail_logs`
					SET `send_date`=:send_date,`send_flg`=:send_flg, `modified`=:modified
		    		WHERE `id` = :id'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':send_date', $data['send_date'] ); $this->stmt->bindValue( ':send_flg', $data['send_flg'] ); $this->stmt->bindValue( ':modified', $now ); $this->stmt->bindValue( ':id', $id ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_extra_mail_log( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_extra_mail_log( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_extra_mail_log( $start, $num ) { try { $sql = "SELECT TA.id, TA.group_id, TA.send_date, TA.send_flg, TA.title
					FROM extra_mail_logs AS TA LEFT JOIN users AS TC ON TA.user_id = TC.id
					GROUP BY TA.`group_id`
					LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_log( $id, &$data ) { $result = false; $this->db_extra_mail_log( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_extra_mail_log( $id ) { try { $sql = "SELECT TA.*, TB.`email`
					FROM `extra_mail_logs` AS TA LEFT JOIN `users` AS TB ON TA.`user_id` = TB.`id`
					WHERE TA.`id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_step_mail_error_count( $user_id, $data ) { $result = false; $this->db_step_mail_error_count( $user_id, $data); $row = $this->stmt->fetchAll(); $count = $row[0][0]; return $count; } private function db_step_mail_error_count( $user_id, $data ) { try { $sql = "SELECT COUNT(*) 
			FROM step_mail_logs 
			WHERE 
			user_id = :user_id
			AND step_mail_id = :step_mail_id 
			AND story_no = :story_no 
			AND send_flg = 0 "; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':user_id', $user_id, PDO::PARAM_INT ); $this->stmt->bindValue( ':step_mail_id', $data['id'], PDO::PARAM_INT ); $this->stmt->bindValue( ':story_no', $data['story_no'], PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_error_count( $user_id, $data ) { $result = false; $this->db_extra_mail_error_count( $user_id, $data); $row = $this->stmt->fetchAll(); $count = $row[0][0]; return $count; } private function db_extra_mail_error_count( $user_id, $data ) { try { $sql = "SELECT COUNT(*) 
			FROM extra_mail_logs 
			WHERE 
			user_id = :user_id
			AND extra_mail_id = :extra_mail_id  
			AND send_flg = 0 "; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':user_id', $user_id, PDO::PARAM_INT ); $this->stmt->bindValue( ':extra_mail_id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function check_extra_mail_log( $id, $flag ) { $result = false; $this->db_check_extra_mail_log( $id, $flag ); $row = $this->stmt->fetchAll(); $count = $row[0][0]; if($count >= 1) { $result = true; } return $result; } private function db_check_extra_mail_log( $id, $flag ) { try { $sql = "SELECT COUNT(*)
			FROM extra_mail_logs 
			WHERE 
			extra_mail_id = :extra_mail_id
			AND send_flg = :send_flg"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':extra_mail_id', $id, PDO::PARAM_INT ); $this->stmt->bindValue( ':send_flg', $flag, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function check_send_flg( $group_id, &$count ) { $num = 0; $this->db_check_send_flg( $group_id, $num ); $row = $this->stmt->fetchAll(); $count['err'] = $row[0][0]; $num = 1; $this->db_check_send_flg( $group_id, $num ); $row = $this->stmt->fetchAll(); $count['done'] = $row[0][0]; $num = 99; $this->db_check_send_flg( $group_id, $num ); $row = $this->stmt->fetchAll(); $count['on'] = $row[0][0]; } private function db_check_send_flg( $group_id, $num ) { try { $sql = "SELECT COUNT(*)
			FROM step_mail_logs 
			WHERE 
			group_id = :group_id
			AND send_flg = :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } } ?>