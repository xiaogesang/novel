<?php
namespace app\supply\controller;

use think\Controller;

class Login extends Controller{
    public function login(){
        if (isGets()){
            return view();
        }
        if (isPosts()){
            $post = I('post.');
            $name = $post['phone'];
            $ref = find('supply',"`phone` = '$name'");
            if (!$ref){
                return $this->error('用户不存在！');
            }
            $password = md5($post['password']);
            if ($password!=$ref['password']){
                return $this->error('密码不正确！');
            }
            session('supply',$ref['id']);
            return $this->redirect(url('supply/index/index'));
        }
    }
}