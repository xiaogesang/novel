<?php
namespace app\supply\controller;

use think\Controller;

class PublicController extends Controller{
    public function __construct(){
        parent::__construct();
        $this->check_login();
    }

    private function check_login(){
        $session = session('supply');
        if (!$session){
            return $this->success('请先登录！',url('supply/login/login'));
        }
    }
}