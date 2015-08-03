<?php
namespace Home\Controller;
use Think\Controller;
class TransferController extends Controller{
	public function index($id = null){
		$t = M('Transfer');
		$where['pid'] = $id;
		$order = array('date_move','desc');

		$data = $t->where($where)->order($order)->select();
		if(!$data) $data['_msg'] = '未找到任何数据';
		dump($data);
	}
}
?>