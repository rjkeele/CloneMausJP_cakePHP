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
            // �F�؎��̐ݒ�
            'authenticate' => array(
                'Form' => array(
                    // �F�؎��Ɏg�p���郂�f��
                    'userModel' => 'Member',
                    // �F�؎��Ɏg�p���郂�f���̃��[�U���ƃp�X���[�h�̑ΏۃJ����
                    'fields' => array('username' => 'user_id' , 'password'=>'password'),
                    'scope' => array( 'Member.role' => array('user','admin'),'Member.status > ' => 0,'Member.status < ' => 4),
                ),
            ),
            // ���O�C�����s���ɏo�͂��郁�b�Z�[�W��ݒ�
            'loginError' => '�p�X���[�h�������̓��O�C��ID�����m�F�������B',
            // ���O�C�����Ă��Ȃ��ꍇ�̃��b�Z�[�W��ݒ�
            'authError' => '�����p�����ɂ̓��O�C�����K�v�ł��B',
            // ���O�C���Ɏg�p����A�N�V�������w��
            'loginAction' => array('controller' => 'mypage', 'action' => 'login'),
            // ���O�C����̃��_�C���N�g����w��
            'loginRedirect' => array('controller' => 'mypage', 'action' => 'index'),
            // ���O�A�E�g��̃��_�C���N�g����w��
            'logoutRedirect' => array('controller' => 'mypage', 'action' => 'login'),
        ),
    );

    var $ext = '.html';

    //ver2.4
    public function beforeFilter() {
	$server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
	$domain = Configure::read('info.domain');
	
	if ($domain != $server_name) {
		echo "Failed to install site.";
		exit;
	}

        $this->set('root_url',FULL_BASE_URL.'/');

        // �}�X�^�[�f�[�^�擾
        $this->arrMasterData = $this->Utility->getMasterData();
        $this->set('arrMasterData',$this->arrMasterData);

        //Copyright
        $this->crYear = date('Y');

        // �����L�[���[�h
        $keywords = '�L�[���[�h�ŒT��';
        if(isset($this->request->query['keywords'])){
            $keywords = $this->request->query['keywords'];
        }
        $this->set('search_keyword',$keywords);

        $this->set('isMobile', $this->RequestHandler->isMobile());

        $this->auth_user = $this->Auth->user();
        //exit;
        if (isset($this->auth_user['u_id']) && $this->auth_user['u_id']) {
        	$u_id = $this->auth_user['u_id'];
        	
        	$member = $this->Member->getDetail($u_id);
        	$this->user_id = $member['Member']['id'];
        	$this->login_name = $member['Member']['user_id'];
        	$this->user_role = $member['Member']['role'];
        	
        } else {
        	$this->user_id = $this->auth_user['id'];
        	$this->login_name = $this->auth_user['user_id'];
        	$this->user_role = $this->auth_user['role'];
        }
        
        
        $this->set('login_member_id',$this->user_id);
        $this->set('loginname',$this->login_name);
        $this->set('user_role',$this->user_role);

        // �s�b�N�A�b�v���
        $arrPickUp = $this->Item->getPickUpEntity();
        $this->set('arrPickUp',$arrPickUp);
        
        // �^�O���
        $arrTags = $this->Item->geTagList(10);
        $this->set('arrTagList',$arrTags);
		if ($this->Message && $this->user_id) {
			$intgetUnreadCount = $this->Message->getUnreadCount($this->user_id);
        } else {
        	$intgetUnreadCount = 0;
        }
        $this->set('intgetUnreadCount', $intgetUnreadCount);
        
        if(!empty($this->user_role) && !in_array($this->user_role, array('user', 'admin'))){
            $this->Auth->logout();
            $this->redirect('/');
        }
        
    }

    // ��y�[�W�Ǘ��̐ÓI�y�[�W�̏���
    function page($dir,$page,$param1 = null,$param2 = null,$param3 = null) {

        global $render_name;
        $this->render(null,null,$render_name);

    }

    function getTopicPath() {
/*
        global $slug;
        $this->loadModel('PageContents');
        return $this->PageContent->getTopicPath($slug," | ");
 *
 */

    }

    // ���[�����M���\�b�h
    protected function sendMail($mailData, $mailTo, $viewVars) {
        $Email = new CakeEmail();
        $Email->template($mailData['templete'])
            ->emailFormat('html')
            ->viewVars($viewVars)
            //->from(array(Configure::read('info.sendDomain') => 'fillmall'))
            ->from(array(Configure::read('info.sendDomain') => Configure::read('info.siteName')))
            ->to($mailTo)
            ->subject($mailData['subject'])
            ->send();
    }
}
