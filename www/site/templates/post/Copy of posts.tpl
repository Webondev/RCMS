{foreach from=$list item=i}					
					
<div class="content">
	<div class="title"><a href="{$ROOT}post/{$i.url}.html">{$i.title}</a></div>
	<div class="text">{$i.text_preview} | <a href="{$ROOT}post/{$i.url}.html">Читать дальше...</a></div>
</div>
{foreachelse}
Ничего не найдено.
{/foreach}

{$pages}