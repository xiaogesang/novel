<?php
namespace app\vue_home\controller;
header('Access-Control-Allow-Origin: *');
class Login extends PublicController{
    public function login(){
        if (isPosts()){
            $post = I('post.');
            if (!$post['phone']||!$post['password']){
                return jfaild('请输入手机号或密码！');
            }
            $phone = $post['phone'];
            $user = find('user',"phone = $phone");
            if (!$user){
                return jfaild('用户不存在！');
            }
            $password = md5($post['password']);
            if ($user['password']!=$password){
                return jfaild('密码不正确！');
            }
            $id = $user['id'];
            return jok($id);
        }
    }
    public function register(){
        if (isPosts()){
            $post = I('post.');
            if (!$post['phone']||!$post['password']||!$post['password2']){
                return jfaild('请输入手机号或密码！');
            }
            if ($post['password']!=$post['password2']){
                return jfaild('两次输入的密码不一致！');
            }
            $phone = $post['phone'];
            $temp = find('user',"phone = $phone");
            if ($temp){
                return jfaild('手机号已被注册！');
            }
            unset($post['password2']);
            $post['password'] = md5($post['password']);
            $post['add_time'] = now();
            $post['status'] = 1;
            $ref = add('user',$post);
            if ($ref>0){
                return jok($ref);
            }
            else{
                return jfaild('注册失败，请重试！');
            }
        }
    }
}