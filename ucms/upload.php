<?php
require('../inc/config.php');
require 'chk.php';
$filedomain='';//文件域名前缀例:http://uuu.la,不需要/结尾
$allowfileext=array();
foreach($ext_arr as $val) {
	foreach($val as $thisext) {
		$allowfileext[]=$thisext;
	}
}
if(isset($_POST['picsize'])) {
	$picsize=htmlspecialchars($_POST['picsize']);
}elseif(isset($_GET['picsize'])) {
	$picsize=htmlspecialchars($_GET['picsize']);
}else {
	$picsize='';
}

if(strtolower($_SERVER['REQUEST_METHOD'])=='post') {
	$ifpost=true;
}else {
	$ifpost=false;
}
if($ifpost==false) {
	if(isset($_GET['inputname'])) {
		$_GET['inputname']=htmlspecialchars($_GET['inputname']);
	}else {
		die('error');
	}
	if(isset($_GET['buttonvalue'])) {
		$buttonvalue=htmlspecialchars($_GET['buttonvalue']);
	}else {
		$buttonvalue='选择文件';
	}
	$jsstr='';
	foreach($allowfileext as $thisext) {
		$jsstr.='(filename.indexOf(".'.$thisext.'") == -1) && ';
	}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>上传</title>
<style>
body{overflow-x:hidden;overflow-y:hidden;overflow:hidden;margin:0px;padding:0px;background:#F9F9F9}
#uploadfileform{display:none}
#uploadbutton{font-size:14px;line-height:34px;cursor:pointer}
</style>
<!--[if lt IE 10]>
<style>
#uploadfileform{display:block}
#imgFile{width:70px;height:30px;display:block;float:left;}
#uploadbutton{display:none}
#uploadtips{display:block;float:left;line-height:20px;margin-top:10px;}
</style>
<![endif]-->
</head>
<body  scroll=no>
<div class="uploadarea">
<form method=post enctype="multipart/form-data" action="?inputname=<?php echo($_GET['inputname']);?>" id="uploadfileform">
<input type="hidden" id="picsize" name="picsize" value="<?php echo($picsize);?>"/>
<input type="file" id="imgFile" name="imgFile" onchange="gouploadfile();"/>
<span  id="uploadtips"><?php if($buttonvalue<>'选择文件') {echo($buttonvalue);}?></span>
</form>
<label for="imgFile" id="uploadbutton" onClick="iframeuploadfile();"><?php echo($buttonvalue);?></label>
</div>
<script type="text/javascript">
function iframeuploadfile(){
	document.getElementById('uploadtips').innerText="上传中...";
}
function gouploadfile(){
	var filename=document.getElementById('imgFile').value.toLowerCase();
	if (<?php echo($jsstr);?> 1==1)
	{
		alert('该文件不允许上传');
		return false;
	}
	document.getElementById('uploadbutton').innerText="上传中...";
	document.getElementById('uploadfileform').submit();
}
</script>
</body>
</html>
<?php
	die();
}
$save_path =SystemRoot.UploadDir.DIRECTORY_SEPARATOR;
$save_url = $filedomain.SystemDir.UploadDir.'/';
$max_size = 100000000;//文件最大尺寸
$save_path = realpath($save_path) . '/';
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过系统允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}
if(!isset($_FILES['imgFile'])) {
	alert('上传错误');
}else {
	$file_name = $_FILES['imgFile']['name'];
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	$file_size = $_FILES['imgFile']['size'];
	if (!$file_name) {
		alert("请选择文件。");
	}
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}
	if (@is_writable($save_path) === false) {
		alert("上传目录没有写权限。");
	}
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = strtolower(trim($file_ext));

	foreach($ext_arr as $key=>$val) {
		if(in_array($file_ext, $val)) {
			$dir_name=$key;
			break;
		}
	}
	if(!isset($dir_name)) {
		alert("上传文件扩展名是不允许的扩展名。");
	}
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。");
	}
	//ajax粘帖上传blob改成png
		if($file_ext=='blob') {
			$file_ext='png';
		}
	if ($dir_name !== '') {
		$save_path .= $dir_name . DIRECTORY_SEPARATOR;
		$save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			mkdir($save_path);
		}
	}
	$ymd = date("Ymd");
	$save_path .= $ymd . DIRECTORY_SEPARATOR;
	$save_url .= $ymd . "/";
	if (!file_exists($save_path)) {
		mkdir($save_path);
	}
	$new_file_name = substr(md5(time().rand(10000, 99999)),0,9) .'.'.$file_ext;
	$file_path = $save_path . $new_file_name;
	$save_url .=$new_file_name;
	$picsizes=explode('_',$picsize);
	$a=false;
	if($dir_name=='image' && isset($picsizes[0]) && isset($picsizes[1]) && $picsizes[0]>1 && $picsizes[1]>1 && $picsizes[0]<10000  && $picsizes[1]<10000) {
		$a=imagezoom($tmp_name, $file_path, $picsizes[0], $picsizes[1], '#FFFFFF');
		if($a==='ext error') {
			$a=false;
		}else {
			if(!$a) {
				alert("生成缩略图失败");
			}
		}
	}
	if(!$a) {
		if (move_uploaded_file($tmp_name, $file_path) === false) {
			alert("上传文件失败。");
		}
	}
	
	@chmod($file_path, 0644);
	@header('Content-type: text/html; charset=UTF-8');
	if(isset($_GET['inputname'])) {
		$errormsg='';
		echo("<script type=\"text/javascript\">parent.window.document.form1.".$_GET['inputname'].".value='".$save_url."';</script>");
		if(stripos($_GET['inputname'],'_multiple_upload')>0) {
			echo("<script type=\"text/javascript\">parent.window.document.form1.".$_GET['inputname'].".click();</script>");
			echo("<meta http-equiv=refresh content='0; url=?buttonvalue=继续上传&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
		}else {
			echo("<meta http-equiv=refresh content='0; url=?buttonvalue=上传成功&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
		}
		die();
	}
	echo(json_encode(array('error' => 0,'success' => 1, 'url' => $save_url,'message'=>'')));
	exit;
}
function alert($msg) {
	@header('Content-type: text/html; charset=UTF-8');
	global $picsize;
	if(isset($_GET['inputname'])) {
		echo('<script language="javascript">window.alert("'.$msg.'");</script>');
		echo("<meta http-equiv=refresh content='0; url=?buttonvalue=上传失败&inputname=".$_GET['inputname']."&picsize=".$picsize."'>");
		die();
	}
	echo(json_encode(array('error' => 1, 'message' => $msg)));
	exit;
}
function imagezoom( $srcimage, $dstimage,  $dst_width, $dst_height, $backgroundcolor ) {
	$dstimg = imagecreatetruecolor( $dst_width, $dst_height );
	$color = imagecolorallocate($dstimg, hexdec(substr($backgroundcolor, 1, 2)),hexdec(substr($backgroundcolor, 3, 2)), hexdec(substr($backgroundcolor, 5, 2)));
	imagefill($dstimg, 0, 0, $color);
	if ( !$arr=getimagesize($srcimage) ) {
		Return false;
	}
	$src_width = $arr[0];
	$src_height = $arr[1];
	$srcimg = null;
	$fd = fopen( $srcimage, "rb" );
	$data = fread( $fd, 3 );
	$data = img_str2hex( $data );
	if($data=='474946') {
		 $srcimg=imagecreatefromgif($srcimage);
	}elseif($data=='FFD8FF') {
		$srcimg=imagecreatefromjpeg($srcimage);
	}elseif($data=='89504E') {
		$srcimg=imagecreatefrompng($srcimage);
	}else {
		Return 'ext error';
	}
	
	$dst_x = 0;
	$dst_y = 0;
	$dst_w = $dst_width;
	$dst_h = $dst_height;
	if ( ($dst_width / $dst_height - $src_width / $src_height) > 0 ) {
		$dst_w = $src_width * ( $dst_height / $src_height );
		$dst_x = ( $dst_width - $dst_w ) / 2;
	} elseif ( ($dst_width / $dst_height - $src_width / $src_height) < 0 ) {
		$dst_h = $src_height * ( $dst_width / $src_width );
		$dst_y = ( $dst_height - $dst_h ) / 2;
	}
	imagecopyresampled($dstimg, $srcimg, $dst_x, $dst_y, 0, 0, $dst_w, $dst_h, $src_width, $src_height);
	if($data=='474946') {
		$a=imagegif($dstimg,$dstimage);
	}elseif($data=='FFD8FF') {
		$a=imagejpeg($dstimg,$dstimage);
	}elseif($data=='89504E') {
		$a=imagepng($dstimg,$dstimage);
	}
	imagedestroy($dstimg);
	imagedestroy($srcimg);
	Return $a;
}

function img_str2hex( $str ) {
	$ret = "";
	for( $i = 0; $i < strlen( $str ) ; $i++ ) {
		$ret .= ord($str[$i]) >= 16 ? strval( dechex( ord($str[$i]) ) ): '0'. strval( dechex( ord($str[$i]) ) );
	}
	return strtoupper( $ret );
}
