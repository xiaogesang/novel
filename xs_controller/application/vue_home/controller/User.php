<?php
namespace app\vue_home\controller;

class User extends PublicController{
    public function update(){
        if (isPosts()){
            $post = I('post.');
            if (!$post['user_id']||!$post['old_password']||!$post['new_password']||!$post['new_password2']){
                return jfaild('输入的数据有误！');
            }
            $user_id = $post['user_id'];
            $user = find('user',"id = $user_id");
            if (!$user){
                return jfaild('用户不存在！');
            }
            $old_password = $post['old_password'];
            if ($user['password']!=md5($old_password)){
                return jfaild('密码不正确！');
            }
            if ($post['new_password']!=$post['new_password2']){
                return jfaild('两次输入的密码不一致！');
            }
            $ref = update('user',"id = $user_id",array('password'=>md5($post['new_password'])));
            if ($ref>-1){
                return jok('操作成功！');
            }
            else{
                return jfaild('操作失败');
            }
        }
    }
}