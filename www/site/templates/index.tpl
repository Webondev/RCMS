{*Шаблон контейнер*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
{include file='head_data.tpl'}
  {* <link rel="icon" href="images/favicon.gif" type="image/x-icon"/>*}
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
     <![endif]-->

  {* <link rel="shortcut icon" href="/theme/images/favicon.gif" type="image/x-icon"/> *} 
   <link rel="stylesheet" type="text/css" href="/theme/css/styles.css"/>
   </head>
   <body>

   <!--start container-->
   <div id="container">

   <!--start header-->
   <div class="header">

   <!--start logo-->
   <a href="/" id="logo"><img src="/theme/images/logo.png" width="221" height="84" alt="logo"/></a>    
   <!--end logo-->

   <!--start menu-->

   <div class="nav">
   <ul>
   <li><a href="/" class="current">Главная</a></li>
   <li><a href="/rss">RSS</a></li>
  {* <li><a href="#">Services</a></li>
   <li><a href="#">Portfolio</a></li>
   <li><a href="#">News</a></li>
   <li><a href="#">Contact</a></li>*}
   </ul>
   </div>
   <!--end menu-->

   <!--end header-->
   </div>

   <!--start intro-->

   <div id="intro">
   <img src="/theme/images/banner3.jpg"  alt="baner">
   </div>
   <!--end intro-->

   <div class="group_bannner_left">
   <hgroup>
	   <string class="header_title">Женские фенечки</string>
	   <string class="header_desc">Сплетничаем, делимся опытом и говорим о себе, о красивых. </string>
   </hgroup>
   <div class="button black"><a href="/">Последние записи</a></div>
   </div>

   <!--start holder-->

   <div class="holder_content">
	<!--left_menu-->
   <div class="group2l content_menu"><!--group2l-->

   
   {include file="sidebars/sidebar1.tpl"}

  {* <!--Баннер-->
   <a class="photo_hover2" href="/"><img src="/theme/images/picture3.jpg" width="257" height="295" alt="picture"/></a> 
   *}

 	</div><!--END group2l-->


   <section class="group1">
   {$error}
   {include file=$template}
   
   </section><!--group1-->

    <div class="group2"><!--group2-->
    {include file="sidebars/sidebar2.tpl"}
	</div><!--group2-->

   {*<section class="group3"><!--group3-->
   <h3>Про сайт</h3>
   <a class="photo_hover2" href="/"><img src="/theme/images/default.jpg" width="200" height="97" alt="picture1"/></a>

   <p>Новый и амбициозный.   </p>
   <p>Рады и старым и новым друзьям. 
   В этом невероятно 
   <span class="readmore"> <a href="#">Читать дальше ..</a></span>
   </p>
*}
   {* <h3>Пожелание всем</h3>
    <p>Не болейте! </p>*}

   {*</section><!--group3-->*}

   </div>
   <!--end holder-->

   </div>
   <!--end container-->

   <!--start footer-->
   <footer>
   <div class="container">  
   <div id="FooterTwo"> © {date("Y")} <a href="/">Женские фенечки</a>
   
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t44.1;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet' "+
"border='0' width='31' height='31'><\/a>")
//--></script><!--/LiveInternet-->

    </div>
   <div id="FooterTree">Разработка: <a href="http://netkurator.ru/" target="_blank">Netkurator</a>  </div> 
   </div>
   </footer>
   </body>
</html>