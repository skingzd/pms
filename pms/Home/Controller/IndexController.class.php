<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

   	public $eduLevelIndex = array(0=>'初中及以下',1=>'高中',2=>'技校',3=>'中专',4=>'大专',5=>'本科',6=>'研究生',7=>'博士');
    public $postLevelIndex = array(0 => '无级别', 1 => '副科级',2 => '正科级',3 =>'副总级',4=>'副处级',5=>'正处级',);
    public $titleLevelIndex = array(0 => '无级别', 1 =>'员级', 2=>'助理级' ,3 =>'中级', 4 =>'高级', 5=>'教授级') ;
    public $postTypeIndex = array('0' => '常规', '1' => '高级别低职务', '-1' => '虚职');
    

    public function index(){
        A('User')->checkLevel();
        $this->display();        
    }

    public function people(){
        A('User')->checkLevel();
 
    	//人员信息总览
    	$p = M('People');
        //按照人员级别统计
        $levelCount = $p->field('post_level as level,count(1) count')->order('post_level desc')->group('post_level')->select();
    	foreach ( $levelCount as $value) {
    		$data[ $this->postLevelIndex[$value['level']] ] = $value['count'];
    	}
        //按照任职类别进行统计
        $typeCount = $p->field('post_type type,count(1) count')->group('post_type')->select();
    	foreach ( $typeCount as $value) {
    		$data[ $this->postTypeIndex[$value['type']] ] = $value['count'];
    	}

        $data['干部总数'] = $data['虚职'] + $data['常规'] + $data['高级别低职务'];

        $this->assign("summary",$data);
        $this->display();
    }

    public function education($ajax = false){

        A('User')->checkLevel();

    	//学历库记载信息总览
		$e = M('Summary');
		$result = $e
			->field('post_level ,edu_level, count(1) count')
			->group('post_level,edu_level')
			->order(array('post_level'=>'desc','edu_level'=>'desc'))
			->select();
		foreach ($result as $value) {
			$tmpPostLevelName = $this->postLevelIndex[$value['post_level']];
			$tmpEduLevelName = $this->eduLevelIndex[$value['edu_level']];
            $data[$tmpPostLevelName]['总计'] += $value['count'];
			$data[$tmpPostLevelName][$tmpEduLevelName] = $value['count'];
		}
        // dump($data);
        $this->assign("data",$data);
        $this->display();

        if($ajax) $this->ajaxReturn($data);
        return $data;
    }

    public function title(){

        A('User')->checkLevel();

    	// 职称类别、级别信息总览
        $t = M('Summary');
        $result = $t
            ->field('post_level ,title_level, count(1) count')
            ->group('post_level,title_level')
            ->order(array('post_level'=>'desc','title_level'=>'desc'))
             // ->fetchSql()
            ->select();
            // dump($result);
        foreach ($result as $value) {
            $tmpPostLevelName = $this->postLevelIndex[$value['post_level']];
            $tmpTitleLevelName = $this->titleLevelIndex[$value['title_level']];
            if(!$value['title_level']) $tmpTitleLevelName = "无职称";
            $data[$tmpPostLevelName][$tmpTitleLevelName] = $value['count'];
        }
        // dump($data); 
        $this->assign("levelSummary",$data);
        $this->display();
    }

    public function department($goTo = null){
        A('User')->checkLevel();
        $rootDm = A('Common')->getDm(0,0,0);

        $this->assign("rootDm", json_encode($rootDm));
        $this->assign('goTo', $goTo);
        $this->display();
    }

    public function view($id){
        $p = A('Common');
        $result['info'] = $p -> getRecord('baseinfo', $id, $ajax = false);
        $result['edu'] = $p -> getSearch('edu', $id, $ajax = false);
        $result['title'] = $p -> getSearch('title', $id, $ajax = false);
        $result['trans'] = $p -> getSearch('trans', $id, $ajax = false);
        dump($result);
        $this->assign("result",$result);
    }
}