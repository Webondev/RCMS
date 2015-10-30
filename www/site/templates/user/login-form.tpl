
{if !$this->user->is_authed()}
<form action="{$ROOT}user/auth.html" method="post">
<div class="form">
	<p class="error_str">{$error}</p>
	<div>
		<label for='_login'>Логин</label>
		<input type="text" name="login" id="_login" value="">
	</div>
	<div>
		<label for='_password'>Пароль</label>
		<input type="password" name="password" id="_password" value="">
	</div>
	<div>
		<label for='_captcha'>Капча</label>
		<img src="/captcha/?rand={rand()}">
		<input type="text" name="captcha" id="_captcha" value="">
	</div>
	<div>
		<label for='_remember'><input type="checkbox" name="remember" id="_remember" value="">Запомнить меня</label>
		
	</div>
	<div>
		<input type="submit" value="Войти">
	</div>
</div>
</form>
{else}
Вы авторизировались как {$this->user->data.login}. | <a href="{$ROOT}user/logout/">Выйти</a>
{/if}