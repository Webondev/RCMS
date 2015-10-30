<div class="holder_gallery1">
   
   <h1>{$data.title}</h1>
   {if !empty($data.show_img)}
  <a class="photo_hover2" href="{$data.show_img}">
  <img src="{$data.show_img}" width="150" height="99" alt="{$data.title}"/></a>
  {/if}
  {$data.text}   
 
</div>



{include file='comments.tpl'}

