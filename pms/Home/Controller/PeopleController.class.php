<?php
namespace Home\Controller;
use Think\Controller;
Class PeopleController extends Controller{
	public function view($pid = null){
		A('User')->checkLevel();

		$this->assign('pid',$pid);
		$this->display('viewpeople');
	}

	public function addNew(){
		A('User')->checkLevel(5);

		$this->assign('pid','newadd');
		$this->display('viewpeople');
	}
}