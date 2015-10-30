<div style="float:left;">
<form method="post">
<div class="form_element">
	<div class="_logo">Название</div>
	<div class="_element"><input type="text" name="category[name]" value="{$data.name}" required></div>
</div>

<div class="form_element">
	<div class="_logo">Урл</div>
	<div class="_element"><input type="text" name="category[url]" value="{$data.url}" required></div>
</div>

<div class="form_element">
	<div class="_logo">Статус</div>
	<div class="_element">
	{html_options name="category[status]" options=$this->status_list selected=$data.status}

	</div>
</div>

<div class="form_element">
	<div class="_logo"></div>
	<div class="_element"><input type="submit" value="Сохранить"></div>
</div>

</form>
</div>
