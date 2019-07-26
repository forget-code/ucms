{$set=array()}
{$set['where']['id']=intval($_GET['id'])}
{$article=a($set)}
{if !$article}
	{notfound()}
{/if}
<!DOCTYPE html>
<!-- 文章页<?php if(!defined('ucms'))exit; ?> -->
<html>
<head>
<meta charset="utf-8"/>
<title>{$article['title']}</title>
<meta name="keywords" content="{$article['keywords']}"/>
<meta name="description" content="{$article['description']}"/>
<meta name="viewport" content="width=device-width"/>
<link rel="stylesheet" type="text/css" href="{tempdir}css/style.css" />
</head>
<body>
{file header}
<div class="main warp">
	<div class="main_left">
		<div class="page_content">
			<h1>{$article['title']}</h1>
			<div class="article_content">
			{$article['content']}
			</div>
		</div>
	</div>
	<div class="main_right">
		{file right_channel}
		{file right_article}
		{file right_ad}
	</div>
</div>
{file footer}
</body>
</html>