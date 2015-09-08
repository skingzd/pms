function setChecked() {

  if (cr(map, "name")) {
    map['name'][1] = map['name'][1].replace(/\%/g, "");
    $("#name").attr("value", map['name']['1']);
  }

  if (cr(map, "birthday")) {
    $("#birthday").attr("value", map['birthday'][1]);
    $("#birthdayB>[value=" + map['birthday'][0] + "]").attr("selected", "selected");
  }
  if (cr(map, "date_start_work")) {
    $("#workdate").attr("value", map['date_start_work'][1]);
    $("#workdateB>[value=" + map['date_start_work'][0] + "]").attr("selected", "selected");
  }
  if (cr(map, "post_level")) {
    $("#postLevel>[value=" + map['post_level'][1] + "]").attr("selected", "selected");
    $("#postLevelB>[value=" + map['post_level'][0] + "]").attr("selected", "selected");
  }
  if (cr(map, "title_level")) {
    $("#titleLevel>[value=" + map['title_level'][1] + "]").attr("selected", "selected");
    $("#titleLevelB>[value=" + map['title_level'][0] + "]").attr("selected", "selected");
  }
  if (cr(map, "edu_level")) {
    $("#eduLevel>[value=" + map['edu_level'][1] + "]").attr("selected", "selected");
    $("#eduLevelB>[value=" + map['edu_level'][0] + "]").attr("selected", "selected");
  }
  if (cr(map, "sex")) {
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

function cr(m, rule) { //short for check rule
  if (typeof(m[rule]) == "undefined") return false;

  if (typeof(m[rule]) == "object") {
    if (typeof(m[rule][0]) == "undefined") false;
    if (typeof(m[rule][1]) == "undefined") false;
    if (m[rule][0] == "") false;
    if (m[rule][1] == "") false;
  }

  if (typeof(m[rule]) == "string") {
    if (typeof(m[rule]) == "undefined") return false;
    if (m[rule] == "") return false;
  }
  return true;
}

function goPage(e){
  $("#page").attr("value", e.data.to);
  $("#searchForm").submit();
}