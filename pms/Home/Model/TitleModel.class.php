<?php
namespace Home\Model;
use Think\Model;
//定义 单位 类
class TitleModel extends Model{
	protected $_map = array(
				'id'       => 't_id',
				'title'    => 'title_name',
				'level'    => 'title_level',
				'type'     => 'title_type',
				'major'	   => 'title_major',
				'topLevel' => 'title_level_top',
				'date'     => 'date_get_title',
				'no'       => 'title_number',
				'status'   => 'title_status',
				'editBy'   => 'last_edit',
				'editTime' => 'time_last_edit',
				);
}

?>