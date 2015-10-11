<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller{

	public function index(){
		if(!session('user')) $this->redirect('User/login',null,2,'即将转到登陆界面...');
		// $this->show('用户控制页面');
		$this->assign('ulevel',$this->checkLevel());
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

	public function addUser(){
		$this->checkLevel(5);
		$name = I('post.name',false);
		$pwd = I('post.pwd',false);
		$level = I('post.level',false);

		if($level >= $this->checkLevel()) $this->ajaxReturn('权限不得超过当前用户');
		if( !$name || !$pwd ) $this->ajaxReturn('添加失败，数据不完整');
		//重复性检查
		$u = M('User');
		$check = $u->where("u_name='%s'",$name)->find();
		if($check) $this->ajaxReturn('用户名重复');

		$data['u_name'] = $name;
		$data['u_pwd'] = md5($pwd);
		$data['time_create'] = time();
		$data['u_level'] = $level;
		$result = $u->data($data)->add();
		if(!$result) $this->ajaxReturn('添加失败');
		$this->ajaxReturn('添加成功');
	}

	public function listUser($page = 1, $ajax = true, $word = null){
		$level = $this->checkLevel();
		$u = M("User");
		$where['u_level'] = array("LT",$level);
		if($word) $where['u_name'] = array('LIKE','%'.$word.'%');
		$result = $u
				->field('u_id 			as i,
						u_name 			as n,
						u_level 		as l'
						)
				->where($where)
				// ->fetchSql()
				->page($page,3)
				->select();
		$count = $u->where($where)->count();
		//没有数据直接返回
		if(!$result) return $ajax ? $this->ajaxReturn('无匹配数据') : '无匹配数据';
		// dump($result);
		$data['r'] = $result;
		$data['_count'] = $count;

		return $ajax ? $this->ajaxReturn($data) : $data;
	}

	public function viewUser($uid ,$ajax = true){
		$level = $this->checkLevel();
		$u = M("User");
		$where['u_id'] = $uid;
		$result = $u
				->where($where)
				// ->fetchSql()
				->field('u_id 			as i,
						u_name 			as n,
						u_level 		as l,
						time_last_login	as t,
						time_create		as c'
						)
				->find();
		if($result['t'] > 100) $result['t'] = date("Y-m-d H:i:s", $result['t']); 
		if($result['c'] > 100) $result['c']  = date("Y-m-d H:i:s", $result['c']); 
		return $ajax ? $this->ajaxReturn($result) : $result;
	}


	public function saveUser($uid){
		if(IS_POST){
			$level = $this->checkLevel(7);
			$setLevel = (int) I('post.level',1);
			$setPwd	=	I('post.pwd',null);
			if($setLevel < 1 || $setLevel >9) $this->ajaxReturn('权限等级设置错误');
			if($level < $setLevel) $this->ajaxReturn('无权修改');
			if($setPwd != ''){
				if(strlen($setPwd) < 6 || strlen($setPwd) >16) $this->ajaxReturn('密码长度范围需在6-16位之间');
				$data['u_pwd'] = md5($setPwd);
			}
			
			
			$data['u_level'] = $setLevel;

			$u = M('User');
			$result = $u
					->where("u_id = '%d'",$uid)
					// ->fetchSql()
					->data($data)
					->save();
			if($result) $this->ajaxReturn('修改成功');
			$this->ajaxReturn('无任何修改');
		}		
	}
}
?>