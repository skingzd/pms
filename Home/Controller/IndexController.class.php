<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

   	public $eduLevelIndex = array(0=>'初中及以下',1=>'高中',2=>'技校',3=>'中专',4=>'大专',5=>'本科',6=>'研究生',7=>'博士');
    public $postLevelIndex = array(1 => '副科级',2 => '正科级',3 =>'副总级',4=>'副处级',5=>'正处级',);
    public $titleLevelIndex = array(1 =>'员级', 2=>'助理级' ,3 =>'中级', 4 =>'高级', 5=>'教授级') ;
    public $postTypeIndex = array('0' => '常规', '1' => '高级别低职务', '-1' => '虚职');
    

    public function index(){
        A('User')->checkLevel();
        $this->show('人员管理系统-选择总览项目界面');

        dump($this->title());
        dump(A('Common')->getDm());
    }

    public function people($ajax = false){
    	//人员信息总览
    	$p = M('People');
        //按照人员级别统计
        $levelCount = $p->field('post_level level,count(1) count')->order('post_level desc')->group('post_level')->select();
    	foreach ( $levelCount as $value) {
    		$data[ $this->postLevelIndex[$value['level']] ] = $value['count'];
    	}
        //按照任职类别进行统计
        $typeCount = $p->field('post_type type,count(1) count')->group('post_type')->select();
    	foreach ( $typeCount as $value) {
    		$data[ $this->postTypeIndex[$value['type']] ] = $value['count'];
    	}
        // dump($data); 
    	if($ajax) $this->ajaxReturn($data);
        return $data;
    }

    public function education($ajax = false){
    	//学历库记载信息总览
		$e = M('Summary_pe');
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

    public function title($ajax = false){
    	// 职称类别、级别信息总览
        $t = M('Summary_pt');
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
            $data[$tmpPostLevelName][$tmpTitleLevelName] = $value['count'];
        }
        // dump($data); 
        if($ajax) $this->ajaxReturn($data);
        return $data;
    }
/*
    public function department($ajax = false){
         老版部门树
    	$d = M('Department');

        $where['status'] = 1;
        //返回系统列表
        $where['is_system'] =1;
        $system = $d
        ->field('dm_id,dm_name,is_system')
        ->where($where)
        ->order('dm_sort')
        ->select();
        //返回部门列表
        $where['is_system'] = 0;
        $dm = $d
        ->where($where)
        ->field('dm_id,dm_name,by_system')
        ->order('dm_sort')
        ->select();
        
        //如果带参数则返回相应列表 ID => name 数组；
        if($ajax == 'system'){
            foreach ($system as $sys_value) $returnData[$sys_value['dm_id']] = $sys_value['dm_name'];
            return $returnData;
        }elseif($return){
            foreach ($dm as $dm_value) $returnData[$dm_value['dm_id']] = $dm_value['dm_name'];
            return $returnData;
        }

        foreach ($system as $sys_value) {//遍历系统
            $dmTree[$sys_value['dm_name']] = array();
            foreach ($dm as $dm_value) {//遍历单位
                if($dm_value['by_system'] == $sys_value['dm_id'])
                    $dmTree[$sys_value['dm_name']][$dm_value['dm_id']] = $dm_value['dm_name'];
            }
            $dmTree[$sys_value['dm_name']]['_count'] = count($dmTree[$sys_value['dm_name']]);
        }
        dump($dmTree); 
        $this->assign('dmTree',$dmTree);
        
    }
*/
}