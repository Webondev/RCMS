<?php
defined('ROOT_PATH') or die('No direct script access.');

class myFunc {

    function __construct() {
    }
   
   public function generSitemap($db){

		//Нужно для даты
		define('DATE_FORMAT_RFC822','r');
		// Создаем документ
		$xml = new DomDocument('1.0','utf-8');
		
		//Заголовки
		$urlset = $xml->appendChild($xml->createElement('urlset'));
		$urlset->setAttribute('xmlns:xsi','http://www.w3.org/2001/XMLSchema-instance');
		$urlset->setAttribute('xsi:schemaLocation','http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd');
		$urlset->setAttribute('xmlns','http://www.sitemaps.org/schemas/sitemap/0.9');

	//	HOST_URL;
		$res['cats'] = $db->select("SELECT *  FROM ?# " .
			"WHERE status <> 3 AND status > '0' 
			ORDER BY id DESC", DB_PFX."post_categories");
		
		$res['posts'] = $db->select("SELECT * " .
			" FROM ?# " .
			"WHERE status <> '3' AND status > '0' 
			ORDER BY id DESC", DB_PFX."posts");
		
		$res['pages'] = $db->select("SELECT * " .
			" FROM ?# " .
			"WHERE status <> '3' AND status > '0' 
			ORDER BY id DESC", DB_PFX."pages");
				
			//добавим главную страницу
				// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
				$lastmod_value = date(DATE_FORMAT_RFC822, time());;
				
				$url = $urlset->appendChild($xml->createElement('url'));
				$loc = $url->appendChild($xml->createElement('loc'));
				$lastmod = $url->appendChild($xml->createElement('lastmod'));
				$changefreq = $url->appendChild($xml->createElement('changefreq'));
				$priority = $url->appendChild($xml->createElement('priority'));
				$loc->appendChild($xml->createTextNode(HOST_URL."/"));
				$lastmod->appendChild($xml->createTextNode($lastmod_value));
				$changefreq->appendChild($xml->createTextNode('monthly'));
				//Укажем средний приоритет
				$priority->appendChild($xml->createTextNode('0.5'));
			//END добавим главную страницу	
				
		if($res['cats']){
			foreach($res['cats'] as $row){
				// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
				$lastmod_value = date(DATE_FORMAT_RFC822, time());;
				
				$url = $urlset->appendChild($xml->createElement('url'));
				$loc = $url->appendChild($xml->createElement('loc'));
				$lastmod = $url->appendChild($xml->createElement('lastmod'));
				$changefreq = $url->appendChild($xml->createElement('changefreq'));
				$priority = $url->appendChild($xml->createElement('priority'));
				$loc->appendChild($xml->createTextNode(HOST_URL."/post/category/".$row['url']."/"));
				$lastmod->appendChild($xml->createTextNode($lastmod_value));
				$changefreq->appendChild($xml->createTextNode('monthly'));
				//Укажем средний приоритет
				$priority->appendChild($xml->createTextNode('0.5'));
				
			}
		}

		if($res['pages']){
			foreach($res['pages'] as $row){
				// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
				$lastmod_value = date(DATE_FORMAT_RFC822, $row['update_time']);;
				
				$url = $urlset->appendChild($xml->createElement('url'));
				$loc = $url->appendChild($xml->createElement('loc'));
				$lastmod = $url->appendChild($xml->createElement('lastmod'));
				$changefreq = $url->appendChild($xml->createElement('changefreq'));
				$priority = $url->appendChild($xml->createElement('priority'));
				$loc->appendChild($xml->createTextNode(HOST_URL."/page/".$row['url'].".html"));
				$lastmod->appendChild($xml->createTextNode($lastmod_value));
				$changefreq->appendChild($xml->createTextNode('monthly'));
				//Укажем средний приоритет
				$priority->appendChild($xml->createTextNode('0.5'));
				
			}
		}
				
		if($res['posts']){
			foreach($res['posts'] as $row){
				// Вы можете сконвертировать свою дату в нужный формат DATE_FORMAT_RFC822
				$lastmod_value = date(DATE_FORMAT_RFC822, $row['update_time']);;
				
				$url = $urlset->appendChild($xml->createElement('url'));
				$loc = $url->appendChild($xml->createElement('loc'));
				$lastmod = $url->appendChild($xml->createElement('lastmod'));
				$changefreq = $url->appendChild($xml->createElement('changefreq'));
				$priority = $url->appendChild($xml->createElement('priority'));
				$loc->appendChild($xml->createTextNode(HOST_URL."/post/".$row['url'].".html"));
				$lastmod->appendChild($xml->createTextNode($lastmod_value));
				$changefreq->appendChild($xml->createTextNode('monthly'));
				//Укажем средний приоритет
				$priority->appendChild($xml->createTextNode('0.5'));
				
			}
		}
				
		$xml->formatOutput = true;
		//Записываем файл
		$xml->save(ROOT_PATH.'/sitemap.xml');
   }
 
   
	public function pingPostUrl($postURL = false){
		
		if(!$postURL || empty($postURL)){
			echo "Не указан урл поста для пинга";
			return false;
		}
		
		include_once(M_E_PATH."/IXR_Library.php");
		
		 $postURL = HOST_URL."/post/".$postURL.".html";
		
		// Что посылаем в пингах
		// Название сайта
		$siteName = SITE_NAME;
		// Адрес сайта
		$siteURL  = HOST_URL;
		// Адрес страницы с фидом
		$feedURL  = HOST_URL."/rss/";
		 
		/**
		* Яндекс.Блоги
		*/
		$pingClient = new IXR_Client('ping.blogs.yandex.ru', '/RPC2');
		 
		// Посылаем challange-запрос
		if (!$pingClient->query('weblogUpdates.ping', $siteName, $siteURL, $postURL)) {
		    echo 'Ошибка ping-запроса [' .
		    $pingClient->getErrorCode().'] '.$pingClient->getErrorMessage();
		}
		else {
		  //  echo 'Послан ping Яндексу';
		}
		 
		/**
		* Google
		*/
		$pingClient = new IXR_Client('blogsearch.google.com', '/ping/RPC2');
		 
		// Посылаем challange-запрос
		if (!$pingClient->query('weblogUpdates.extendedPing',
		        $siteName, $siteURL, $postURL, $feedURL)) {
		    echo 'Ошибка ping-запроса [' .
		    $pingClient->getErrorCode().'] '.$pingClient->getErrorMessage();
		}
		else {
		  //  echo 'Послан ping Google';
		}
		
	}


	public function email(){
		include_once("phpmailer/class.phpmailer.php");
   			
   			
   	
	}

    /**Создание папок по заданному пути**/
	public function prepareDir($dir){
		@mkdir($dir, 0777, true);
		
//		$dir = rtrim($dir, "/\\");
//		if (!is_dir($dir)) {
//			if (!myFunc::prepareDir(dirname($dir)))
//				return false;
//			if (@!mkdir($dir, 0777))
//				return false;
//			chmod($dir, 0777);
//		}
//		return true;
	}
	
	public function removeDir($dir) {
	    if ($objs = glob($dir."/*")) {
	       foreach($objs as $obj) {
	         is_dir($obj) ? $this->removeDir($obj) : unlink($obj);
	       }
	    }
	    rmdir($dir);
 	}

	/**Получим укороченный текст заданной длины**/
	public function getShort($text, $length = 400){
		
		$res = "";
		
		if($str_res = strpos($text, '<!--more-->')){
			$res = substr( $text , 0 , $str_res);
		}elseif(strlen($text) > $length){
			$text = strip_tags($text);
			$res = substr( $text , 0 , $length);
			if($str_res = strripos($res, ' ')){
				$res = substr( $res, 0, $str_res);
			}
		}else{
			$res = $text;
		}
		return $res;
		
	}

/**Удалить расширениея файла**/
	public function delFileExt($name){
		
		return substr($name, 0, strrpos($name, '.'));
	}
	
	/**тарнслитерация - русские буквы заменяем на английские**/
	public function translitToUrl($str, $filename = false){
	    $trans = array("а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e", 
			"ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", 
			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t", 
			"у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"shh",
			"ы"=>"i","э"=>"e","ю"=>"u","я"=>"ya","ї"=>"i","'"=>"","ь"=>"","Ь"=>"",
			"ъ"=>"","Ъ"=>"","і"=>"i","А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
			"Е"=>"E", "Ё"=>"Yo","Ж"=>"J","З"=>"Z","И"=>"I","Й"=>"I","К"=>"K", "Л"=>"L",
			"М"=>"M","Н"=>"N","О"=>"O","П"=>"P", "Р"=>"R","С"=>"S","Т"=>"T","У"=>"Y",
			"Ф"=>"F", "Х"=>"H","Ц"=>"C","Ч"=>"Ch","Ш"=>"Sh","Щ"=>"Sh", "Ы"=>"I","Э"=>"E",
			"Ю"=>"U","Я"=>"Ya","Ї"=>"I","І"=>"I");
			
	   $res=str_replace(" ","-",strtr($str,$trans));
	   $res=str_replace("--","-",$res);
	   $res =   strtolower( $res);
	    //если надо, вырезаем все кроме латинских букв, цифр и дефиса (например для формирования логина)
	    if($filename){  //если это имя файла, то не удаляем точки
	    	$pattern = "|[^a-zA-Z0-9-\.]|";
	    }else{ //если просто урл то оставяем самое нужное
	    	$pattern = "|[^a-zA-Z0-9\-]|";
	    }
	   $res=preg_replace($pattern,"",$res); 
	    return $res;
	}

/**можно сказать шаблоны функций**/
	public function startCountScriptStat(){
		$start_memory_usage = memory_get_usage();
		$start_time = microtime(true);
	}
	
	public function stopCountSCriptStat(){
			global $start_time, $start_memory_usage;
					    $end_time = microtime(true);
			$end_memory_usage = memory_get_usage();
			
			echo "Выполнено за: ".round(($end_time-$start_time),5)." секунд |  ";
			$total_memory_usage = $end_memory_usage - $start_memory_usage;
			//echo $total_memory_usage."<br>";
			echo "Расход памяти:  ". number_format($total_memory_usage, 0, '.', ',') . " байт";
	}

}
