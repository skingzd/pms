<?
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	protect $_map = array(
		'username'	=>	'u_name',
		'pwassword'	=>	'u_password',
		);
}
?>