function goPanel(panel){
	$("div[id^=panel]").hide();
	$("div[id^=panel"+panel+"]").show(200);
}

function choiceDm(dmId, dmName, addsOn){
	// alert(dmId+dmName);
	if(typeof(addsOn) == "undefined") return false;
	var nowDm = "#dmNowChoice";
	$(nowDm).val('').text(dmName);
	if(addsOn == "choiceDm") $("#choiceButton").unbind('click').click( {"dmId" : dmId, "to" : "dm"}, getDm);
	if(addsOn == "choiceP") $("#choiceButton").unbind('click').click( {"dmId" : dmId, "to" : "p"}, getDm);	
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
}

function dmEditSave(){
	var data,from;
	from = '#dmInfo';
	data = {
		'id'			:	Number($(from+' #dmId').val()),
		'name'			:	$(from+' #dmName').val(),
		'datesetup'	:	$(from+' #dateSetup').val(),
		'c'			:	$(from+' #comment').val(),
		'byp'		:	Number($('#parentDmInfo #dmId').val()),
	};
	if( $("#dmInfo #dmId").val() != "加载中..." && $("#parentDmInfo #dmId").val() != "加载中..." ) {
		if(data.name == '' && data.byp == ''){
			alert("部门名称和父级部门不能为空");
		}else{
			$.post('/index.php/Department/edit/'+data.id, data, function(msg) {
				alert(msg);
			}); // /.post
		}	
	}else{
		alert("请等待数据加载完毕");
	}
	

}