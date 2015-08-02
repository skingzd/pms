<?php
namespace Home\Controller;
use Think\Controller;
class DepartmentController extends Controller{
	public function index(){
		$d = M('Department');
		$where['status'] = 1;
		$where['is_system'] =1;
		$system = $d->where($where)->order('dm_sort')->select();
		$where['is_system'] = 0;
		$dm = $d->where($where)->order('dm_sort')->select();

		foreach ($system as $sys_value) {//遍历系统
			$dmTree[$sys_value['dm_name']] = array();
			foreach ($dm as $dm_value) {//遍历单位
				if($dm_value['by_system'] == $sys_value['dm_id'])
					$dmTree[$sys_value['dm_name']][] = $dm_value;
			}
			$dmTree[$sys_value['dm_name']]['_count'] = count($dmTree[$sys_value['dm_name']]);
		}
		dump($dmTree);

	}
	public function search($words, $return = false){
		if(!$words) $this->error('参数错误');
		$d = M('Department');
		$where['status'] = 1;
		$where['is_system'] = 0;

		if( (int) $words ){ //如果关键字为数字则按照部门编号查找
			$where['dm_id'] = $words;
		}else{
			//关键词为字符串首先进行系统名称严格匹配
			$where['is_system'] = 1; 
			$where['dm_name'] = $words;
			$data = $d->where($where)->find();
			//匹配到对应系统名，则返回该系统下所有单位名
			if($data['is_system'] == 1){
				$where['is_system'] = 0;
				$where['by_system'] = $data['dm_id'];
				unset($where['dm_name']);
			}else{
				$where['is_system'] = 0;
				$where['dm_name'] = array('LIKE','%'.$words.'%');
			}
		}

		$data = $d->where($where)->select();
		if( !$data ) $this->error('未找到数据'); //都无法匹配时提示出错
		$data['_count'] = count($data);
		dump($data);
		if($return) return $data;

		
	}

	public function addnew(){
		if( A('User')->checkLevel() < 5 ) $this->error('非法操作');	//执行权限检查
		$d = M('Department');
		//名称重复性检查
		$check = $d->where("dm_name='%s'",I('post.dm_name'))->find();
		if($check) $this->error('单位名称已存在');
		//所属系统存在
		$check['dm_id'] = I('post.by_system');
		$check['is_system'] = 1;
		$check['status'] = 1;
		$check = $d->where($check)->find();
		if(!$check) $this->error('无所属系统');
		//创建数据
		$d->create();

		$d->status = 1;
		$d->last_edit = session('user');
		$d->time_last_edit = time();

		$d->add();
	}

	public function edit($id){
		if( A('User')->checkLevel() < 5 ) $this->error('非法操作');
		if(I('post.dm_name')){//如果传入post数据则更新相应记录
			$d = M('Department');
			$where['dm_id'] = I('post.dm_id');
			$d->create();

			$d->last_edit = session('user');
			$d->time_last_edit = time();

			$result = $d->where($where)->save();
			if(!$result) $this->error('编辑失败');
			$this->success('编辑成功','?s=/Department/search/'.I('post.dm_name'));
		}
		//返回指定id部门信息
		$d = M('Department');
		$data = $d->where("dm_id='%d'",$id)->find();
		if(!$data) $this->error('未找到数据');
		dump($data);

	}

	public function del($id){
		if( A('User')->checkLevel() < 5 ) $this->error('非法操作');

		$d = M('Department');
		//如果是删除系统，判断系统是否为空
		$isEmpty = $d->where("by_system = '%d'",$id)->find();
		if($isEmpty) $this->error('删除失败，系统非空');

		$result = $d->where("dm_id='%d'",$id)->setField('status',0);
		if(!$result) $this->error('删除失败');
		$this->success('删除成功','?s=/Department/');

	}
}	
?>