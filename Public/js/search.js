function makePager (nowPage,resultCount) {
    // 清除页数列表
    var i,li,a;
    page={
      "pre":nowPage-1,
      "now":nowPage,
      "next":nowPage+1, 
      "per":perPage, 
      "max":null, 
      "resultCount":resultCount, 
    };

    page.max = parseInt(page.resultCount/page.per);
    if(page.max*page.per < page.resultCount) page.max = parseInt(page.max)+1;
    //如果没有记录则隐藏pager
    if(page.max == 0){
      $("#pager").hide();
    }else{
      $("#pager").show();
    }

    //清除工作
    $("#pager li").unbind("click");
    $("#pager li").removeClass();
    while($("#pre+").attr("id") != "next"){
      $("#pre+").remove();
    }
    
    //上一页按钮
    if(page.now <= 1) {//是第一页则禁用上一页
      $("#pre").addClass("disabled");
    }else{//不是第一页则设定上一页按钮页码-1
      $("#pre").click(page.pre, function(p){ submitSearch(p.data); });
    }

    // 页面按钮
    for(i = 1; i <= page.max; i++){
      li = $("<li></li>");
      a = $("<a></a>").text(i);
      if(i == page.now){
        $(li).addClass("active");
      }else{
        $(li).click(i, function(p){submitSearch(p.data); });
      }
      li = $(li).append(a);
      $("#next").before(li);      
    }
    // 下一页按钮123
    if(page.next >= page.max) {//如果是最后一页
      $("#next").addClass("disabled");
    }else{
      $("#next").click(page.next, function(p){ submitSearch(p.data); });
    }
}

function setChecked(){
  
  if(cr(map,"name")) {
    map['name'][1] = map['name'][1].replace(/\%/g,"");
    $("#name").attr("value",map['name']['1']);
  }

  if(cr(map,"birthday")){
    $("#birthday").attr("value",map['birthday'][1]);
    $("#birthdayB>[value="+map['birthday'][0]+"]").attr("selected","selected");
  }
  if(cr(map,"date_start_work")){
    $("#workdate").attr("value",map['date_start_work'][1]);
    $("#workdateB>[value="+map['date_start_work'][0]+"]").attr("selected","selected");
  }
  if(cr(map,"post_level")){
    $("#postLevel>[value="+map['post_level'][1]+"]").attr("selected","selected");
    $("#postLevelB>[value="+map['post_level'][0]+"]").attr("selected","selected");
  }
  if(cr(map,"title_level")){
    $("#titleLevel>[value="+map['title_level'][1]+"]").attr("selected","selected");
    $("#titleLevelB>[value="+map['title_level'][0]+"]").attr("selected","selected");
  }
  if(cr(map,"edu_level")){
    $("#eduLevel>[value="+map['edu_level'][1]+"]").attr("selected","selected");
    $("#eduLevelB>[value="+map['edu_level'][0]+"]").attr("selected","selected");
  }
  if(cr(map,"sex")){
    $(":radio").removeAttr("checked");
    $("label").removeClass("active");
    switch ( map["sex"] )
    {
      case "0" :
      $("#sex-f").attr("checked","checked").parent().addClass("active");
      break;

      case "1" :
      $("#sex-m").attr("checked","checked").parent().addClass("active");
      break;

      default:
      $("#sex").attr("checked","checked").parent().addClass("active");
    }
  }
}
function cr(m,rule){ //short for check rule
  if(typeof(m[rule]) == "undefined") return false;

  if(typeof(m[rule]) == "object"){
    if(typeof(m[rule][0]) == "undefined") false;
    if(typeof(m[rule][1]) == "undefined") false;
    if(m[rule][0] == "") false;
    if(m[rule][1] == "") false;
  }

  if(typeof(m[rule]) == "string"){
    if(typeof(m[rule]) == "undefined") return false;
    if(m[rule] == "") return false;
  }
  return true;
}

function submitSearch(page){
  $("#page").attr("value",page);
  $("#searchForm").submit();
}