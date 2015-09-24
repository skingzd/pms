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
		if(!IS_POST) return false;
		A('User')->checkLevel(5);
		$d = D('Department');
		$dc = M('Department');
		$d->create();
		//名称重复性检查
		$where['dm_name'] = $d->dm_name;
		$check = $dc->where($where)->find();
		if($check) $this->ajaxReturn('单位名称已存在');
		//所属系统存在
		$checkParent['dm_id'] = $d->by_parent;
		$checkParent['status'] = 1;
		$check = $dc->where($checkParent)->find();
		if(!$check) $this->ajaxReturn('所属上级单位无效');
		//设置编辑记录
		
		//是否有子部门
		$d->is_parent = 0;
		//新建部门，不会有子部门
		//if($dc->where("by_parent = %s",$id)->find()) $d->is_parent = 1;
		//创建日期为空则设置null
		if($d->date_dm_setup == '') $d->date_dm_setup = null;
		$d->status = 1;
		$d->last_edit = session('user');
		$d->time_last_edit = time();
		$result = $d
				// ->fetchSql()
				->add();
		// $result ='新增失败';
		// if($d->add()) $result = '新增成功';
		$this->ajaxReturn($result);
	}

	public function edit($id){
		A('User')->checkLevel(5);
		if(IS_POST){
			$dc = M('Department');
			$d = D('Department');

			//创建数据
			if(!$d->create()) $this->ajaxReturn("无数据提交");
			// $d->create();

			if($d->date_dm_setup == '') $d->date_dm_setup = null;
			//是否有子部门
			$d->is_parent = 0;
			if($dc->where("by_parent = %s",$id)->find()) $d->is_parent = 1;

			$d->last_edit = session('user');
			$d->time_last_edit = time();
			$d->is_parent = 0;			

			

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
			// echo json_encode($result);
		}

	}

	public function del($id){
		A('User')->checkLevel(5);

		$d = M('Department');
		$isExist = $d->where("dm_id = %d and `status` = 1",$id)->find();
		if(!$isExist) $this->ajaxReturn('待删除部门不存在');
		//如果是删除系统，判断系统是否为空
		$isEmpty = $d->where("by_parent = '%d'",$id)->find();
		if($isEmpty) $this->ajaxReturn('删除失败，部门非空');

		$result = $d->where("`dm_id` = %d",$id)->setField('status',0);
		if($result == 1) $this->ajaxReturn("成功删除");
	}
}	
?>