function goPanel(panel){
	$("div[id^=panel]").hide();
	$("div[id^=panel"+panel+"]").show(200);
}

function choiceDm(dmId, dmName, addsOn){
	// alert(dmId+dmName);
	// alert(addsOn);
	if(typeof(addsOn) == "undefined") return false;
	var nowDm = "#dmNowChoice";
	$(nowDm).empty().text(dmName);
	if(addsOn == "choiceDm") $("#choiceButton").unbind('click').click( {"dmId" : dmId, "to" : "dm"}, getDm);
	if(addsOn == "choiceP") {
		if($("#dmInfo #dmName").val() == ""){
			alert("指定活动部门后选择父级部门");
			$("#selectorModal").modal('hide');
		}else{
			$("#choiceButton").unbind('click').click( {"dmId" : dmId, "to" : "p"}, getDm);
		}
	}
}

function getDm(e){
	var to,dmId;
	if (e.data.to == "dm" ) to = "#dmInfo";
	if (e.data.to == "p") to = "#parentDmInfo";
	dmId = e.data.dmId;

	$("#selectorModal").modal('hide');
	$(to+" #dmId").val('加载中...');
	loading('dm');
	$.get('/index.php/Common/getDm/'+dmId+'/0/1', function(data) {
		if(typeof(data.n) == "undefined") {
			$(to+" #dmName").val('所选部门无效');
		}else{
			//调出数据
			$(to+" #dmName").val(data.n);
			$(to+" #dmId").val(dmId);
			$(to+" #dateSetup").val(data.date_setup);
			$(to+" #comment").val(data.comment);	
		}
		loading('dm');
		if (e.data.to == "dm" ) getP(dmId);
	});
}

function getP(dmId){
	var to ="#parentDmInfo";
	$("#selectorModal").modal('hide');
	$(to+" #dmId").val('加载中...');
	loading('dm');
	$.get('/index.php/Common/getDm/'+dmId+'/0/1', function(dm) {
		// alert(dm.by_p);
		$.get('/index.php/Common/getDm/'+dm.by_p+'/0/1', function(p) {
			//调出数据
			// alert(p.n);
			$(to+" #dmName").val(p.n);;
			$(to+" #dmId").val(dm.by_p);
			$(to+" #dateSetup").val(p.date_setup);
			$(to+" #comment").val(p.comment);	
			loading('dm');
		});	
		loading('dm');
	});
}

function loading(op){
	$("#loading").show();
	if(op == "dm"){
		if( $("#dmInfo #dmId").val() != "加载中..." && $("#parentDmInfo #dmId").val() != "加载中..." ) {
			$("#loading").hide();
		}
	}
	if(op == 'saveDm'){

	}
}

function dmEditSave(){
	var data,from,dmId;
	from = '#dmInfo';
	dmId =  $(from+' #dmId').val()
	data = {
		'n'			:	$(from+' #dmName').val(),
		's'			:	$(from+' #dateSetup').val(),
		'c'			:	$(from+' #comment').val(),
		'byp'		:	$('#parentDmInfo #dmId').val(),
	};
	//删除所有空值数据提交
	// $.each(data, function(i, v) {
	// 	if(v == '') delete data[i];
	// });
	if(dmId == "")	return false;

	// 检查是否有数据还在加载
	if( $("#dmInfo #dmId").val() == "加载中..." || $("#parentDmInfo #dmId").val() == "加载中..." ) {
		// 防止提前提交提示
		alert("请等待数据加载完毕");
		return false;
	}
	if(data.n == '' || data.byp == ''){
		if(dmId != "0"){
			alert("部门名称与父级部门不能为空");
			return false;
		}
		
	}

	// 规范数据
	dmId = Number(dmId);
	if(data.byp != "") data.byp = Number(data.byp);
	
	//设置按钮无法点击
	// $("#saveDm").unbind('click').attr('disabled', 'disabled');
	$.post('/index.php/Department/edit/'+dmId, data, function(msg) {
		alert(msg);
		// $("#saveDm").click(dmEditSave).removeAttr('disabled');
	},"json"); // /.post

}