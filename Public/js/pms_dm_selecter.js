/**
 * [listDm description]
 * @param  {[type]} listTo    [目标容器]
 * @param  {[type]} defaultId [默认列表目录单位ID]
 * @param  {[type]} rootName  [默认列表目录单位名]
 * @param  {[type]} callFn    [每个单位名的回调函数，可选]
 * @param  {[type]} addsOn    [回调函数第三个参数，可传递，可选]
 * @return {[type]}           [no return]
 */
function listDm(listTo, defaultId, rootName, callFn, addsOn){

	var txt="<li id='0' class='open'><i></i><a href='javascript:void(0)'>"+rootName+"</a></li>\n";;
	$("#loading").show();
	$(listTo).empty();
	$(listTo).parent().find("button").last().text("选择部门");
	$.get('/index.php/Common/getDmTree/'+defaultId+'/1', function(dmTree) {

		buildTree = function(k,v){
		if(typeof(v.c) != "undefined"){
			// 有子部门，重复函数
			txt +="<li id='"+k+"' class='closed'><i></i><a href='javascript:void(0)'>"+v.n+"</a></li>\n";
			txt += "<ul  style='display:none;'>\n";
			$.each(v.c, function(ki, vi) {
				buildTree(ki,vi);
			});			
			txt += "</ul>\n";
			}else{
				txt +="<li id='"+k+"'><i></i><a href='javascript:void(0)'>"+v.n+"</a></li>\n"
			}
		}//buildTree

		txt += "<ul>";
		$.each(dmTree, function(key, val) {
			buildTree(key,val);
		}); //each
		txt += "</ul>";

		$(listTo).html(txt);

		$(listTo+" li[class] > i").click(function(){ 
			// 单击折叠按钮动作
			if($(this).parent("li").attr('class') == 'closed'){
					$(this).parent("li").attr('class',"open");
				}else{
					$(this).parent("li").attr('class',"closed");
			}
			$(this).parent("li").next("ul").toggle(300);			
		})
		$(listTo+" a").click(function(){
			//选中文字动作
			$(listTo+" a").removeClass();
			$(this).addClass('active');
			$(listTo).parent().find("button").last().text("选择->"+$(this).text());
		})
		.dblclick(function() {
			/* 设置文字双击动作 */
			if($(this).parent("li").attr('class') == 'closed'){
				$(this).parent("li").attr('class',"open");
				$(this).parent("li").next("ul").show(300);
			}else if($(this).parent("li").attr('class') == 'open'){
				$(this).parent("li").attr('class',"closed");
				$(this).parent("li").next("ul").hide(300);
			}
		});
		if(typeof(callFn) == "function"){
			//如果附加变量不存在则指定为空
			if(typeof(addsOn) == "undefined") addsOn = null;
			$(listTo+" a[href]").click(function(){
				callFn(
					$(this).parent("li").attr('id'),
					$(this).text(),
					addsOn
					);
			});
		}
	$("#loading").hide();
	}); // .get
}