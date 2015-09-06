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
form{
	margin: 50px 0;
	font:15px bold "黑体";
}
button{
	font-size: 17px !important;
	font-weight: 900 !important;
	margin: 0 15%;
	width: 70%;
}
table{
	margin: auto;
	width: 90% !important;
}
#pager{
	cursor: pointer;
}
tr{
	cursor: pointer;
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
	<form class="form-horizontal" id="searchForm" action="" method="get"> 
		<div class="row">
			<div class="col-sm-1"></div>
			<div class="col-sm-5">

				<div class="form-group">
				<lable class="col-sm-3 control-label" for="name">姓 名</lable>
					<div class="col-sm-9">
							<input type="text" class="form-control" name="name" id="name" placeholder="输入名字或名字中几个字" />
					</div>
				</div>

				<div class="form-group">
					<lable class="col-sm-3 control-label" for="birthday">出 生 年 份</lable>
					<div class="col-sm-3">
						<select name="birthdayB" id="birthdayB" class="form-control">
							<option>   </option>
							<option value="eq" id="birthdayBeq"> = </option>
							<option value="lt" id="birthdayBlt"> &lt; </option>
							<option value="gt" id="birthdayBgt"> &gt; </option>
							<option value="elt" id="birthdayBelt"> &le; </option>
							<option value="egt" id="birthdayBegt"> &ge; </option>
							<option value="neq" id="birthdayBneq"> &ne; </option>
						</select>
					</div>
					<div class="col-sm-6">
							<input type="text" class="form-control" name="birthday" id="birthday" placeholder="格式：1975-05-30" />
					</div>
				</div>

				<div class="form-group">
				<lable class="col-sm-3 control-label" for="workdate">参加工作日期</lable>
					<div class="col-sm-3">
						<select name="workdateB" id="workdateB" class="form-control">
							<option></option>
							<option value="eq" id="workdateBeq"> = </option>
							<option value="lt" id="workdateBlt"> &lt; </option>
							<option value="gt" id="workdateBgt"> &gt; </option>
							<option value="elt" id="workdateBelt"> &le; </option>
							<option value="egt" id="workdateBegt"> &ge; </option>
							<option value="neq" id="workdateBneq"> &ne; </option>
						</select>
					</div>
					<div class="col-sm-6">
							<input type="text" class="form-control" name="workdate" id="workdate" placeholder="格式：1975-05-30" />
					</div>
				</div>
			</div> <!-- /col-sm-4 -->

			<div class="col-sm-5">

				<div class="form-group">
					<lable class="col-sm-3 control-label" for="postLevel">职 务 级 别</lable>
					<div class="col-sm-3">
						<select name="postLevelB" id="postLevelB" class="form-control">
							<option> </option>
							<option value="eq" id="postLevelBeq"> = </option>
							<option value="lt" id="postLevelBlt"> &lt; </option>
							<option value="gt" id="postLevelBgt"> &gt; </option>
							<option value="elt" id="postLevelBelt"> &le; </option>
							<option value="egt" id="postLevelBegt"> &ge; </option>
							<option value="neq" id="postLevelBneq"> &ne; </option>
						</select>
					</div>
					<div class="col-sm-6">
						<select name="postLevel" name="postLevel" id="postLevel" class="form-control">
							<option></option>
							<option value="1" id="postLevel1">副科级</option>
							<option value="2" id="postLevel2">正科级</option>
							<option value="3" id="postLevel3">副总级</option>
							<option value="4" id="postLevel4">副处级</option>
							<option value="5" id="postLevel5">正处级</option>
						</select>
					</div>
				</div> <!-- /form-group -->

				<div class="form-group">
					<lable class="col-sm-3 control-label" for="title">职 称 级 别</lable>
					<div class="col-sm-3">
							<select name="titleLevelB" id="titleLevelB" class="form-control">
								<option></option>
								<option value="eq" id="titleLevelBeq"> = </option>
								<option value="lt" id="titleLevelBlt"> &lt; </option>
								<option value="gt" id="titleLevelBgt"> &gt; </option>
								<option value="elt" id="titleLevelBelt"> &le; </option>
								<option value="egt" id="titleLevelBegt"> &ge; </option>
								<option value="neq" id="titleLevelBneq"> &ne; </option>
							</select>
						</div>
						<div class="col-sm-6">
							<select name="titleLevel" name="titleLevel" id="titleLevel" class="form-control">
								<option></option>
								<option value="1" id="titleLevel1">员级</option>
								<option value="2" id="titleLevel2">助理级</option>
								<option value="3" id="titleLevel3">中级</option>
								<option value="4" id="titleLevel4">副高级级</option>
								<option value="5" id="titleLevel5">教授级级</option>
							</select>
						</div>
				</div> <!-- /form-group -->

				<div class="form-group">
				<lable class="col-sm-3 control-label" for="edu">学 历 层 次</lable>
					<div class="col-sm-3">
							<select name="eduLevelB" id="eduLevelB" class="form-control">
								<option></option>
								<option value="eq" id="eduLevelBeq"> = </option>
								<option value="lt" id="eduLevelBlt"> &lt; </option>
								<option value="gt" id="eduLevelBgt"> &gt; </option>
								<option value="elt" id="eduLevelBelt"> &le; </option>
								<option value="egt" id="eduLevelBegt"> &ge; </option>
								<option value="neq" id="eduLevelBneq"> &ne; </option>
							</select>
						</div>
						<div class="col-sm-6">
							<select name="eduLevel" name="eduLevel" id="eduLevel" class="form-control">
								<option></option>
								<option value="0" id="eduLevel0">初中及以下</option>
								<option value="1" id="eduLevel1">高中</option>
								<option value="2" id="eduLevel2">技校</option>
								<option value="3" id="eduLevel3">中专</option>
								<option value="4" id="eduLevel4">大专</option>
								<option value="5" id="eduLevel5">本科</option>
								<option value="6" id="eduLevel6">研究生</option>
								<option value="7" id="eduLevel7">博士</option>
							</select>
						</div>
				</div><!-- /form-group -->		
			</div> <!-- /col-sm-5 -->
		<div class="col-sm-1"></div>
		</div> <!-- /row -->
		<div class="row">
				<div class="form-group">
					<lable class="col-sm-2 control-label" for="sex">性别</lable>

					<div class="col-sm-4 btn-group" data-toggle="buttons">
						<label class="btn btn-default">
							<input type="radio" name="sex" value="1" id="sex-m" />男性
						</label>
						<label class="btn btn-default">
							<input type="radio" name="sex" value="0" id="sex-f" />女性
						</label>
						<label class="btn btn-default active">
							<input type="radio" name="sex" value="all" id="sex"  checked="checked"/>全部
						</label>
					</div>

					<div class="col-sm-6">
						<button type="submit" class="btn btn-default"> <span class="glyphicon glyphicon-search"></span> 筛选人员 </button>
					</div>
				</div>
		</div> <!-- /row -->
		<input type="hidden" name="page" id="page" value="<?php echo ((isset($page) && ($page !== ""))?($page):'1'); ?>">
	</form>

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
	<?php if(is_array($result)): foreach($result as $key=>$val): ?><tr id="<?php echo ($val['pid']); ?>">
	    <th scope="row"><?php echo ($val["no"]); ?></th>
	    <td><?php echo ($val["name"]); ?></td>
	    <td><?php echo ($val["sex"]); ?></td>
	    <td><?php echo ($val["birthday"]); ?></td>
	    <td><?php echo ($val["date_start_work"]); ?></td>
	    <td><?php echo ($val["post"]); ?></td>
	    <td><?php echo ($val["post_level"]); ?></td>
	  </tr><?php endforeach; endif; ?>
	</tbody>

</table>
	<div class="row">
		<div class="col-sm-10">
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
		</div>
	</div>


</div> <!-- /content-min-height -->


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
nowPage     = <?php echo ((isset($page) && ($page !== ""))?($page):"1"); ?>;
resultCount = <?php echo ((isset($resultCount) && ($resultCount !== ""))?($resultCount):0); ?>;
perPage     = <?php echo ((isset($perPage) && ($perPage !== ""))?($perPage):15); ?>;;
map         = <?php echo ((isset($map) && ($map !== ""))?($map):"''"); ?>;

$("document").ready(function(){
  initial();
})

function initial(){
  $("#navbar li#search").addClass("active");
  if(resultCount >=0 ) makePager(nowPage,resultCount);
  $("tr").click(function(){
  	alert($(this).attr("id"));
  })
  setChecked();
}
</script>
<script src="/Public/js/search.js"></script>

</body>	
</html>