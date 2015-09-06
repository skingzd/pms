    function pListLoadFrom(id,page){
    // 动态加载人员列表框内容
    var subTitle = $("#pListTitle+#subTitle");
    page = typeof(page) == "undefined" ? 1 : page ;//默认第一页

    $(subTitle).text("加载中...");
    $("#content-right").show();
    $.get("/index.php/Common/getDmP/"+id+"/0/"+page+"/1/",function(p){
      if(typeof(p['_msg']) != "undefined") $(subTitle).text(p['_msg']);

      $(subTitle).text("共"+p["resultCount"]+"人");

      $("#pList").empty();
      

      $(p["result"]).each(function(i){
        var no,id,name,sex,birthday,date_startwork,post,post_level,txt;
        no        =   (page-1)*perPage+i+1;
        id        =   p["result"][i]["pid"];
        name      =   p["result"][i]["name"];
        sex       =   (p["result"][i]["sex"] ==   1) ?  "男" : "女";
        birthday  =   p["result"][i]["birthday"];
        workdate  =   p["result"][i]["date_startwork"];
        post      =   p["result"][i]["post"];
        postLevel =   p["result"][i]["post_level"];

        txt += "<tr id=\""+id+"\">";
        txt += "<th scope=\"row\">"+no+"</th>";
        txt += "<td>"+name+"</td>";
        txt += "<td>"+sex+"</td>";
        txt += "<td>"+birthday+"</td>";
        txt += "<td>"+workdate+"</td>";
        txt += "<td>"+post+"</td>";
        txt += "<td>"+postLevel+"</td>";
        txt += "</tr>";
        $("#pList").append(txt);
        $("#"+id).click(id,function(id){
          alert(id.data);
        })
      });
      //输出翻页条
      makePager(id,page,p["resultCount"]);
    });
    $("#pListTitle").text(dmList[id]["name"]);
  }
  function makePager (id,page,resultCount) {
    // 清除页数列表
    var i,li,a;
    page={
      "pre":page-1,
      "now":page,
      "next":page+1, 
      "per":perPage, 
      "max":null, 
      "dmId":null, 
      "resultCount":resultCount, 
    };
    page.dmId = parseInt(id);
    page.max = parseInt(page.resultCount/page.per);
    if(page.max*page.per < page.resultCount) page.max = parseInt(page.max)+1;

    //清除工作
    $("#pager li").unbind("click");
    $("#pager li").removeClass();
    while($("#pre+").attr("id") != "next"){
      $("#pre+").remove();
    }
    
    //上一页按钮
    if(page.now == 1) {//是第一页则禁用上一页
      $("#pre").addClass("disabled");
    }else{//不是第一页则设定上一页按钮页码-1
      $("#pre").click({"dm":page.dmId,"to":page.pre},function(p){ pListLoadFrom( p.data.dm, p.data.to ); });
    }

    // 页面按钮
    for(i = 1; i <= page.max; i++){
      li = $("<li></li>");
      a = $("<a></a>").text(i);
      if(i == page.now){
        $(li).addClass("active");
      }else{
        $(li).click({"dm":page.dmId,"to":i},function(p){ pListLoadFrom( p.data.dm, p.data.to ); });
      }
      li = $(li).append(a);
      $("#next").before(li);      
    }
    // 下一页按钮123
    if(page.next > page.max) {//如果是最后一页
      $("#next").addClass("disabled");
    }else{
      $("#next").click({"dm":page.dmId,"to":page.next},function(p){ pListLoadFrom( p.data.dm, p.data.to ); });
    }
    if(page.max == 0){
      $("#pager").hide();
    }else{
      $("#pager").show();
    }

    // $("#pre").append(function(){})
  }

  function dmListLoadFrom(id){
    //动态加载单位列表
    var dm,key,txt;
    $("#dmList").empty().text("加载中...");
    $.get("/index.php/Common/getDm/"+id+"/1/1",function(dm){
      $("#dmList").empty();
      for(key in dm){
        txt = $("<a></a>")
              .addClass("list-group-item")
              .attr("id",key)
              .text(dm[key]['name'])
              .attr("href","#top")
              .click(key,function(k){goToDm(k.data)});
        $("#dmList").append(txt);
      }
      // 更新单位列表
      dmList = dm;
    });    
  }

  function backToDm(id){
    $("#dmPath>li#"+id+"~li").remove();
    $("#dmPath>li#"+id).addClass("active").unbind("click");
    dmListLoadFrom(id);
  }

  function goToDm(id){
    var lastPath,lastId,txt,isParent;
    lastPath = $("#dmPath>li:last");
    lastId = $(lastPath).attr("id");
    if(typeof(dmList[id]) != "undefined") isParent = dmList[id]["is_parent"];
    if(isParent == 1){
      //移除当前单位样式，恢复点击跳转
      $(lastPath).removeClass().click(lastId,function(n){backToDm(n.data)});
      //添加新路径为id部门
      txt = $("<li></li>")
            .addClass('active')
            .attr("id",id)
            .text(dmList[id]["name"]);
      $("#dmPath").append(txt);

      dmListLoadFrom(id);
      pListLoadFrom(id);
    }else{
      //不是父部门则更改路径当前位置
      $(lastPath).attr("id",id).text( dmList[id]["name"] );
      // 去掉当前活动部门样式，设置新部门为活动样式
      $("#dmList>a#"+lastId).removeClass().addClass("list-group-item");
      $("#dmList>a#"+id).addClass("active");
      pListLoadFrom(id);
    }
  }