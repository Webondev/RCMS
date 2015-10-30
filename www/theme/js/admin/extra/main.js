$(document).ready(function() {
	
		popUpMsg();
		
		$("#sendPrivatMsg").click(function(){
			postMsg();
			return false;
		});
		
		$("#innerPopName, #innerPopEmail, #innerPopMsgText").change(function(){
			checkFields();
			return false;
		});

		
	});

/**send private message*/
function postMsg(){
	
	if(!checkFields()){
		return false;
	}
	$("#sendPrivatMsgImg").show();
	var _form = $("#privatMsg").serialize();
	$("#sendPrivatMsg").attr("disabled", true);
	$.post("/privatMsgs/create/", _form, function(data){
		$("#sendPrivatMsgImg").hide();
		if(data == "OK"){
			$("#statusPopUpMSg").css("color", "green").text("Оправлено.");
			setTimeout(function(){
				$("#innerPopLink").click(); 
				$("#sendPrivatMsg").attr("disabled", false);
				$('textarea#innerPopMsgText').val('');
				
			}, 1100);
			
			
		}else{
			$("#statusPopUpMSg").css("color", "red").text("Ошибка.");
			$("#sendPrivatMsg").attr("disabled", false);
		}
	});
	return false;
}

function checkFields(){
	//console.log();
	var res = true;
	
	//name
	var element = $('#innerPopName');
	var pattern = /^.{2,50}$/i;
	if(!pattern.test(element.val())){
		$("#innerPopNameError").text("Не введено имя, 2-50 символов.");
		res = false;
	}else{
		$("#innerPopNameError").text("");
	}
	
	//email
	var element = $('#innerPopEmail');
	var error = 'Неверный email';
	var pattern = /^([a-z0-9_\.\-]{1,20})@([a-z0-9\.\-]{1,20})\.([a-z]{2,4})/i;
	if(!pattern.test(element.val())){
		$("#innerPopEmailError").text("Не введен email");
		res = false;
	}else{
		$("#innerPopEmailError").text("");
	}
	
	//text
	
	var element = $('textarea#innerPopMsgText');
	var pattern = /^.{10,250}$/im;
	//console.log(element.val());
	if(!pattern.test(element.val())){
		$("#innerPopMsgError").text("10- 250 символов");
		res = false;
	}else{
		$("#innerPopMsgError").text("");
	}
	
	return res;
}

/**work with popup msgField**/
function popUpMsg(){
		//popup condition
		var tmp_cond = "closed";
		var wtop = 0;
		var tmp_h = -290;
		
		$("#innerPopLink").click(function(){
			var offset = $("#topPop").offset();
			// console.log(offset.top);
			 
			if(tmp_cond == "closed"){
				  $("#topPop").stop().animate({top: wtop+"px"});
				  $("#innerPopLink").text("Обратная связь/Скрыть");
				  tmp_cond = "opened";
			}else if(tmp_cond == "opened"){
				$("#topPop").stop().animate({top: wtop+tmp_h+"px"});
				$("#innerPopLink").text("Обратная связь/Показать");
				tmp_cond = "closed";
			}
			return false;
		});
		//scrolling window
		$(window).scroll(function() {
			var offset = $("#topPop").offset();
			wtop = $(window).scrollTop();
			if(tmp_cond == "closed"){
				
				$("#topPop").css("top", wtop + tmp_h+"px");
			}else if(tmp_cond == "opened"){
				$("#topPop").css("top", wtop);
			}
				
		});	
}