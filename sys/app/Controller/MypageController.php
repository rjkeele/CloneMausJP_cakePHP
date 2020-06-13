<?php

App::uses('FrontAppController', 'Controller');
App::uses('File', 'Utility');
App::uses('Folder', 'Utility');

class MypageController extends FrontAppController {

    public $uses = array('Item', 'FavoriteItem', 'OrderItem', 'Member', 'CashingData', 'Follower', 'Message', 'OrderPoint', 'Review');

    function beforeFilter() {

        parent::beforeFilter();
        $this->Auth->allow('login', 'logout', 'sellerinfo', 'withdrawal_complete');


        // 認証者情報
        $this->set('loginMember', $this->Auth->user());
        
        // 制限チェック
        $checkActionList = array('index', 'login', 'logout', 'sellerinfo', 'withdrawal_complete');
        
        if (!empty($this->user_id) && !in_array(strtolower($this->action), $checkActionList)) {
            $userInfo = $this->Member->getDetail($this->user_id);
            if ($userInfo['Member']['status'] == 3) {
                $this->redirect('/mypage/');
            }
        }
    }

    public function login() {
        $eventid = $this->request->query('eventid');
        if ($this->request->is('post') || $this->request->is('put')) {
        	
            $redirect_url = $this->Session->read('redirect_url');
            if ($this->Auth->login()) {
                if (!empty($redirect_url)) {
                    $this->Session->write('redirect_url', null);
                    $this->redirect($redirect_url);
                } else {
                    $this->redirect('/mypage/');
                }
            } else {
                $this->Session->setFlash(MSG_LOGIN_ERR, null, array(), 'auth');
            }
        }
    }

    public function logout() {
        $this->Auth->logout();
        $this->redirect('/');
    }

    function index() {

        $arrData = $this->Member->getDetail($this->user_id);
        $this->set('arrMemberInfo', $arrData);

        $arrItemSummary = $this->Item->getSummary($this->user_id);
        $this->set('arrItemSummary', $arrItemSummary);

        $arrOrderCount = $this->OrderItem->getSummary($this->user_id);
        $this->set('intOrderCount', $arrOrderCount);

        $intFavoriteCount = $this->FavoriteItem->getSummary($this->user_id);
        $this->set('intFavoriteCount', $intFavoriteCount);

        //$intFollowerCount = $this->Follower->getSummary($this->user_id);
        $intFollowerCount = $this->Follower->getFollowerCount($this->user_id);
        $this->set('intFollowerCount', $intFollowerCount);

        $intFollowCount = $this->Follower->getFollowCount($this->user_id);
        $this->set('intFollowCount', $intFollowCount);


        $intReceivedCount = $this->Message->getReceivedCount($this->user_id);
        $this->set('intReceivedCount', $intReceivedCount);

        $intgetUnreadCount = $this->Message->getUnreadCount($this->user_id);
        $this->set('intgetUnreadCount', $intgetUnreadCount);

        // レビューの平均値の計算
        if ($arrData['Member']['admin_level'] === null) {
            $itemIds = $this->Item->findAllMemberId($this->user_id);
            $reviews = $this->Review->findAllByItemId($itemIds);
            $ratingAve = $this->Utility->calculateReviewAve($reviews);
            $this->set('ratingAve', $ratingAve);
        } else {
            $this->set('ratingAve', $arrData['Member']['admin_level']);
        }
//        $this->loadModel('Order');
        // 購入履歴
//        $member_id = $this->arrMemberInfo["id"];
//        $param["credit_payment_flg"] = 1;
//        $this->Order->setWhere($param);
//        $this->arrHistorys = $this->Order->getOrderHistorysByCustomerId($member_id);
        // ビュー設定
//        $this->setView('index',$this->isSp);
    }

    /**
     * 購入者管理TOP
     * */
    function consumer() {
        
    }

    /**
     * 購入者管理 お気に入り一覧
     * */
    function favorite() {

        $member_id = $this->user_id;
        $session_key = @$this->Session->id();
        $arrData = $this->FavoriteItem->getFavoriteEntryList($member_id, $session_key);
        $this->set('arrData', $arrData);
    }

    /**
     * 購入者管理 お気に入り削除
     * */
    function favorite_del($id) {
        $arrData = $this->FavoriteItem->delete($id);
        $this->redirect('/mypage/favorite');
    }

    /**
     * 購入者管理 購入商品一覧
     * */
    function purchased() {

        $member_id = $this->user_id;
        $disp_num = 15;
        $pgnum = Hash::get($this->request->query, 'pg');
        $param['member_id'] = $member_id;
        $this->OrderItem->setWhereVal($param);
        $arrData = $this->OrderItem->getPagingEntity($disp_num, $pgnum);
        $this->set('arrData', $arrData);

        $url = '/mypage/purchased/?';
        $this->set('url', $url);
    }

// ●ユーザーマイページにポイント購入履歴がないので追加する 2017/12/01 add --START
    /**
     * 購入者管理 購入ポイント履歴
     * */
    function purchased_point() {

        $member_id = $this->user_id;
        $disp_num = 15;
        $pgnum = Hash::get($this->request->query, 'pg');
        $param['member_id'] = $member_id;
        $this->OrderPoint->setWhereVal($param);
        $arrData = $this->OrderPoint->getPagingEntity($disp_num, $pgnum);
        $this->set('arrData', $arrData);

        $url = '/mypage/purchased_point/?';
        $this->set('url', $url);
    }

// ●ユーザーマイページにポイント購入履歴がないので追加する 2017/12/01 add --END

    /**
     * フォロー一覧
     * */
    function followlist() {

        $this->loadModel('Follower');

        $disp_num = $this->Session->read('sesDispNum');
        if ($this->request->is('post') &&
                $this->request->data['formDispNum']['mode'] == 'changeDispNum') {
            $disp_num = $this->request->data['formDispNum']['disp_num'];
            $this->Session->write('sesDispNum', $disp_num);
        }
        if (empty($disp_num)) {
            $disp_num = 20;
        }
        $this->set('disp_num', $disp_num);

        $sort = $this->Session->read('sesSort');
        if ($this->request->is('post') &&
                $this->request->data['formDispNum']['mode'] == 'sort') {
            $sort = $this->request->data['formDispNum']['sort'];
            $this->Session->write('sesSort', $sort);
        }
        $this->set('setSort', $sort);

        $member_id = $this->user_id;
        $pgnum = Hash::get($this->request->query, 'pg');
        $param['member_id'] = $member_id;
        $this->Follower->setWhereSortVal($sort);
        $this->Follower->setWhereVal($param);
        $arrData = $this->Follower->getPagingEntity($disp_num, $pgnum);
        $this->set('arrData', $arrData);

        $url = '/mypage/followlist/?';
        $this->set('url', $url);
    }

    /**
     * フォロワー一覧
     * */
    function followerlist() {

        $this->loadModel('Follower');

        $disp_num = $this->Session->read('sesDispNum');
        if ($this->request->is('post') &&
                $this->request->data['formDispNum']['mode'] == 'changeDispNum') {
            $disp_num = $this->request->data['formDispNum']['disp_num'];
            $this->Session->write('sesDispNum', $disp_num);
        }
        if (empty($disp_num)) {
            $disp_num = 20;
        }
        $this->set('disp_num', $disp_num);

        $sort = $this->Session->read('sesSort');
        if ($this->request->is('post') &&
                $this->request->data['formDispNum']['mode'] == 'sort') {
            $sort = $this->request->data['formDispNum']['sort'];
            $this->Session->write('sesSort', $sort);
        }
        $this->set('setSort', $sort);

        $member_id = $this->user_id;
        $pgnum = Hash::get($this->request->query, 'pg');
        $param['follow_member_id'] = $member_id;
        $this->Follower->setWhereSortVal($sort);
        $this->Follower->setWhereVal($param);
        $arrData = $this->Follower->getPagingEntity($disp_num, $pgnum);
        $this->set('arrData', $arrData);

        $url = '/mypage/followerlist/?';
        $this->set('url', $url);
    }

    /**
     * フォロー追加
     * */
    function follower_add($member_id) {

        $this->autoRender = false;
        $this->loadModel('Follower');
        if ($this->user_id == $member_id) {
            echo '自分自身をフォローに追加することは出来ません';
            exit;
        }
        $msg = 'フォローに追加出来ません';
        if ($this->Follower->addData($this->user_id, $member_id)) {
            $msg = 'フォローに追加しました';
        }
        echo $msg;
    }

    /**
     * 販売管理 TOP
     * */
    function seller() {

        $member_id = $this->user_id;

        // 商品リスト
        $disp_num = 6;
        $param['member_id'] = $member_id;
        $this->Item->setWhereVal($param);
        $arrItems = $this->Item->getSalePagingEntity($disp_num, 1);
        $this->set('arrItems', $arrItems['list']);

        // 売上リポート
        $arrSaleReport = $this->OrderItem->getSaleReport($member_id, 6);
        $this->set('arrSaleReport', $arrSaleReport);

        $this->set('intMaxTotal', $this->OrderItem->getMaxTotal());
    }

    /**
     * 販売会員TOP
     * */
    function sellerinfo($member_id) {

        $this->set('currentMemberId', $member_id);

        $arrMember = $this->Member->getDetail($member_id);
        if (empty($arrMember)) {
            $this->redirect('/');
        }
        $this->set('arrMemberInfo', $arrMember);

        // レベル
        $sellerLevel = $this->Member->getSellerLevel($member_id);
        $this->set('sellerLevel', $sellerLevel);
        
        // 販売数ランキング
        $arrSaleReport = $this->Item->getEntityBySaleCount($member_id, 4);
        $this->set('arrSaleReport', $arrSaleReport);

        // 商品リスト
        $arritem_list = $this->Item->getEntityByMemberId($member_id, 12);
        $this->set('arrItemList', $arritem_list);

        // 商品リスト
        $arrItemCount = $this->Item->getCountByMemberId($member_id);
        $this->set('arrItemCount', $arrItemCount);
    }

    /**
     * 販売管理 売上管理
     * */
    function sales_report() {

        $member_id = $this->user_id;
        $arrData = $this->OrderItem->getSaleReport($member_id);
        $this->set('arrData', $arrData);

        $this->set('intMaxTotal', $this->OrderItem->getMaxTotal());
    }

    /**
     * 販売管理 売上管理
     * */
    function sale_ym($ym) {

        $member_id = $this->user_id;
        $arrData = $this->OrderItem->getMonthSaleData($member_id, $ym);
        $this->set('arrData', $arrData);

        $this->set('strYearMonth', substr($ym, 0, 4) . '年' . substr($ym, 4, 2) . '月');
    }

    /**
     * 販売管理 換金申請
     * */
    function cashing($mode = null) {

        $this->loadModel('Config');
        $this->loadModel('CashingData');

        $member_id = $this->user_id;
        $arrDef = $this->CashingData->getDefFields();
        $arrData['CashingData'] = $arrDef;
        $arrData['CashingData']['member_id'] = $member_id;

        //現在の換金情報
        $arrCashingData = $this->CashingData->getDetailByMemberId($member_id);
        $this->set('arrCashingData', $arrCashingData);

        $arrMember = $this->Member->getDetail($member_id);
        $arrData['Member'] = $arrMember['Member'];

        $this->set('arrData', $arrData);

        $point = $arrData['Member']['point'];
        $cashingMinMoney = $this->Config->getCashingMinMoney();
        $this->set('cashingPossible', $point);
        $this->set('cashingMinMoney', $cashingMinMoney);

        // 申請フォーム
        if ($this->request->is('post') or $this->request->is('put')) {

            $data = $this->request->data;

            // 確認
            if ($data['CashingData']['mode'] == 'confirm') {
                $money = str_replace(',', '', $data['CashingData']['money']);
                $cashingFee = $this->Config->getCashingFee($money);
                $data['CashingData']['money'] = $money - $cashingFee;
                $data['CashingData']['fee'] = $cashingFee;
                $data['CashingData']['possible_cashing'] = $point;
                $data['CashingData']['possible_cashing_min'] = $cashingMinMoney;
                $this->CashingData->set($data);
                if ($this->CashingData->validates()) {
                    $this->Session->write('sesCashingData', $data);
                    $this->redirect('/mypage/cashing/confirm');
                } else {
                    $arrData['CashingData'] = $data['CashingData'];
                    $this->Session->setFlash('入力エラーがあります。', null, array(), 'auth');
                }
            }

            // 申請登録
            if ($data['CashingData']['mode'] == 'complete') {
                $data = $this->Session->read('sesCashingData');
                $data['CashingData']['apply_date'] = date('Y-m-d');
                if ($this->CashingData->save($data)) {
                    $this->Member->addPoint($data['CashingData']['member_id'], -($data['CashingData']['money'] + $data['CashingData']['fee']));
                    $this->redirect('/mypage/cashing/complete');
                } else {
                    $arrData['CashingData'] = $data['CashingData'];
                    $this->Session->setFlash('入力エラーがあります。', null, array(), 'auth');
                }
            }
        }

        // 確認画面
        if ($mode == 'confirm') {
            $data = $this->Session->read('sesCashingData');
            $arrData['CashingData'] = $data['CashingData'];
            $this->set('arrData', $arrData);
            $this->render('cashing_confirm');
        }

        // 完了画面
        if ($mode == 'complete') {
            $data = $this->Session->read('sesCashingData');
            if (empty($data)) {
                $this->redirect('/mypage/cashing');
            }
            $this->Session->write('sesCashingData', null);
            $this->render('cashing_complete');
        }
    }

    /**
     * 登録情報 会員登録内容
     * */
    function profile($param = null) {

        $member_id = $this->user_id;
        $arrData = $this->Member->getDetail($member_id);
        $sesData = $this->Session->read('sesProfileData');
        if ($param == 'mod' && !empty($sesData)) {
            $arrData = $sesData;
        }

        if ($this->request->is('post') or $this->request->is('put')) {

            $data = $this->request->data;
            // 確認
            if ($data['Member']['mode'] == 'profile') {
                $this->Member->validate = $this->Member->validate_profile;
            }
            if ($data['Member']['mode'] == 'email') {
                $data['Member']['user_id'] = $data['Member']['email'];
                $this->Member->validate = $this->Member->validate_email;
            }
            if ($data['Member']['mode'] == 'password') {
                $this->Member->validate = $this->Member->validate_password;
            }
            $this->Member->set($data);
            if ($this->Member->validates()) {
                $this->Session->write('sesProfileData', $data);
                $this->redirect('/mypage/profile_confirm');
            } else {
                $arrData['Member'] = $data['Member'];
                $this->Session->setFlash('入力エラーがあります。', null, array(), 'auth');
            }
        }

        $this->set('arrData', $arrData);
    }

    function profile_confirm() {

        $arrData = $this->Session->read('sesProfileData');
        $this->set('arrData', $arrData);
        if ($this->request->is('post') or $this->request->is('put')) {

            if ($arrData['Member']['mode'] == 'profile') {
                $this->Member->validate = $this->Member->validate_profile;
            }
            if ($arrData['Member']['mode'] == 'email') {
                $this->Member->validate = $this->Member->validate_email;
            }
            if ($arrData['Member']['mode'] == 'password') {
                $this->Member->validate = $this->Member->validate_password;
            }
            $this->Member->validates();
            if ($this->Member->save($arrData)) {
                $this->redirect('/mypage/profile_complete');
            } else {
                $this->Session->setFlash('入力エラーがあります。', null, array(), 'auth');
                $this->redirect('/mypage/profile');
            }
        }
    }

	public function item_all_public() {
		$data = $this->request->data;
		
		$type = $data['mypage-public-type'];
		
		$my_page_data = $data['Mypage'];
		foreach($my_page_data as $key=>$val) {
			$pos = strpos($key, "delete_id_");
			if ($pos> -1) {
				$id = substr($key, $pos + 10);
				
				$this->Item->id = $id;
				$this->Item->saveField('public', $type);
			}
		}
		
		$this->redirect($this->redirect('/mypage/item_list'));
	}
	
	public function item_copy($id) {
		$arrData = $this->Item->copyData($id);
		if ($arrData == false) {
			$this->redirect('/mypage/item_list');
		}
		
		$new_id = $arrData['Item']['id'];
		$this->Item->copyFiles($id, $new_id);
		$this->Item->copyCategories($id, $new_id);
		
        $this->redirect('/mypage/item_list');
	}
	
    function profile_complete() {

        $data = $this->Session->read('sesProfileData');
        $this->set('arrData', $data);
        if (!empty($data)) {
            $this->Session->write('sesProfileData', null);
        } else {
            $this->redirect('/mypage/profile');
        }
    }

    /**
     * 販売管理 商品一覧
     * */
    public function item_list() {

        $member_id = $this->user_id;
        $disp_num = 15;
        $pgnum = Hash::get($this->request->query, 'pg');
        $param['member_id'] = $member_id;
        $this->Item->setWhereVal($param);
        $arrData = $this->Item->getSalePagingEntity($disp_num, $pgnum);
        $this->set('arrData', $arrData);
        $url = '/mypage/item_list/?';
        $this->set('url', $url);
    }

    public function item($id = null) {

        $this->loadModel('Config');

        $arrUploadMaxSize = $this->Config->getUploadMaxSize();
        $this->set('arrUploadMaxSize', $arrUploadMaxSize);

        $arrData['Item'] = $this->Item->getDefFields();
        $arrData['Item']['member_id'] = $this->user_id;
        $sesItemData = $this->Session->read('sesItemData');
        
        if (!empty($sesItemData) && !empty($id)) {
            $arrData = $sesItemData;
        }
        if (!empty($id)) {
            $arrData = $this->Item->getDetail($id);
        } else {
            $maxCnt = $this->Config->getMaxItemCnt();
            $cnt = $this->Item->find('count', array('conditions' => array('Item.member_id' => $this->user_id, 'Item.del_flg' => '0')));
            if ($maxCnt > 0 && $maxCnt <= $cnt) {
                $this->set('limitedMsg', 'トライアル制限を越えています。');
                return;
            }
        }
        if ($this->request->is('get')) {
            $this->Session->setFlash(null, null, array(), 'auth');
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
        
            $fileValid = true;
            $valid = true;
            $data['Item']['save_flg'] = 1;
            if (isset($data['Item']['categories']) && count($data['Item']['categories']) > 0){
            	$data['Item']['category'] = implode(" ", $data['Item']['categories']);
            } else {
            	$valid = false;
            }
            
            // $data['Item']['selling'] = $arrData['Item']['selling'];
            // ファイルアップ
            if ($data['Item']['item_file']['size'] > 0) {
                $size = null;
                $extensionList = $this->Config->getItemUploadExtensionList();
                $path_parts = pathinfo($data['Item']['item_file']["name"]);
                if (in_array(strtolower($path_parts['extension']), $extensionList)) {
                    $this->Utility->fileUpTempSave($data['Item']['item_file'], $size);
                    $data['Item']['file_name'] = $this->Utility->getFileName();
                    $data['Item']['file_path'] = $this->Utility->getFilePath();
                    $data['Item']['file_type'] = $this->Utility->getFileType();
                    $data['Item']['file_size'] = $this->Utility->getFileSize();
                    $data['Item']['file_extension'] = $this->Utility->getFileExtension();
                } else {
                    $fileValid = false;
                }
            }
            if ($fileValid) {
            	$save_data = $data['Item'];
                if (isset($save_data['categories'])) {
                	unset($save_data['categories']);
                }
                
                $this->Item->create($save_data);
                $this->Item->validate = $this->Item->user_validate;
                
                $categories = isset($data['Item']['categories']) ? $data['Item']['categories'] : array();
                
                if ($valid && $this->Item->save($save_data)) {
                	
                    $id = $data['Item']['id'];
                    if (empty($id)) {
                        $id = $this->Item->getLastInsertID();
                    }
                    $this->Item->insertCategories($id, $categories);
                    
                    $this->Session->write('sesItemData', null);
                    $this->Session->setFlash('商品情報を更新しました', null, array(), 'auth');
                    $this->Session->write('status', true);
                    $this->redirect('/mypage/item/' . $id);
                }else {
                	
                    $arrData = $data;
                    $this->Session->setFlash('情報を更新出来ませんでした', null, array(), 'auth');
                }
            } else {
                $arrData = $data;
                $this->Session->setFlash('ファイル拡張子が不正です。', null, array(), 'auth');
            }
        }
        if ($this->Session->check('status')) {
            $status = $this->Session->read('status');
            $this->set('isSuccess', $status);
            $status = $this->Session->delete('status');
        }
        $this->set('arrData', $arrData);
        $this->set('userId', $this->user_id);
    }

    function item_fileup($id = null) {

        $data = $this->request->data;

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            // ファイルアップ
            $size = null;
            $this->Utility->fileUpTempSave($data['Item']['file'], $size);
            $data['Item']['file_name'] = $this->Utility->getFileName();
            $data['Item']['file_path'] = $this->Utility->getFilePath();
            $data['Item']['file_type'] = $this->Utility->getFileType();
            $data['Item']['file_size'] = $this->Utility->getFileSize();
            $data['Item']['file_extension'] = $this->Utility->getFileExtension();

            $this->Item->validate = array();
            $this->Item->create($data);

            if ($this->Item->save($data)) {
                $id = $data['Item']['id'];
                if (empty($id)) {
                    $id = $this->Item->getLastInsertID();
                }
            } else {
                $this->Session->setFlash('アップロード出来ませんでした', null, array(), 'auth');
            }
        }
        // $this->redirect('/mypage/item/' . $id);
    }

    function image_fileup() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            if ($data['Item']['input_name'] == 'item_file') {
                $this->item_fileup($data['Item']['id']);
            } else {
                $data = $this->request->data;
                
                $data['Item'][$data['Item']['input_name']] = $data['Item']['file'];
                $this->Item->validate = $this->Item->validate_fileup;
                if ($this->Item->save($data)) {
                    $id = $data['Item']['id'];
                    if (empty($id)) {
                        $id = $this->Item->getLastInsertID();
                    }
                    $arrData = $this->Item->findById($id);
                    $this->Session->write('sesItemData', $arrData);
                    $this->redirect('/mypage/item/' . $id);
                } else {
                    $this->autoRender = false;
                    //debug($this->Item->validationErrors);
                }
            }
        }
    }

    function member_image_fileup() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;
            $data['Member'][$data['Member']['input_name']] = $data['Member']['file'];
            $this->Member->validate = $this->Member->validate_fileup;
            if (!$this->Member->save($data)) {
                $arrMsg = array();
                foreach ($this->Member->validationErrors as $err) {
                    foreach ($err as $msg) {
                        array_push($arrMsg, $msg);
                    }
                }
                if (!empty($arrMsg)) {
                    $this->Session->setFlash(join('<br/>', $arrMsg));
                } else {
                    $this->Session->setFlash('アップロードに失敗しました。');
                }
            }
            $this->redirect('/mypage/');
        }
    }

    function member_image_del() {
        $data = array(
            'Member' => array(
                'id' => $this->user_id,
                'image' => null,
            )
        );
        $this->Member->save($data);
        $this->redirect('/mypage/');
    }

    function item_image_del($file_name, $item_id) {
        $member_id = $this->user_id;
        if (!$this->Item->isHaving($item_id, $member_id)) {
            $this->redirect('/mypage/item/' . $item_id);
        }
        $this->Item->isImageDel($item_id, $file_name);
        $this->redirect('/mypage/item/' . $item_id);
    }

    /**
     * 商品リスト　削除
     * */
    public function item_del($id) {
        $arrData = $this->Item->delData($id);
        $this->Item->delCateogires($id);
        $this->Item->delImages($id);
        
        $this->redirect('/mypage/item_list');
    }

    public function item_all_del() {
        if ($this->request->is('post') || $this->request->is('put')) {
            $request = $this->request->data('Mypage');
            if (isset($request)) {
                $ids = array();
                foreach ($request as $deleteId) {
                    $ids[] = $deleteId;
                }
                $message = '';
                $result = '';
                $this->Item->begin();
                try {
                    $this->Item->delAllData($ids);
                    $this->Item->delAllCateogires($ids);
                    $this->Item->delAllImages($ids);
                    
                    $this->Item->commit();
                    $message = '削除処理が完了致しました。';
                    $result = 'alert alert-success';
                } catch (Exception $ex) {
                    // Exception発生時はロールバック
                    $this->Item->rollback();
                    $message = '削除処理が失敗しました。';
                    $result = 'alert alert-danger';
                }
            } else {
                $message = '削除処理が失敗しました。';
                $result = 'alert alert-danger';
            }
            $this->Session->setFlash($message, null, array('class' => $result), 'auth');
            $this->autoRender = true;
            $this->redirect('/mypage/item_list');
        }
    }

    function history() {

        $this->loadModel('Order');

        // 認証者情報
        $this->arrMemberInfo = $this->MemberCom->getAuth();

        // 購入履歴
        $member_id = $this->arrMemberInfo["id"];
        $this->arrHistorys = $this->Order->orderHistorysByMemberId($member_id);
//print_r($this->arrHistorys);

        $this->set('arrHistorys', $this->arrHistorys);
    }

    function history_detail($param) {

        $this->loadModel('Order');
//        $this->loadModel('Constant');
        // 認証者情報
        $this->arrMemberInfo = $this->MemberCom->getAuth();

//        $this->arrPaymentOptions = $this->Constants->getArrOptions("payment");
        // 商品情報
        $array = $this->Order->orderHistorysById($param);
//print_r($array);
        if (count($array) > 0) {
            $this->arrHistory = $array;
        } else {
            $this->redirect(HOME_URL);
        }

        $this->set('arrHistory', $this->arrHistory);
    }

    // 退会処理
    public function withdrawal($mode = null) {

        $member_id = $this->user_id;

        $this->set('mode', $mode);

        if ($this->request->is('get') && $mode == 'enter') {

            if ($this->Member->withdrawal($member_id)) {
                $this->Auth->logout();
                $this->redirect('/mypage/withdrawal_complete');
            } else {
                $this->Session->setFlash('退会処理は完了出来ませんでした。管理者にお問い合わせください。');
            }
        }
    }





/**	
* 購入者から商品の受け取り連絡	
*/	
	function delivered($orderItemId) {	
		$orderDetails = $this->OrderItem->find('first', array(	
			'fields' => array('*'),	
			'conditions' => array(	
			'OrderItem.id' => $orderItemId,	
			'OrderItem.member_id' => $this->user_id,	
			'OrderItem.status' => OrderItem::STATUS_SHIPPING,	
			'OrderItem.del_flg' => 0,	
		),	
		'joins' => array(	
		array('table' => 'items', 'alias' => 'Item', 'conditions' => 'Item.id = OrderItem.item_id'),	
		array('table' => 'members', 'alias' => 'Seller', 'conditions' => array('Seller.id = Item.member_id', 'Seller.del_flg = 0', 'Seller.status < 3')),	
		),	
		));	
		if (!empty($orderDetails)) {	
			$dbSrc = $this->Member->getDataSource();	
			if ($dbSrc->begin()) {	
			try {	
			$total = $orderDetails['OrderItem']['total'];	
			$fee = floor($total * $this->Config->getSaleFee() / 100);	
			if ($this->OrderItem->save(array('id' => $orderItemId, 'fee' => $fee, 'status' => OrderItem::STATUS_COMPLETED))) {	
			//add point to seller account	
			$this->Member->addPoint($orderDetails['Item']['member_id'], $total - $fee);	
			$this->PointHistory->grantPoint($orderDetails['Item']['member_id'], $total - $fee);	
			$dbSrc->commit();	
			//send mail	
			if (!empty($orderDetails['Seller']) && !empty($orderDetails['Seller']['id'])) {	
			$this->sendMail(Configure::read('mail.itemDelivered'), $orderDetails['Seller']['email'], $orderDetails);	
			}	
			$this->Session->setFlash('受取連絡が完了しました。', 'flash_success');	
			} else {	
			$this->Session->setFlash('受取連絡が失敗しました。[1]', 'flash_error');	
			}	
			} catch (Exception $ex) {	
			$dbSrc->rollback();	
			$this->Session->setFlash('受取連絡が失敗しました。[2]', 'flash_error');	
			}	
			} else {	
			$this->Session->setFlash('受取連絡が失敗しました。[3]', 'flash_error');	
			}	
			} else {	
			$this->Session->setFlash('対象注文が見つかりません。', 'flash_error');	
		}	
		$this->redirect('/mypage/purchased');	
	}





    // 退会完了
    public function withdrawal_complete() {

        $this->set('mode', 'complete');
        $this->render('withdrawal');
    }

    public function notice_mail() {
        $memberId = $this->user_id;
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Member']['id'] = $memberId;
            $this->Member->validate = $this->Member->validate_notice_email;
            if ($this->Member->save($this->request->data)) {
                $this->Session->setFlash('メール通知設定に成功致しました。');
            } else {
                $this->Session->setFlash('メール通知設定に失敗致しました。');
            }
        }
        $member = $this->Member->findById($memberId);
        $this->set('member', $member);
    }

    public function review($itemId = null) {
        if ($itemId == null) {
            $this->redirect('/mypage/');
        }
        $reviews = $this->Review->findAllByItemId($itemId);
        $this->set('reviews', $reviews);
    }
    
/**
* CSVアップロード
* */
	public function csv_upload($id=null) {
	
		$csv = $_FILES['file']['tmp_name'];
		/*
		$buffer = mb_convert_encoding(file_get_contents($csv), "UTF-8", "sjis");
		$fp = tmpfile();
		fwrite($fp, $buffer);
		rewind($fp);
		*/
		$file = fopen($csv, "r");
		$lines = array();
		while( ($row = fgetcsv($file, 8192)) !== FALSE ) {
			$lines[] = $row;
		}
		
		$headers = $lines[0];
		
		foreach($lines as $key => $line) {
			$insert_data = array();
			$item = array();
			$categories = array();
			if ($key > 0) {
				foreach($line as $k => $v) {
					$t = strpos($headers[$k], '_file_name');
					if ($t > -1) {
						$image = substr($headers[$k], 0, $t);
						$item[$image] = $v;
					}
					if ($headers[$k] == 'category') {
						$categories = explode(" ", $v);
					}
					$insert_data[$headers[$k]] = $v;
				}
				
				
				$insert_data['save_flg'] = 1;
				
				$this->Item->validate = $this->Item->validate_csv;
				$res = $this->Item->save($insert_data);
				
				$item['id'] = $res['Item']['id'];
				
				$dir = $_SERVER['DOCUMENT_ROOT'] . '/upload/items/' . $item['id'];
				if (!is_dir($dir)) {
					@mkdir($dir);
				}
				$data['Item'] = $item;
				
				$this->Item->validate = $this->Item->validate_fileup;
				
				if (!$this->Item->save($data)) {
					$message = 'CSVのアップロードに失敗しました';
					$result = 'alert alert-danger';
					break;
				}
				$this->Item->insertCategories($item['id'], $categories);
			}
			
		}
		$message = 'CSVのアップロードに成功しました';
		$result = 'alert alert-success';
		
		$this->Session->setFlash($message, null, array('class' => $result), 'auth');
        $this->autoRender = true;
        $this->redirect('/mypage/item_list');
	}
	
}

?>