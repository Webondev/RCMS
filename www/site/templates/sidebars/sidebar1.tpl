<div class="main_menu">   
<h3>Меню</h3>
   <ul >
   	<li><a href="/">Главная</a></li>
	{foreach from=$p_categories item=c_item}
	<li><a href="{$ROOT}post/category/{$c_item.url}/">{$c_item.name}</a></li>
	{/foreach}
   </ul>
</div>