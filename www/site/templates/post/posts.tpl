{*<h3>Новые записи</h3>
<p>Самый свежий список статей и новостей. </p>
   	*}
{foreach from=$list item=i}					
	
   <div class="holder_gallery">
   <a class="photo_hover2" href="{$ROOT}post/{$i.url}.html">
   <img src="{if empty($i.show_img)}/theme/images/default.jpg{else}{$i.show_img}{/if}" width="150" height="99" alt="{$i.title}"/></a>
   <string class="title_string">{$i.title}</string>
   <p>{$i.text_preview}   </p> 
   <span class="readmore"><a href="{$ROOT}post/{$i.url}.html">Читать дальше..</a></span>
   </div>

{foreachelse}
Ничего не найдено.
{/foreach}

{$pages}
