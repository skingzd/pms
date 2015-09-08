/**
 * @param  {[type]}   pagerId         [页码条ID]
 * @param  {[type]}   nowPage         [当前页码]
 * @param  {[type]}   resultCount     [记录总数]
 * @param  {[type]}   perPage         [每页多少条记录]
 * @param  {[type]}   callFn          [点击页码调用的函数]
 * @param  {[type]}   addsOn          [传往callFn的第二个参数，第一个参数为点击的页码数]
 * @return {[type]}   NaN
 */
function makePager(pagerId, nowPage, resultCount, perPage, callFn, addsOn) {
  // 清除页数列表
  var i, li, a, pager;
  var page = {
    "pre": nowPage - 1,
    "now": nowPage,
    "next": nowPage + 1,
    "per": perPage,
    "max": null,
    "addOn": addsOn,
    "resultCount": resultCount,
  };
  var pager = {
    "pre" : $("#"+pagerId+">#pre"),
    "next": $("#"+pagerId+">#next"),
  }
  //计算上、下页码，总页数
  page.max = parseInt(page.resultCount / page.per);
  if (page.max * page.per < page.resultCount) page.max = parseInt(page.max) + 1;

  //清除工作
  $("#"+pagerId+" li").unbind("click");
  $("#"+pagerId+" li").removeClass();
  while ($(pager.pre).next().attr("id") != "next") {
    $(pager.pre).next().remove();
  }

  //上一页按钮
  if (page.now == 1) { //是第一页则禁用上一页
    $(pager.pre).addClass("disabled");
  } else { //不是第一页则设定上一页按钮页码-1
    $(pager.pre).click({"to":page.pre, "addsOn":addsOn},callFn);
  }

  // 页面按钮
  for (i = 1; i <= page.max; i++) {
    li = $("<li></li>");
    a = $("<a></a>").text(i);
    if (i == page.now) {
      $(li).addClass("active");
    } else {
      $(li).click({"to":i, "addsOn":addsOn},callFn);
    }
    li = $(li).append(a);
    $(pager.next).before(li);
  }
  // 下一页按钮123
  if (page.next > page.max) { //如果是最后一页
    $(pager.next).addClass("disabled");
  } else {
    $(pager.next).click({"to":page.next, "addsOn":addsOn},callFn);
  }
  if (page.max == 0) {
    $("#"+pagerId).hide();
  } else {
    $("#"+pagerId).show();
  }

  // $("#pre").append(function(){})
}