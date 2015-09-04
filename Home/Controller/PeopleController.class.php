<?php
namespace Home\Controller;
use Think\Controller;

//人员控制器
class PeopleController extends Controller {

    // 列目录，功能选择页面
    public function index(){
        $this->show('人员管理系统');
    }

    //按照人名进行搜索
    public function search($words = null,$page = 1){
        if( A('User')->checkLevel() < 1 ) $this->error('非法操作');
    	$this->show('人员信息列表');
        echo $this->user['level'];


        // 如果只给出姓名则按照姓名查找

        if($words){
            $p = M('People');

            //设置查询条件，人名默认模糊查询
            $where['name'] = array('LIKE','%'.$words."%");
            $where['status'] = 1;
            $data = $p->where($where)->select();
            if(!$data)$this->error('找不到数据');

            $data['_count'] = count($data);
            dump($data);
        }
        dump($data);

        
    }
    
    public function add(){

        if( A('User')->checkLevel() < 3 ) $this->error('非法操作');
        //检查身份证是否重复
        $p = M('People');
        $data = $p->where("pid = '%s'",I('post.pid'))->find();

        if($data)$this->error('身份证重复性检查失败');//找不到新增身份证则执行添加

        $p->create();
        //设置编辑戳
        $p->last_edit = session('user');
        $p->time_last_edit = time();
        $result = $p->add();

        if(!$result) $this->error('添加人员失败，请返回检查填写数据正确性');
        $this->redirect('/People',array('id'=>I('post.pid')),1,'新增成功...');
    }

    public function edit($id = null){
        if( A('User')->checkLevel() < 3 ) $this->error('非法操作');
        
        //如果Post数据发送pid,修改相应pid记录
        $editById = I('post.pid',null);
        if($editById){
            $edit = M('People');

            $fieldExclude = array('pid','status');//设置排除字段
            $where['pid'] = $editById;

            $edit->create();
            //设置编辑戳
            $edit->last_edit = session('user');
            $eidt->time_last_edit = time();

            $data = $edit->where($where)->field($fieldExclude,ture)->save();

            if(!$data) $this->error('修改失败');//修改失败，返回上一页
            $this->redirect('/People',array('id'=>$editById),1,'修改成功...');//修改成功，返回个人资料
        }else{
            //没检测到post数据则获取id对应数据    
            if(!$id || strlen($id)>20) $this->error('参数错误');
            $p = M('People');
            $data = $p->where("pid='%s'",$id)->find();
            if(!$data)$this->error('找不到数据');
            dump($data);
        }
    }

    public function del($id){
        if( A('User')->checkLevel() < 3 ) $this->error('非法操作');

        $p = M('People');
        $result = $p->where("pid='%s'",$id)->setField('status',0);
        if(!$result) $this->error('删除失败');
        $this->success('删除人员成功','Index/index');
    }   
        
}