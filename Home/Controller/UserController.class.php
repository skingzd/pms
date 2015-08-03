<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{

	public function index(){
		if(!session('user')) $this->redirect('User/login',null,2,'即将转到登陆界面...');
		$this->show('用户控制页面');
		$this->success('修改成功','User/all');
	}

	public function checkLevel($user){
		if(!$user) $user = session('user');
		if(!$user) return false;
		$u = M('User');
		$data = $u->where("u_name='%s'",$user)->select();
		if($data) return $data[0]['u_level'];
		return false;
	}

	public function login(){
		$name = I('post.username',fasle);
		$pwd = I('post.password',false);
		//测试
		$name = 'admin';
		$pwd = '123456';

		if( $name && $pwd ){
			
			$u = M('User');
			$where['u_name'] = $name;
			$pwd = md5($pwd);

			$user = $u->where($where)->find();
			if(!$user) $this->error('登录失败，用户不存在');
			if( $pwd != $user['u_pwd'] ) $this->error('登录失败，密码错误');

			$result = $u->where($where)->setField('time_last_login',time());
			if(!$result) $this->error('登录失败');

			session('user',$user['u_name']);
			$this->redirect('Index/index',null,2,'登录成功即将返回首页...');
		}else{
			echo '用户登录窗口';
		}
		
	}

	public function changePwd($name = null){
		
		$name = session('user');
		$pwd = I('post.password',false);
		$newPwd = I('post.newpassword',false);

		if( !$name || !$pwd )//检测到post数据则修改数据库记录
		$u = M('User');
		$pwd = md5($pwd);
		$newPwd = md5($newPwd);
		$where['u_name'] = $name;
		$where['u_pwd'] = $pwd;
		$check = $u->where($where)->find();
		if(!$check)$this->error('原始密码不正确');
		
		//执行密码修改
		$data['u_name'] = $name;
		$data['u_pwd'] =$newPwd;
		$result = $u->data($data)->save();
		if(!$result) $this->error('修改密码失败');
		$this->success('修改成功','User/index',3);
	}

	public function changeLevel($name){
		if( $this->checkLevel() < 7 ) $this->error('无权添加');
		$level = I('post.level',false);
		if($level > $this->checkLevel()) $this->error('权限不得超过自己');

		$check = $u->where("u_name='%s'",$name)->setField('level',$level);
		if(!$check) $this->error('修改级别失败');
		$this->success('修改成功','User/all');
	}

	public function addNew(){
		if( $this->checkLevel() < 7 ) $this->error('无权添加');
		$name = I('post.username',fasle);
		$pwd = I('post.password',false);
		$level = I('post.level',false);
		if($level > 9) $this->error('级别设置错误');
		if( !$name || !$pwd ) $this->error('添加失败，数据不完整');
		//重复性检查
		$u = M('User');
		$check = $u->where("u_name='%s'",$name)->find();
		if($check) $this->error('用户名重复');

		$pwd = md5($pwd);
		$data['u_name'] = $name;
		$data['u_pwd'] = $pwd;
		$data['time_create'] = time();
		$data['level'] = $level;
		$result = $u->data($data)->add();
		if(!$result) $this->error('添加失败');
		$this->success('添加成功','User/all');
	}

	public function all(){
		if( $this->checkLevel() < 7 ) $this->error('无权添加');
		$u = M('User');
		$data = $u->select();
		dump($data);
	}
}
?>