<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>PMS</title>
	<link href="/Public/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Public/css/pms.css" rel="stylesheet">
  
		<style>
		h3{
			font-family: "黑体" !important;
		}
    .dm-path li{
      cursor: pointer;    
      color: #707070;
    }
    .dm-path .active{
      cursor: auto; 
      color: #D0D0D0;
    }
    .dm-list{
      cursor:pointer;
    }
    .list-group .active{
      background-color: #888888;
      border-color: #707070;
    }
    .list-group .active:hover{
      background-color: #707070;
      border-color: #606060;
    }
    .list-group .active:focus{
      background-color: #888888;
      border-color: #606060;
    }
    #pListTitle{
      display: inline-block;
      font:20px bold "黑体";
      margin: 0 30px;
    }
    #pList tr{
      cursor:pointer;
    }
    tbody tr:hover{
      color: #fff;
      background-color: #888888 !important;
    }
    #pager{
      cursor:pointer;
    }
    .btn-default {
      width: 100%;
      margin: 5px 0;
    }
    </style>
  
</head>
<body>
<div class="container">
<!--顶部块 tp模版用-->
<div class="header" id="header">
  <!-- 顶部登录、用户状态框 -->
  <div class="top-status">
    <div class="status-bar"><span class="logo"></span>欢迎 <a href="/index.php/User/index.html"><?php echo ($user); ?></a>. 退出登录</div>
  </div>
  <!-- 搜索框 -->
  <div class="top-search">
    <input class="form-control"type="text" placeholder="输入人员姓名、身份证号码或单位名" />
  </div>
  <!-- 导航栏 -->
	<nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">导航</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a href="/">
              <span class="logo"></span>
              <span class="brand hidden-xs hidden-sm">PEOPLE MANAGE SYSTEM</span>
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li id="people"><a href="/index.php/Index/people.html">人员信息总览<span class="sr-only">(current)</span></a></li>
              <li id="education"><a href="/index.php/Index/education.html">学历总览</a></li>
              <li id="title"><a href="/index.php/Index/title.html">职称总览</a></li>
              <li id="department"><a href="/index.php/Index/department.html">部门浏览</a></li>
              <li id="search"><a href="/index.php/search.html">高级查询</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
</div>


<div class="content-min-height">
<a name="top"></a>
<div class="row">
  <div class="col-xs-12">
    <ol class="breadcrumb dm-path" id="dmPath">
    </ol>
  </div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-3">
    <button class="btn btn-default visible-xs-inline-block" id="dmListController" type="button"><span class="glyphicon glyphicon-list"></span> 打开/收起 单位列表</button>
    <ul class="list-group dm-list" id="dmList">
    </ul>
</div>
  <div class="col-xs-12 col-sm-9" id="content-right">
    <table class="table table-striped table-hover">
      <caption><h4 id="pListTitle"> </h4><small id="subTitle"></small></caption>
      <thead>
        <tr>
          <th scope="row">#</th>
          <th>姓名</th>
          <th>性别</th>
          <th>出生年月</th>
          <th>参加工作时间</th>
          <th>职务</th>
          <th>职务级别</th>
        </tr>
      </thead>
      <tbody id="pList">
      <!-- 人员列表区域 -->
      </tbody>
    </table>
<nav class="pull-right">
  <ul class="pagination" id="pager">
    <li id="pre">
      <a aria-label="上一页">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <!-- 页码排列位置 -->
    <li id="next">
      <a aria-label="下一页">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
</div> <!-- /col-sm-9 -->
</div> <!-- /row -->
</div> <!-- /div min-height -->
  <!-- 单位列表 -->
  
<!--底部块-->

<div class="footer">
  <div class="footer-bar">
    <span class="logo"></span><span class="hidden-xs">The PEOPLE MANAGE SYSTEM by KinGzd.</span>
  </div>
</div>

</div><!--/container-->
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>

  <script type="text/javascript">

  var dmList,perPage=3;
  $("document").ready(function(){
    initial();
  })

  function initial(){
    var txt,rootDm;
    $("#dmPath").text("加载中...");
    $.get("/index.php/Common/getDm/0/0/1",function(rootDm){
      txt = $("<li></li>").text(rootDm["name"]).attr("id",0).addClass("active");
      $("#dmPath").empty().append(txt);
    });
    dmListLoadFrom(0);
    $("#navbar li#department").addClass("active");
    $("#content-right").hide();
    $("#dmListController").click(function(){
      $("#dmList").slideToggle(300);
    })
  }
  </script>
  <script src="/Public/js/dm.js"></script>

</body>	
</html>