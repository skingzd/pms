<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{

	public function index(){
		if(!session('user')) $this->redirect('User/login',null,2,'即将转到登陆界面...');
		// $this->show('用户控制页面');
		$this->display();
	}

	public function checkLevel($level = 1){
		if(session('?user')) $user = session('user');
		if(!isset($user)) $this->redirect('User/login');
		$result = M('User')->field('u_level')->where("u_name='%s'",$user)->find();
		if($result['u_level'] < $level) $this->error('无权访问');
		$this->assign("user",$user);
		return $result['u_level'];
	}

	public function login(){
		// if(session('?user')) $this->redirect('Index/index');//防止重复登录
		if(!IS_POST){//无post数据则显示登录框
			$this->display();
			return false;
		}else{
			$name = I('post.name',fasle);
			$pwd  = I('post.pwd',false);

			$u   = M('User');
			$pwd = md5($pwd);
			$where['u_name'] = $name;
			$user = $u->where($where)->find();
			// dump($name,$pwd);
			if(!$user) $this->error('用户不存在');
			if( $pwd !== $user['u_pwd'] ) $this->error('密码错误');

			$result = $u->where($where)->setField('time_last_login',time());
			if(!$result) $this->error('登录失败');
			session('user',$user['u_name']);
			$this->redirect('Index/index');
		}
		
	}

	public function logout(){
		session('user',null);
		$this->checkLevel();
	}

	public function changePwd(){
		$this->checkLevel();
		if(IS_POST){
			$name   = session('user');
			$pwd    = I('post.password',false);
			$newPwd = I('post.newpassword',false);

			$u   = M('User');
			$pwd = md5($pwd);
			
			$where['u_name'] = $name;
			$where['u_pwd']  = $pwd;
			$check = $u->where($where)->find();
			if(!$check)$this->error('原始密码不正确');
			
			//执行密码修改
			$newPwd         = md5($newPwd);
			$data['u_name'] = $name;
			$data['u_pwd']  = $newPwd;
			$result = $u->data($data)->save();
			if(!$result) $this->error('修改密码失败');
			$this->success('修改成功','User/index',3);
		}
		$this->show('显示修改密码界面');
		
	}

	public function changeLevel($name){
		if(IS_POST){
			if( $this->checkLevel() < 7 ) $this->error('无权修改');

			$level = I('post.level',false);
			if($level >= $this->checkLevel()) $this->error('权限不得超过当前用户');

			$check = $u->where("u_name='%s'",$name)->setField('level',$level);
			if(!$check) $this->error('修改级别失败');
			$this->success('修改成功','User/index');
		}
		
	}

	public function addNew(){
		if( $this->checkLevel() < 7 ) $this->error('无权添加');
		$name = I('post.username',fasle);
		$pwd = I('post.password',false);
		$level = I('post.level',false);
		if($level >= $this->checkLevel()) $this->error('权限不得超过当前用户');
		// if( !$name || !$pwd ) $this->error('添加失败，数据不完整');
		//重复性检查
		$u = M('User');
		$check = $u->where("u_name='%s'",$name)->find();
		if($check) $this->error('用户名重复');

		$data['u_name'] = $name;
		$data['u_pwd'] = md5($pwd);
		$data['time_create'] = time();
		$data['level'] = $level;
		$result = $u->data($data)->add();
		if(!$result) $this->error('添加失败');
		$this->success('添加成功','User/index');
	}	
}
?>