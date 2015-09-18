<?php
namespace Home\Model;
use Think\Model;
//定义 单位 类
class EducationModel extends Model{
	$_validate = array(
		array('edu_level', array(0,7), "学历提交错误", self::EXISTS_VALIDATE, 'between'),
		array('edu_level_top', array(0,1),"学历是否最高学历？", self::EXISTS_VALIDATE, 'in'),

		);
}

?>