<?php
namespace app\admin\controller;

class Admin extends PublicController{
    public function lists(){
        if (isGets()){
            $ref = page('admin',"1=1",null,null,function($val){
               unset($val['password']);
                return $val;
            });
            $this->assign("lists",$ref);
            return view();
        }
    }

    public function add(){
        if (isGets()){
            return view();
        }
        if (isPosts()){
            $post = I('post.');
            if (!$post['user_name']){
                return $this->error('请输入管理员账号！');
            }
            $name = $post['user_name'];
            $check_user = find('admin',"`user_name` = '$name'");
            if ($check_user){
                return $this->error('用户已存在！');
            }
            if (!$post['password']||!$post['password2']){
                return $this->error('请输入密码！');
            }
            if ($post['password']!=$post['password2']){
                return $this->error('两次输入的密码不一致！');
            }
            unset($post['password2']);
            $post['password'] = md5($post['password']);
            $ref = add('admin',$post);
            if ($ref>0){
                return $this->success('操作成功！',url('admin/admin/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }

    public function update($id){
        if (isGets()){
            $data = find('admin',"id = $id");
            if (!$data){
                return $this->error('数据不存在！');
            }
            $this->assign('data',$data);
            return view();
        }
        if (isPosts()){
            $post = I('post.');
            if (!$post['user_name']){
                return $this->error('请输入管理员账号！');
            }
            $name = $post['user_name'];
            $check_user = find('admin',"`user_name` = '$name'");
            if ($check_user&&$check_user['id']!=$id){
                return $this->error('用户已存在！');
            }
            if (!$post['password']||!$post['password2']){
                unset($post['password']);
                unset($post['password2']);
            }
            elseif ($post['password']&&$post['password2']){
                if ($post['password']!=$post['password2']){
                    return $this->error('两次输入的密码不一致！');
                }
                else{
                    unset($post['password2']);
                    $post['password'] = md5($post['password']);
                }
            }
            else{
                return $this->error('两次输入的密码不一致！');
            }
            $ref = update('admin',"id = $id",$post);
            if ($ref>-1){
                return $this->success('操作成功！',url('admin/admin/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }

    public function delete($id){
        if (isGets()){
            $data = find('admin',"id = $id");
            if (!$data){
                return $this->error('数据不存在！');
            }
            $ref = delete('admin',"id = $id");
            if ($ref>0){
                return $this->success('操作成功！',url('admin/admin/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }
}