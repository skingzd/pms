<?php
namespace Home\Controller;
use Think\Controller;
Class EducationController extends Controller{
	protected $level = array(0=>'初中及以下',1=>'高中',2=>'技校',3=>'中专',4=>'大专',5=>'本科',6=>'研究生',7=>'博士');
	public function index(){
		$e = M('Education');
		foreach ($e->field('edu_level level,count(1) count')->group('edu_level')->select() as $value) {
			$level = $this->level[$value['level']];
			$data[$level] = $value['count'];
		}
		dump($data);
	}

	public function search($words = null, $page = 1,$retrun =0){
		$e = M('Education');

		if(!$words) $this->show('返回搜索框');
		if( strlen($words)<15 ) $where['name'] = array('LIKE','%'.$words.'%');
		if(	strlen($words)>15 ) $where['pid'] = $words;


		$order = array('edu_level' => 'desc','date_enterschool' => 'desc');
		$data = $e->where($where)->page($page,25)->order($order)->select();
		if(!$data) $data['_msg'] = '无搜索结果';
		dump($data);
		if($retrun) return $data;
	}
	public function advSearch($level = null,$name = null, $year = null,
	$school = null, $major = null, $page = 1, $pageNum = 25, $return = false) {

		$level = array_search($level,$this->level);
		if($level)		$where['edu_level']		=	$level;//按照级别搜索
		if($name) 		$where['name']			=	array('LIKE',$name.'%');//按照姓名搜索
		if($graduate)	$where['date_graduate']	=	array('LIKE',$graduate.'%');//按照毕业年份搜索
		if($school)		$where['school']		=	array('LIKE','%'.$school.'%');//按照毕业院校搜索
		if($major)		$where['major']			=	array('LIKE','%'.$major.'%');//按照专业搜索

		if(!$where){
			$this->show('未设置查询条件');
		}else{
			$e = M('Education');
			$order = array('edu_level' => 'desc','date_enterschool' => 'desc');
			$data = $e->order($order)->page($page,$pageNum)->where($where)->select();
			dump($where);
			if(!$data) $data['_msg'] = '无搜索结果';
			dump($data);
			if($result) return $data;
		}
	}
}