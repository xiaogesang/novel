<?php
namespace app\admin\controller;

class Index extends PublicController{
    public function index(){
        if (isGets()){
            return view();
        }
    }
}