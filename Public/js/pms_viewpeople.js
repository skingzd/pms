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
			fillData(data, item);
			L(item);
		})
		.fail(function() {
			alert('服务器通信失败');
			L(item);
		})
		.always(function() {
			console.log("AJAX DONE");
		});

}
/**
 * [getData 生成发送到后台的data数组，从制定模块或制定模块的记录中获取]
 * @param  {[type]} item     [需要生成data的模块类别]
 * @param  {[type]} recordNo [模块下的记录号]
 * @return {[type]}          [返回数组 id : val]
 */
function buildData(item, recordNo) {
	var data = {},
		key, val, from;
	from = '#' + item + 'Info';
	if (typeof(recordNo) != 'undefined') from += '>#' + item + recordNo;
	console.log(from);
	$.each($(from + ' input,' + from + ' select,' + from + ' textarea'), function(i, e) {
		/* iterate through array or object */
		key = $(e).attr('id');
		val = $(e).val();
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
	to = '#' + item + 'Info ';
	if(item == 'base') {
		$.each(data[0], function(i, e) {
			/*  */
			$(to + '#' + i).val(e);
		});	
	}else{
		//清空Info类别列表
		$(to + "div.record[id!='new']").remove();
		$.each(data, function(i, e) {
			//复制空条目，以ID命名
			$(to + '#new')
				.clone(true)
				.show()
				.attr('id', e.id)
				.appendTo(to);
			$.each(e, function(inputId, value) {
				//填充数据
				if(inputId == 'topLevel'){
					//如果是设置checkBox的投票Level框则设置属性，其他用val设置
					if(value == '1') $(to + ' #' + e.id + ' #' + inputId).attr('checked', 'checked');
				}else{
					$(to + ' #' + e.id + ' #' + inputId).val(value);
				}
			});
			$(to + ' #' + e.id + ' #recordId').text(e.id);
			if(e.editBy != '' && e.editTime != '')$(to + ' #' + e.id + ' #lastEdit').text('由' + e.editBy + '于' + e.editTime + '编辑.');
		});	
	}
	
}
function getRecord(e){
	var record;
	if($(e).parents("[class*='record']").length > 0 ){
		record = $(e).parents("[class*='record']");
	}else{
		record = $(e).parents('#baseInfo');
	}
	return record;
}

function getItem(e){
	var item;
	item = $(e).parents('.infobox').attr('id');
	item = item.substr(0, item.length-4);
	return item;
}

function edit(e){
	var record;
	record = getRecord(e);
	$(record).find('input,textarea,select').removeAttr('disabled');
	$(record).find('#editTip').hide(300);
	$(record).find('#editPanel').show(300);

}

function cancelEdit(e){
	var item;
	item = getItem(e);
	if (item =='base'){
		$('#baseInfo').find('input,textarea,select').attr('disabled','disabled');
		$('#baseInfo').find('#editPanel').hide(300);
		$('#baseInfo').find('#editTip').show(300);
	}
	pullData(item);	
}