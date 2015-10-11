function setChecked() {

  if (cr(map, "name")) {
    map['name'][1] = map['name'][1].replace(/\%/g, "");
    $("#name").attr("value", map['name']['1']);
  }

  if (cr("birthday")) {//检查存在birthday条件
    $("#birthday").attr("value", map['birthday'][1]);//设置生日数值为后台传递map值
    $("#birthdayB>[value=" + map['birthday'][0] + "]").attr("selected", "selected");//设置该值为被选择状态
  }
  if (cr("workdate")) {
    $("#workdate").attr("value", map['workdate'][1]);
    $("#workdateB>[value=" + map['workdate'][0] + "]").attr("selected", "selected");
  }
  if (cr("postLevel")) {
    $("#postLevel>[value=" + map['postLevel'][1] + "]").attr("selected", "selected");
    $("#postLevelB>[value=" + map['postLevel'][0] + "]").attr("selected", "selected");
  }
  if (cr("titleLevel")) {
    $("#titleLevel>[value=" + map['titleLevel'][1] + "]").attr("selected", "selected");
    $("#titleLevelB>[value=" + map['titleLevel'][0] + "]").attr("selected", "selected");
  }
  if (cr("eduLevel")) {
    $("#eduLevel>[value=" + map['eduLevel'][1] + "]").attr("selected", "selected");
    $("#eduLevelB>[value=" + map['eduLevel'][0] + "]").attr("selected", "selected");
  }
  if (cr("postType")) {
    $("#postType>[value=" + map['postType'] + "]").attr("selected", "selected");
  }
  if (cr("sex")) {
    $(":radio").removeAttr("checked");
    $("label").removeClass("active");
    switch (map["sex"]) {
      case "0":
        $("#sex-f").attr("checked", "checked").parent().addClass("active");
        break;

      case "1":
        $("#sex-m").attr("checked", "checked").parent().addClass("active");
        break;

      default:
        $("#sex").attr("checked", "checked").parent().addClass("active");
    }
  }
}

function cr(rule) { //short for check rule

  if (map[rule] == null) return false;
  if (typeof(map[rule]) == "undefined") return false;
  
  if (typeof(map[rule]) == "string") {
    if (typeof(map[rule]) == "undefined") return false;
    if (map[rule] == "") return false;
  }

  if (typeof(map[rule]) == "object") {
    if (typeof(map[rule][0]) == "undefined") false;
    if (typeof(map[rule][1]) == "undefined") false;
    if (map[rule][0] == "") false;
    if (map[rule][1] == "") false;
  }
  return true;
}

function goPage(e){
  $("#page").attr("value", e.data.to);
  $("#searchForm").submit();
}