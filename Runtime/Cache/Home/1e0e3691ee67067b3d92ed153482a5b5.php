<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>test</title>
  <base href="/"></base>
	<link href="/Public/css/bootstrap.min.css" rel="stylesheet">
	<link href="/Public/css/pms.css" rel="stylesheet">
</head>
<body>
<div class="container">
<!--顶部块 tp模版用-->
<div class="header" id="header">
  <!-- 顶部登录、用户状态框 -->
  <div class="top-status">
    <div class="status-bar"><span class="logo"></span>欢迎 Admin. 退出登录</div>
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
            <a href="#">
              <span class="logo"></span>
              <span class="brand hidden-xs hidden-sm">PEOPLE MANAGE SYSTEM</span>
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li class="active"><a href="/index.php/index/people.html">人员信息总览<span class="sr-only">(current)</span></a></li>
              <li><a href="#">学历总览</a></li>
              <li><a href="#">职称总览</a></li>
              <li><a href="#">部门总览</a></li>
              <li><a href="#">高级查询</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
    </nav>
</div>


  <div class="container-fluid">
    <div class="row title-row">
      <div class="col-xs-12 col-md-6">
        <span class="summary-graph hidden-xs"></span>
      </div>
      <div class="col-xs-12 col-md-6 summary-text">
        人员信息总览
      </div>
    </div><!-- /title row -->

    <div class="row summary">
      <div class="col-sm-6 col-md-4">
        <div class="row">
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12 summary-header">干部总数</div>
              <div class="col-md-12"><?php echo ($summary['干部总数']); ?></div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12 summary-header">高级低职</div>
              <div class="col-md-12"><?php echo ($summary['高级别低职务']); ?></div>
            </div></div>
        </div>
      </div>
      <div class="col-sm-6 col-md-8">
        <div class="row">
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12 summary-header">虚职</div>
              <div class="col-md-12"><?php echo ($summary['虚职']); ?></div>
            </div>
          </div>
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12 summary-header">正处级</div>
              <div class="col-md-12"><?php echo ($summary['正处级']); ?></div>
            </div></div>
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12 summary-header">副处级</div>
              <div class="col-md-12"><?php echo ($summary['副处级']); ?></div>
            </div></div>
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12 summary-header">副总级</div>
              <div class="col-md-12"><?php echo ($summary['副总级']); ?></div>
            </div></div>
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12 summary-header">正科级</div>
              <div class="col-md-12"><?php echo ($summary['正科级']); ?></div>
            </div></div>
          <div class="col-md-2">
            <div class="row">
              <div class="col-md-12 summary-header">副科级</div>
              <div class="col-md-12"><?php echo ($summary['副科级']); ?></div>
            </div></div>
        </div>
      </div>
    </div><!-- /summary row -->
  </div><!--/container-fluid-->

<!--底部块-->

<div class="footer">
  <div class="footer-bar">
    <span class="logo"></span><span class="hidden-xs">The PEOPLE MANAGE SYSTEM by KinGzd.</span>
  </div>
</div>

</div><!--/container-->
<script src="/ublic/js/jquery.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>

</body>	
</html>