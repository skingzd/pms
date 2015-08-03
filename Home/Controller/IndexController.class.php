<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $this->show('人员管理系统');
		if(!session('user')){
			echo "请登录";
			$this->redirect('User/login',null,5,'前往登录');
		}
		
    }
}