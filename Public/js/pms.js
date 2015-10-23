var loaded = {};
function L(op){
  //loading判断条
  var hide = true,i;
  $('#loading').show();
  
  if(typeof(loaded[op]) == "undefined"){
    loaded[op] = false;
  }else{
    loaded[op] = loaded[op] ? false : true;
  }

  $.each(loaded,function(i,v){
    if(loaded[i] == false) hide = false;
    // console.log(i);
  });

  // console.log(loaded);
  // console.log('hide:'+hide);
  if(hide) $('#loading').hide();
}

function searchAble(){
  $('#searchBox').keypress(function(e) {
    if(e.keyCode == 13){
      location.href = "/index.php/Search/result/" + $(this).val();
    }
  });
}