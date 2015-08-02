<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show('人员管理系统');
        session('user','Admin');

    }
}