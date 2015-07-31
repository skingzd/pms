<?php
namespace Home\Controller;
use Think\Controller;
class TitleController extends Controller {
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
}
?>