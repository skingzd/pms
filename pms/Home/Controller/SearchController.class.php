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
		$where['date_startwork'] = array( trim($i['workdateB']), trim($i['workdate'])  );
		$where['post_level']      = array( trim($i['postLevelB']), trim($i['postLevel']) );
		$where['title_level']     = array( trim($i['titleLevelB']), trim($i['titleLevel']) );
		$where['edu_level']       = array( trim($i['eduLevelB']), trim($i['eduLevel']) );
		$where['post_type']       = trim($i['postType']);
		$where['sex']             = $i['sex'];
		// dump($where);
		foreach ($where as $k => $v) {
			if(is_array($v)){
			//如果数组的任何参数未设置或为空则删除当前条件
				if($v[0] == '' || $v[1] == '') unset($where[$k]);
			}
			// 参数为空则删除条件
			if( $v == "" ) unset($where[$k]);
		}
		//页码设置规范
		if((int)$page < 1) $page = 1;

		//例外处理name条件因为%模糊查询,处理sex条件如果为all则去除sex筛选
		if($i['sex'] == "") unset($where['sex']);
		if(trim($i['name']) == "") unset($where['name']);
		// dump($where);
		if(count($where)){	
			$p = M("Summary");

			$postLevelIndex = A("Index")->postLevelIndex;
			$sexIndex = array( "0" => "女", "1" => "男" );

			$resultCount = $p->where($where)->count(1);
			$result = $p->where($where)
						->order("dm_id,post_level desc,name")
						// ->fetchSql()
						->page($page,$perPage)
						->select();
						// dump($result);
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

	public function result($word = null, $page =1){
		$A = A('Common');
		A("User")->checkLevel();
		if(!$word) $this->error('请输入搜索条件');

		$d = D('People');

		if((int) $word[0] == 0 && strlen($word) < 15){
		//首位转为数字为0,总长度不超过15位判断为字符查找
			$where['name'] = array('LIKE',"%$word%");
		}else{
		//首位非0则按身份证查找
			$where['pid'] = $word;			
		}
		$perPage = 15;
		$resultCount = $d->where($where)->count(1);
		$record = $d
				->field('pid, name, sex, birthday, date_startwork, post, post_level')
				->where($where)
				->page($page, $perPage)
				->select();

		$postLevelIndex = A("Index")->postLevelIndex;
		$sexIndex = array( "0" => "女", "1" => "男" );

		// if(!$record) $this->assign('msg','未找到匹配人员');
		
		foreach ($record as $key => $value) {	
			// $A->convertTimeStamp($value);
			$value["post_level"] = $postLevelIndex[$value["post_level"]];
			$value["sex"]        = $sexIndex[$value["sex"]];
			$value["no"]         = $key + 1 + (($page-1) * $perPage);
			$record[$key]        = $d->parseFieldsMap($value);
			// dump($postLevelIndex[$value["post_level"]]);
		}

		// dump($record);
		$this->assign("page",$page);
		$this->assign("perPage",$perPage);
		$this->assign('resultCount',$resultCount);
		
		$this->assign('record',$record);
		$this->assign('dm',$A->searchDm($word));
		dump($A->searchDm($word));
		$this->display();
	}
}