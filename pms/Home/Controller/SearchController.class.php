<?php
namespace Home\Controller;
use Think\Controller;
Class SearchController extends Controller{
	public function index (){
		A("User")->checkLevel();
		//不关三七二十一，导入所有可能参数成为查询条件
		$i = I("get.");
		$page                     = $i['page'];
		$perPage                  = 15; //每页显示条数
		$where["name"]            = array("LIKE","%".trim($i['name'])."%");
		$where["birthday"]        = array( trim($i['birthdayB']), trim($i['birthday']) );
		$where['date_start_work'] = array( trim($i['workdateB']), trim($i['workdate'])  );
		$where['post_level']      = array( trim($i['postLevelB']), trim($i['postLevel']) );
		$where['title_level']     = array( trim($i['titleLevelB']), trim($i['titleLevel']) );
		$where['edu_level']       = array( trim($i['eduLevelB']), trim($i['eduLevel']) );
		$where['post_type']       = trim($i['postType']);
		$where['sex']             = $i['sex'];
		// dump($where);
		foreach ($where as $k => $v) {
			if(is_array($v)){
			//如果数组的任何参数未设置或为空则删除当前条件
				// if(is_null($v[0]) || is_null($v[1])) unset($where[$k]);
				if($v[0]=="" || $v[1]=="" ) unset($where[$k]);
			}
			// 参数为空则删除条件
			// if(is_null($v) || $v == "" ) unset($where[$k]);
			if( $v == "" ) unset($where[$k]);
		}
		//页码设置规范
		if((int)$page < 1) $page = 1;

		//例外处理name条件因为%模糊查询,处理sex条件如果为all则去除sex筛选
		if($i['sex'] == "all") unset($where['sex']);
		if(trim($i['name']) == "") unset($where['name']);
		// dump($where);
		if(count($where)){	
			$p = M("Summary");
			$postLevelIndex = A("Index")->postLevelIndex;
			$sexIndex = array( "0" => "女", "1" => "男" );
			$resultCount = $p->where($where)->count(1);
			$result = $p->where($where)
						->order("dm_id,post_level desc,name")
						->page($page,$perPage)
						->select();
			foreach ($result as $k => $v){
				$result[$k]["post_level"] = $postLevelIndex[$v["post_level"]];
				$result[$k]["sex"] = $sexIndex[$v["sex"]];
				$result[$k]["no"] = $k + 1 + (($page-1) * $perPage);
			} 
			// dump($page);
			// dump(json_encode($where));
			
			// 转换map 变为非数据库字段
			$map["name"] = $where["name"];
			$map["birthday"] = $where["birthday"];
			$map["workdate"] = $where['date_start_work'];
			$map["postLevel"] = $where['post_level'];
			$map["titleLevel"] = $where['title_level'];
			$map["eduLevel"] = $where['edu_level'];
			$map["postType"] = $where['post_type'];
			$map["sex"] = $where['sex'];
			// dump($map);

			$this->assign("page",$page);
			$this->assign("map", json_encode($map));
			$this->assign("perPage", $perPage);
			$this->assign("resultCount", $resultCount);
			$this->assign("result", $result);
		}
		
		$this->display();
	}

	public function result($type = null, $words = null){
		$this->display();
	}
}