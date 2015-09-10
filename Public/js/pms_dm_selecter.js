function listDm(listTo, defaultId, rootName, callFn){

	var txt=rootName,li;
	$("#loading").show();
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

		$(listTo).append(txt);

		$("li[class]").click(function(){ 
			// $(this).removeClass();
			if($(this).attr('class') == 'closed'){
					$(this).attr('class',"open");
				}else{
					$(this).attr('class',"closed");
			}
			$(this).next("ul").toggle(300);
			
		})
	$("#loading").hide();
	}); // .get
}