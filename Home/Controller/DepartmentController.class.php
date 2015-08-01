<?php
namespace Home\Controller;
use Think\Controller;
class DepartmentController extends Controller{
	public function search($words, $type = 'name' ,$return ){
		if(!$words || strlen($words)>7) $this->error('参数错误');
		$d = M('Department');
		if($type == 'name')  $where['dm_words'] = array('LIKE','%'.$words.'%');
		if($type == 'system') $where['dm_system'] = array('LIKE','%'.$words.'%');
		if($type == 'id') $where['dm_id'] = $words;
		
		$data = $d->where($where)->select();
		if( !$data ) $this->error('未找到数据');
		$data['_count'] = count($data);
		$this->assign($data);
		if($return) return $data;
	}
}
?>