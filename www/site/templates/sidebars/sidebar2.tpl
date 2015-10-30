{*
<div class="newsblock">
<h3>Последние записи</h3>
{foreach from=$p_posts item=pi}
   <div class="holder_news">
   <span>{date("d.m.Y", $pi.update_time)}</span>
   <h4>
   {$pi.title}</h4>
   <p>{$pi.text_preview}<span class="readmore">
   <a href="{$ROOT}post/{$pi.url}.html">Дальше..</a></span></p>
   </div>
{/foreach}
*}

   {*<article class="holder_news">
   <h4>Сайт в работе
   <span>10.05.2013</span></h4>
   <p>Сайт открыт для всех желающих<span class="readmore">
   <a href="#">Дальше..</a></span></p>
   </article>*}
 </div>  <!--newsblock-->
     {* <!--Баннер-->
   <a class="photo_hover2" href="/"><img src="/theme/images/picture3.jpg" width="257" height="295" alt="picture"/></a> 
   *}
   