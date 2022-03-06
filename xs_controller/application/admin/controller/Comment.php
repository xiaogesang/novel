<?php

namespace app\admin\controller;

class Comment extends PublicController {
    public function lists() {
        if (isGets()) {
            $lists = page('novel_comment', "1=1", null, null, function ($val) {
                $user_id = $val['user_id'];
                $user = find('user', "id = $user_id");
                if (!$user){
                    $val['user'] = '用户不存在';
                }
                else{
                    $val['user'] = '用户'.$user['phone'];
                }
                $pid = $val['pid'];
                $novel = find('novel',"id = $pid");
                if (!$novel){
                    $val['novel'] = '小说不存在';
                }
                else{
                    $val['novel'] = $novel['title'];
                }
                return $val;
            });
            $this->assign('lists',$lists);
            return view();
        }
    }

    public function disable($id){
        if (isGets()){
            $comment = $this->findComment($id);
            $novel_id = $comment['pid'];
            $this->findNovel($novel_id);
            $ref = update('novel_comment',"id = $id",array('status'=>2));
            if ($ref>0){
                return $this->success('操作成功！',url('admin/comment/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }

    public function enable($id){
        if (isGets()){
            $comment = $this->findComment($id);
            $novel_id = $comment['pid'];
            $this->findNovel($novel_id);
            $ref = update('novel_comment',"id = $id",array('status'=>1));
            if ($ref>0){
                return $this->success('操作成功！',url('admin/comment/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }

    private function findComment($id){
        $comment = find('novel_comment',"id = $id");
        if (!$comment){
            return $this->error('数据不存在！');
        }
        else{
            return $comment;
        }
    }

    private function findNovel($id){
        $novel = find('novel',"id = $id");
        if (!$novel){
            return $this->error('数据不存在！');
        }
    }
}