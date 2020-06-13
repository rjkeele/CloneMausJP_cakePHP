<?php
class MagazineController extends AppController {

    public $uses = array('Member');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        if ($this->request->is('post') && !empty($this->request->data['subject']) && !empty($this->request->data['body'])) {
            $options = array('fields' => array('email'), 'conditions' => array('role' => 'user'));
            if ($this->request->data['type'] == 1) {
                //希望のみ
                $options['conditions']['mailmag_flg'] = 1;
            }
            $list = $this->Member->find('list', $options);
            foreach ($list as $email) {
                $this->sendMail($this->request->data['subject'], $this->request->data['body'], $email);

            }
        }
    }
}