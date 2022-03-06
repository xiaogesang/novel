<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
use think\Db;

error_reporting(E_ERROR | E_WARNING | E_PARSE);

define('prefix','x_');

function find($table,$where){ //查询单条数据
    $ref = Db::name($table)->where($where)->order('id desc')->find();
    return $ref;
}
function select($table,$where="1=1",$order="id desc",$limit=null){ //查询多条数据
    $ref = Db::name($table)->where($where)->order($order)->limit($limit)->select();
    return $ref;
}
function key_select($select="*",$table,$where="1=1",$order="id desc",$limit=null){
    $table = prefix.$table;
    $sql = "select $select from $table where $where order by $order";
    if ($limit) {
        $sql .= " limit $limit";
    }
    $ref = Db::query($sql);
    return $ref;
}

function page($table,$where="1=1",$order="id desc",$nums="10",$function='false'){ //分页查询并输出
    if ($function == 'false') {
        $ref = Db::name($table)->where($where)->order($order)->paginate($nums);
    }
    else{
        $ref = Db::name($table)->where($where)->order($order)->paginate($nums)->each($function);
    }
    return $ref;
}
function delete($table,$where){ //删除
    $ref = Db::name($table)->where($where)->delete();
    return $ref;
}
function update($table,$where,$data){ //修改
    $ref = Db::name($table)->where($where)->update($data);
    return $ref;
}
function add($table,$data){
    $ref = Db::name($table)->strict(true)->insertGetId($data);
    return $ref;
}

function isGets(){
    if (request()->isGet()){
        return 1;
    }
    else{
        return 0;
    }
}
function isPosts(){
    if (request()->isPost()) {
        return 1;
    }
    else{
        return 0;
    }
}

function findAll($table,$order="id desc"){
    $ref = Db::name($table)->where('1=1')->order($order)->select();
    return $ref;
}

function getCandA(){
    $controller = request()->controller();
    $action = request()->action();
    return array('controller'=>$controller,'action'=>$action);
}

function I($input){
    $ref = input($input);
    return $ref;
}


function now(){
    $now = date('Y-m-d H:i:s');
    return $now;
}

function checkUpload($inputName){
     $file = request()->file($inputName);
     if (!$file) {
         return 2;
     }
     else{
        return 1;
     }
}

function uploadFile($inputName,$inputFileName=''){
    // 获取表单上传文件 例如上传了001.jpg
    $file = request()->file($inputName);
    if (!$inputFileName) {
        $inputFileName = md5(now().rand(0,99));
    }
    // 移动到框架应用根目录/public/uploads/ 目录下
    if($file){
        $info = $file->move( ROOT_PATH . 'public' . DS . 'admin/uploads',$inputFileName);
        if($info){
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            return '/admin/uploads/'.$info->getFilename(); 
        }else{
            // 上传失败获取错误信息
            return $file->getError();
        }
    }
}

function uploadImgs($InputName){
    $files = request()->file($InputName);
    $src = [];
    foreach($files as $file){
        $fileName = md5(date('YmdHis').rand(0,999));
        $info = $file->move(ROOT_PATH . 'public' . DS . 'admin/uploads',$fileName);
        if($info){
            $src[] = '/admin/uploads/'.$info->getFilename();
        }else{
            return $file->getError();
        }    
    }
    return $src;
}

function keyword_search($table,$where="1=1",$order="id desc",$limit="0,9999",$keyword){
    $ref = Db::name($table)->where($where)->order($order)->limit($limit)->value($keyword);
    return $ref;
}

function counts($table,$where="1=1"){
    $ref = Db::name($table)->where($where)->count();
    return $ref;
}

function getMin($table,$key){
    $ref = Db::name($table)->min($key);
    return $ref;
}

function faild($info){
    $data = array('status'=>'n','info'=>$info);
    return $data;
}

function ok($info){
    $data = array('status'=>'y','info'=>$info);
    return $data;
}
function vueSrc($src){
    $src = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$src;
    return $src;
}

function sql_search($sql){
    $ref = Db::query($sql);
    return $ref;
}

function jok($msg){
    $msg = json(ok($msg));
    return $msg;
}

function jfaild($msg){
    $msg = json(faild($msg));
    return $msg;
}

