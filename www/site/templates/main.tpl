{*Стандартно загружается этот шаб*}

{foreach from=$list item=i}
<div class="item">
	<div class="title">
	{$i.title}
	</div>
	<div class="text">
	{$i.text}
	</div>

</div>
{/foreach}

{$pages}