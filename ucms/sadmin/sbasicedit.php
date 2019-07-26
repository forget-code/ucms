<?php
if (!defined('admin')) {exit();}
if(power('alevel')!=3) {die('error');}
if(isset($_GET['id'])) {
	$id=intval($_GET['id']);
}else {
	die();
}
$query = $GLOBALS['db'] -> query("SELECT * FROM ".tableex('str')." where id='$id' and inputkind>0");
$link = $GLOBALS['db'] -> fetchone($query);
$strarray=explode('|',$link['strarray']);
if(count($strarray)<2) {
	$strarray[0]=0;
	$strarray[1]='title';
}
$ssetting=json_decode($link['ssetting'],1);
$cid=$link['strcid'];
?>
<div id="UMain">
  <!-- 当前位置 -->
<div id="urHere"><em class="homeico"></em>后台管理<b>&gt;</b><strong>栏目配置</strong> </div>   <div id="mainBox">
    <h3><a href="?do=sadmin_sbasic&cid=<?php echo($cid);?>" class="actionBtn">返回</a><?php echo($link['strname']);?> <i>变量修改</i></h3>

     <table width="100%" border="0" cellpadding="8" cellspacing="0" class="tableBasic">
<form id="form1" method="post" action="?do=sadmin_seditpost">
<?php newtoken();?>
		<input type="hidden" name="id" value="<?php echo($link['id']);?>">
		<input type="hidden" name="strcid" value="<?php echo($link['strcid']);?>">
			<tr><td width="10%" align="right">变量名</td>
				<td align="left"><input type="text" name="strname" value="<?php echo(htmlspecialchars($link['strname']));?>"  class="inputtext">
				<label><input type="checkbox" name="ifadmin" value="0" <?php if($link['ifadmin']==1) { echo('checked');}?>>管理员变量</label>
<?php
if($link['strcid']>0) {
?>
	<label style="display:none"><input type="checkbox" name="ifbind" value="0" <?php if($link['ifbind']==1) { echo('checked');}?>>绑定到栏目值</label>
<?php
}
?>
</td></tr>
<tr><td width="10%" align="right">变量类型</td><td align="left">
<select name="inputkind" id="inputkind"> 
<?php
foreach($inputkindarray as $val) {
	if(isset($val['strfrom'])) {$val['strfrom']=$val['strfrom'];}else {$val['strfrom']=0;}
	if($val['id']==$link['inputkind']) {
		echo('<option rel="'.$val['setting'].'" rev="'.$val['strfrom'].'" value="'.$val['id'].'" selected>'.$val['name'].'</option>'."\r\n");
		if($val['setting']==1) {$moresettingdisplay='';}else {$moresettingdisplay='none';}
		if($val['strfrom']==1) {$strfromdisplay='';}else {$strfromdisplay='none';}
	}else {
		echo('<option rel="'.$val['setting'].'" rev="'.$val['strfrom'].'" value="'.$val['id'].'">'.$val['name'].'</option>'."\r\n");
	}
}
?>
</select> 
<script type="text/javascript">
	$(function(){
		$('#inputkind').change(function(){
			$('.strarrytipslist li').hide();
			$('.strarrytipslist li[rel='+$(this).val()+']').show();
			if ($("#inputkind").find("option:selected").attr('rel')==1)
			{
				$('#moresetting').show();
			}else{
				$('#moresetting').hide();
			}
			
			if ($("#inputkind").find("option:selected").attr('rev')==1)
			{
				$('#strfrom').show();
			}else{
				$('#strfrom').hide();
			}
		});
	});
</script>
</td></tr>
<tr id="moresetting" style="display:<?php echo($moresettingdisplay);?>"><td width="10%" align="right">变量数据来源</td>
<td align="left">
<select id="strfrom0" name="strarray0">
<?php
channel_select($strarray[0],0,0,1,'变量数据来源栏目');
?>
</select>
 <img class="strarrayloading" src="img/loading.gif"> 
<select id="strfrom1" name="strarray1">
<?php
if(isset($strarray[1])) {
	echo('<option value="'.$strarray[1].'">'.$strarray[1].'</option>');
}
?>
</select>
<em class="pleasetips" style="color:red;display:none">请配置变量数据来源</em>
<script>
$(function(){
	changestrarray('<?php echo($strarray[1]);?>');
	$('#strfrom0').change(function(){
		changestrarray('');
	});
});
function changestrarray(strdefault){
	cid=$('#strfrom0').val();
	if (strdefault=='')
	{
		strdefault=$('#strfrom1').val();
	}
	$('.strarrayloading').show();
	$.post("ajax.php?do=strarraylist",
	  {
		cid:cid,
		strdefault:strdefault
	  },
	  function(data,status){
		$('#strfrom1').html('');
		$("#strfrom1").append(data);
		$('.strarrayloading').hide();
		if ($('#strfrom1').val()=='')
		{
			$('.pleasetips').show();
		}else{
			$('.pleasetips').hide();
		}
	  });
}
</script>
				</td></tr>

			<tr><td width="10%" align="right">输入提示</td>
				<td align="left">
				<textarea name="strtip" rows="3" cols="60"><?php echo($link['strtip']);?></textarea>
				</td></tr>

<tr><td width="10%" align="right">数据校验正则</td>
				<td align="left">
				<input type="text" id="sregular" name="ssetting[regular]" size="40" value="<?php if(isset($ssetting['regular'])) {echo(htmlspecialchars($ssetting['regular']));}else{$ssetting['regular']='';}?>"  class="inputtext">
				<select name="pattern_select" onchange="javascript:$('#sregular').val(this.value)">
<option<?php if($ssetting['regular']=='') {echo(' selected');}?> value="">常用正则</option>
<option<?php if($ssetting['regular']=='/^[0-9.-]+$/') {echo(' selected');}?> value="/^[0-9.-]+$/">数字</option>
<option<?php if($ssetting['regular']=='/^[0-9-]+$/') {echo(' selected');}?> value="/^[0-9-]+$/">整数</option>
<option<?php if($ssetting['regular']=='/^[a-z]+$/i') {echo(' selected');}?> value="/^[a-z]+$/i">字母</option>
<option<?php if($ssetting['regular']=='/^[0-9a-z]+$/i') {echo(' selected');}?> value="/^[0-9a-z]+$/i">数字+字母</option>
<option<?php if($ssetting['regular']=='/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/') {echo(' selected');}?> value="/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/">E-mail</option>
<option<?php if($ssetting['regular']=='/^[0-9]{5,20}$/') {echo(' selected');}?> value="/^[0-9]{5,20}$/">QQ</option>
<option<?php if($ssetting['regular']=='/^http:\/\//') {echo(' selected');}?> value="/^http:\/\//">超级链接</option>
<option<?php if($ssetting['regular']=='/^(1)[0-9]{10}$/') {echo(' selected');}?> value="/^(1)[0-9]{10}$/">手机号码</option>
<option<?php if($ssetting['regular']=='/^[0-9-]{6,13}$/') {echo(' selected');}?> value="/^[0-9-]{6,13}$/">电话号码</option>
<option<?php if($ssetting['regular']=='/^[0-9]{6}$/') {echo(' selected');}?> value="/^[0-9]{6}$/">邮政编码</option>
<option<?php if($ssetting['regular']=='/(.*)$/') {echo(' selected');}?> value="/(.*)$/">任意字符串</option>
</select>

				</td></tr>

<tr><td width="10%" align="right">长度限制</td>
				<td align="left">
				最短 <input type="text" name="ssetting[lenmin]" size="10" value="<?php if(isset($ssetting['lenmin'])) {echo(intval($ssetting['lenmin']));}?>"  class="inputtext">
				最长 <input type="text" name="ssetting[lenmax]" size="10" value="<?php if(isset($ssetting['lenmax'])) {echo(intval($ssetting['lenmax']));}?>"  class="inputtext">
				<i>不填则不限制</i>
				</td></tr>


				<tr><td width="10%" align="right">HTML代码设置</td>
				<td align="left">
				<select name="ssetting[filterhtml]">
<option value="0" <?php if(!isset($ssetting['filterhtml'])){echo(' selected');}?>>HTML代码设置</option>
<option value="0" <?php if(isset($ssetting['filterhtml']) && $ssetting['filterhtml']==0){echo(' selected');}?>>允许HTML代码</option>
<option value="1" <?php if(isset($ssetting['filterhtml']) && $ssetting['filterhtml']==1){echo(' selected');}?>>过滤危险HTML代码</option>
<option value="2" <?php if(isset($ssetting['filterhtml']) && $ssetting['filterhtml']==2){echo(' selected');}?>>禁用HTML代码</option>
</select>
<i> 超级管理员始终允许HTML代码</i>
				</td></tr>

				

<tr><td width="10%" align="right">输入框style</td>
				<td align="left">
				<input type="text" name="strstyle" size="60" value="<?php echo(htmlspecialchars($link['strstyle']));?>"  class="inputtext">
				<i>如:height:250px;width:1212px</i>
				</td></tr>	


			<tr><td width="10%" align="right">排序</td>
				<td align="left">
				<input type="text" name="strorder" size="40" value="<?php echo($link['strorder']);?>"  class="inputtext">
				</td></tr>
</td></tr>

      <tr>
       <td></td>
       <td>
        <input class="btn btn140" type="submit" value="提交" />
       </td>
      </tr>
     </table>
    </form>
       </div>
 </div>

