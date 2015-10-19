function pListLoadFrom(id, page) {
  // 动态加载人员列表框内容
  if($("#subTitle").text() == "加载中...") return false;
  page = typeof(page) == "undefined" ? 1 : page; //默认第一页
  L('pListLoadFrom');
  setTimeout(3000);
  $("#subTitle").text("加载中...");
  $("#content-right").show();
  $("#pList").empty();
  $.get("/index.php/Common/getDmP/" + id + "/0/" + page + "/1/", function(p) {
    if (typeof(p['_msg']) != "undefined") $(subTitle).text(p['_msg']);
    $(p["result"]).each(function(i) {
      var no, id, name, sex, birthday, date_startwork, post, post_level, txt;
      no = (page - 1) * perPage + i + 1;
      id = p["result"][i]["pid"];
      name = p["result"][i]["name"];
      sex = (p["result"][i]["sex"] == 1) ? "男" : "女";
      birthday = p["result"][i]["birthday"];
      workdate = p["result"][i]["date_startwork"];
      post = p["result"][i]["post"];
      postLevel = p["result"][i]["post_level"];

      txt += "<tr id=\"" + id + "\">";
      txt += "<th scope=\"row\">" + no + "</th>";
      txt += "<td>" + name + "</td>";
      txt += "<td>" + sex + "</td>";
      txt += "<td>" + birthday + "</td>";
      txt += "<td>" + workdate + "</td>";
      txt += "<td>" + post + "</td>";
      txt += "<td>" + postLevel + "</td>";
      txt += "</tr>";
      $("#pList").append(txt);
    });
    // ./each
    //输出翻页条
    console.log("#pager", page, p["resultCount"], perPage, goPage, id);
    makePager("#pager", page, p["resultCount"], perPage, goPage, id);
    $("#subTitle").text("共" + p["resultCount"] + "人");
    
    $("tr[id]").click(function() {//实现行点击动作
      location.href="/index.php/People/view/"+this.id;
    })
    L('pListLoadFrom');
  });
  //.get
  $("#pListTitle").text(dmList[id]["n"]);
}

function dmListLoadFrom(id) {
  //动态加载单位列表
  var dm, key, txt;
  L('dmListLoadFrom');
  
  $("#dmList").empty().text("加载中...");
  $.get("/index.php/Common/getDm/" + id + "/1/1", function(dm) {
    $("#dmList").empty();
    for (key in dm) {
      txt = $("<a></a>")
        .addClass("list-group-item")
        .attr("id", key)
        .text(dm[key]['n'])
        .attr("href", "#top")
        .click(key, function(k) {
          goToDm(k.data)
        });
      $("#dmList").append(txt);
      
    }
    // 更新单位列表
    dmList = dm;
    L('dmListLoadFrom');
  });
}

function backToDm(id) {
  $("#dmPath>li#" + id + "~li").remove();
  $("#dmPath>li#" + id).addClass("active").unbind("click");
  dmListLoadFrom(id);
}

function goToDm(id) {
  var lastPath, lastId, txt, isParent;
  L('goToDm');
  lastPath = $("#dmPath>li:last");
  lastId = $(lastPath).attr("id");
  if (typeof(dmList[id]) != "undefined") isParent = dmList[id]["is_p"];
  if (isParent == 1) {
    //移除当前单位样式，恢复点击跳转
    $(lastPath).removeClass().click(lastId, function(n) {
      backToDm(n.data)
    });
    //添加新路径为id部门
    txt = $("<li></li>")
      .addClass('active')
      .attr("id", id)
      .text(dmList[id]["n"]);
    $("#dmPath").append(txt);

    dmListLoadFrom(id);
    pListLoadFrom(id);
    L('goToDm');
  } else {
    //不是父部门则更改路径当前位置
    $(lastPath).attr("id", id).text(dmList[id]["n"]);
    // 去掉当前活动部门样式，设置新部门为活动样式
    $("#dmList>a#" + lastId).removeClass().addClass("list-group-item");
    $("#dmList>a#" + id).addClass("active");
    pListLoadFrom(id);
    L('goToDm');
  }
  

}
function goPage(e){
  // alert(e.data.addsOn);
  // alert(e.data.to);
  pListLoadFrom(e.data.addsOn,e.data.to);
}