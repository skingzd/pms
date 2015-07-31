<?php
namespace Home\Controller;
use Think\Controller;
class TitleController extends Controller {
	//Search For single person title info
	public function search($words,$return){
		if(!$words) $this->error('错误参数');
		//以人名查找
		if(strlen($words)<5){
			$t = M('Tilte');
			$where['name'] = array('LIKE','%'.$words.'%');
			$data = $t->where($where)->select();

			if(!$data) $this->error('未找到数据');
			$data['_count'] = count($data);
			if($return) return $data;
			$this->assign($data);
		}

		//以身份证号码查找
		if(strlen($words)<20){
			$t = M('Tilte');
			$data = $t->where('pid=%s',$words)->select();

			if(!$data) $this->error('未找到数据');
			$data['_count'] = count($data);
			if($return) return $data;
			$this->assign($data);
		}

		$this->error('未找到数据');
	}
	//list all title_name or all level
	public function index($title,$level,$page=1){
		//设置级别对应查找值
		$levelIndex=array(
			'员级' => 1,
			'助理级' => 2,
			'中级' => 3,
			'高级' => 4,
			'教授级' =>5
			);
		// 第一参数为level则只进行级别查找
		if($title != 'level')			$where['title_name'] = array('LIKE','%'.$title.'%');
		if(isset($levelIndex[$level]))	$where['level'] = $levelIndex[$level];
		$t = M('Tilte');
		$data = $t->where($where)->page($page,25)->select();
		if(!$data) $this->error('未找到数据');
		$data['_count'] = count($data);
		$this->assign($data);
	}

	public function addnew(){
		//接受post添加新职称信息
	}

	public function edit($tid){
		//编辑指定职称信息
	}

	public function del($tid){
		// 删除指定职称信息
	}
}
?>