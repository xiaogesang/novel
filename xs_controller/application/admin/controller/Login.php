<?php
namespace app\admin\controller;

use think\Controller;

class Login extends Controller {
    public function login(){
        if (isGets()){
            return view();
        }
        if (isPosts()){
            $post = I('post.');
            $user_name = $post['user_name'];
            if (!$user_name){
                return $this->error('请输入用户名！');
            }
            $user = find('admin',"`user_name` = '$user_name'");
            if (!$user){
                return $this->error('账号不存在！');
            }
            $password = $post['password'];
            if (!$password){
                return $this->error('请输入密码！');
            }
            $password = md5($password);
            if ($password!=$user['password']){
                return $this->error('密码不正确！');
            }
            session('user',$user['id']);
            return $this->redirect(url('admin/index/index'));
        }
    }
}