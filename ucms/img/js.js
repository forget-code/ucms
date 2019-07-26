function showdiv(div){
		if (document.getElementById(div).value.indexOf(".png") == -1 && document.getElementById(div).value.indexOf(".jpg") == -1 && document.getElementById(div).value.indexOf(".gif") == -1 && document.getElementById(div).value.indexOf(".bmp") == -1 && document.getElementById(div).value.indexOf(".PNG") == -1 && document.getElementById(div).value.indexOf(".JPG") == -1 && document.getElementById(div).value.indexOf(".GIF") == -1)
		{
			return false;
		}
		var ei = document.getElementById(div+"_pic");
		if (document.getElementById(div).value!="" && ei.style.display == "none")
		{
			ei.innerHTML = '<img onload="if(this.width>500)this.width=500" src="' + document.getElementById(div).value + '" />';
			
		}
		ei.style.top  = document.body.scrollTop + event.clientY + 2 + "px";
		ei.style.left = document.body.scrollLeft + event.clientX + 10 + "px";
		ei.style.display = "block";
		
		
}
function divclose(div){
			var ei = document.getElementById(div+"_pic");
			ei.innerHTML = "";
			ei.style.display = "none";
}
//多图上传删除,移动
function picdel(deltr){
		$(deltr).parent().parent("li").remove(); 
};
function picmoveup(deltr){
	var prevhtml=$(deltr).parent().prev().html();
	if (prevhtml)
	{
		var myhtml=$(deltr).parent().prev().next().html();
		$(deltr).parent().prev().html(myhtml);
		$(deltr).parent().prev().next().html(prevhtml);
		
	}
}
function picmovenext(deltr){
	var nexthtml=$(deltr).parent().next().html();
	if (nexthtml)
	{
		var myhtml=$(deltr).parent().next().prev().html();
		$(deltr).parent().next().html(myhtml);
		$(deltr).parent().next().prev().html(nexthtml);
		
	}
}
//动态文本框
function textdel(deltr){
	$(deltr).parent().remove();
};
function getos()
{
	if(isIE = navigator.userAgent.indexOf("MSIE")!=-1) { 
		return "MSIE"; 
	}
	if(isFirefox=navigator.userAgent.indexOf("Firefox")!=-1){ 
		return "Firefox"; 
	}
	if(isChrome=navigator.userAgent.indexOf("Chrome")!=-1){ 
		return "Chrome"; 
	}
	if(isSafari=navigator.userAgent.indexOf("Safari")!=-1) { 
		return "Safari"; 
	}
	if(isOpera=navigator.userAgent.indexOf("Opera")!=-1){ 
		return "Opera"; 
	}
	return "";
}
function ismobile() {
	var userAgentInfo = navigator.userAgent.toLowerCase();
	var Agents = ["android", "iphone","ipad", "mobile"];
	for (var v = 0; v < Agents.length; v++) {
		if (userAgentInfo.indexOf(Agents[v]) > 0) {
			return true;
		}
	}
	return false;
}
function confirmurl(url,message) {
	if(confirm(message)) location.href =url;
}
function selectcheckbox(form)
{
	for(var i = 0;i < form.elements.length; i++) 
	{
		var e = form.elements[i];
		if(e.name != 'chkall' && e.disabled != true) e.checked = form.chkall.checked;
	}
}
function CloseWebPage(){
	if (navigator.userAgent.indexOf("MSIE") > 0) {
		if (navigator.userAgent.indexOf("MSIE 6.0") > 0) {
			window.opener = null;
			window.close();
		} else {
			window.open('', '_top');
			window.top.close();
		}
	}
	else if (navigator.userAgent.indexOf("Firefox") > 0) {
		window.location.href = 'about:blank ';
	} else {
		window.opener = null;
		window.open('', '_self', '');
		window.close();
	}
}
function setCookie(name,value) 
{ 
	var Days = 30;
	var exp = new Date();
	exp.setTime(exp.getTime() + Days*24*60*60*1000);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function time_zero(number){
	if (number<10)
	{
		return '0'+number;
	}
	return number;
}