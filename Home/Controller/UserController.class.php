<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{

	public function checkLevel($user){
		if(!$user) $user = session('user');
		if(!$user) return false;
		$u = M('User');
		$data = $u->where("u_name='%s'",$user)->select();
		if($data) return $data[0]['u_level'];
		return false;
	}
}
?>