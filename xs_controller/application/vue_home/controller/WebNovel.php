<?php
namespace app\vue_home\controller;

class WebNovel extends PublicController{
	public function find_common($id){
		if (isGets()) {
			if (!$id) {
				return jfaild('数据异常！');
			}
			$ref = select('novel_comment',"status = 3 AND pid = $id");
			return jok($ref);
		}
	}

	public function add_cover(){
		if (isPosts()) {
			$post = I('post.');
			if (!$post['user_id']||!$post['bookid']) {
				return jfaild('请先登录！');
			}
			$user_id = $post['user_id'];
			$bookid = $post['bookid'];
			$ref = find('user_cover',"user_id = $user_id AND novel_id = $bookid");
			if ($ref) {
				return jok('该小说已在您的书架中！');
			}
			else{
				$ref = add('user_cover',array('user_id'=>$user_id,'novel_id'=>$bookid,'add_time'=>now(),'status'=>2));
				$data['name'] = $post['name'];
				$data['author'] = $post['author'];
				$data['img'] = $post['img'];
				$data['bookid'] = $post['bookid'];
				$data['intro'] = $post['intro'];
				$data['user_id'] = $post['user_id'];
				$data['add_time'] = now();
				$res = find('novel_web_cover',"bookid = ".$data['bookid']);
				if (!$res) {
					$red = add('novel_web_cover',$data);
				}
				if ($ref>0) {
					return jok('添加成功！');
				}
				else{
					return jfaild('添加失败');
				}
			}
		}
	}
}