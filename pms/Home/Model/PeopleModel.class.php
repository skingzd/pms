<?php
namespace Home\Model;
use Think\Model;
//定义人员类
class PeopleModel extends Model{
	protected $_map = array(
				'id'        => 'pid',
				'dm'		=> 'dm_id',
				'workdate'  => 'date_startwork',
				'postLevel' => 'post_level',
				'postType'  => 'post_type',
				'postDate'  => 'date_get_post',
				'editBy'    => 'last_edit',
				'editTime'  => 'time_last_edit',
				);
}

?>