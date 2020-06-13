<?php
App::uses('AppController', 'Controller');

class BulletinBoardController extends AppController
{

    public $uses = array('Message');

    public function index()
    {
        $pgnum = Hash::get($this->request->query, 'pg');

        $arrSearchParam = array('order_id' => null);

        if (empty($pgnum)) {
            $this->Session->write('arrSearchParam', $arrSearchParam);
        }

        if ($this->request->is('post')) {
            $arrSearchParam = $this->request->data['SearchParam'];
            $this->Session->write('arrSearchParam', $arrSearchParam);
        } else {
            $arrSearchParam = $this->Session->read('arrSearchParam');
        }
        $this->set('arrSearchParam', $arrSearchParam);

        // 条件表示
        $strSearchParam = null;
        $this->set('strSearchParam', $strSearchParam);

        $disp_num = 15;
        $this->Message->setWhereVal($arrSearchParam);
        $arrDatas = $this->Message->getPagingEntity($disp_num, $pgnum);
        $this->set('arrData', $arrDatas);
        $url = '/order/index/?';
        $this->set('url', $url);
    }
}
