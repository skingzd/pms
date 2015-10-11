<?php
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protected $_map = array(
		'l'	=>	'u_level',
		'p'	=>	'u_pwd',
		);
}
?>