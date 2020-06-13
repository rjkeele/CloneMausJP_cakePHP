<?php
class Message extends AppModel {

    /*
     * 入力値検証
     */
    public $validate = array(
        'subject' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => '必須項目です。'
            ),
            'maxLength' => array(
                'allowEmpty' => true,
                'rule' => array( 'maxLength', 60),
                'message' => 'このフィールドは60文字以内です'
            ),
        ),
        'body' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => '必須項目です。'
            ),
            'maxLength' => array(
                'allowEmpty' => true,
                'rule' => array( 'maxLength', 2010),
                'message' => 'このフィールドは2000文字以内です'
            ),
        ),
        'to_member_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => '必須項目です。'
            )
        ),
        'from_member_id' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => '必須項目です。'
            )
        ),
    );

    /*
     * 詳細情報
     */
    function getOneEntityById($id){

        return $this->findById($id);

    }

    /*
     * リスト
     */
    function saveData($data){

        return $this->save($data);

    }

    /*
     * メッセージ送信
     */
    function isSend($data){

        $flg = false;

        $dataSource = $this->getDataSource();
        $dataSource->begin();
        // 幾つかのタスクを実行する

        // 送信処理
        if($data['Message']['status'] == 1){

            // 送信
            $data['Message']['member_id'] = $data['Message']['to_member_id'];
            $data['Message']['send_date'] = date('Y-m-d H:i:s');
            $this->save($data);
            
            if (!$this->save($data)) {
                $dataSource->rollback();
            }

            // 控えメッセージ
            $data['Message']['id'] = null;
            $data['Message']['member_id'] = $data['Message']['from_member_id'];
            $data['Message']['read_flg'] = 1;
        }

        // 下書き処理
        if($data['Message']['status'] == 0){
            $data['Message']['member_id'] = $data['Message']['from_member_id'];
        }

        if ($this->save($data)) {
            $dataSource->commit();
            $flg = true;
        } else {
            $dataSource->rollback();
            // メインタスクの処理を変更する
        }

        return $flg;

    }

    function delData($param,$session_id){

        $arrData = explode('__',$param);
        $code = @$arrData[0];
        $room_number = @$arrData[1];

        $resData = $this->find('first',array('conditions' => array(
                'session_id' => $session_id,
                'code' => $code,
                'room-number' => $room_number)));

        if(!empty($resData)){
            $id = $resData['Favorite']['id'];
            $data['session_id'] = $session_id;
            $data['code'] = $code;
            $data['room-number'] = $room_number;
            return $this->delete($id);
        }else{
            return false;
        }

    }
	
/*
 * 気になる通知 重複確認
 * */
    public function isDepliConcern($to_id,$from_id) {

        $count = $this->find('count',array('conditions' => array('Message.member_id' => $from_id,
                                                                    'Message.to_member_id' => $to_id,
                                                                    'Message.subject' => '気になる通知が届きました',
                                                                    'Message.del_flg' => 0)));

        if($count > 0){
            return false;
        }else{
            return true;
        }
    }

/**
 * 送信済み合計
 * */
    public function getReceivedCount($member_id) {

        $arrData = $this->find('count',array('conditions'=>array('del_flg' => 0 ,'member_id' => $member_id ,'to_member_id' => $member_id)));

        return $arrData;
    }

/**
 * 未開封合計
 * */
    public function getUnreadCount($member_id = null) { 
		if ($member_id == null) {
			return 0;
		}
        $arrData = $this->find('count',array('conditions'=>array('del_flg' => 0 ,'read_flg' => 0 ,'member_id' => $member_id ,'to_member_id' => $member_id)));

        return $arrData;
    }
    
    public function getUnreadCountById($id) {
    	
    	$arrData = $this->getDetail($id);
		$f_m_id = $arrData['Message']['from_member_id'];
		$t_m_id = $arrData['Message']['to_member_id'];
		$m_id = $arrData['Message']['member_id'];
		$p_id = $arrData['Message']['from_item_id'];
		
		$ret1 = $this->find('count',array('conditions'=>array('del_flg' => 0 ,'read_flg' => 0 ,'member_id' => $m_id ,'from_item_id' => $p_id, 'from_member_id' => $f_m_id, 'to_member_id' => $t_m_id)));
		$ret2 = $this->find('count',array('conditions'=>array('del_flg' => 0 ,'read_flg' => 0 ,'member_id' => $m_id ,'from_item_id' => $p_id, 'from_member_id' => $t_m_id, 'to_member_id' => $f_m_id)));
		return $ret1 + $ret2;
    }

/**
 * 開封済み処理
 * */
    public function opened($id) {

        $sql =  "UPDATE messages SET read_flg = 1 WHERE read_flg = 0 AND id = $id ";
        $this->query($sql);

    }

    public function getDetail($id) {

        $this->bindModel(
            array(
                'belongsTo' => array(
                    'FromMember' => array(
                        'className' => 'Member',
                        'foreignKey' => 'from_member_id'
                    ),
                    'ToMember' => array(
                        'className' => 'Member',
                        'foreignKey' => 'to_member_id'
                    ),
            		'Item' => array(
                        'className' => 'Item',
                        'foreignKey' => 'from_item_id'
                    )
                )
            )
        );

        $arrDatas = $this->find('first',array('conditions' => array('Message.id' => $id,'Message.del_flg' => 0)));
        return $arrDatas;
    }
    
    function message_sort($a, $b) {
		return $a['Message']['created'] > $b['Message']['created'] ? 1: -1;
	}
	
    public function getList($f_id, $t_id, $p_id, $u_id) {
		$o_id = $f_id;
		if ($f_id == $u_id) {
			$o_id = $t_id;
		}
        $this->bindModel(
            array(
                'belongsTo' => array(
                    'FromMember' => array(
                        'className' => 'Member',
                        'foreignKey' => 'from_member_id'
                    ),
                    'ToMember' => array(
                        'className' => 'Member',
                        'foreignKey' => 'to_member_id'
                    )
                )
            )
        );

        $arrDatas = $this->find('all',array('conditions' => array('Message.from_member_id' => $f_id,'Message.to_member_id' => $t_id,'Message.from_item_id' => $p_id,'Message.del_flg' => 0)));
        
        $ret = array();
        foreach($arrDatas as $arrData) {
        	if ($arrData['Message']['member_id'] == $u_id) {
        		$ret[] = $arrData;
        		$this->opened($arrData['Message']['id']);
        	}
        	
        }
        
        $this->bindModel(
            array(
                'belongsTo' => array(
                    'FromMember' => array(
                        'className' => 'Member',
                        'foreignKey' => 'from_member_id'
                    ),
                    'ToMember' => array(
                        'className' => 'Member',
                        'foreignKey' => 'to_member_id'
                    )
                )
            )
        );
        
        $arrDatas = $this->find('all',array('conditions' => array('Message.to_member_id' => $f_id,'Message.from_member_id' => $t_id,'Message.from_item_id' => $p_id,'Message.del_flg' => 0)));
        
        foreach($arrDatas as $arrData) {
        	if ($arrData['Message']['member_id'] == $o_id) {
        		$ret[] = $arrData;
        		$this->opened($arrData['Message']['id']);
        	}
        	
        }
        
        uasort($ret, array($this, 'message_sort'));
        
        return $ret;
    }

	
	
    function getCountBySes($session_id = null){
/*
        $sql =  "";
        $sql .=  "     SELECT COUNT(Browse.id) AS cnt ";
        $sql .=  "       FROM browses Browse ";
        $sql .=  " INNER JOIN rooms Room ";
        $sql .=  "         ON Browse.code = Room.code ";
        $sql .=  "        AND Browse.`room-number` = Room.`room-number` ";
        $sql .=  "        AND Room.hide_flg = 0 ";
        $sql .=  " INNER JOIN properties Property ";
        $sql .=  "         ON Property.id = Room.property_id ";
        $sql .=  "      WHERE Browse.id > 0 ";
        $sql .=  "        AND Browse.session_id = '$session_id' ";
        $array = $this->query($sql);
        return $array[0][0]['cnt'];
*/
    }

    var $search_param;

    function setSearchParam($param){

        $this->search_param = $param;

    }

    /*
     * ページング
     */
    function setWhereVal($param){
        $this->where_value = $param;
    }

    /*
     * ページング
     */
    function getPagingEntity($disp_num,$pgnum, $direction=null){

        // ページング用パラメータ設定
        $this->setDispNum($disp_num);
        $this->setPgNum($pgnum);

        // SQL処理
        $sql =  "";
        $sql .=  "     SELECT * ";
        $sql .=  "       FROM messages Message ";
        
        // Group By
        if (!empty($direction)) {
        	if ($direction == 'receive') {
        		$sql .= ' INNER JOIN (Select max(created) MaxCreated, from_item_id, from_member_id FROM messages GROUP BY from_item_id, from_member_id) p2 ON Message.from_item_id=p2.from_item_id AND Message.created=p2.MaxCreated AND Message.from_member_id=p2.from_member_id ';
        	} else if ($direction == 'send') {
        		$sql .= ' INNER JOIN (Select max(created) MaxCreated, from_item_id, to_member_id FROM messages GROUP BY from_item_id, to_member_id) p2 ON Message.from_item_id=p2.from_item_id AND Message.created=p2.MaxCreated AND Message.to_member_id=p2.to_member_id ';
        	}
        } 
        
        $sql .=  " INNER JOIN members ToMember ";
        $sql .=  "         ON ToMember.id = Message.to_member_id ";
        $sql .=  " INNER JOIN members FromMember ";
        $sql .=  "         ON FromMember.id = Message.from_member_id ";

        // ●商品問い合わせ時メール送信 2017/12/02 add --START
        $sql .=  " LEFT JOIN items FromItem ";
        $sql .=  "         ON FromItem.id = Message.from_item_id ";
        // ●商品問い合わせ時メール送信 2017/12/02 add --END

        $sql .=  "     WHERE Message.del_flg = 0 ";
        if(!empty($this->where_value)){
            if(isset($this->where_value['status'])){
                $val = $this->where_value['status'];
                $sql .=  " AND Message.status = '$val' ";
            }
            if(isset($this->where_value['member_id']) && !empty($this->where_value['member_id'])){
                $val = $this->where_value['member_id'];
                $sql .=  " AND Message.member_id = '$val' ";
            }
            if(isset($this->where_value['to_member_id']) && !empty($this->where_value['to_member_id'])){
                $val = $this->where_value['to_member_id'];
                $sql .=  " AND Message.to_member_id = '$val' ";
            }
            if(isset($this->where_value['from_member_id']) && !empty($this->where_value['from_member_id'])){
                $val = $this->where_value['from_member_id'];
                $sql .=  " AND Message.from_member_id = '$val' ";
            }
        }
        
        
        $order = ' ORDER BY Message.`modified` DESC';

        // ページング用SQL文字列
        $pg_sql = $this->getPagingString($sql.$order);
        $array = $this->query($pg_sql);

        $arrRes["list"] = array();
        foreach($array as $key => $row){
        	$uRow = $row;
        	$uRow['Message']['unread_count'] = $this->getUnreadCountById($uRow['Message']['id']);
            $arrRes["list"][$key] = $uRow;
        }

        // ページング用
        $arrRes["current_pg"] = $this->getCurrentPg();
        $arrRes["pg_list"] = $this->getArrPgList($sql);
        $arrRes["prev"] = $this->getPgPrev();
        $arrRes["next"] = $this->getPgNext();
        $arrRes["total"] = $this->getRecordTotal();

        return $arrRes;
    }


}
?>