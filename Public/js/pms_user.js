function goPanel(panel){
	$("div[id^=panel]").hide();
	$("div[id^=panel"+panel+"]").show(300);
}