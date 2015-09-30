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
			$name = trim(I('post.name',fasle));
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
			$pwd    = I('post.oldPwd',false);
			$newPwd = I('post.newPwd',false);

			$u   = M('User');
			$pwd = md5($pwd);
			
			$where['u_name'] = $name;
			$where['u_pwd']  = $pwd;
			$check = $u
					// ->fetchSql()
					->where($where)
					->find();
			if(!$check) $this->ajaxReturn('原始密码不正确');
			// $this->ajaxReturn($check);
			
			//执行密码修改
			$newPwd         = md5($newPwd);
			$data['u_pwd']  = $newPwd;
			$result = $u
					->where("u_name = '%s'",$name)
					->data($data)
					// ->fetchSql()
					->save();
			// $this->ajaxReturn($result);
			if(!$result) $this->ajaxReturn('修改密码失败');
			$this->ajaxReturn('修改成功');
		}		
	}

	public function changeLevel($name){
		if(IS_POST){
			$this->checkLevel(7);

			$level = I('post.level',false);
			if($level >= $this->checkLevel()) $this->error('权限不得超过当前用户');

			$check = $u->where("u_name='%s'",$name)->setField('level',$level);
			if(!$check) $this->error('修改级别失败');
			$this->success('修改成功','User/index');
		}
		
	}

	public function addNew(){
		$this->checkLevel(7);
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
	public function listUser($page = 1, $ajax = false){
		$level = $this->checkLevel();
		$u = M("User");
		$where['u_level'] = array("LT",$level);
		$result = $u
				->field('u_id 			as i,
						u_name 			as n,
						u_level 		as l,
						time_last_login as t,
						time_create 	as c'
						)
				->where($where)
				// ->fetchSql()
				->page($page,10)
				->select();
		//没有数据直接返回
		if(!$result) return $ajax ? json_encode(false) : false;
		foreach ($result as $key => $value) {
			$result[$key]['t'] = date("Y-m-d H:i:s", $value['t']); 
			$result[$key]['c'] = date("Y-m-d H:i:s", $value['c']); 
		}
		// dump($result);

		return $ajax ? $this->ajaxReturn($result) : $result;
	}
}
?>