<?php
 require_once( dirname(__FILE__).'/main.php' ); class builders extends main { private $err; function get_last_id() { $this->db_last_id(); $row = $this->stmt->fetchAll(); return $row[0][0]; } private function db_last_id() { try { $sql = "SELECT LAST_INSERT_ID();"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_add_top( $data ) { try { $sql = "INSERT INTO `tp_tops` (
					`description` ,
					`keyword` ,
					`title` ,
					`contents` ,
					`add_br` ,
					`url` ,
					`public` ,
					`created` ,
					`modified`)
					VALUES (:description, :keyword, :title, :contents, :url, :public, NOW(), NULL)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':description', $data['description'] ); $this->stmt->bindValue( ':keyword', $data['keyword'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':add_br', $data['add_br'] ); $this->stmt->bindValue( ':url', $data['url'] ); $this->stmt->bindValue( ':public', $data['public'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_top( $data ) { try { $sql = "UPDATE `tp_tops`
					SET
					`description` = :description,
					`keyword` = :keyword,
					`title` = :title,
					`contents` = :contents,
					`add_br` = :add_br,
					`url` = :url,
					`public` = :public,
					`modified` = NOW()
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':description', $data['description'] ); $this->stmt->bindValue( ':keyword', $data['keyword'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':add_br', $data['add_br'] ); $this->stmt->bindValue( ':url', $data['url'] ); $this->stmt->bindValue( ':public', $data['public'] ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_top( &$data, $start=0, $num=1 ) { $result = FALSE; $this->db_all_top( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = TRUE; } return $result; } private function db_all_top( $start, $num ) { try { $sql = "SELECT * FROM `tp_tops` ORDER BY `created` ASC LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_top( $id, &$data ) { $result = false; $this->db_top( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_top( $id ) { try { $sql = "SELECT * FROM `tp_tops` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_add_content( $data ) { try { $sql = "INSERT INTO `tp_contents` (
					`description` ,
					`keyword` ,
					`title` ,
					`contents` ,
					`add_br` ,
					`url` ,
					`public_date` ,
					`public` ,
					`created` ,
					`modified`)
					VALUES (:description, :keyword, :title, :contents, :add_br, :url, :public_date, :public, NOW(), NULL)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':description', $data['description'] ); $this->stmt->bindValue( ':keyword', $data['keyword'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':add_br', $data['add_br'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':url', $data['url'] ); $this->stmt->bindValue( ':public_date', $data['public_date'] ); $this->stmt->bindValue( ':public', $data['public'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_content( $data ) { try { $sql = "UPDATE `tp_contents`
					SET
					`description` = :description,
					`keyword` = :keyword,
					`title` = :title,
					`contents` = :contents,
					`add_br` = :add_br,
					`url` = :url,
					`public_date` = :public_date,
					`public` = :public,
					`modified` = NOW()
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':description', $data['description'] ); $this->stmt->bindValue( ':keyword', $data['keyword'] ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':add_br', $data['add_br'] ); $this->stmt->bindValue( ':url', $data['url'] ); $this->stmt->bindValue( ':public_date', $data['public_date'] ); $this->stmt->bindValue( ':public', $data['public'] ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_content( $id ) { try { $sql = "DELETE FROM `tp_contents`
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_content( &$data, $start=0, $num=99 ) { $result = FALSE; $this->db_all_content( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_content( $start, $num ) { try { $sql = "SELECT * FROM `tp_contents` ORDER BY `public_date` ASC LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_content( $id, &$data ) { $result = false; $this->db_content( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_content( $id ) { try { $sql = "SELECT * FROM `tp_contents` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_all_sidebar( &$data, $start=0, $num=99 ) { $result = FALSE; $this->db_all_sidebar( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_sidebar( $start, $num ) { try { $sql = "SELECT
			ts.id,
			ts.contents_id,
			ts.side_title_id,
			ts.position,
			tc.title as contents_title,
			tc.contents as contents_contents,
			tc.public as contents_public,
			tc.public_date as contents_public_date,
			tst.title as side_titles_title,
			tst.public as side_titles_public
			FROM `tp_sidebars` ts
			LEFT JOIN tp_contents tc
			ON ts.contents_id = tc.id
			LEFT JOIN tp_side_titles tst
			ON ts.side_title_id = tst.id
			ORDER BY `ts`.`position` ASC
			LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_max_position_sidebar() { $this->db_max_position_sidebar(); $row = $this->stmt->fetchAll(); return $row[0]['max']; } private function db_max_position_sidebar() { try { $sql = "SELECT MAX(`position`) as max FROM `tp_sidebars`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function make_sidebar( $data ) { $i = 0; foreach( $data as $content ) { $sidebar['contents_id'] = $content['id']; $sidebar['side_title_id'] = NULL; $sidebar['position'] = $i; $i++; $this->db_add_sidebars( $sidebar ); } } function db_add_sidebars( $data ) { try { $sql = "INSERT INTO `tp_sidebars` (
					`contents_id` ,
					`side_title_id` ,
					`position` ,
					`created` ,
					`modified`)
					VALUES (:contents_id, :side_title_id, :position, NOW(), NULL)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':contents_id', $data['contents_id'] ); $this->stmt->bindValue( ':side_title_id', $data['side_title_id'] ); $this->stmt->bindValue( ':position', $data['position'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_sidebars( $data ) { try { $sql = "UPDATE `tp_sidebars`
					SET
					`contents_id` = :contents_id,
					`side_title_id` = :side_title_id,
					`position` = :position,
					`modified` = NOW()
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':contents_id', $data['contents_id'] ); $this->stmt->bindValue( ':side_title_id', $data['side_title_id'] ); $this->stmt->bindValue( ':position', $data['position'] ); $this->stmt->bindValue( ':id', $data['id'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_sidebars( $id ) { try { $sql = "DELETE FROM `tp_sidebars`
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_sidebars_contents_id( $id ) { try { $sql = "DELETE FROM `tp_sidebars`
					WHERE `contents_id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function check_reg_date( $date ) { $public = FALSE; $reg_date = htmlspecialchars($_SESSION['tes_REG_DATE']); $psd_day = time() - strtotime($reg_date); $psd_day /= (60 * 60 * 24); if( (int)$date <= (int)ceil( $psd_day )) { $public = TRUE; } return $public; } function get_all_side_freeareas( &$data, $start=0, $num=99 ) { $result = FALSE; $this->db_all_side_freeareas( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_side_freeareas( $start, $num ) { try { $sql = "
			SELECT *
			FROM `tp_side_freeareas` 
			LIMIT :start, :num
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_edit_side_freeareas( $data ) { try { $sql = "UPDATE `tp_side_freeareas`
					SET
					`contents` = :contents,
					`modified` = NOW()
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':id', $data['id'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_add_side_titles( $data ) { try { $sql = "INSERT INTO `tp_side_titles` (
					`title` ,
					`public` ,
					`created` ,
					`modified`)
					VALUES (:title, :public, NOW(), NULL)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':public', $data['public'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_side_titles( $id ) { try { $sql = "DELETE FROM `tp_side_titles`
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_img_uploaders( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_img_uploaders( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_img_uploaders( $start, $num ) { try { $sql = "
			SELECT *
			FROM `tp_img_uploaders` 
			ORDER BY `created` ASC 
			LIMIT :start, :num
			"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_add_img_uploaders( $data ) { try { $sql = "INSERT INTO `tp_img_uploaders` (
					`title` ,
					`org_file` ,
					`store_file` ,
					`store_folder` ,
					`thumbnail` ,
					`created` ,
					`modified`)
					VALUES (:title, :org_file, :store_file, :store_folder, :thumbnail, NOW(), NULL)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':org_file', $data['org_file'] ); $this->stmt->bindValue( ':store_file', $data['store_file'] ); $this->stmt->bindValue( ':store_folder', $data['store_folder'] ); $this->stmt->bindValue( ':thumbnail', $data['thumbnail'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_img_uploaders( $id ) { try { $sql = "DELETE FROM `tp_img_uploaders`
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_img_uploaders( $id, &$data ) { $result = false; $this->db_img_uploaders( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_img_uploaders( $id ) { try { $sql = "SELECT * FROM `tp_img_uploaders` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_all_setting( &$data ) { $result = FALSE; $this->db_all_setting(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = TRUE; } return $result; } private function db_all_setting() { try { $sql = "SELECT * FROM `tp_settings`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_add_setting( $data ) { try { $sql = "INSERT INTO `tp_settings` (
					`site_name` ,
					`head` ,
					`css` ,
					`top_template` ,
					`contents_template` ,
					`created` ,
					`modified`
					)
					VALUES( :site_name, :head, :css, :top_template, :contents_template, NOW(), NULL )"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':site_name', $site_name ); $this->stmt->bindValue( ':head', $head ); $this->stmt->bindValue( ':css', $css ); $this->stmt->bindValue( ':top_template', $top_template ); $this->stmt->bindValue( ':contents_template', $contents_template ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_setting( $data ) { try { $sql = "UPDATE `tp_settings`
					SET
					`site_name` = :site_name ,
					`head` = :head ,
					`css` = :css ,
					`top_template` = :top_template ,
					`contents_template` = :contents_template ,
					`modified` = NOW()
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':site_name', $data['site_name'] ); $this->stmt->bindValue( ':head', $data['head'] ); $this->stmt->bindValue( ':css', $data['css'] ); $this->stmt->bindValue( ':top_template', $data['top_template'] ); $this->stmt->bindValue( ':contents_template', $data['contents_template'] ); $this->stmt->bindValue( ':id', $data['id'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_set_setting() { try { $sql = "INSERT INTO `tp_settings` (
					`site_name` ,
					`head` ,
					`css` ,
					`top_template` ,
					`contents_template` ,
					`created` ,
					`modified`
					)
					VALUES ( '会員サイトサイト名', '&lt;meta name=&quot;author&quot; content=&quot;AUTHOR&quot;&gt;', 'add.css', 'index.php', 'main.php', NOW(), NULL )"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_all_delete_setting() { try { $sql = "TRUNCATE TABLE `tp_settings`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_inquirys( &$data, $start=0, $num=1 ) { $result = FALSE; $this->db_all_inquirys( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = TRUE; } return $result; } private function db_all_inquirys( $start, $num ) { try { $sql = "SELECT * FROM `tp_inquirys` LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_inquirys( $id, &$data ) { $result = false; $this->db_inquirys( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_inquirys( $id ) { try { $sql = "SELECT * FROM `tp_inquirys` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_edit_inquirys( $data ) { try { $sql = "UPDATE `tp_inquirys`
					SET
					`title` = :title ,
					`contents` = :contents ,
					`modified` = NOW()
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':title', $data['title'] ); $this->stmt->bindValue( ':contents', $data['contents'] ); $this->stmt->bindValue( ':id', $data['id'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function upload( &$data, $upload_key='upfile', $save_directory='images', $max_filesize=2000000 ) { $msg = FALSE; if (isset($_FILES[$upload_key])) { try { $error = $_FILES[$upload_key]['error']; if (is_array($error)) { throw new RuntimeException('複数ファイルの同時アップロードは許可されていません。'); } switch ($error) { case UPLOAD_ERR_INI_SIZE: throw new RuntimeException('php.iniで許可されている最大サイズを超過しました。'); case UPLOAD_ERR_FORM_SIZE: throw new RuntimeException('フォームで許可されている最大サイズを超過しました。'); case UPLOAD_ERR_PARTIAL: throw new RuntimeException('ファイルが壊れています。'); case UPLOAD_ERR_NO_FILE: throw new RuntimeException('ファイルが選択されていません。'); case UPLOAD_ERR_NO_TMP_DIR: throw new RuntimeException('テンポラリディレクトリが見つかりません。'); case UPLOAD_ERR_CANT_WRITE: throw new RuntimeException('テンポラリデータの生成に失敗しました。'); case UPLOAD_ERR_EXTENSION: throw new RuntimeException('エクステンションでエラーが発生しました。'); } $data['org_file'] = $_FILES[$upload_key]['name']; $ext = pathinfo( $data['org_file'], PATHINFO_EXTENSION ); $tmp_name = $_FILES[$upload_key]['tmp_name']; $data['size'] = $_FILES[$upload_key]['size']; $mictime = microtime(); $data['store_file'] = substr( $mictime, 11 ) . substr( $mictime, 2, 6 ) . '.' . $ext; if( $data['org_file'] === '' ) { throw new Exception('ファイル名が無効です。'); } if( $data['size'] > $max_filesize ) { throw new RuntimeException("{$max_filesize}バイトを超過するファイルは受理できません。"); } if( !is_uploaded_file( $tmp_name )) { throw new RuntimeException('不正なファイルです。'); } $finfo = new finfo(FILEINFO_MIME_TYPE); $type = $finfo->file($tmp_name); if( $finfo === false ) { throw new RuntimeException('MimeType取得に失敗しました。'); } if( strpos($type, 'image/') !== 0 ) { throw new RuntimeException('画像ファイルではありません。'); } $path = realpath($save_directory); if( $path === false || !is_dir( $path )) { throw new LogicException('ディレクトリが存在しません。'); } if( !is_writable( $path )) { throw new LogicException('ディレクトリに書き込み権限がありません。'); } $new_name = "{$path}/{$data['store_file']}"; if( is_file( $new_name )) { throw new RuntimeException("ファイル名が重複しています。"); } if( !move_uploaded_file( $tmp_name, $new_name )) { throw new RuntimeException('アップロードされたファイルの保存に失敗しました。'); } $msg = TRUE; } catch( Exception $e ) { $msg = $e->getMessage(); } } else { $msg = '送信されたファイルはありません。'; } return $msg; } function make_thumbnail( $data, $image_area_length=100 ) { $size = GetImageSize( $data['store_folder'].'/'.$data['store_file'] ); if( $size[0] > $size[1] ) { $height = $image_area_length; $width = $height * ($size[0] / $size[1]); } else { $width = $image_area_length; $height = $width * ($size[1] / $size[0]); } $thumb = new Image( $data['store_folder'].'/'.$data['store_file'] ); $thumb->name( $data['thumbnail'] ); $thumb->width( $width ); $thumb->height( $height ); $thumb->save(); $thumb = new Image( $data['store_folder'].'/'.$data['thumbnail'] ); $thumb->name( 'c-'.$data['thumbnail'] ); $thumb->width( $image_area_length ); $thumb->height( $image_area_length ); if( $width < $height ) { $thumb->crop( 0, ($height-$width)/2 ); } else { $thumb->crop( ($width-$height)/2, 0 ); } $thumb->save(); } function del_img_file( $data ) { @unlink( $data['store_folder'].'/'.$data['store_file'] ); @unlink( $data['store_folder'].'/'.$data['thumbnail'] ); @unlink( $data['store_folder'].'/c-'.$data['thumbnail'] ); } function br_replace( $str ) { $content = htmlspecialchars_decode( $str ); $content = nl2br( $content ); $content = $this->strip_br( $content ); return $content; } private function strip_br($str){ $search = array( '</h1><br />', '</h2><br />', '</h3><br />', '<ul><br />', '</ul><br />', '</li><br />', '</p><br />', '</blockquote><br />', '</div><br />', ); $replace = array('</h1>','</h2>','</h3>','<ul>','</ul>','</li>','</p>','</blockquote>','</div>'); $str = str_replace($search,$replace,$str); return $str; } private function tagOk($str){ $search = array( '&lt;br /&gt;', '&lt;ul&gt;', '&lt;/ul&gt;', '&lt;li&gt;', '&lt;/li&gt;', '&lt;b&gt;', '&lt;/b&gt;', '&lt;strong&gt;', '&lt;/strong&gt;', ); $replace = array('<br />','<ul>','</ul>','<li>','</li>','<b>','</b>','<strong>','</strong>'); $str = str_replace($search,$replace,$str); $str = preg_replace_callback( '|&lt;div.+?&gt;|', array($this, 'enc2tag'), $str ); $str = preg_replace_callback( '|&lt;\/div?&gt;|', array($this, 'enc2tag'), $str ); $str = preg_replace_callback( '|&lt;p.*&gt;|', array($this, 'enc2tag'), $str ); $str = preg_replace_callback( '|&lt;a.*&gt;|', array($this, 'enc2tag'), $str ); $str = preg_replace_callback( '|&lt;h2.*&gt;|', array($this, 'enc2tag'), $str ); return $str; } private function enc2tag( $tag ) { $str = str_replace( '&lt;', '<', $tag[0] ); $str = str_replace( '&gt;', '>', $str ); return $str; } function check_input_tops( $form ) { $this->check_contents($form["contents"]); } function check_input_contents( $form ) { $this->check_title($form["title"]); $this->check_contents($form["contents"]); } function check_input_side_titles( $form ) { $this->check_title($form["title"]); } function check_input_side_freeareas( $form ) { $this->check_contents($form["contents"]); } function check_input_site_name( $form ) { $this->check_title($form["site_name"]); $this->check_template($form["top_template"]); $this->check_template($form["contents_template"]); } private function check_title( $title ) { if(mb_strlen($title,"UTF-8") < 2 ) { $this->err['title'] = 'タイトルを入力してください。'; } if(mb_strlen($title,"UTF-8") >= 200 ) { $this->err['title'] = 'タイトルは200文字以内で入力してください。'; } } private function check_contents( $contents ) { if(mb_strlen($contents,"UTF-8") < 2 ) { $this->err['contents'] = '記事を入力してください。'; } } private function check_template( $template ) { if(mb_strlen($template,"UTF-8") < 2 ) { $this->err['template'] = 'テンプレートを入力してください。'; } } function get_err() { return $this->err; } } ?>