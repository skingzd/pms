<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

   	protected $eduLevelIndex = array(0=>'初中及以下',1=>'高中',2=>'技校',3=>'中专',4=>'大专',5=>'本科',6=>'研究生',7=>'博士');
    protected $postLevelIndex = array(1 => '副科级',2 => '正科级',3 =>'副总级',4=>'副处级',5=>'正处级',);
    protected $titleLevelIndex = array('员级' => 1, '助理级' => 2, '中级' => 3, '高级' => 4, '教授级' => 5) ;
    public function index(){
        $this->show('人员管理系统-选择总览项目界面');
        session('user','Admin');
    }

    public function people($return = false){
    	//人员信息总览
    	$p = M('People');
    	foreach ($p->field('post_level level,count(1) count')->group('post_level')->select() as $value) {
    		$data[ $this->postLevelIndex[$value['level']] ] = $value['count'];
    	}

    	$typeIndex = array('0' => '常规', '1' => '高级别低职务', '-1' => '虚职');
    	foreach ($p->field('post_type type,count(1) count')->group('post_type')->select() as $value) {
    		$data[ $typeIndex[$value['type']] ] = $value['count'];
    	}
    	if($return) return $data;
    	dump($data);
    	$this->assign('peopleStatus',$data);

    	
    }

    public function education($return = false){
    	//学历库记载信息总览
		$e = M('Education');
		$result = $e
			->join('pms_people on pms_people.pid = pms_education.pid')
			->field('pms_people.post_level ,pms_education.edu_level, count(1) count')
			->group('pms_people.post_level,pms_education.edu_level')
			->order(array('pms_people.post_level'=>'desc','pms_education.edu_level'=>'desc'))
			->select();
		foreach ($result as $value) {
			$tmpPostLevelName = $this->postLevelIndex[$value['post_level']];
			$tmpEduLevelName = $this->eduLevelIndex[$value['edu_level']];
			$data[$tmpPostLevelName][$tmpEduLevelName] = $value['count'];
		}
		if($return)  return $data;
		dump($data); 
		$this->assign('educationStatus',$data);
    }

    public function title($return = false){
    	// 职称类别、级别信息总览
    	$t = M('Title');
		$data['total']           	= $t->count('1');
		$data['peopleHaveTitle']	= $t->field('count(distinct(`pid`))')->find();
		$data['levelAndType']=$t
		->field("`title_type` type,`title_level` level,count(1) count")
		->order(array('type','level'=>'desc'))
		->group('`title_type`,`title_level`')
		->select();
		dump($data);    	
    }

    public function department($return = false){
    	// 部门概况总览
    	
    	
    }

}