$(document).ready(function(){
	//#Post_main_pic

	addMainPic();
	clickByImage();
	

});

/*Добавляем главную картинку к посту*/
function addMainPic(){
	$('.addMainPic').click(function(){
		var parent_li = $(this).closest("li");
		var new_main_pic = parent_li.find('img').attr('src');
		$('#Page_main_pic').val(new_main_pic);
		//console.log($('#Page_main_pic'));
		$('#show_post_main_pic').html("<img width='85px' src='"+new_main_pic+"'>");
		return false;
	});
}

/**вставка по клику изображения  на место курсора**/
function clickByImage(){
	
		//Add image to post by click on need image
	$('.img-list li img').click(function(data){
//		$('#_content_text').insertAtCaret("<a href='" + $(this).attr('src') + "'><img style='width:200px;' src='" + $(this).attr('src') + "'></a>");
		
		addImgTitleIn = $("input[name=post\\[title\\]]").val();
		if(!addImgTitleIn){
			addImgTitleIn = "";
		}
		$('#_content_text').insertAtCaret("<div class=\"image_show\"><img  src='" 
				+ $(this).attr('src') 
				+ "' title=\""+addImgTitleIn+"\"></div>");
	});
}


/**Для вставки на место курсора напр:$('#thetext,#thearea').insertAtCaret("Текст для вставки");*/
jQuery.fn.extend({
    insertAtCaret: function(myValue){
        return this.each(function(i) {
            if (document.selection) {
                // Для браузеров типа Internet Explorer
                this.focus();
                var sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else if (this.selectionStart || this.selectionStart == '0') {
                // Для браузеров типа Firefox и других Webkit-ов
                var startPos = this.selectionStart;
                var endPos = this.selectionEnd;
                var scrollTop = this.scrollTop;
                this.value = this.value.substring(0, startPos)+myValue+this.value.substring(endPos,this.value.length);
                this.focus();
                this.selectionStart = startPos + myValue.length;
                this.selectionEnd = startPos + myValue.length;
                this.scrollTop = scrollTop;
            } else {
                this.value += myValue;
                this.focus();
            }
        })
    }
});