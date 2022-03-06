<?php
namespace app\vue_home\controller;

use think\Controller;

class PublicController extends Controller{
    public function __construct() {
        parent::__construct();
        $this->header();
    }

    public function header(){
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: content-type");
    }

}