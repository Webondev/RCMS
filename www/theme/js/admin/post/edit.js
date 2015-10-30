$(document).ready(function(){
	
	$("#shab_youtube").click(addYoutube);
	$("#shab_more").click(addMore);
	
	getUrlName();
});
	

function getUrlName(){
	
	$("input[name='post\[title\]']").change(function(){
		
		var tmp =  $("input[name='post\[url\]']");
	//console.log(tmp.val());
		if(!tmp.val()){
			var str = toTranslit($(this).val());
			str = str.toLowerCase();
			tmp.val(str);
		}
		
		//console.log( toTranslit($(this).val()))
	});
	
	//console.log($("input[name='page\[title\]']"));
}

function addYoutube(){
	
	var str = '<iframe width="500" height="300" src="http://www.youtube.com/embed/'
	+'?feature=player_detailpage" frameborder="0" allowfullscreen></iframe>';
	
	$('#_content_text').insertAtCaret(str);
	return false;
}

function addMore(){
	
	var str = '<!--more-->';
	$('#_content_text').insertAtCaret(str);
	return false;
}