<?php
namespace app\admin\controller;

use think\Controller;

class PublicController extends Controller{
    public function __construct() {
        parent::__construct();
        $this->check_login();
    }

    public function check_login(){
        $session = session('user');
        if (!$session){
           return $this->success('请先登录！',url('admin/login/login'));
        }
        else{
            $temp = getCandA();
            $this->assign('controller',$temp['controller']);
            $this->assign("action",$temp['action']);
        }
    }
}