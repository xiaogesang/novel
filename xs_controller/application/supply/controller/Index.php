<?php
namespace app\supply\controller;

class Index extends PublicController{
    public function index(){
        if (isGets()){
            return view();
        }
    }
}