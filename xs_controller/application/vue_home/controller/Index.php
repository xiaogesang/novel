<?php

namespace app\vue_home\controller;
use think\Db;
class Index extends PublicController{
    public function index(){
        if (isGets()){
            $ref = select('novel',"status = 1");
            foreach ($ref as $key=>$val){
                $ref[$key]['cover'] = vueSrc($val['cover']);
            }
            return jok($ref);
        }
    }

    public function rank(){
        if (isGets()){
            $ref = select('novel',"status = 1","point desc");
            foreach ($ref as $key=>$val){
                $ref[$key]['cover'] = vueSrc($val['cover']);
            }
            return jok($ref);
        }
    }

    public function complete(){
        if (isGets()){
            $ref = select('novel',"novel_status = 2","id desc");
            foreach ($ref as $key=>$val){
                $ref[$key]['cover'] = vueSrc($val['cover']);
            }
            return jok($ref);
        }
    }

    public function new_book(){
        if (isGets()){
            $ref = select('novel',"status = 1","id desc");
            foreach ($ref as $key=>$val){
                $ref[$key]['cover'] = vueSrc($val['cover']);
            }
            return jok($ref);
        }
    }

    public function findBanner(){
        if (isGets()){
            $lists = select('banner',"1=1",null,"0,5");
            foreach ($lists as $key=>$val){
                $lists[$key]['imgs'] = vueSrc($val['imgs']);
            }
            return jok($lists);
        }
    }

    public function novel_info($id){
        if (isGets()){
            $data = find('novel',"id = $id");
            if (!$data){
                return jfaild('数据不存在！');
            }
            $data['cover'] = vueSrc($data['cover']);
            $end_novel_list = select('novel_list',"pid = $id","id desc","0,1");
            if ($end_novel_list){
                $data['end_novel_list'] = $end_novel_list[0];
            }
            else{
                $data['end_novel_list'] = null;
            }
            $start_novel_list = select('novel_list',"pid = $id","id asc","0,1");
            if ($start_novel_list){
                $data['start_novel_list'] = $start_novel_list[0];
            }
            else{
                $data['start_novel_list'] = null;
            }
            return jok($data);
        }
    }

    public function novel_list($id,$page=0){
        if (isGets()){
            $data = find('novel',"id = $id");
            if (!$data){
                return jfaild('数据不存在！');
            }
            $page = $page * 15;
            $novel_list = select('novel_list',"pid = $id","id desc","$page,15");
            return jok($novel_list);
        }
    }

    public function novel_detail($id){
        if (isGets()){
            $data = find('novel_list',"id = $id");
            if (!$data){
                return jfaild('数据异常，请重试！');
            }
            return jok($data);
        }
    }

    public function get_prev($id){
        if (isGets()){
            $data = select('novel_list',"id < $id","id desc","0,1");
            if (!$data){
                return jfaild('');
            }
            else{
                return jok($data[0]['id']);
            }
        }
    }

    public function get_next($id){
        if (isGets()){
            $data = select('novel_list',"id > $id","id asc","0,1");
            if (!$data){
                return jfaild('');
            }
            else{
                return jok($data[0]['id']);
            }
        }
    }

    public function novel_title($id,$page=0){
        if(isGets()){
            $page = $page*15;
            $lists = key_select('id,title',"novel_list","pid = $id","id asc","$page,15");
            return jok($lists);
        }
    }

    public function getComment($id){
        if (isGets()){
            $data = find('novel',"id = $id");
            if (!$data){
                return jfaild('数据异常，请重试！');
            }
            $commant = select('novel_comment',"pid = $id and status = 1","id desc","0,999");
            foreach ($commant as $key=>$val){
                $user_id = $val['user_id'];
                $user = find('user',"id = $user_id");
                if (!$user){
                    unset($commant[$key]);
                }
                else{
                    $commant[$key]['user'] = '用户'.$user['phone'];
                }
            }
            return jok($commant);
        }
    }

    public function cover_novel($user_id=0,$novel_id=0){
        if (isGets()){
            $user = find('user',"id = $user_id");
            if (!$user){
                return jfaild('用户不存在！');
            }
            $novel = find('novel',"id = $novel_id");
            if (!$novel){
                return jfaild('小说不存在！');
            }
            $has_cover = find('user_cover',"user_id = $user_id AND novel_id = $novel_id");
            if ($has_cover){
                return jfaild('已在书架中');
            }
            $data['user_id'] = $user_id;
            $data['novel_id'] = $novel_id;
            $data['add_time'] = now();
            $ref = add('user_cover',$data);
            if ($ref>0){
                return jok('添加成功！');
            }
            else{
                return jfaild('添加失败');
            }
        }
    }

    public function novel_types(){
        if (isGets()){
            $ref = select('novel_types',"status = 1","id desc","0,999");
            return jok($ref);
        }
    }

    public function novel_list_byType($types=0,$page=0){
        if (isGets()){
            if ($types<1){
                $where = "status = 1";
            }
            else{
                $where = "types = $types AND status = 1";
            }
            $page = $page * 10;
            $ref = select('novel',$where,"id desc","$page,10");
            if ($ref) {
                foreach ($ref as $key => $val) {
                    $cover = $val['cover'];
                    $cover = vueSrc($cover);
                    $ref[$key]['cover'] = $cover;
                }
            }
            return jok($ref);
        }
    }

   public function findUserCover($user_id=0){
           if (isGets()){
               if ($user_id<1){
                   return jfaild('请先登录！');
               }
               $has_user = find('user',"id = $user_id");
               if (!$has_user){
                   return jfaild('用户不存在！');
               }
               $cover = select('user_cover',"user_id = $user_id");
               $data = [];
               if ($cover){
                   foreach ($cover as $key=>$val){
                       $nid = $val['novel_id'];
                       $novel = find('novel',"id = $nid");
                       if ($novel) {
                           $novel['id'] = $val['novel_id'];
                           $novel['cover'] = vueSrc($novel['cover']);
                           $novel['cover_id'] = $val['id'];
                           $novel['status'] = $val['status'];
                           $data[] = $novel;
                       }
                   }
               }
               $webCover = $this->findWebCover($user_id);
               if ($webCover) {
                   foreach ($webCover as $key => $val) {
                       $novel = [];
                       $novel['id'] = $val['id'];
                       $novel['cover_id'] = $val['bookid'];
                       $novel['cover'] = $val['img'];
                       $novel['title'] = $val['name'];
                       $novel['intro'] = $val['intro'];
                       $novel['status'] = 2;
                       $data[] = $novel;
                   }
               }
               return jok($data);
           }
       }

    private function findWebCover($user_id){
        $webCover = select('novel_web_cover',"user_id = $user_id");
        return $webCover;
    }


    public function remove_cover($user_id=0,$cover_id=0,$status=0){
        if (isGets()){
            if ($user_id<1){
                return jfaild('请先登录！');
            }
            if ($status<1||$cover_id<1) {
                return jfaild('数据异常！');
            }
            $has_user = find('user',"id = $user_id");
            if (!$has_user){
                return jfaild('用户不存在！');
            }
            if ($status==1) {
                $has_cover = find('user_cover',"id = $cover_id");
                if (!$has_cover){
                    return jfaild('数据不存在！');
                }
                $ref = delete('user_cover',"id = $cover_id");    
            }
            elseif ($status==2) {
                $has_cover = find('novel_web_cover',"bookid = $cover_id");
                if (!$has_cover){
                    return jfaild('数据不存在！');
                }
                $ref = delete('novel_web_cover',"bookid = $cover_id");       
            }
            if ($ref){
                return jok('移除成功！');
            }
            else{
                return jfaild('移除失败');
            }
        }
    }

    public function user_comment(){
        if (isPosts()){
            $post = I('post.');
            if (!$post['user_id']||!$post['novel_id']||!$post['comment']){
                return jfaild('数据异常！');
            }
            $user_id = $post['user_id'];
            $novel_id = $post['novel_id'];
            $user = find('user',"id = $user_id");
            $novel = find('novel',"id = $novel_id");
            if (!$user || !$novel){
                return jfaild('数据异常！');
            }
            $data = [];
            $data['pid'] = $post['novel_id'];
            $data['user_id'] = $post['user_id'];
            $data['content'] = $post['comment'];
            $data['add_time'] = now();
            $data['status'] = 9;
            // status = 1,审核已通过；status=2，审核未通过；status=9，待审核
            $ref = add('novel_comment',$data);
            if ($ref>0){
                return jok('评价成功！审核后即可发布！');
            }
            else{
                return jfaild('数据异常！');
            }
        }
    }

    public function feedback(){
        if (isPosts()){
            $post = I('post.');
            if (!$post['content']||!$post['user_id']){
                return jfaild('请填写内容！');
            }
            $user_id = $post['user_id'];
            $user = find('user',"id = $user_id");
            if (!$user){
                return jfaild('数据异常！');
            }
            $post['add_time'] = now();
            $ref = add('feedback',$post);
            if ($ref>0){
                return jok('反馈成功！');
            }
            else{
                return jfaild('操作失败');
            }
        }
    }
	public function setHistory(){
	    if (isGets()){
			$post = I('get.');
			$post['add_time'] = now();
			$ref = add('history',$post);
			if ($ref>0){
	           return jok('记录成功！');
			}
			else{
	           return jfaild('记录失败');
	       }
	    }
	}
	
	public function gethistroylist(){
	    if (isGets()){
			$post = I('get.');
			$ref = Db::name('history')->where('userId',$post['userId'])->order('id desc')->select();
			return jok( $ref);
			
	    }
	}
	public function setBookInfo(){
	    if (isPosts()){
			$post = I('post.');
			// $ref = Db::name('bookdetai')->where('id',$post['id'])->find();
			$ref = Db::name('bookdetail')->where('id',$post['id'])->find();
			if(!$ref){
				$ref = add('bookdetail',$post);
				return jok('数据不存在,已经创建成功');
			}else{
				return jok('小说数据已存在');
			}
	    }
	}
	public function getBookInfo(){
	    if (isPosts()){
			$post = I('post.');
			// $ref = Db::name('bookdetai')->where('id',$post['id'])->find();
			$ref = Db::name('bookdetail')->where('id',$post['id'])->find();
			if(!$ref){
				return jok('数据不存在');
			}else{
				return jok($ref);
			}
	    }
	}
}