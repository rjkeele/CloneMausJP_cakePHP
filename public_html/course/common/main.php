<?php
 require_once( dirname(__FILE__).'/config.ini' ); class main { protected $pdo; protected $stmt; protected $reqData; protected $version; function __construct() { try { $this->pdo = new PDO('mysql:host=' . DB_HOST . '; dbname='.DB_NAME, DB_USER, DB_PASSWORD); $this->pdo->query('SET NAMES utf8'); } catch(PDOException $e) { die($e->getMessage()); } date_default_timezone_set('Asia/Tokyo'); ini_set("session.bug_compat_42", 0); ini_set( 'display_errors', 1 ); } function __destruct() { $this->pdo = null; } function get_data( $data, &$aryData ) { $aryData = array(); foreach($data as $key=>$value) { $$key = isset($value) ? htmlspecialchars($value, ENT_QUOTES) : NULL ; $this->reqData[$key] = $$key; $aryData = $this->reqData; } } function str_length( $str, $max ) { $cnt = mb_strlen( $str ); if( isset($max) && $cnt > $max ) { $ten = '...'; } else { $ten = ''; } return $ten; } function show_esc( $var ) { if($var != '') { if(!is_array($var)) { $var = htmlspecialchars($var); } else { foreach($var as $key=>$value) { $var[$key] = show_esc($value); } } } return $var; } function html_decode( $var ) { if($var != '') { if(!is_array($var)) { $var = htmlspecialchars_decode($var); } else { foreach($var as $key=>$value) { $var[$key] = $this->html_decode($value); } } } return $var; } function get_now_date() { $now = date("Y-m-d H:i:s"); return $now; } function make_password( $chars=8 ) { return substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnm'), 0, $chars); } function date_format($date, $format='Y/m/d') { $d = explode('-', $date); $pos = strpos($d[2], ' '); $d[2] = $pos !== false ? substr($d[2], 0, $pos) : $d[2]; $format = preg_quote($format); $pattern = array('/Y/', '/m/', '/d/'); $formatting = preg_replace($pattern, $d, $format); return $formatting; } function wbsRequest( $method, $url, $params = array() ) { $data = http_build_query($params); $header = Array("Content-Type: application/x-www-form-urlencoded"); $options = array('http' => Array( 'method' => $method, 'header' => implode("\r\n", $header), )); $respons = get_headers($url); if(preg_match("/(404|403|500)/",$respons['0'])){ return false; } if($method == 'GET') { $url = ($data != '')?$url.'?'.$data:$url; }elseif($method == 'POST') { $options['http']['content'] = $data; } $content = file_get_contents($url, false, stream_context_create($options)); return $content; } function AboutDelay($start_time,$delay) { while(time()-$start_time < $delay) { sleep(1); } } function txtReplace( $from_str, $to_str ) { $str = $from_str; if(!empty( $to_str['firstname'] )) { $str = str_replace('%firstname%', $to_str['firstname'] , $str); } else{ $str = str_replace('%firstname%', '' , $str); } if(!empty( $to_str['lastname'] )) { $str = str_replace('%lastname%', $to_str['lastname'] , $str); } else{ $str = str_replace('%lastname%', '' , $str); } if(!empty( $to_str['password'] )) $str = str_replace('%password%', $to_str['password'] , $str); if(!empty( $to_str['order_no'] )) { $str = str_replace('%order_no%', $to_str['order_no'] , $str); } else{ $str = str_replace('%order_no%', '' , $str); } if(!empty( $to_str['email'] )) { $str = str_replace('%email%', $to_str['email'] , $str); $url = URLSTOP . '?email='; $url .= urlencode( $to_str['email'] ); $str = str_replace('%stopurl%', $url , $str); } else { $str = str_replace('%stopurl%', URLSTOP , $str); } $str = str_replace('%url%', URL, $str); return $str; } function set_session( $data ) { $_SESSION = $data; } function get_session( $session ) { $data = $session; return $data; } function session_dell() { $_SESSION = array(); session_destroy(); } function db_sql( $sql ) { try { $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e) { die($e->getMessage()); } } function db_cnt_data( $stmt ) { $result = false; $cnt = $stmt->rowCount(); if($cnt != 0) { $result = true; } return $result; } function get_version() { $ver = '0.27'; return $ver; } function check_input() { $err = FALSE; $fields = func_get_args(); foreach ($fields as $field) { if ($this->reqData[$field] == '') { $err[$field] = TRUE; } } return $err; } function measure() { list($m, $s) = explode(' ', microtime()); return ((float)$m + (float)$s); } } ?>