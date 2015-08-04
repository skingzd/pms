<?php
namespace Home\Controller;
use Think\Controller;

class TitleController extends Controller {
	private $levelIndex;

	public function index ($titleLevel = null, $titleType =null, $page = 1, $return = false){
		//未设置参数则跳转到欢迎界面显示统计
		if(!$titleLevel && !$titleType) $this->redirect('welcome');

		$t = M('Ttitle');
		$levelIndex = array('员级' => 1, '助理级' => 2, '中级' => 3, '高级' => 4, '教授级' => 5) ;
		$typeIndex = $t->distinct(true)->field('title_type')->select();//获得职称在库类别
	
		if( !in_array($titleType, $typeIndex) ) $this->error('错误职称类别');
		if( !array_key_exists($titleLevel, $levelIndex) ) $this->error('错误职称级别');
		//如果参数设置为ALL系列，则不设置该项查找条件，查找全部
		if($titleLevel != 'allLevel')	$where['level'] = $titleLevel;
		if($titleType != 'allType')		$where['type'] 	= $titleType;
		$where['status'] = 1;
		$order = array('level'=>'desc','type');

		$data = $t->where($where)->order($order)->page($page,50)->select();
		if(!$data) $data['_msg'] = '未找到任何数据';
		if($return) return $data;
		dump($data);
	}
	public function welcome(){
		//显示职称统计信息
		$t = M('Ttitle');
		$data['total']           = $t->count();
		$data['peopleHaveTitle'] = $t->count('pid');
		
		}
	}

	public function search($words){
		//搜索某个人或某个身份证号码
		if( (int)$words == 0 ){
			$where['name'] = $words;
		}else{
			$where['pid'] = strtoupper($words);
		}
		$where['status'] = 1;
		$t = M('Title');
		$data = $t->where($where)->select();
		if(!$data) $this->error('未找到任何数据');
		$data['_count'] = count($data);
		dump($data);
	}

	public function addnew($pid){
		//接受post添加新职称信息
		$p = M('People');
		$checkPeople = $p->where("pid='%s'",$pid)->find();
		if(!$checkPeople) $this->error('人员信息不存在，无法添加职称');

		if(I('post.pid',false)){
			//执行添加
			if( $checkPeople['pid'] != I('post.pid') ) $this->error('编辑人员与提交人员不符');
			$t = M('Title');
			$data = $t->create();
			$data['name'] = $checkPeople['name'];
			$data['pid'] = $checkPeople['pid'];
			$data['last_edit'] = session('user');
			$data['time_last_edit'] = time();

			$where['pid'] = $checkPeople['pid'];

			$result = $t->where($where)->save($data);
			if(!$result) $this->error('添加失败');
			$this->redirect('Title/',array('search'=>$checkPeople['pid']),3,'添加成功...');
		}
		//返回欲添加职称人员资料
		dump($checkPeople);
	}

	public function edit($tid){
		//编辑指定职称信息
        if( A('User')->checkLevel() < 3 ) $this->error('非法操作');
		if(!$tid) $this->error();
		$t = M('Title');
		$data = $t->create();
		$data['last_edit'] = session('user');
		$data['time_last_edit'] = time();

		$result = $t->where("tid = %d", $tid)->save($data);
		if(!$result) $this->error('修改失败');
		$this->redirect('Title/',array('search'=>$data['pid']),3,'修改成功...');
	}

	public function del($tid){
		// 删除指定职称信息
		if( A('User')->checkLevel() < 3 ) $this->error('非法操作');
		if(!$tid) $this->error();
		$t = M('Title');
		$result = $t->where("tid = %d", $tid)->setField('status',0);
		if(!$result) $this->error('删除失败');
		$this->success('删除成功','Title/index');
	}
	public function test($name){
		if(!$name) echo 'OK';
	}
}
?>