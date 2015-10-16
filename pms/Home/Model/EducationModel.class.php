<?php
namespace Home\Model;
use Think\Model;
//定义 单位 类
class EducationModel extends Model{
	protected $_map = array(
				'id'        => 'edu_id',
				'eduLevel'  => 'edu_level',
				'degree'    => 'degree',
				'college'   => 'college',
				'major'     => 'major',
				'eduCer'    => 'edu_cer_number',
				'type'      =>	'edu_type',
				'degreeCer' => 'degree_cer_number',
				'graduate'  => 'date_graduate',
				'topLevel'  => 'edu_level_top',
				'editBy'    => 'last_edit',
				'editTime'  => 'time_last_edit',
				);
}
?>