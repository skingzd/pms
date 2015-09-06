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

.carousel{
	margin: 20px 0;
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
<div id="carousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <li data-target="#carousel" data-slide-to="0" class="active"></li>
    <li data-target="#carousel" data-slide-to="1"></li>
    <li data-target="#carousel" data-slide-to="2"></li>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <div class="item active">
    	<img src="/Public/image/carousel_people.jpg" />
    </div>
    <div class="item">
			<img src="/Public/image/carousel_edu.jpg" />
    </div>
    <div class="item">
      <img src="/Public/image/carousel_title.jpg" />
    </div>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div> <!-- /carousel -->
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
    $("#navbar li#?").addClass("active");
  }
</script>

</body>	
</html>