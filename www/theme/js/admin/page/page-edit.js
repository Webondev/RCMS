$(document).ready(function(){
	
	getUrlName();
});
	

function getUrlName(){
	
	$("input[name='page\[title\]']").change(function(){
		
		var tmp =  $("input[name='page\[url\]']");
		
		if(!tmp.val()){
			tmp.(toTranslit($(this).val()));
		}
		
		//console.log( toTranslit($(this).val()))
	});
	
	//console.log($("input[name='page\[title\]']"));
}