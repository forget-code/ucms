<?php
if(!is_numeric($inputvalue)) {
	$defaulttime=@strtotime($inputvalue);
	if($defaulttime) {
		$inputvalue=date("Y-m-d H:i:s",$defaulttime);
	}else {
		$inputvalue='';
	}
}else {
	if(empty($inputvalue)) {
		$inputvalue='';
	}else {
		$inputvalue=date("Y-m-d H:i:s",$inputvalue);
	}
}
?>
<input<?php echo($style);?> name="<?php echo($inputname);?>" autocomplete="off" id="time_<?php echo($inputname);?>" type="text" value="<?php echo($inputvalue);?>" size="20"  class="inputtext timeinput"/>
<?php
if(isset($_SERVER['HTTP_USER_AGENT'])) {
	if(stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 5') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 6') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 7') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 8') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 9') || stripos($_SERVER['HTTP_USER_AGENT'],'MSIE 10')) {echo('<!-- ie不支持date -->');}else{
?>
<div id="time_function_<?php echo($inputname);?>" class="time_function">
<input type="button" value="当前时间" rel="1" style="width:90px;height:24px">
<input type="button" value="整点" rel="2" style="width:55px;height:24px">
<input type="button" value="加一小时" rel="3" style="width:90px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="4" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一天" rel="5" style="width:90px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="6" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一周" rel="7" style="width:90px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="8" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一月" rel="9" style="width:90px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="10" style="width:55px;height:24px;margin-top:5px">
<input type="button" value="加一年" rel="11" style="width:90px;height:24px;margin-top:5px">
<input type="button" value="(减)" rel="12" style="width:55px;height:24px;margin-top:5px">
</div>
<script>
$(function(){
	$('#time_<?php echo($inputname);?>').click(function(){
		var mytop=$(this).offset().top+$(this).height()+8;
		var myleft=$(this).offset().left;
		$('#time_function_<?php echo($inputname);?>').css({"top":mytop,"left":myleft}).show();
	});
	$('#time_<?php echo($inputname);?>').blur(function(){
		var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
		var r = $('#time_<?php echo($inputname);?>').val().match(reg);
		if(r == null){
			alert("输入格式不正确，请按2012-12-12 12:12:12的格式输入！");
			return false;
		}
		$('#time_function_<?php echo($inputname);?>').hide();
	});
	$('#time_function_<?php echo($inputname);?>').hover(function(){
		$('#time_<?php echo($inputname);?>').unbind('blur');
	},function(){
		$('#time_function_<?php echo($inputname);?>').hide();
		$('#time_<?php echo($inputname);?>').blur(function(){
			var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
			var r = $('#time_<?php echo($inputname);?>').val().match(reg);
			if(r == null){
				alert("输入格式不正确，请按2012-12-12 12:12:12的格式输入！");
				return false;
			}
			$('#time_function_<?php echo($inputname);?>').hide();
		});
	});
	$("#time_function_<?php echo($inputname);?> input").click(function(){
		var nowdate = new Date();
		inputdate=$('#time_<?php echo($inputname);?>').val();
		switch($(this).attr('rel'))
		{
		case '1':
			inputdate=nowdate.getFullYear()+"-"+time_zero((nowdate.getMonth()+1))+"-"+time_zero(nowdate.getDate())+" "+time_zero(nowdate.getHours())+":"+time_zero(nowdate.getMinutes())+":"+time_zero(nowdate.getSeconds());
			break;
		case '2':
			var newTime = (new Date(inputdate));
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":00:00";
			break;
		case '3':
			var newTime = (new Date(inputdate).getTime());
			newTime =newTime+3600*1000;
			newTime = new Date(newTime);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '4':
			var newTime = (new Date(inputdate).getTime());
			newTime =newTime-3600*1000;
			newTime = new Date(newTime);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '5':
			var newTime = (new Date(inputdate).getTime());
			newTime =newTime+3600*1000*24;
			newTime = new Date(newTime);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '6':
			var newTime = (new Date(inputdate).getTime());
			newTime =newTime-3600*1000*24;
			newTime = new Date(newTime);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '7':
			var newTime = (new Date(inputdate).getTime());
			newTime =newTime+3600*1000*24*7;
			newTime = new Date(newTime);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '8':
			var newTime = (new Date(inputdate).getTime());
			newTime =newTime-3600*1000*24*7;
			newTime = new Date(newTime);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '9':
			var newTime = (new Date(inputdate));
			newTime.setMonth(newTime.getMonth()+1);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '10':
			var newTime = (new Date(inputdate));
			newTime.setMonth(newTime.getMonth()-1);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '11':
			var newTime = (new Date(inputdate));
			newTime.setFullYear(newTime.getFullYear()+1);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		case '12':
			var newTime = (new Date(inputdate));
			newTime.setFullYear(newTime.getFullYear()-1);
			inputdate=newTime.getFullYear()+"-"+time_zero((newTime.getMonth()+1))+"-"+time_zero(newTime.getDate())+" "+time_zero(newTime.getHours())+":"+time_zero(newTime.getMinutes())+":"+time_zero(newTime.getSeconds());
			break;
		default:
			
		}
		$('#time_<?php echo($inputname);?>').val(inputdate);
	});
});
</script>
<?php
	}
}
?>