<?php
namespace Home\Controller;
use Think\Controller;
class DepartmentController extends Controller{

	public function index(){
		//部门管理首页
		echo '部门浏览、有权限则显示部门管理界面';
		A('User')->checkLevel();
		$dmTree = A('Common')->getDmTree(0);
		dump($dmTree);
	}

	public function search($words){
		A('User')->checkLevel(3);
		$d = M('Department');
		$where['status'] = 1;

		$where['dm_name'] = array('LIKE','%'.$words.'%');
		$data = $d->where($where)->select();

		if( !$data ) $this->error('未找到数据'); //都无法匹配时提示出错
		$data['_count'] = count($data);
		dump($data);
		return $data;		
	}

	public function addnew(){
		A('User')->checkLevel(5);
		$d = D('Department');
		//名称重复性检查
		$check = $d->where("dm_name='%s'",I('post.dm_name'))->find();
		if($check) $this->error('单位名称已存在');
		//所属系统存在
		$checkParent['dm_id'] = I('post.by_parent');
		$checkParent['status'] = 1;
		$check = $d->where($checkParent)->find();
		if(!$check) $this->error('所属上级单位无效');
		//创建数据
		$d->create();

		$d->status = 1;
		$d->last_edit = session('user');
		$d->time_last_edit = time();

		return $d->add();
	}

	public function edit($id){
		A('User')->checkLevel(5);
		if(1){
			$dc = M('Department');
			$d = D('Department');
			//查看是否有子部门
			
			$where['by_parent'] = $id;
			$haveChild = $dc->where($where)->find();
			unset($where);

			//创建数据
			// if(!$d->create()) $this->ajaxReturn("无数据提交");
			$d->create();
			// dump($d);
			$d->last_edit = session('user');
			$d->time_last_edit = time();
			$d->is_parent = 0;			
			if($haveChild) $d->is_parent = 1;
			
			// dump($data);

			$result = $d
					->where("dm_id = %s",$id)
					// ->fetchSql()
					->save();
			 
			if($result) {
				$result = '编辑成功';
			}else{
				$result = '编辑失败';
			}
			// dump($result);
			$this->ajaxReturn($result);
		}

	}

	public function del($id){
		A('User')->checkLevel(5);

		$d = M('Department');
		$isExist = $d->where("dm_id = %d and `status` = 1",$id)->find();
		if(!$isExist) $this->error('待删除部门不存在');
		//如果是删除系统，判断系统是否为空
		$isEmpty = $d->where("by_parent = '%d'",$id)->find();
		if($isEmpty) $this->error('删除失败，系统非空');

		$result = $d->where("`dm_id` = %d",$id)->setField('status',0);
		if($result == 1) $this->success("成功删除");
			
	}
}	
?>