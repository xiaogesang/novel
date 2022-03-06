<?php

namespace app\admin\controller;

class Novel extends PublicController {
    public function types() {
        if (isGets()) {
            $types = page('novel_types');
            $this->assign('lists', $types);
            return view();
        }
    }

    public function addtype() {
        if (isGets()) {
            return view();
        }
        if (isPosts()) {
            $post = I('post.');
            if (!$post['name']) {
                return $this->error('请输入分类名称！');
            }
            $post['status'] = 1;
            $ref = add('novel_types', $post);
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/types'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function updatetype($id) {
        if (isGets()) {
            $data = find('novel_types', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $this->assign('data', $data);
            return view();
        }
        if (isPosts()) {
            $post = I('post.');
            if (!$post['name']) {
                return $this->error('请输入分类名称！');
            }
            $ref = update('novel_types', "id = $id", $post);
            if ($ref > -1) {
                return $this->success('操作成功！', url('admin/novel/types'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function sable($id) {
        if (isGets()) {
            $data = find('novel_types', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            if ($data['status'] > 1) {
                $data['status'] = 1;
            } else {
                $data['status'] = 2;
            }
            $ref = update('novel_types', "id = $id", $data);
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/types'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function deletetype($id) {
        if (isGets()) {
            $data = find('novel_types', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $ref = delete('novel_types', "id = $id");
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/types'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function lists() {
        if (isGets()) {
            $lists = page('novel', "1=1", null, null, function ($val) {
                $tid = $val['types'];
                $types = find('novel_types', "id = $tid");
                if ($types) {
                    $val['types'] = $types['name'];
                } else {
                    $val['types'] = '未分类';
                }
                return $val;
            });
            $this->assign('lists', $lists);
            return view();
        }
    }

    public function add() {
        if (isGets()) {
            $types = findAll('novel_types');
            $this->assign('types', $types);
            return view();
        }
        if (isPosts()) {
            $post = I('post.');
            if (!$post['title'] || !$post['editor'] || !$post['types'] || !$post['intro'] || !$post['novel_status'] ||!$post['tags']||!$post['point']) {
                return $this->error('请完善基本信息！');
            }
            if (checkUpload('cover') != 1) {
                return $this->error('请上传封面图片！');
            } else {
                $post['cover'] = uploadFile('cover');
            }
            $post['add_time'] = now();
            $post['status'] = 1;
            $ref = add('novel', $post);
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/lists'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function update($id) {
        if (isGets()) {
            $data = find('novel', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $types = findAll('novel_types');
            $this->assign('types', $types);
            $this->assign('data', $data);
            return view();
        }
        if (isPosts()) {
            $post = I('post.');
            if (!$post['title'] || !$post['editor'] || !$post['types'] || !$post['intro'] || !$post['novel_status'] ||!$post['tags']||!$post['point']) {
                return $this->error('请完善基本信息！');
            }
            if (checkUpload('cover') != 1) {
                unset($post['cover']);
            } else {
                $post['cover'] = uploadFile('cover');
            }
            $post['add_time'] = now();
            $ref = update('novel', "id = $id", $post);
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/lists'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function status($id) {
        if (isGets()) {
            $data = find('novel', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $status = $data['status'];
            $temp['status'] = 0;
            if ($status == 2) {
                $temp['status'] = 1;
            } else {
                $temp['status'] = 2;
            }
            $ref = update('novel', "id = $id", array('status'=>$temp['status']));
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/lists'));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function novel_list($id) {
        if (isGets()) {
            $keywods = I('get.keywords');
            if (!$keywods) {
                $where = "pid = $id";
            } else {
                $where = "pid = $id AND `title` LIKE '%$keywods%'";
            }
            $data = find('novel', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $novel_list = page('novel_list', $where, "id asc");
            $this->assign('lists', $novel_list);
            $this->assign('data', $data);
            $this->assign('keywords', $keywods);
            return view();
        }
    }

    public function add_note($id) {
        if (isGets()) {
            $data = find('novel', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            return view();
        }
        if (isPosts()) {
            $post = I('post.');
            if (!$post['title'] || !$post['intro'] || !$post['content']) {
                return $this->error('请输入章节标题/内容！');
            }
            $post['pid'] = $id;
            $post['add_time'] = now();
            $post['status'] = 1;
            $ref = add('novel_list', $post);
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/novel_list', array('id' => $id)));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function update_note($id) {
        $data = find('novel_list', "id = $id");
        if (isGets()) {
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $this->assign('data', $data);
            return view();
        }
        if (isPosts()) {
            $post = I('post.');
            if (!$post['title'] || !$post['intro'] || !$post['content']) {
                return $this->error('请输入章节标题/内容！');
            }
            $post['add_time'] = now();
            $ref = update('novel_list', "id = $id", $post);
            if ($ref > 0) {
                return $this->success('操作成功！', url('admin/novel/novel_list', array('id' => $data['id'])));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function delete_note($id) {
        if (isGets()) {
            $data = find('novel_list', "id = $id");
            if (!$data) {
                return $this->error('数据不存在！');
            }
            $ref = delete('novel_list', "id = $id");
            if ($ref) {
                return $this->success('操作成功！', url('admin/novel/novel_list', array('id' => $data['id'])));
            } else {
                return $this->error('操作失败');
            }
        }
    }

    public function upload_book($id){
        if (isGets()){
            return view();
        }
        if (isPosts()){
            if (checkUpload("books")!=1){
                return $this->error('请上传文件！');
            }
            $post = I('post.');
            if (!$post['file_name']){
                return $this->error('请输入文件名称！');
            }
            else{
                $ref = uploadFile('books',$post['file_name']);
                return $this->redirect(url('admin/novel/update_txt',array('book_name'=>$post['file_name'],'pid'=>$id,"name_type"=>$post['book_type'],"title_type"=>$post['title_type'])));
//                if ($ref>0){
//                    return $this->success('操作成功！',url('admin/novel/lists'));
//                }
            }
        }
    }

    public function update_txt($book_name,$pid,$name_type,$title_type) {
        if (isGets()) {
            $url = ROOT_PATH . 'public' . DS . 'admin'. DS .'uploads'. DS . $book_name .'.txt';
            $file = file($url);
            // $file现在已经将小说内所有内容转成数组。
//            $max_length = 999;
//            $number = $this->number2chinese($max_length);
//            dump($number);
//            die;
            $nums = 1;
            $temp = [];
            foreach ($file as $key=>$val){
                if ($name_type!=1) {
                    $nums_ch = $this->number2chinese($nums);
                    if ($title_type==1){
                        $title = '第' . $nums_ch . '章';
                    }
                    else{
                        $title = '第' . $nums_ch . '节';
                    }
                }
                else{
                    if ($title_type==1) {
                        $title = '第' . $nums . '章';
                    }
                    else{
                        $title = '第' . $nums . '节';
                    }
                }
                if (strstr($val,$title)!=false) {
                    // 如果找到了标题
                    if ($nums>1){
                        //如果有title和content，且找到下一章的标题
                        $temp['content'] = implode(" ",$temp['content']);
                        $temp['intro'] = '';
                        $temp['pid'] = $pid;
                        $temp['add_time'] = now();
                        $temp['status'] = 1;
                        $ref = add('novel_list',$temp);
                        if ($ref>0){
                            $temp = [];
                            $temp['title'] = $val;
                            $temp['content'] = [];
                        }
                        else{
                            return $this->error($title."添加失败！");
                        }
                    }
                    else if ($nums==1){
                        $temp['title'] = $val;
                    }
                    $nums++;
                }
                else{
                    // 如果找到标题
                    if ($temp['title']) {
                        if (strlen($val)>3) {
                            $temp['content'][] = $val;
                        }
                    }
                }
//                dump($temp);
            }
            return $this->success('操作成功！',url('admin/novel/novel_list',['id'=>$pid]));
        }
        if (isPosts()) {
            return false;
        }
    }

    public function number2chinese($num) {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('', '十', '百', '千', '万', '亿', '十', '百', '千');
        $chiStr = '';
        $num_str = (string)$num;
        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字
        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num] . $chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        } else if ($count > 2) {
            $index = 0;
            for ($i = $count - 1; $i >= 0; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag) {
                        $chiStr = $chiNum[$temp_num] . $chiStr;
                        $last_flag = true;
                    }
                } else {
                    $chiStr = $chiNum[$temp_num] . $chiUni[$index % 9] . $chiStr;
                    $zero_flag = false;
                    $last_flag = false;
                }
                $index++;
            }
        } else {
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }
}
