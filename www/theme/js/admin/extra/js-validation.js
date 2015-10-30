/**Простая валидация полей*/
function simpleValidation(){
	
	myVal = {
			'correct':function(pole){
				$('.' +pole+ '_error').remove();
				myVal.ready = true;
			},
			'error': function(pole, error){
				$('.' +pole+ '_error').remove();
				$('#' + pole).after('<span class="'+pole+'_error">'+error+'</span>');
				myVal.ready = false;
			},
			'name': function(){
				var pole = 'ts_name';
				var element = $('#' + pole);
				var error = 'Неверно, мин. 2 символа';
				var pattern = /^.{2,50}$/i;
				
				if(!pattern.test(element.val())){
					myVal.error(pole, error);
				}else{
					myVal.correct(pole);
				}
			},
			'email': function(){
				var pole = 'ts_email';
				var element = $('#' + pole);
				var error = 'Неверный email';
				var pattern = /^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})/i;
				if(!pattern.test(element.val())){
					myVal.error(pole, error);
				}else{
					myVal.correct(pole);
				}
			},
			'number': function(){
				var pole = 'ts_number';
				var element = $('#' + pole);
				var error = 'Неверно, символы [0-9], мин. 1';
				var pattern = /^[0-9]{1,5}$/i;
				if(!pattern.test(element.val())){
					myVal.error(pole, error);
				}else{
					myVal.correct(pole);
				}
			},
			'login': function(){
				var pole = 'ts_login';
				var element = $('#' + pole);
				var error = 'Неверно, символы [0-9A-Za-z], мин. 2';
				var pattern = /^[0-9A-Za-z]{2,50}$/i;
				if(!pattern.test(element.val())){
					myVal.error(pole, error);
				}else{
					myVal.correct(pole);
				}
			},
			'text': function(pole){
				//var pole = 'ts_text';
				if(pole == undefined){
					var pole = 'ts_text';
				}
				
				var element = $('#' + pole);
				var error = 'Неверно, мин. 5, макс. 250 символов';
				var pattern = /^.{5,250}$/im;
				if(!pattern.test(element.val())){
					myVal.error(pole, error);
				}else{
					myVal.correct(pole);
				}
			}
			
			
	};
	
	/*support tickets*/
	$('#ts_name').change(myVal.name);
	$('#ts_email').change(myVal.email);
	$('#ts_login').change(myVal.login);
	$('#ts_text').change(myVal.text);
	
	$('#submitSupport').click(function(){
		myVal.ready = false;
		myVal.name();
		myVal.email();
		myVal.login();
		myVal.text();
		
		if(myVal.ready){
			$('#submitSupport').attr('disabled', 'disabled');
			
			var options = {
					  target: "#divToUpdate",
					  url: AJAXPath + 'technical_support.php',
					  dataType: 'json',
					  success: function(data) {
					        //console.log(data);
						  if (data.action !== undefined){
							  $('#support_error').css("color", "yellow");
								  $('#support_error').text(data.action);
								  
								  
								  setTimeout('hideForm()', 1000);
								  
								  
						  }else if(data.error !== undefined){
							
							  $('#support_error').text(data.error+'. Попробуйте сново');
							  
							  $('#submitSupport').removeAttr('disabled');
						  }
						  
					  }
					};
			$("#techsupport_form").ajaxSubmit(options);
	
		}
		
	});
	/*users comment*/
	$('#add_comment').click(function(){
		$('#add_comment').attr('disabled', true);
		
		
		
		$.post(AJAXPath + 'comment_add.php', {'comment':{"text": $('#user_comment_text').val()}}, function(data){
			data = $.parseJSON(data);
			//console.log(data.action);
			  if (data.action !== undefined){
				   $('#comment_edit_error').text(data.action);
				   $('#add_comment').removeAttr('disabled');
				   setTimeout('hideCommentError()', 1000);
			  }else if(data.error !== undefined){
				
				  $('#comment_edit_error').text(data.error+'. Попробуйте сново');
				  
				  $('#add_comment').removeAttr('disabled');
			  }
		});
		

		
	});
	

	
	
}