<?php
namespace Home\Controller;
use Think\Controller;
Class EditController extends Controller{
	public $editItemIndex = array(
		'基本信息'	=>	array('table'=>'People','key'=>'pid'),
		'学历'		=>	array('table'=>'Education','key'=>'edu_id'),
		'职称'		=>	array('table'=>'Title','key'=>'t_id'),
		'调动'		=>	array('table'=>'Transfer','key'=>'trans_id'),
		);
	public function index($item = null, $pid = null){
		//如果传入item和pid则列出该人员在该项目中记录
		$this->show('人员选择、编辑项目选择页');

		$result = $m->where("pid = '%s'",$pid)->select();
		if(!$result) $this->error('该人员无库存学历信息');
	}

	public function record($item, $id){
		//传入编辑项目与ID则检查POST数据，提交修改
		$postid = I('post.pid',false);
		$m = M($this->editItemIndex[$item]['table']);//初始化对应表的模型
		//如果传入POST数据EDU_ID则进行数据库操作修改
		if($postid){
			$data = $m->create();
			// if($data['pid'] != $pid) $this->error('记录所属人与提交数据不符');
			unset($data['pid']);
			$data['last_edit'] = session('user');
			$data['time_last_edit'] = time();
			$where[$this->editItemIndex[$item]['key']] = $id;
			$result = $m->data($data)->save();
			if(!$result) $this->error('出错了，修改失败');
			$this->success('修改成功');
		}
	}

}