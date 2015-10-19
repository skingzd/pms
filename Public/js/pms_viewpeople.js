/**
 * [getInfo 获得后台数据]
 * @param  {[type]} item [base,edu,title,trans]
 * @return {[type]}      [刷新指定模块]
 */
function pullData(item) {
	L(item);
	$.ajax({
			url: '/index.php/Common/getSearch/' + item + '/' + pid + '/1/',
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {
			if(item == 'base' && data.length == 0)unfound();
			fillData(data, item);
			L(item);			
		})
		.fail(function() {
			$('#' + item + 'Msg').text('服务器通信失败');
			L(item);
		})
		.always(function() {

		});

}
/**
 * [getData 生成发送到后台的data数组，从制定模块或制定模块的记录中获取]
 * @param  {[type]} item     [需要生成data的模块类别]
 * @param  {[type]} recordNo [模块下的记录号]
 * @return {[type]}          [返回数组 id : val]
 */
function buildData(record) {
	var data = {};
	// key, val, from;
	// from = '#' + item + 'Info';
	// if (typeof(record) != 'undefined') from += '>#' + item + record;

	$.each($(record).find('input,textarea,select'), function(i, e) {
		key = $(e).attr('id');
		val = $(e).val();
		//如果是checkbox
		if ($(e).is('[type=checkbox]')) val = $(e).is(':checked') ? 1 : 0;
		data[key] = val;
	});
	return data;
}
/**
 * [fillData 填充数据到页面]
 * @param  {[type]} data [用来填充的数据 格式 id:val]
 * @param  {[type]} item [项目名]
 * @return {[type]}      [NaN]
 */
function fillData(data, item) {
	var to;
	to = $('#' + item + 'Info');
	//清空状态
	$('#' + item + 'Msg').empty();

	if (item == 'base') {
		$.each(data[0], function(i, e) {
			$(to).find('#' + i).val(e);
		});

		if (data[0].editBy != '' && data[0].editTime != '') {
			$(to).find('#lastEdit').text('由 ' + data[0].editBy + ' 于 ' + data[0].editTime + ' 编辑.');
		}
		makeEditTip(to);
	} else {
		//清空Info类别列表
		$(to).find("div.record[id!='new']").remove();
		$.each(data, function(i, e) {
			//复制空条目，以ID命名
			$(to).find('#new')
				.clone(true)
				.show()
				.attr('id', e.id)
				.appendTo(to);
			$.each(e, function(inputId, value) {
				//填充数据
				if (inputId == 'topLevel') {
					//如果是设置checkBox的投票Level框则设置属性，其他用val设置
					if (value == '1') $(to).find(' #' + e.id + ' #' + inputId).attr('checked', 'checked');
				} else {
					$(to).find(' #' + e.id + ' #' + inputId).val(value);
				}
			});
			$(to).find(' #' + e.id + ' #recordId').text(e.id);
			if (e.editBy != '' && e.editTime != '') $(to).find(' #' + e.id + ' #lastEdit').text('由 ' + e.editBy + ' 于 ' + e.editTime + ' 编辑.');
		}); //.each
		makeEditTip(to);
		$(to).prev('.page-header').find('.add-record').show(300);
	} //if-else

}

function getRecord(e) {
	var record;
	if ($(e).parents("[class*='record']").length > 0) {
		record = $(e).parents("[class*='record']");
	} else {
		record = $(e).parents('#baseInfo');
	}
	return record;
}

function getItem(e) {
	var item;
	item = $(e).parents('.infobox').attr('id');
	item = item.substr(0, item.length - 4);
	return item;
}

function edit(e) {
	var record;
	record = getRecord(e);
	$(record).addClass('editing-record');
	$(record).find('input,textarea,select').removeAttr('disabled');
	$(record).find('#editTip').hide(300);
	$(record).find('#editPanel').show(300);

}

function cancel(e) {
	var item, record;
	item = getItem(e);
	record = getRecord(e);

	if (item == 'base') {
		$('#baseInfo').removeClass('editing-record');
		$('#baseInfo').find('input,textarea,select').attr('disabled', 'disabled');
		$('#baseInfo').find('#editPanel').hide(300);
		$('#baseInfo').find('#editTip').show(300);
	}
	if ($(record).attr('id') == 'newadd') {
		$(record).remove();
	}
	pullData(item);
}

function save(e) {
	var item, record, recordId, data, url;
	item = getItem(e);
	record = getRecord(e);
	data = buildData(record);
	recordId = $(record).attr('id');
	if (item == 'base') recordId = pid;

	url = '/index.php/Common/editRecord/' + item + '/' + recordId + '/1';
	//if action is addNew,change the submit url
	if (recordId == 'newadd') url = '/index.php/Common/addRecord/' + item + '/'+ pid +'/1';

	L(item + recordId);
	$.ajax({
			url: url,
			type: 'POST',
			data: data,
		})
		.done(function(msg) {
			$(record).removeClass('add-record');
			alert(msg);
			// console.log(msg);
			cancel(e);
		})
		.fail(function() {
			alert('服务器通信失败');
		})
		.always(function() {
			L(item + recordId);
			console.log(data);
		});

}

function makeEditTip(e) {
	if ($(e).attr('id') == 'baseInfo') {
		$(e).hover(function() {
			if ($(this).find('#editPanel').is(':hidden')) $(this).find('#editTip').show(300);
		}, function() {
			if ($(this).find('#editPanel').is(':hidden')) $(this).find('#editTip').hide(300);
		});
	} else {
		$(e).find(".record").hover(function() {
			if ($(this).find('#editPanel').is(':hidden')) $(this).find('#editTip').show(300);
		}, function() {
			if ($(this).find('#editPanel').is(':hidden')) $(this).find('#editTip').hide(300);
		});
	}
}

function del(e) {
	if (confirm("确定删除该条记录？")) {
		var item, record, recordId;
		item = getItem(e);
		record = getRecord(e);
		recordId = $(record).attr('id');
		if (item == 'base') {
			recordId = pid;
			if(!confirm("确定删除该人员信息？（同时会删除职称、学历、调动记录信息）"))return false;
		}

		$.ajax({
				url: '/index.php/Common/delRecord/' + item + '/' + recordId + '/1/',
				type: 'GET',
			})
			.done(function(msg) {
				console.log(msg);
				cancel(e);
			})
			.fail(function() {
				alert('服务器通信失败');
			})
			.always(function() {

			});
	}
}

function addRecord(item) {
	var to, newRecord;
	to = $('#' + item + 'Info');
	if ($(to).find('#newadd').is('div')) {
		alert("请先保存当前新建条目");
		return false;
	}
	newRecord = $(to).find('#new')
		.clone(true)
		.attr('id', 'newadd')
		.show(300)
		.addClass('editing-record')
		.prependTo($(to));
	$(newRecord).find('input,textarea,select').removeAttr('disabled');
	$(newRecord).find('#editPanel').show(300).find("a:contains('删除')").remove();
}

function unfound(){
	alert('未找到对应人员');
	location.href = '/index.php';
}