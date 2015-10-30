<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>Админка</title>
{include file='admin/head_data.tpl'}

</head>
<body>
<div class="main">
	{include file='admin/menu.tpl'}
	
	<div class="content">
		<div class="navigation"><a href="/admin-zone/">Админка</a> | 
			<a href="/" target="_blank">Перейти на сайт</a> | <a href="/user/logout/">Выйти</a>
		</div><!--navigation-->
		<div class="error_div {if !$error}hidden{/if}">{$error}</div>
		<div class="info_div {if !$info}hidden{/if}">{$info}</div>
		<div class="main_content">
				{include file=$template}
		</div><!--main_content-->
		
	</div><!--content-->
</div>
</body>
</html>