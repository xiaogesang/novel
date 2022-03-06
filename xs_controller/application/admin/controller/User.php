<?php
namespace app\admin\controller;

class User extends PublicController{
    public function lists(){
        if(isGets()){
            $lists = page('user',"1=1",null,null,function($val){
               if ($val){
                   unset($val['password']);
               }
                return $val;
            });
            $this->assign('lists',$lists);
            return view();
        }
    }

    public function change($id){
        if (isGets()){
            $user = find('user',"id = $id");
            if (!$user){
                return $this->error('用户不存在！');
            }
            $status = $user['status'];
            if ($status>1){
                $data['status'] = 1;
            }
            else{
                $data['status'] = 2;
            }
            $ref = update('user',"id = $id",$data);
            if ($ref>0){
                return $this->success('操作成功！',url('admin/user/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }

    public function feedback(){
        if (isGets()) {
            $ref = page('feedback',"1=1",null,null,function($val){
                $user = find('user',"id = ".$val['user_id']);
                if ($user) {
                    $val['phone'] = $user['phone'];
                }
                else{
                    $val['phone'] = '用户已删除';
                }
                return $val;
            });
            $this->assign('lists',$ref);
            return view();
        }
    }
}