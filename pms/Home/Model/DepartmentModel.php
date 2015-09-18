<?php
namespace Home\Model;
use Think\Model;
class DepartmentModel extends Model{
	protected $_map = array(
		'id'			=>	'dm_id',
		'name'			=>	'dm_name',
		'datesetup'		=>	'date_dm_setup',
		'c'				=>	'comment',
		'byp'			=>	'by_parent',
		);
}
?>
