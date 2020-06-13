<?php

App::uses('CakeEmail', 'Network/Email');

class FrontAppController extends AppController {

    public $helpers = array('Form', 'Html', 'Time','Calendar','Image','UploadPack.Upload','FormElements','Cache','Paging');
    public $uses = array('Item', 'Message');

    public $components = array(
        'Session',
        'Cookie',
        'RequestHandler',
        'Utility',
        'Cart',
        'Auth' => array(
            // 認証時の設定
            'authenticate' => array(
                'Form' => array(
                    // 認証時に使用するモデル
                    'userModel' => 'Member',
                    // 認証時に使用するモデルのユーザ名とパスワードの対象カラム
                    'fields' => array('username' => 'user_id' , 'password'=>'password'),
                    'scope' => array( 'Member.role' => array('user','admin'),'Member.status > ' => 0,'Member.status < ' => 4),
                ),
            ),
            // ログイン失敗時に出力するメッセージを設定
            'loginError' => 'パスワードもしくはログインIDをご確認下さい。',
            // ログインしていない場合のメッセージを設定
            'authError' => 'ご利用されるにはログインが必要です。',
            // ログインに使用するアク