<?php
namespace Home\Model;
use Think\Model;
//定义 单位 类
class TransferModel extends Model{
	protected $_map = array(
				'id'       => 'trans_id',
				'date'     => 'date_move',
				'moveType' => 'move_type',
				'moveFrom' => 'move_from',
				'postFrom' => 'post_from',
				'moveTo'   => 'move_to',
				'postTo'   => 'post_to',
				'editBy'   => 'last_edit',
				'editTime' => 'time_last_edit',
				);
}

?>