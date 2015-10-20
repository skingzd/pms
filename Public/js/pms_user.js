function goPanel(panel) {
	$("div[id^=panel]").hide();
	$("div[id^=panel" + panel + "]").show(200);
	if (panel == 'ManageUser'){
		listUser(1);
		$('#userEditor #ulevel').change(function() {
			$(this).next('kbd').text($(this).val());
		});
		$('#userCreator #ulevel').change(function() {
			$(this).next('kbd').text($(this).val());
		});
	} 
}

function choiceDm(dmId, dmName, addsOn) {
	// alert(dmId+dmName);
	// alert(addsOn);
	if (typeof(addsOn) == "undefined") return false;
	// var nowDm = "#dmNowChoice";
	// $(nowDm).empty().text(dmName);
	if (addsOn == "choiceDm") $("#choiceButton").unbind('click').click({
		"dmId": dmId,
		"to": "dm"
	}, getDm);
	if (addsOn == "choiceP") {
		if ($("#dmInfo #dmName").val() == "") {
			alert("指定活动部门后选择父级部门");
			$("#selectorModal").modal('hide');
		} else {
			$("#choiceButton").unbind('click').click({
				"dmId": dmId,
				"to": "p"
			}, getDm);
		}
	}
}

function getDm(e) {
	var to, dmId;
	L('getDm');
	if (e.data.to == "dm") to = "#dmInfo";
	if (e.data.to == "p") to = "#parentDmInfo";
	dmId = e.data.dmId;
	$(to + ' input,textarea').val('');
	// $("#selectorModal").modal('hide');
	$(to + " #dmId").val('加载中...');

	$.get('/index.php/Common/getDm/' + dmId + '/0/1', function(data) {
		if (typeof(data.n) == "undefined") {
			$(to + " #dmName").val('所选部门无效');
		} else {
			//调出数据
			$(to + " #dmName").val(data.n);
			$(to + " #dmId").val(dmId);
			$(to + " #dateSetup").val(data.date_setup);
			$(to + " #comment").val(data.comment);
			if (data.e_by != '') $("#editLog").text("最后由 " + data.e_by + " 于 " + data.e_time + " 编辑");
		}
		if (e.data.to == "dm") getP(dmId);
		L('getDm');
	});
}

function getP(dmId) {
	var to = "#parentDmInfo";
	L('getP');
	// $("#selectorModal").modal('hide');
	$(to + " #dmId").val('加载中...');
	$.get('/index.php/Common/getDm/' + dmId + '/0/1', function(dm) {
		// alert(dm.by_p);
		$.get('/index.php/Common/getDm/' + dm.by_p + '/0/1', function(p) {
			//调出数据
			// alert(p.n);
			$(to + " #dmName").val(p.n);;
			$(to + " #dmId").val(dm.by_p);
			$(to + " #dateSetup").val(p.date_setup);
			$(to + " #comment").val(p.comment);
		});
		L('getP');
	});
}


function dmEditSave(add) {
	var data, from, dmId, commitTo;
	from = '#dmInfo';
	dmId = $(from + ' #dmId').val();
	data = {
		'n': $(from + ' #dmName').val(),
		's': $(from + ' #dateSetup').val(),
		'c': $(from + ' #comment').val(),
		'byp': $('#parentDmInfo #dmId').val(),
	};
	// 删除所有空值数据提交
	$.each(data, function(i, v) {
		if (v == '') data[i] = null;
	});
	if (dmId == "" && add == false) {
		alert('请选择部门');
		listDm('#dmSelector', 0, '四矿', choiceDm, 'choiceDm');
		return false;
	}

	// 检查是否有数据还在加载
	if ($("#dmInfo #dmId").val() == "加载中..." || $("#parentDmInfo #dmId").val() == "加载中...") {
		// 防止提前提交提示
		alert("请等待数据加载完毕");
		return false;
	}
	if ($.trim(data.n) == '') {
		alert('部门名称不能为空');
		return false;
	}
	if ($.trim(data.byp) == '' && dmId != "0") {
		alert('父级部门不能为空');
		return false;
	}


	//设置按钮无法点击
	$("#panelManageDm button").attr('disabled', 'disabled');
	//选择保存还是添加
	if (add == true) {
		commitTo = "/index.php/Department/addnew";
	} else {
		commitTo = '/index.php/Department/edit/' + dmId;
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
			if (add == true) $('#btnChoiceDm').attr('disabled', 'disabled');
		})
		.fail(function() {
			alert("服务器通信失败");
			console.log("error");
			$("#panelManageDm button").removeAttr('disabled');
			if (add == true) $('#btnChoiceDm').attr('disabled', 'disabled');
		});
}

function dmEditDel() {
	var dmId = $('#dmInfo #dmId').val();
	if ($.trim(dmId) == '') {
		alert("请选择要删除的部门");
		return false;
	}
	if ($.trim(dmId) == '加载中...') {
		alert("请等待加载完毕");
		return false;
	}
	$("#panelManageDm button").attr('disabled', 'disabled');

	if (confirm("确定删除？") == true) {
		$.ajax({
				url: '/index.php/Department/del/' + dmId,
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

function changePwd() {
	var data;
	data = {
		'oldPwd': $('#panelChangePwd #oldPwd').val(),
		'newPwd': $('#panelChangePwd #newPwd').val(),
		'reNewPwd': $('#panelChangePwd #reNewPwd').val(),
	};

	if (data.newPwd === data.oldPwd) {
		alert('原密码与新密码一致，无需修改');
		return;
	}

	if (data.newPwd.length < 6 || data.newPwd.length > 16) {
		alert('密码长度需在6-16位之间');
		return;
	}

	if (data.reNewPwd !== data.newPwd) {
		alert('新密码与重复新密码不一致');
		return;
	}

	$('#panelChangePwd button').attr('disabled', 'disabled');
	$.ajax({
			url: '/index.php/User/changePwd/',
			type: 'POST',
			data: data,
			dataType: 'json',
		})
		.done(function(msg) {
			alert(msg);
			console.log("success：" + msg);
			$('#panelChangePwd button').removeAttr('disabled');
			$('#panelChangePwd input').val('');
		})
		.fail(function() {
			alert("服务器通信失败");
			console.log("error");
			$('#panelChangePwd button').removeAttr('disabled');
		});
}

function listUser(e) {
	var txt, url, word, page;
	L('listUser');
	console.log(e);
	if (typeof(e.data) == 'object') {
		//如果通过makePager传入事件
		// console.log('pager事件传入');
		page = e.data.to;
		if (e.data.addsOn != null) word = e.data.addsOn;
	}
	if (typeof(e.data) == 'undefined' && typeof(e) != 'number' && typeof(e) == 'object') {
		//如果传入数组
		page = e.to;
		word = e.addsOn;
		// console.log('搜索数组传入');
	}
	if (typeof(e) == 'number') {
		page = e;
		word = null;
		// console.log('页码直接传入');
	}
	url = '/index.php/User/listUser/' + page;
	if (word != null) {
		url = '/index.php/User/listUser/' + page + '/1/' + word;
	}

	console.log(url);
	$.get(url, function(data) {
		console.log(data);
		if (typeof(data) != 'object') {
			$('#userList').text(data);
			L('listUser');
			return false;
		}
		$('#userList').empty();
		$.each(data.r, function(index, val) {
			txt = '<a href=\"javascript:void(0);\" class=\"list-group-item\" id=\"' + val.i + '\"><span class=\"badge\">' + val.l + '</span>' + val.n + '</a>\n';
			$('#userList').append(txt);
		}); // ./each
		$('#userList a').click(function() {
			$('#userList a').removeClass('active');
			$(this).addClass('active');
			viewUser($(this).attr('id'));
		});
		makePager('#userListPager', page, data['_count'], 3, listUser, word);
		L('listUser');
	}); // ./get


}

function saveUser() {

	var uid, data = {
		pwd: $('#userEditor #pwd').val(),
		level: $('#userEditor #ulevel').val(),
	};
	uid = $('#userEditor #uid').text();

	if (data.pwd != '' && (data.pwd.length < 6 || data.pwd.length > 16)) {
		alert('密码长度需在6-16位之间');
		return;
	}

	if (data.level < 1 || data.level > 8) {
		alert('级别设置错误');
		return;
	}
	$('#userEditor button').attr('disabled', 'disabled');
	$.ajax({
			url: '/index.php/User/saveUser/' + uid,
			type: 'POST',
			dataType: 'json',
			data: data,
		})
		.done(function(msg) {
			console.log("发送成功");
			alert(msg);
			listUser(Number($('#userListPager .active > a').text()));
			$('#userEditor button').removeAttr('disabled', 'disabled');

		})
		.fail(function() {
			alert('服务器通信失败');
			console.log("服务器端返回数据错误");
			$('#userEditor button').removeAttr('disabled', 'disabled');
		})
		.always(function() {
			console.log(data);
		});

}

function viewUser(uid) {
	var to = '#userEditor ';
	$(to).addClass('active');
	L('vewUser');
	$.ajax({
			url: '/index.php/User/viewUser/' + uid,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {
			console.log(data);
			$.each(data, function(i, v) {
				if (v == null) data[i] = '';
			});
			$(to + '#uid').text(data.i);
			$(to + '#uname').text(data.n);
			$(to + '#ulevel').val(data.l);
			$(to + '#ulevel+kbd').text(data.l);
			$(to + '#ucreate').text(data.c);
			$(to + '#ulastlogin').text(data.t);
			L('vewUser');
		}) // ./.done
		.fail(function() {
			L('vewUser');
			alert('服务器通信失败');
			console.log("服务器端返回数据错误");
		})
		.always(function() {
			console.log(uid);
		});

}

function searchUser() {
	var map, word = $('#panelManageUser #searchUser').val();
	if (word == '') word = null;
	map = {
		to: 1,
		addsOn: word,
	}
	listUser(map);
}

function addUser() {
	var data, from;
	from = '#userCreator ';
	data = {
		name: $(from + '#uname').val(),
		pwd: $(from + '#pwd').val(),
		rePwd: $(from + '#rePwd').val(),
		level: $(from + '#ulevel').val(),
	}
	if (data.pwd != '' && (data.pwd.length < 6 || data.pwd.length > 16)) {
		alert('密码长度需在6-16位之间');
		return;
	}

	if (data.level < 1 || data.level > $(from + "#ulevel").attr('max')) {
		alert('级别设置错误');
		return;
	}

	if (data.pwd !== data.rePwd) {
		alert('新密码与重复新密码不一致');
		return;
	}
	$(from + 'button').attr('disabled', 'disabled');
	$.ajax({
			url: '/index.php/User/addUser',
			type: 'POST',
			dataType: 'json',
			data: data,
		})
		.done(function(msg) {
			alert(msg);
			$(from+'input').val('');
			listUser(1);
		})
		.fail(function() {
			alert('服务器通信失败')
		})
		.always(function() {
			$(from + 'button').removeAttr('disabled');
		});

}