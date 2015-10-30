<div style="float:left;">
<form method="post">
<input type="hidden" name="page[id]" value="{$data.id}" >
<div class="form_element">
	<div class="_logo">Тайтл</div>
	<div class="_element"><input type="text" name="page[title]" value="{$data.title}" required></div>
</div>

<div class="form_element">
	<div class="_logo">Урл</div>
	<div class="_element"><input type="text" name="page[url]" value="{$data.url}" required></div>
</div>

<div class="form_element">
	<div class="_logo">Текст</div>
	<div class="_extra">{htmlspecialchars('<!--more-->')} - разделитель на предпросмотр и остальную часть</div>
	<div class="_element"><textarea id="_content_text" name="page[text]" required rows="10" cols="50">{$data.text}</textarea></div>
</div>

<div class="form_element">
	<div class="_logo">Дескрипшн</div>
	<div class="_element"><textarea name="page[description]"  rows="1" cols="50">{$data.description}</textarea></div>
</div>

<div class="form_element">
	<div class="_logo">Статус</div>
	<div class="_element">
	{html_options name="page[status]" options=$this->status_list selected=$data.status}

	</div>
</div>

<div class="form_element">
	<div class="_logo"></div>
	<div class="_element"><input type="submit" value="Сохранить"></div>
</div>

</form>
</div>

<div style="
	float:left;
	padding:20px; 
	overflow: auto; 
	height:400px;
	width:400px;
	background: #E8F2FE;
	">

	{include file=$imgUploader}

</div>