<?php

require_once(M_LIB_PATH."/init/initAdminMainFrame.class.php");

class initAdminImage extends initAdminMainFrame{

    function __construct() {
    	parent::__construct();
    }
    
    /**активация загрузчика картинок
     * $id - номер записи
     * $folder - папка, в которую все сохранять, а также - название контроллера, в общем должно совпадать
     * $mainImg - задавать главную какртинку к посту
     * **/
	public function activateImgUp($id, $folder, $mainImg = false){
		
		$this->addJS("lib/img-uploader/functions.js");
		$this->addJS("lib/img-uploader/upload-image.js");
		$this->addJS("lib/img-uploader/jquery.damnUploader.js");
		
		$this->assign("img_up_id_note", $id);
		$this->assign("img_up_folder_note", $folder);
		
		$this->assign("imgUploader", "admin/img_upload.tpl");
		
		$this->img_list  = $this->getImgList( $id, $folder, "orig_");
	}
	
	/**короткий путь к папке с картинками записи**/
	public function getImgFolder($id, $folder){
		
		$res  = "/upload/images/".$folder."/".ceil($id/1000)."/".$id;
		return $res;
	}
	
	/**получаем список изображений для записи
	 * $time - время создания поста
	 * $id - номер поста
	 * $folder - папка типа записей: page, post  и др.
	 * $prfx - префикс изображения: orig_ - оригинал, 60x60_ - тумба 60х60
	 * **/
	public function getImgList( $id, $folder, $prfx="orig_"){
		$url_list = array();
		$list = array();
		$path = $this->getImgFolderPath( $id, $folder);
		
		$list = glob($path."/".$prfx."*");
		
		if($list){
			foreach($list as $k=>$v){
				$url_list[] = array( 
								"link" => $this->getImgFolder($id,$folder)."/".basename($v),
								"name" => basename($v));
			}
		}
		return $url_list;
	}
	
	/**папка с изображениями для записи
	 * 
	 * $time - время создания поста
	 * $id - номер поста
	 * $folder - папка типа записей: page, post  и др.
	 * 
	 * ***/
	public function getImgFolderPath( $id, $folder){
		$path = ROOT_PATH.$this->getImgFolder($id,$folder);
		myFunc::prepareDir($path);
		return $path;
	}

	/**Сохранение картинки 
	 * 
	 ***/
	public function actionSaveimage(){
		try{
			$res = array();
			$this->get();

			if(empty($_FILES['my-pic']) || empty($_FILES['my-pic']['tmp_name'])){
				throw new Exception("EMPTY_FILE");				
			}
			$_img = $_FILES['my-pic'];
			if(empty($this->get['folder'])){
				throw new Exception("NO_NAME_OF_FOLDER");	
				
			}
			$folder = trim($this->get['folder']);
			
			$id = 0;
			if(!(int)$this->get['id']){
				throw new Exception("NO_CORRECT_NOTE_ID");	
			}
			$id = (int)$this->get['id'];
			
			if(!$path = $this->getImgFolderPath( $id, $folder)){
				throw new Exception("ERROR_CREATE_FOLDERS");	
			}
			$_img['name'] = myFunc::translitToUrl($_img['name'], true);
			
			include_once(M_E_PATH."/WideImage/WideImage.php");
			$image = WideImage::load($_img['tmp_name'])
			->resize(500,500,'inside')
			->saveToFile($path."/orig_".$_img['name'], 100);
			
			//copy($_img['tmp_name'], $path."/orig_".$_img['name']);
			
			echo $this->getImgFolder($id, $folder)."/orig_".$_img['name'];
			$this->endApp(true);
			
		}catch(Exception $e){
			$res['error'] = $e->getMessage();
			
		}
		
		echo json_encode($res);

		$this->endApp(true);
		
	}
	
	public function actionDelimage(){
		
		
	}
    
}
