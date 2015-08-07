<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{

	public function checkLevel($level = 1){
		if(session('?user')) $user = session('user');
		if(!isset($user)) $this->redirect('User/login');
		$u = M('User');
		$result = $u->where("u_name='%s'",$user)->find();
		if($result['u_level'] < $level) $this->error('无权访问');
	}

	public function getLevel($user){
		if(!$user) $user = session('user');
		if(!$user) return false;
		$u = M('User');
		$data = $u->where("u_name='%s'",$user)->select();
		if($data) return $data[0]['u_level'];
		return false;
	}
	public function login(){
		session('user','Admin');
	}
	public function logout(){
		session('user',null);
	}
}
?>