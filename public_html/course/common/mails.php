<?php
require_once( dirname(__FILE__).'/main.php' ); require_once( dirname(__FILE__).'/logs.php' ); require_once( dirname(__FILE__).'/bodys.php' ); class mails extends main { private $err; function db_add_stepmail( $data ) { $data['scenario_id'] = SCENARIOS_ID; $now = $this->get_now_date(); try { $sql = "
		    INSERT INTO `step_mails`(
		    `scenario_id`,
		    `title`,
		    `header_id`,
		    `contents`,
		    `footer_id`,
		    `send_date`,
		    `send_time`,
		    `send_flg`,
		    `created`)
		    VALUES ( :scenario_id, :title, :header_id, :contents,
		    :footer_id, :send_date, :send_time, :send_flg, :created )"; $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $this->pdo->beginTransaction(); $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':scenario_id', $data['scenario_id'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':header_id', $data['header_id'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':footer_id', $data['footer_id'] ); $this->stmt->bindValue( ':send_date', $data['send_date'] ); $this->stmt->bindValue( ':send_time', $this->get_send_time_combined($data['send_time_hour'], $data['send_time_minute']) ); $this->stmt->bindValue( ':send_flg', $data['send_flg'] ); $this->stmt->bindValue( ':created', $now ); $this->stmt->execute(); $this->pdo->commit(); } catch( PDOException $e ){ $this->pdo->rollBack(); die( $e->getMessage() ); } $this->update_story_no( $data['scenario_id'] ); } function db_edit_stepmail( $data ) { $now = $this->get_now_date(); try { $sql = "UPDATE `step_mails`
					SET 
					`title` = :title,
					`header_id` = :header_id, 
					`contents` = :contents,
					`footer_id` = :footer_id,
					`send_date` = :send_date,
					`send_time` = :send_time,
					`send_flg` = :send_flg,
					`modified` = :modified
					WHERE `step_mails`.`id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':header_id', $data['header_id'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':footer_id', $data['footer_id'] ); $this->stmt->bindValue( ':send_date', $data['send_date'] ); $this->stmt->bindValue( ':send_time', $this->get_send_time_combined($data['send_time_hour'], $data['send_time_minute'])); $this->stmt->bindValue( ':send_flg', $data['send_flg'] ); $this->stmt->bindValue( ':modified', $now ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } $this->update_story_no( $data['scenario_id'] ); } function db_delete_stepmail( $data ) { $now = $this->get_now_date(); try { $sql = "DELETE FROM `step_mails`
					WHERE `step_mails`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } $this->update_story_no( $data['scenario_id'] ); } function get_all_stepmail( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_stepmail( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_stepmail( $start, $num ) { try { $sql = "SELECT * 
			FROM 
			`step_mails` 
			ORDER BY `story_no` ASC 
			LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_stepmail_count( &$cnt ) { $result = FALSE; $this->db_get_stepmail_count(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $result = TRUE; } return $result; } private function db_get_stepmail_count() { try { $sql = "SELECT * 
			FROM 
			`step_mails`
			WHERE `send_flg` = 1"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_stepmail( $id, &$data ) { $result = false; $this->db_stepmail( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_stepmail( $id ) { try { $sql = "SELECT * FROM `step_mails` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function update_story_no( $scenario_id ) { $this->db_select_update_story_no( $scenario_id ); $result = $this->stmt->fetchAll(); if (!empty($result)){ $story_no = 1; foreach ($result as $data) { $this->db_update_story_no( $data['id'] , $story_no ); $story_no++; } } return true; } private function db_select_update_story_no( $scenario_id ) { try { $sql = "
			SELECT
			 `id` 
			FROM
			 `step_mails` 
			WHERE
			 `scenario_id` = :scenario_id 
			ORDER BY `send_date` ASC, `send_time` ASC"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':scenario_id', $scenario_id ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } private function db_update_story_no( $stepmail_id, $story_no ) { try { $sql = "UPDATE `step_mails` 
			SET 
			`story_no` = :story_no,
			`modified` = :modified
			WHERE `step_mails`.`id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':story_no', $story_no ); $this->stmt->bindValue( ':modified', $this->get_now_date() ); $this->stmt->bindValue( ':id', $stepmail_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_last_story_no( $scenario_id ) { $this->db_select_last_story_no( $scenario_id ); $result = $this->stmt->fetchAll(); if (!empty($result)){ return $result[0]; } return false; } private function db_select_last_story_no( $scenario_id ) { try { $sql = "
			SELECT
			 `send_date` 
			FROM
			 `step_mails` 
			WHERE
			 `scenario_id` = :scenario_id 
			ORDER BY `send_date` DESC, `send_time` DESC
			LIMIT 0 , 1"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':scenario_id', $scenario_id ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function send_split_step_mail( $setting ) { $logsObj = new logs(); mb_language("Ja") ; mb_internal_encoding("UTF8") ; $this->get_admin_user($admin_user); $sender_name = $admin_user['firstname']; $sender_email = $admin_user['email']; $from = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email."> \n"; if ( !empty($setting['reply_email']) ) { $from .= "Reply-To: " .mb_encode_mimeheader( $sender_name ) ."<".$setting['reply_email']."> \n"; } $cnt_send_list = $this->get_step_mail_list_count(); $cnt = 0; $start = microtime(true); for( $i=0; $i<$cnt_send_list; $i+=$setting['send_num'] ) { $this->get_step_mail_list_split( 0, $setting['send_num'], $users ); foreach( $users as $user ) { $time = microtime(true) - $start; if( $time > 480 ){ break; } $rep_subject = $this->txtReplace( $user['title'], $user); $rep_message = $this->txtReplace( $user['contents'], $user); $rep_subject = htmlspecialchars_decode( $rep_subject, ENT_QUOTES ); $rep_message = htmlspecialchars_decode( $rep_message, ENT_QUOTES ); $ret = mb_send_mail($user['email'], $rep_subject, $rep_message, $from); $data['send_date'] = $this->get_now_date(); $data['send_flg'] = ($ret) ? 1 : 0; $logsObj->db_update_step_mail_log($data, $user['id']); $cnt++; if( $cnt >= $cnt_send_list ){ break; } } sleep($setting['send_interval']); } } function db_add_extra_mail( $data ) { $data['scenario_id'] = 1; $send_time = $data['send_time_year']."/".$data['send_time_month']."/".$data['send_time_day']." ".$this->get_send_time_combined($data['send_time_hour'], $data['send_time_minute']); $now = $this->get_now_date(); try { $sql = "
		    INSERT INTO `extra_mails`(
		    `scenario_id`,
		    `title`,
		    `header_id`,
		    `contents`,
		    `footer_id`,
		    `send_time`,
		    `created`)
		    VALUES ( :scenario_id, :title, :header_id, :contents,
		    :footer_id, :send_time, :created )"; $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $this->pdo->beginTransaction(); $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':scenario_id', $data['scenario_id'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':header_id', $data['header_id'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':footer_id', $data['footer_id'] ); $this->stmt->bindValue( ':send_time', $send_time ); $this->stmt->bindValue( ':created', $now ); $this->stmt->execute(); $this->pdo->commit(); } catch( PDOException $e ){ $this->pdo->rollBack(); die( $e->getMessage() ); } } function db_edit_extra_mail( $data ) { $send_time = $data['send_time_year']."/".$data['send_time_month']."/".$data['send_time_day'] ." ".$this->get_send_time_combined($data['send_time_hour'], $data['send_time_minute']); $now = $this->get_now_date(); try { $sql = "UPDATE `extra_mails`
					SET 
					`title` = :title, `header_id` = :header_id, 
					`contents` = :contents,
					`footer_id` = :footer_id,
					`send_time` = :send_time,
					`modified` = :modified
					WHERE `extra_mails`.`id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':header_id', $data['header_id'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':footer_id', $data['footer_id'] ); $this->stmt->bindValue( ':send_time', $send_time); $this->stmt->bindValue( ':modified', $now ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_extra_mail( $data ) { $now = $this->get_now_date(); try { $sql = "DELETE FROM `extra_mails`
					WHERE `extra_mails`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_extra_mail( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_extra_mail( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_extra_mail( $start, $num ) { try { $sql = "SELECT 
			`id`, `title`,
			DATE_FORMAT(`send_time`, '%Y-%m-%d') AS `send_date`,
			DATE_FORMAT(`send_time`, '%k:%i') AS `send_time`	
			FROM 
			`extra_mails` 
			ORDER BY `id` ASC 
			LIMIT :start, :num "; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail( $id, &$data ) { $result = false; $this->db_extra_mail( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_extra_mail( $id ) { try { $sql = "SELECT * FROM `extra_mails` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_last_extra_mail_id() { $this->db_last_extra_mail_id(); $row = $this->stmt->fetchAll(); return $row[0][0]; } private function db_last_extra_mail_id() { try { $sql = "SELECT LAST_INSERT_ID();"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_headers_list() { try { $stmt = $this->pdo->prepare( 'SELECT 
				 id,
				 header
				FROM 
				 `headers` 
				ORDER BY 
				 `created` ASC' ); $stmt->execute(); $row = $stmt->fetchAll(); return $row; } catch(PDOException $e){ die($e->getMessage()); } return true; } function get_footers_list() { try { $stmt = $this->pdo->prepare( 'SELECT 
				 id,
				 footer
				FROM 
				 `footers` 
				ORDER BY 
				 `created` ASC' ); $stmt->execute(); $row = $stmt->fetchAll(); return $row; } catch(PDOException $e){ die($e->getMessage()); } return true; } function check_input_mails( $form ) { $this->check_title($form["title"]); $this->check_contents($form["contents"]); return true; } private function check_title( $title ) { if(mb_strlen($title,"UTF-8") < 2 ) { $this->err['title'] = 'タイトルを入力してください。'; } if(mb_strlen($title,"UTF-8") >= 200 ) { $this->err['title'] = 'タイトルは200文字以内で入力してください。'; } } private function check_contents( $contents ) { if(mb_strlen($contents,"UTF-8") < 2 ) { $this->err['contents'] = '記事を入力してください。'; } } function get_err() { return $this->err; } function get_stepmail_users_list( &$data ) { $result = false; $this->db_stepmail_users_list(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_stepmail_users_list() { try { $sql = "SELECT u.id, u.email, u.firstname, u.lastname,u.scenario_id, 
			MIN(st.id) AS step_mail_id
			FROM `users` u
			INNER JOIN scenarios sc
			ON u.scenario_id = sc.id 
			LEFT JOIN step_mails st
			ON sc.id = st.scenario_id
			LEFT JOIN step_mail_logs sl
			ON u.id = sl.user_id
			AND st.id = sl.step_mail_id
			WHERE DATEDIFF(NOW(),u.send_date) = st.send_date
			AND u.`delete_flg` = 0
			AND u.`auth` !=9
			AND CURTIME() >= st.send_time
			AND st.`send_flg` = 1
			AND ISNULL(sl.`send_flg`)
			GROUP BY u.`id`
			ORDER BY st.`id` ASC 
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_stepmail_users_list_count( &$data ) { $result = false; $this->db_stepmail_users_list_count(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_stepmail_users_list_count() { try { $sql = "SELECT COUNT(*)
			FROM `users` u
			INNER JOIN scenarios sc
			ON u.scenario_id = sc.id 
			LEFT JOIN step_mails st
			ON sc.id = st.scenario_id
			LEFT JOIN step_mail_logs sl
			ON u.id = sl.user_id
			AND st.id = sl.step_mail_id
			WHERE DATEDIFF(NOW(),u.send_date) = st.send_date
			AND st.send_time BETWEEN SUBTIME(CURTIME(), '00:05:00') AND ADDTIME(CURTIME(), '00:05:00')
			AND u.`delete_flg` = 0
			GROUP BY u.`id`
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_stepmail_resend_users_list( &$data ) { $result = false; $this->db_stepmail_resend_users_ist(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_stepmail_resend_users_ist() { try { $sql = "SELECT
			u.`id`,
			u.`email`,
			u.`firstname`,
			u.`lastname`,
			u.scenario_id,
			sl1.`step_mail_id`
			FROM `step_mail_logs` AS sl1
			RIGHT JOIN
			(SELECT 
			`step_mail_id`, 
			`user_id`, 
			MAX(`send_date`) AS `send_date`
			FROM `step_mail_logs`
			GROUP BY `step_mail_id`,`user_id`)
			AS sl2
			ON sl1.`step_mail_id` = sl2.`step_mail_id`
			AND sl1.`user_id` = sl2.`user_id`
			INNER JOIN `users` u
			ON sl1.`user_id` = u.`id`
			WHERE sl1.`send_date` = sl2.`send_date`
			AND sl1.`send_flg` = 0
			AND u.`delete_flg` = 0
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_step_mail_list_split( $start, $num, &$data ) { $result = false; $this->db_get_step_mail_list_split( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_get_step_mail_list_split( $start, $end ) { try { $sql = 'SELECT
			sl.id,
			sl.title,
			sl.contents,
			u.firstname,
			u.lastname,
			u.password,
			u.order_no,
			u.email
			FROM `step_mail_logs` AS sl
			INNER JOIN `users` u
			ON sl.`user_id` = u.`id`
			WHERE `send_flg` =99
			LIMIT '.$start.','.$end; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_step_mail_list_count() { $this->db_get_step_mail_list_count(); $row = $this->stmt->fetchAll(); $cnt = $row[0][0]; return $cnt; } private function db_get_step_mail_list_count() { try { $sql = 'SELECT
			COUNT(*)
			FROM `step_mail_logs` AS sl
			INNER JOIN `users` u
			ON sl.`user_id` = u.`id`
			WHERE `send_flg` =99'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_users_list( &$data ) { $result = false; $this->db_extra_mail_users_list(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_extra_mail_users_list() { try { $sql = "SELECT u.id, u.email, u.firstname, u.lastname,u.scenario_id, 
			ex.id AS extra_mail_id, u.`delete_flg`
			FROM `users` u
			INNER JOIN scenarios sc
			ON u.scenario_id = sc.id
			LEFT JOIN `extra_mails` ex
			ON sc.id = ex.scenario_id 
			LEFT JOIN extra_mail_logs el
			ON u.id = el.user_id
			AND ex.id = el.extra_mail_id
			WHERE ex.send_time
			BETWEEN SUBTIME(NOW(), '00:05:00') AND ADDTIME(NOW(), '00:05:00')
			AND u.`delete_flg`=0
			AND u.`auth` !=9
			AND ISNULL(el.`send_flg`)
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_users_list_count( &$data ) { $result = false; $this->db_stepmail_users_list_count(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_extra_mail_users_list_count() { try { $sql = "SELECT COUNT(*)
			FROM `users` u
			INNER JOIN scenarios sc
			ON u.scenario_id = sc.id 
			LEFT JOIN step_mails st
			ON sc.id = st.scenario_id
			LEFT JOIN step_mail_logs sl
			ON u.id = sl.user_id
			AND st.id = sl.step_mail_id
			WHERE DATEDIFF(NOW(),u.created) = st.send_date
			AND st.send_time BETWEEN SUBTIME(CURTIME(), '00:05:00') AND ADDTIME(CURTIME(), '00:05:00')
			AND u.`delete_flg` = 0
			GROUP BY u.`id`
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_resend_users_list( &$data ) { $result = false; $this->db_extra_mail_resend_users_ist(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_extra_mail_resend_users_ist() { try { $sql = "SELECT 
			u.`id`, 
			u.`email`,
			u.`firstname`,
			u.`lastname`,
			u.scenario_id,
			el1.`extra_mail_id`
			FROM `extra_mail_logs` AS el1
			RIGHT JOIN
			(SELECT 
			`extra_mail_id`, 
			`user_id`, 
			MAX(`send_date`) AS `send_date`
			FROM `extra_mail_logs`
			GROUP BY `extra_mail_id`,`user_id`)
			AS el2
			ON el1.`extra_mail_id` = el2.`extra_mail_id`
			AND el1.`user_id` = el2.`user_id`
			INNER JOIN `users` u
			ON el1.`user_id` = u.`id`
			WHERE el1.`send_date` = el2.`send_date`
			AND el1.`send_flg` = 0
			AND u.`delete_flg` = 0;
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_all_mail_users_list( &$data ) { $result = false; $this->db_get_all_mail_users_list(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_get_all_mail_users_list() { try { $sql = "SELECT *  FROM `users` WHERE `scenario_id` = 1 AND `delete_flg` = 0"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_list_split( $start, $num, &$data ) { $result = false; $this->db_get_extra_mail_list_split( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_get_extra_mail_list_split( $start, $end ) { try { $sql = 'SELECT
			el.id,
			el.title,
			el.contents,
			u.firstname,
			u.lastname,
			u.password,
			u.order_no,
			u.email
			FROM `extra_mail_logs` AS el
			INNER JOIN `users` u
			ON el.`user_id` = u.`id`
			WHERE `send_flg` =99
			LIMIT '.$start.','.$end; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_extra_mail_list_count() { $this->db_get_extra_mail_list_count(); $row = $this->stmt->fetchAll(); $cnt = $row[0][0]; return $cnt; } private function db_get_extra_mail_list_count() { try { $sql = 'SELECT COUNT(*)  FROM `extra_mail_logs` WHERE `send_flg` = 99'; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_send_date_split($send_date) { $split = explode("-",$send_date); $send_date_split['year'] = $split[0]; $send_date_split['month'] = $split[1]; $send_date_split['day'] = $split[2]; return $send_date_split; } function get_send_time_split($send_time) { $split = explode(":",$send_time); $send_time_split['hour'] = $split[0]; $send_time_split['minute'] = $split[1]; return $send_time_split; } function get_send_time_combined($hour, $minute) { $send_time = $hour.":".$minute.":00"; return $send_time; } function send_preview_mail($data, $user, $setting) { $headersObj = new headers(); $footersObj = new footers(); mb_language("Ja") ; mb_internal_encoding("UTF8") ; $to = $user['email']; $this->get_admin_user($admin_user); $sender_name = $admin_user['firstname']; $sender_email = $user['email']; $from = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email.">"; $headersObj->get_header($data['header_id'], $header); $footersObj->get_footer($data['footer_id'], $footer); $subject = $data['title']; $message = $header['header']; $message .= $data['contents']; $message .= $footer['footer']; $subject = $this->txtReplace( $subject, $user); $message = $this->txtReplace( $message, $user); $subject = htmlspecialchars_decode( $subject, ENT_QUOTES ); $message = htmlspecialchars_decode( $message, ENT_QUOTES ); $ret = mb_send_mail($to, $subject, $message, $from); } function send_extra_mail($data, $user, $setting) { $headersObj = new headers(); $footersObj = new footers(); $usersObj = new users(); $logsObj = new logs(); $group_id = date('YmdHis'); $this->get_admin_user($admin_user); $sender_name = $admin_user['firstname']; $sender_email = $user['email']; $from = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email.">"; $headersObj->get_header($data['header_id'], $header); $footersObj->get_footer($data['footer_id'], $footer); $subject = $data['title']; $message = $header['header']."\n\n"; $message .= $data['contents']."\n\n"; $message .= $footer['footer']; $this->get_all_mail_users_list( $users_list ); $data['send_flg'] = 99; $data['group_id'] = $group_id; foreach($users_list as $send_user) { $logsObj->db_add_extra_mail_log($data, $send_user['id']); } } function send_split_extra_mail( $setting ) { $logsObj = new logs(); mb_language("Ja") ; mb_internal_encoding("UTF8") ; $this->get_admin_user($admin_user); $sender_name = $admin_user['firstname']; $sender_email = $admin_user['email']; $from = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email."> \n"; if ( !empty($setting['reply_email']) ) { $from .= "Reply-To: " .mb_encode_mimeheader( $sender_name ) ."<".$setting['reply_email']."> \n"; } $cnt_send_list = $this->get_extra_mail_list_count(); for( $i=0; $i<$cnt_send_list; $i=$i+$setting['send_num'] ) { $this->get_extra_mail_list_split( 0, $setting['send_num'], $users ); foreach( $users as $user ) { $start = $this->measure(); $rep_subject = $this->txtReplace( $user['title'], $user); $rep_message = $this->txtReplace( $user['contents'], $user); $rep_subject = htmlspecialchars_decode( $rep_subject, ENT_QUOTES ); $rep_message = htmlspecialchars_decode( $rep_message, ENT_QUOTES ); $ret = mb_send_mail($user['email'], $rep_subject, $rep_message, $from); $data['send_date'] = $this->get_now_date(); $data['send_flg'] = ($ret) ? 1 : 0; $logsObj->db_update_extra_mail_log($data, $user['id']); } sleep($setting['send_interval']); } } function send_auto_mail($data, $user, $settings) { $bodysObj = new bodys(); mb_language("Ja") ; mb_internal_encoding("UTF8") ; $this->get_admin_user($admin_user); switch( $data['send_settings'] ) { case( 0 ): $to = $user['email']; $bcc = $admin_user['email']; break; case( 1 ): $to = $admin_user['email']; break; case( 2 ): $to = $user['email']; break; default: return; break; } $sender_name = $admin_user['firstname']; $sender_email = $admin_user['email']; $from = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email.">"; if( !empty( $bcc )){ $from .= "\nBcc:" ."<".$bcc.">"; } if( $data['status'] != 'STOP' ) { $type = 0; } else { $type = 1; } $bodysObj->get_all_body( $type, 0, 1, $body ); $subject = $body[0]['title']; $message = $body[0]['body']; $message = $this->txtReplace( $message, $user); $ret = mb_send_mail($to, $subject, $message, $from); } function get_admin_user( &$data ) { $result = false; try { $sql = "SELECT
			`id`,
			`firstname`,`lastname`,
			`email`
			FROM `users` 
			WHERE `auth` = 9"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row[0]; $result = true; } return $result; } } ?>