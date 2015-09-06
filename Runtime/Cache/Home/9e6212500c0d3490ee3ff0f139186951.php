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
	.summary{
		
		margin: auto;
		color:#5D5D5D;
		text-align: center !important;
	}
	.table{
	margin: 20px 0;
	}
	.table caption{
		text-align: center;
		font:3em "黑体";
		margin: 0 0 30px 60px;
	}
	.table thead{
		font-size:16px;
	}
	.table td{
	font-size:18px;
		padding:20px 0 !important;
	}
	.table th{
		text-align: center;
		vertical-align: middle !important;
	}
	.zero:after{
	content: "0";
	color:#D2D2D2;
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



<div class="page-header summary-title">
    职称 - 级别 情况总览
</div>

<div class="table-responsive summary">
	<table class="table table-hover">
      <thead>
        <tr>
          <th>级别</th>
          <th>教授级</th>
          <th>副高级</th>
          <th>中级</th>
          <th>助理级</th>
          <th>员级</th>
          <th>无职称</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row">正处级</td>
          <td><?php echo ($levelSummary['正处级']['教授级']); ?></td>
          <td><?php echo ($levelSummary['正处级']['副高级']); ?></td>
          <td><?php echo ($levelSummary['正处级']['中级']); ?></td>
          <td><?php echo ($levelSummary['正处级']['助理级']); ?></td>
          <td><?php echo ($levelSummary['正处级']['员级']); ?></td>
          <td><?php echo ($levelSummary['正处级']['无职称']); ?></td>
        </tr>

        <tr>
          <th scope="row">副处级</td>
          <td><?php echo ($levelSummary['副处级']['教授级']); ?></td>
          <td><?php echo ($levelSummary['副处级']['副高级']); ?></td>
          <td><?php echo ($levelSummary['副处级']['中级']); ?></td>
          <td><?php echo ($levelSummary['副处级']['助理级']); ?></td>
          <td><?php echo ($levelSummary['副处级']['员级']); ?></td>
          <td><?php echo ($levelSummary['副处级']['无职称']); ?></td>
        </tr>

        <tr>
          <th scope="row">副总级</td>
          <td><?php echo ($levelSummary['副总级']['教授级']); ?></td>
          <td><?php echo ($levelSummary['副总级']['副高级']); ?></td>
          <td><?php echo ($levelSummary['副总级']['中级']); ?></td>
          <td><?php echo ($levelSummary['副总级']['助理级']); ?></td>
          <td><?php echo ($levelSummary['副总级']['员级']); ?></td>
          <td><?php echo ($levelSummary['副总级']['无职称']); ?></td>
        </tr>

        <tr>
          <th scope="row">正科级</td>
          <td><?php echo ($levelSummary['正科级']['教授级']); ?></td>
          <td><?php echo ($levelSummary['正科级']['副高级']); ?></td>
          <td><?php echo ($levelSummary['正科级']['中级']); ?></td>
          <td><?php echo ($levelSummary['正科级']['助理级']); ?></td>
          <td><?php echo ($levelSummary['正科级']['员级']); ?></td>
          <td><?php echo ($levelSummary['正科级']['无职称']); ?></td>
        </tr>

        <tr>
          <th scope="row">副科级</td>
          <td><?php echo ($levelSummary['副科级']['教授级']); ?></td>
          <td><?php echo ($levelSummary['副科级']['副高级']); ?></td>
          <td><?php echo ($levelSummary['副科级']['中级']); ?></td>
          <td><?php echo ($levelSummary['副科级']['助理级']); ?></td>
          <td><?php echo ($levelSummary['副科级']['员级']); ?></td>
          <td><?php echo ($levelSummary['副科级']['无职称']); ?></td>
        </tr>
      </tbody>
    </table>
</div>

<!--底部块-->

<div class="footer">
  <div class="footer-bar">
    <span class="logo"></span><span class="hidden-xs">The PEOPLE MANAGE SYSTEM by KinGzd.</span>
  </div>
</div>

</div><!--/container-->
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>

<script>
$("document").ready(function(){
    initial();
  })

  function initial(){
    $("#navbar li#title").addClass("active");
    $("td:empty").addClass("zero");
  }
</script>

</body>	
</html>