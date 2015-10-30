{*Шаблон контейнер*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
{*<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">*}
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
{include file='head_data.tpl'}
</head>
<body>
<div class="main">
			<div class="header">
			{if !$this->user->is_authed()}
				<div>
					<form method="post" action="{$ROOT}user/auth.html">
					Логин: <input class="input_form" type="text" name="login" placeholder="...">
					Пароль: <input class="input_form"  type="password" name="password" placeholder="...">
					<input type="submit" name="auth" value="Вход"">
					</form>
				</div>
				<div>
					<a href="{$ROOT}user/register.html">Регистрация</a> | <a href="{$ROOT}user/restore.html">Забыли пароль?</a>
				</div>
			{else}
				<div>
					Здравствуйте <a href="{$ROOT}user/">{$this->user->data.login}</a>. 
					{if $this->user->data.role =='admin'} | <a href="{$ADMIN_URL}" target="_blank">Перейти в админку </a> {/if}
					| <a href="{$ROOT}user/logout/">Выйти</a>
					<hr />
				</div>
			{/if}
			</div><!--header-->
			
			<div class="main_body">
			{$error}
				<div class="main_content">
					{include file=$template}
				</div>

			</div><!--main_body-->
			
			{include file="sidebars/sidebar1.tpl"}
				
			<div class="footer">{date("d-m-Y")}</div>
			
</div>
</body>
</html>