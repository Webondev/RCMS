<div class="comments" >
<div class="comment_title">Комментарии</div>
{if !empty($comments_list)}
	{foreach from=$comments_list item=c_item}
	<div class="comment" style=" border-bottom: 1px dotted black;">
		<div class="comment_head " >{$c_item.user_name}</div>
		<div class="comment_body">{$c_item.text}</div>
	</div>



	{/foreach}
{else}	
	Еще нет комментариев.
	<hr />
{/if}

{if !empty($comment_error)}<div class="comment_error">{$comment_error}</div>{/if}
{if !empty($comment_info)}<div class="comment_info">{$comment_info}</div>{/if}
<div class="comment_form">
<form method="post">
	<div class="comment_input">
		Имя*:</br> <input type="text" value="{if !empty($c_data.name)}{$c_data.name}{/if}" name="_comment[name]" required></div>
	<div class="comment_input">
		Email*:</br><input type="text" value="{if !empty($c_data.email)}{$c_data.email}{/if}" name="_comment[email]" required></div>
	<div class="comment_input">
		Website: </br><input type="text" value="{if !empty($c_data.website)}{$c_data.website}{/if}" name="_comment[website]"></div>
	<div class="comment_input">
		Комментрарий*: </br><textarea name="_comment[text]" required>{if !empty($c_data.text)}{$c_data.text}{/if}</textarea></div>
	<div class="comment_input"><img src="/captcha/?rand={rand()}"></div>
	<div class="comment_input">
		Введите буквы и цифры с картинки: </br><input type="text"  name="_comment[captcha]" required></div>
	<div class="comment_input">
	<input type="submit"  value="Отправить"></div>
</form>
</div>
</div><!--comments-->