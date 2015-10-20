function setChecked() {

  if (cr(map, "name")) {
    map['name'][1] = map['name'][1].replace(/\%/g, "");
    $("#name").attr("value", map['name']['1']);
  }
  $.each(map, function(index, val) {
    if (cr(index)) {
      if(index == 'sex'){
          setSex(val);
      }else{
        if(typeof(val) == 'object'){
          $("#" + index).val(val[1]);
          $("#" + index + "B").val(val[0]);
        }else{
          $("#" + index).val(val);
        }
      } 
    }//if(cr)
  });
}

function cr(rule) { //short for check rule

  if (map[rule] == null) return false;
  if (typeof(map[rule]) == "undefined") return false;

  if (typeof(map[rule]) == "string") {
    if (map[rule] == "") return false;
  }

  if (typeof(map[rule]) == "object") {
    if (typeof(map[rule][0]) == "undefined") return false;
    if (typeof(map[rule][1]) == "undefined") return false;
  }
  return true;
}

function goPage(e) {
  $("#page").attr("value", e.data.to);
  $("#searchForm").submit();
}

function setSex(op){
  $(":radio").removeAttr("checked").parent().removeClass('active');
  if(op == 0) $('#sex-f').click().parent().addClass('active');
  if(op == 1) $('#sex-m').click().parent().addClass('active');
  if(op == null) $('#sex').click().parent().addClass('active');
}