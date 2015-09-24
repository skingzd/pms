function goPanel(panel){
	$("div[id^=panel]").hide();
	$("div[id^=panel"+panel+"]").show(200);
}

function choiceDm(dmId, dmName, addsOn){
	// alert(dmId+dmName);
	// alert(addsOn);
	if(typeof(addsOn) == "undefined") return false;
	// var nowDm = "#dmNowChoice";
	// $(nowDm).empty().text(dmName);
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
	$(to+' input,textarea').val('');
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
			if(data.e_by != '')	$("#editLog").text("最后由 "+data.e_by+" 于 "+data.e_time+" 编辑");
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
	}else{
		$("#loading").$.ajaxStop(function() {
			$(this).hide();
		});		
	}

}

function dmEditSave(add){
	var data,from,dmId,commitTo;
	from = '#dmInfo';
	dmId =  $(from+' #dmId').val();
	data = {
		'n'			:	$(from+' #dmName').val(),
		's'			:	$(from+' #dateSetup').val(),
		'c'			:	$(from+' #comment').val(),
		'byp'		:	$('#parentDmInfo #dmId').val(),
	};
	// 删除所有空值数据提交
	$.each(data, function(i, v) {
		if(v == '') data[i] = null;
	});
	if(dmId == "" && add == false){
		alert('请选择部门');
		listDm('#dmSelector', 0, '四矿', choiceDm, 'choiceDm');
		return false;
	} 

	// 检查是否有数据还在加载
	if( $("#dmInfo #dmId").val() == "加载中..." || $("#parentDmInfo #dmId").val() == "加载中..." ) {
		// 防止提前提交提示
		alert("请等待数据加载完毕");
		return false;
	}
	if($.trim(data.n) == ''){
		alert('部门名称不能为空');
		return false;
	}
	if($.trim(data.byp) == '' && dmId != "0"){
		alert('父级部门不能为空');
		return false;
	}
	
	
	//设置按钮无法点击
	$("#panelManageDm button").attr('disabled', 'disabled');
	//选择保存还是添加
	if(add == true){
		commitTo = "/index.php/Department/addnew";
	}else{
		commitTo = '/index.php/Department/edit/'+dmId;
	}
	// AJAX实现
	$.ajax({
		url: commitTo,
		type: 'POST',
		dataType: 'json',
		data: data,
	})
	.done(function(msg) {
		alert(msg);
		console.log("success");
		$("#panelManageDm button").removeAttr('disabled');
		if(add == true) $('#btnChoiceDm').attr('disabled', 'disabled');
	})
	.fail(function() {
		alert("服务器通信失败");
		console.log("error");
		$("#panelManageDm button").removeAttr('disabled');
		if(add == true) $('#btnChoiceDm').attr('disabled', 'disabled');
	});
}

function dmEditDel(){
	var dmId = $('#dmInfo #dmId').val();
	if( $.trim(dmId) == ''){
		alert("请选择要删除的部门");
		return false;
	}
	if( $.trim(dmId) == '加载中...'){
		alert("请等待加载完毕");
		return false;
	}
	$("#panelManageDm button").attr('disabled', 'disabled');

	if (confirm("确定删除？") == true){
		$.ajax({
		url: '/index.php/Department/del/'+dmId,
		type: 'GET',
		dataType: 'json',
		})
		.done(function(msg) {
			alert(msg);
			console.log("success");
			$("#panelManageDm button").removeAttr('disabled');
		})
		.fail(function() {
			alert("服务器通信失败");
			console.log("error");
			$("#panelManageDm button").removeAttr('disabled');
		});
	}

}