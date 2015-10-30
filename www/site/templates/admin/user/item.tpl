<div class="form">
<form  action="" method="post">

<strong class="error_str">{$error}</strong>

<table>
<tr>
	<td><label for='_login'>Логин</label></td>
	<td><input type="text" name="login" id="_login" value="{$data.login}"></td>
</tr>
<tr>
	<td><label for='_email'>Email</label></td>
	<td><input type="text" name="email" id="_email" value="{$data.email}"></td>
</tr>
<tr>
	<td><label for='_password'>Пароль</label></td>
	<td><input type="password" name="password" id="_password" value=""></td>
</tr>
<tr>
	<td><label for='_password2'>Ещё раз пароль</label></td>
	<td><input type="password" name="password2" id="_password2" value=""></td>
</tr>
<tr>
	<td><label for='_role'>Роль</label></td>
	<td>
		{html_options name=role options=$role_options selected=$data.role}
	</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="Сохранить"></td>
</tr>
</table>
</div>
</form>