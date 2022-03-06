<?php
namespace app\admin\controller;

class Banner extends PublicController{
    public function lists(){
        if (isGets()){
            $lists = page('banner',"1=1",null,null,function($val){
                $title = find('novel',"id = ".$val['nid']);
                if ($title){
                    $val['title'] = $title['title'];
                }
                else{
                    $val['title'] = '小说已删除';
                }
                return $val;
            });
            $this->assign('lists',$lists);
            return view();
        }
    }

    public function add(){
        if (isGets()){
            $lists = key_select("id,title","novel");
            $this->assign('novel_list',$lists);
            return view();
        }
        if (isPosts()){
            $post = I('post.');
            if (checkUpload('imgs')!=1){
                return $this->error('请上传轮播图！');
            }
            if (!$post['nid']){
                return $this->error('请选择小说！');
            }
            $post['imgs'] = uploadFile('imgs');
            $ref = add('banner',$post);
            if ($ref>0){
                return $this->success('操作成功！',url('admin/banner/lists'));
            }
            else{
                return $this->error('操作失败，请重试！');
            }
        }
    }

    public function update($id){
        if (isGets()){
            $data = find('banner',"id = $id");
            if (!$data){
                return $this->error('数据不存在！');
            }
            $lists = key_select("id,title","novel");
            $this->assign('novel_list',$lists);
            $this->assign('data',$data);
            return view();
        }
        if (isPosts()){
            $post = I('post.');
            if (checkUpload('imgs')!=1){
                unset($post['imgs']);
            }
            else{
                $post['imgs'] = uploadFile('imgs');
            }
            if (!$post['nid']){
                return $this->error('请选择小说！');
            }
            $ref = update('banner',"id = $id",$post);
            if ($ref>-1){
                return $this->success('操作成功！',url('admin/banner/lists'));
            }
            else{
                return $this->error('操作失败，请重试！');
            }
        }
    }

    public function delete($id){
        if (isGets()){
            $data = find('banner',"id = $id");
            if (!$data){
                return $this->error('数据不存在！');
            }
            $ref = delete('banner',"id = $id");
            if (!$ref){
                return $this->error('操作失败，请重试！');
            }
            else{
                return $this->success('操作成功！',url('admin/banner/lists'));
            }
        }
    }
}