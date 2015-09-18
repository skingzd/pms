<?php
namespace Home\Controller;
use Think\Controller;
Class CommonController extends Controller{
	public $ItemIndex = array(
		'baseinfo'	=>	array('table'=>'People','key'=>'pid'),
		'edu'		=>	array('table'=>'Education','key'=>'edu_id'),
		'title'		=>	array('table'=>'Title','key'=>'t_id'),
		'trans'		=>	array('table'=>'Transfer','key'=>'trans_id'),
	);
	
	public function getSearch($item, $words, $ajax = false){
		A('User')->checkLevel();
		$m = M($this->ItemIndex[$item]['table']);
		$where['status'] = 1;
		if(strlen($words)<15){//关键词大于15则按照ID查找
			$where['name'] = array('LIKE',"%$words%");
			$result = $m->where($where)->select();
			if($ajax) $this->ajaxReturn($result);
			dump($result);
			return $result;
		}
		//长度超过人名则身份证匹配
		$where['pid'] = $words;
		$result = $m->where($where)->select();
		// dump($result);
		if($ajax) $this->ajaxReturn($result);
		return $result;
	}
	/**
	 * [getRecord get one record already know the type's !*ID*!]
	 * @param  [type]  $item [what kind do you want search for]
	 * @param  [type]  $id   [the id you given]
	 * @param  boolean $ajax [return ajax?]
	 * @return [type]        [search result]
	 */
	public function getRecord($item, $id, $ajax = false){
		A('User')->checkLevel();
		$m = M($this->ItemIndex[$item]['table']);
		$where['status'] = 1;
		$where[$this->ItemIndex[$item]['key']] =$id;
		$result = $m
				->where($where)
				// ->fetchSql()
				->find();
		// dump($result);
		if($ajax) $this->ajaxReturn($result);
		return $result;
	}

	public function addRecord($item, $ajax = false){
		//检查权限
		A('User')->checkLevel(3);
		if(!IS_POST) $this->redirect("Index/index");
		$m = M( $this->ItemIndex[$item]['table'] );
		$data = $m->create();
		$data['last_edit'] = session('user');
		$data['time_last_edit'] = time();
		$resultId = $m->add($data);
		if($ajax) $this->ajaxReturn($resultId);
		return $resultId;
	}

	public function editRecord($item, $id, $ajax = false){
		A('User')->checkLevel(3);
		$m = M($this->ItemIndex[$item]['table']);//初始化对应表的模型
		//如果传入POST数据则进行数据库操作修改
		if(IS_POST){
			$data = $m -> create();
			unset($data['pid']);//不更新PID
			unset($data['name']);//不更新NAME
			unset($data[$this->ItemIndex[$item]['key']]);//不更新KEY

			$data['last_edit'] = session('user');
			$data['time_last_edit'] = time();
			$where[$this->ItemIndex[$item]['key']] = $id;

			//表存在*_level_top列时
			$topColumn = $item.'_level_top';
			//设置人员最高级别则平掉其他记录
			if($data[$topColumn] = 1){
				$orign = $m->where($where)->find();
				$updateMap['pid'] = $orign['pid'];
				$updateMap[$topColumn] = 1;
				$m->where($updateMap)->setField($topColumn,0);
			} 

			$result = $m->where($where)->save();
			$result['_msg']='修改成功';
			if(!$result) $result['_msg']='修改失败';
			if($ajax) $this->ajaxReturn($result);
			return $result;
		}
	}

	public function delRecord($item, $id, $ajax = false){
		A('User')->checkLevel(3);
		$m = M($this->ItemIndex[$item]['table']);
		//如果传入POST数据则进行数据库操作修改
		if(IS_POST){
			$where[$this->ItemIndex[$item]['key']] = $id;
			$result = $m->where($where)->setField('status',0);
			$result['_msg']='删除成功';
			if(!$result) $result['_msg']='删除失败';
			if($ajax) $this->ajaxReturn($result);
			return $result;
		}
	}

	public function getDm($id = 0, $getChild = false, $ajax = false){
		A('User')->checkLevel();
		//返回单个部门 dm_id => dm_name
		$d = M('Department');
		$where['status'] = 1;
				
		// $result = $d->field('dm_id,dm_name')->order('dm_sort')->where($where)->select();
		// foreach ($result as $value)	$dm[$value['dm_id']] = $value['dm_name'];
	
		if($getChild){//判定是否返回子部门列表
			$where['by_parent'] = $id;
			$result = $d
						->field('dm_id,dm_name,is_parent')
						->order('dm_sort')
						->where($where)
						->select();
			foreach ($result as $value){
				$dm[$value['dm_id']]['n'] = $value['dm_name'];
				$dm[$value['dm_id']]['is_p'] = $value['is_parent'];
			}
		}else{
			//返回单个dm_id => dm_name
			$where['dm_id'] = $id;
			$result = $d
					->field('dm_id,dm_name,is_parent,by_parent,date_dm_setup,comment')
					->where($where)
					->find();
			$dm["n"] = $result["dm_name"];
			$dm["is_p"] = $result["is_parent"];
			$dm["by_p"] = $result["by_parent"];
			$dm["date_setup"] = $result["date_setup"];
			$dm["comment"] = $result["comment"];

			//查询父部门
			$where['dm_id'] = $result['by_parent'];
			$parent = $d 
					-> field('dm_id,dm_name')
					-> where($where)
					// -> fetchSql()
					-> find();
			$dm['p'] = $parent['dm_name'];
			$dm['by_p'] = $parent['dm_id'];
			// dump($dm);
		}
		if($ajax) $this->ajaxReturn($dm);
		return $dm;
	}

	public function getDmP($id = '0', $includeChild = false, $page = 1, $ajax = false)
	{
		$p = M("People");
		$where['status'] = 1;
		$where["dm_id"] = $id;
		$field = "pid,name,sex,birthday,date_startwork,dm_id,post,post_level";
		$postLevelIndex = A("Index")->postLevelIndex;
		//页码设置出错则直接跳出
		if($page < 1) $data['_msg'] = "页码错误";

		if($includeChild){
		//遍历子部门，包含子部门所有人员

		}else{
		//只查询当前部门
			$resultCount = $p -> where($where) ->count();
			$result = $p 
					-> field($field)
					-> where($where)
					-> order("post_level desc,name")
					-> page($page,3)
					-> select();
			//修改级别为中文
			foreach ($result as $k => $v) $result[$k]["post_level"] = $postLevelIndex[$v["post_level"]];
			$data['resultCount'] = (int) $resultCount;
			$data['result'] = $result;
		}
		// dump($result);
		if($ajax) $this->ajaxReturn($data);
		return $data;
	}

	public function getDmTree($byId = 0, $ajax = false){
		$d = M('Department');
		$where['status'] = 1;
		$dm = $d
		->where($where)
		->order('dm_sort')
		->select();

		foreach ($dm as  $v){
			$idName[$v['dm_id']] = $v['dm_name'];
			$idParent[$v['dm_id']] = $v['by_parent'];
		}

		$buildTree = function ($id) use (&$idParent, &$idName, &$buildTree) {
			foreach ($idParent as $dmId => $byParent) {
				//如果当前记录上级部门为$id
				if($id == $byParent){
					$dmTree[$dmId]['n'] = $idName[$dmId];//dmName
					if(array_search($dmId, $idParent)){
						$dmTree[$dmId]['c'] = $buildTree($dmId);//dm's child list
					}
				}
			}
			if(isset($dmTree)) return $dmTree;
			return false;
		};
		// dump(json_encode($buildTree($byId)));
		if($ajax) $this->ajaxReturn($buildTree($byId));
		// dump($buildTree($byId));
		return $buildTree($byId);
	}


	public function changeIdOrName($type,$id){
		//修改ID或姓名
		if(!IS_POST) $this->redirect('Index/index');//不是POST方法则返回
		A('User')->checkLevel(7);
		
			$m = M();
			$newId = I('post.newId',false);
			$newName = I('post.newName',false);
			$chkIdResult = $m->table('__PEOPLE__')->where("pid='%s'",$d);
			if(!$chkIdResult) return array('_msg','人员不存在');
			if($type == 'id'){
				//检查重复后更新people/education/title/transfer的ID
				if(!$newId) return array('_msg','新身份证不能为空');
				$chkNewIdResult = $m->table('__PEOPLE__')->where("pid='%s'",$newId);
				if($chkNewIdResult) return array('_msg','新身份证重复');
				$result['基本信息'] = $m->table('__PEOPLE__')->where("pid='%s'",$id)->setField('pid',$newId);
				$result['学历'] = $m->table('__EDUCATION__')->where("pid='%s'",$id)->setField('pid',$newId);
				$result['职称'] = $m->table('__TITLE__')->where("pid='%s'",$id)->setField('pid',$newId);
				$result['调动'] = $m->table('__TRANSFER__')->where("pid='%s'",$id)->setField('pid',$newId);
			}
			if($type == 'name'){
				//更新people/education/title/transfer的name
				if(!$newName)  return array('_msg','新姓名证不能为空');
				$result['基本信息'] = $m->table('__PEOPLE__')->where("pid='%s'",$id)->setField('name',$newName);
				$result['学历'] = $m->table('__EDUCATION__')->where("pid='%s'",$id)->setField('name',$newName);
				$result['职称'] = $m->table('__TITLE__')->where("pid='%s'",$id)->setField('name',$newName);
				$result['调动'] = $m->table('__TRANSFER__')->where("pid='%s'",$id)->setField('name',$newName);
			}
			return $result;
	}
}