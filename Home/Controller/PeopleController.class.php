<?php
namespace Home\Controller;
use Think\Controller;

//人员控制器
class PeopleController extends Controller {

    private $user = array();

    // 列目录，功能选择页面
    public function index(){
        $this->show('人员管理系统');
    }

    // 单个人员详细信息查询
    public function id($id = null){
    	$this->show('单个人员详细信息查询');

        //获取人员基本信息
        $p = M('People');
        if($id == null) $this->error('参数错误');
        if(strlen($id) > 20) $this->error('参数错误');

        $wherep['pid'] = $id;
        $wherep['status'] = 1;
        $pdata = $p->where($wherep)->select();
        $this->assign($pdata[0]);

        //获取人员职称信息
        $t = M('Title');
        $tdata = $t->field('title_name,title_level,title_type,date_get_title')->where($id)->select();
        $this->assign($tdata[0]);
    }

    //按照人名进行搜索
    public function search($words = null){
    	$this->show('人员信息列表');
        echo $this->user['level'];

        // 检查页数参数合法，不合法返回默认值
        $page = (int) I('post.page') ? : 1 ;
        $pageNum = (int) I('post.pageNum') ? : 25;
        // 如果只给出姓名则按照姓名查找

        if($words){
            $p = M('People');

            //设置查询条件，人名默认模糊查询
            $where['name'] = array('LIKE','%'.$words."%");
            $where['status'] = 1;
            $data = $p->where($where)->select();
            if($data){
                $data['_count'] = count($data);
                $this->assign($data);
            }else{
                $this->error('找不到数据');
            }

        }

        
        // 检查如果传入数组则进行多条件查询
        // $condition = '';
        // $condition = I('post.conditon');
        // if(array_key_exists('tables',$condition)){
        //     //实例化空模型
        //     $model = M();
        //     //判断需调用表,设置别名
        //     foreach ($condition['tables'] as $value) {
        //         switch ($value) {
        //             case 'people':
        //                 $tables['pms_people'] = 'p';
        //                 break;
        //             case 'title':
        //                 $tables['pms_title'] = 't';
        //                 break;
        //             case 'department':
        //                 $tables['pms_department'] = 'dm';
        //                 break;
        //         }
        //     }
            
            
        //     $result = $model
        //     ->table($tables)
        //     ->where($condition)
        //     ->page($page,$pageNum)
        //     ->select();

        //     if(!$result) E('未找到复合条件人员');
        //     $this->assign($result);
        // }



        // //判断如果传入数字表示部门人员列表
        // if( (int) $map ){
        //     $where['dm_id'] = (int) $map;
        //     $p = M('People');

        //     $data = $p->where($where)->page($page,$pageNum)->select();
        //     if(!$data) E('部门代码错误或该部门没有职员');
        //     $this->assign($data);
        // }

        // //判断map参数如果为字符串则表示系统人员列表
        // if( (int) $map == 0 ){
        //     $where['dm_system'] = I('get.map');

        //     //获取部门列表
        //     $d = M('department');
        //     $dm = $d->field('dm_id')->where($where)->select();
        //     if(!$dm) E('未找到该系统');
        //     unset($where);

        //     //匹配属于map系统的单位包含的人
        //     $p = M('people');
        //     foreach ($dm as $value) {
        //         $dms[] = $value['dm_id'];
        //     }
        //     $where['dm_id'] = array('IN',$dms);

        //     $data = $p->where($where)->page($page,$pageNum)->select();
        //     if(!$data) E('系统名称有误');
        //     $this->assign($data);
        // }
    }
    
    public function add(){

        // if( $this->user['level']<3 ) $this->error('无权操作');
        //检查身份证是否重复
        $p = M('People');
        $data = $p->where("pid = '%s'",I('post.pid'))->find();

        if($data == null){//找不到新增身份证则执行添加
            $p->create();
            //设置编辑戳
            // $p->last_edit = $user['name'];
            $p->time_last_edit = time();
            $result = $p->add();

            if(!$result) $this->error('添加人员失败，请返回检查填写数据正确性');
            $this->success('新增人员成功','People/id/'.I('post.pid'));
        }
        $this->error('身份证重复性检查失败');
        
    }

    public function edit($id = null){
        // if( $this->user['level']<5 ) $this->error('无权操作');
        
        //如果接收Post数据发送pid则按照post内容修改相应pid记录
        $editById = I('post.pid',null);
        if($editById){
            $edit = M('People');

            $fieldExclude = array('pid','status');//设置排除字段
            $where['pid'] = $editById;

            $edit->create();
            //设置编辑戳
            // $edit->last_edit = $user['name'];
            $eidt->time_last_edit = time();

            $data = $edit->where($where)->field($fieldExclude,ture)->save();

            if(!$data) $this->error('修改失败');//修改失败，返回上一页
            $this->success('修改成功','People/id/'.$editById);//修改成功，返回个人资料
            }
        //没检测到post数据则获取id对应数据    
        if(!$id || strlen($id)>20) $this->error('参数错误');
        $p = M('People');
        $data = $p->where("pid='%s",$id)->find();
        if(!$data)$this->error('找不到数据');
        $this->assign($data);
    }

    public function del($id){
        // if( $this->user['level'] < 5 ) $this->error('无权限删除人员信息');

        $p = M('People');
        $p->status = 0;
        $result = $p->where("pid='%s'",$id)->setField('status',0);
        if(!$result) $this->error('删除失败');
        $this->success('删除人员成功','Index/index');

    }   
        
}