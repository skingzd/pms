/**
 * [getInfo 获得后台数据]
 * @param  {[type]} item [base,edu,title,trans]
 * @return {[type]}      [刷新指定模块]
 */
function pullData(item) {
	$.ajax({
			url: '/index.php/Common/getSearch/' + item + '/' + pid + '/1/',
			type: 'GET',
			dataType: 'json',
		})
		.done(function(data) {

			console.log(data);
			fillData(data, item);
		})
		.fail(function() {
			alert('服务器通信失败');
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
		$.each(data, function(i, e) {
			//复制空条目，以ID命名
			$(to + '#new')
				.clone(true)
				.show()
				.attr('id', e.id)
				.appendTo(to);
			$.each(e, function(inputId, value) {
				//填充数据
				$(to + ' #' + e.id + ' #' + inputId).val(value);
			});
			$(to + ' #' + e.id + ' #recordId').text(e.id);
		});	
	}
	
}