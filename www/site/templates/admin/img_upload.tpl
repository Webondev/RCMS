<div class="popup__overlay">
	    <div class="popup">
	    
	       <input type="hidden" value="{$img_up_id_note}" id="img_up_id_note">
	       <input type="hidden" value="{$img_up_folder_note}" id="img_up_folder_note">
	       
	  	<h4>Загрузка файлов и drag&drop</h4>
	    <form action="/index.php/images/addajax" method="POST" enctype="multipart/form-data">
	         <input type="file" name="my-pic" id="file-field" /><br/>
	         <input type="hidden" value="" name="post_id" id="post_id" />
	        или просто перетащи в область ниже &dArr;
	    </form>
	    <div class="img-container" id="img-container">
	        <ul class="img-list" id="img-list"></ul>
	    </div><!--img-container-->
	        <button id="upload-all">Загрузить все</button>
	    <button id="cancel-all">Отменить все</button>
	   <br> Уже загружены<br>
	    <div class="img-container-1" id="img-container-present">
	        <ul class="img-list" id="img-list-present">
	   		{foreach from=$this->img_list item=v}
				<li><div>{$v.name}<br><a class="addMainPic" href="#">Сделать главной</a></div>
				<img width="80px"  src="{$v.link}"></li>
			{/foreach}
	        </ul>
	    </div><!--img-container-present-->
	
	    
	    </div><!--popup-->
	</div><!--popup__overlay-->