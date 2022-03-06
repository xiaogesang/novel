<?php
namespace app\supply\controller;

class Merchant extends PublicController{
    public function lists(){
        if (isGets()){
            $keywords = I('get.keywords');
            if (!$keywords){
                $where = "1=1";
            }
            else{
                $where = "`merchant_name` LIKE '%$keywords%'";
            }
            $ref = page('merchant',$where);
            $this->assign('keywords',$keywords);
            $this->assign('lists',$ref);
            return view();
        }
    }

    public function add(){
        if (isGets()){
            return view();
        }
    }

    public function update($id){
        if (isGets()){
            $data = find('merchant',"id = $id");
            if (!$data){
                return $this->error('商家信息不存在！');
            }
            $this->assign('data',$data);
            return view();
        }
        if (isPosts()){
            $post = I('post.');
        }
    }

    public function delete($id){
        if (isGets()){
            $data = find('merchant',"id = $id");
            if (!$data){
                return $this->error('商家信息不存在!');
            }
            $ref = delete('merchant',"id = $id");
            if ($ref){
                return $this->success('操作成功！',url('supply/merchant/lists'));
            }
            else{
                return $this->error('操作失败');
            }
        }
    }

    public function disabele($id){
        if (isGets()){
            $data = find('merchant',"id = $id");
            if(!$data){
                return $this->error('数据不存在！');
            }
            else{
                $status = $data['status'];
                switch ($status){
                    case 1:
                        $data['status'] = 2;
                        break;
                    case 2:
                        $data['status'] = 1;
                        break;
                }
                $ref = update('merchant',"id = $id",$data);
                if ($ref>0){
                    return $this->success('操作成功！',url('supply/merchant/lists'));
                }
                else{
                    return $this->error('操作失败');
                }
            }
        }
    }
}