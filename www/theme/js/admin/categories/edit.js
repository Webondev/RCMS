$(document).ready(function(){
	
	getUrlName();
});
	

function getUrlName(){
	
	$("input[name='post\[title\]']").change(function(){
		
		var tmp =  $("input[name='post\[url\]']");
		
		if(!tmp.val()){
			tmp.(toTranslit($(this).val()));
		}
		
		//console.log( toTranslit($(this).val()))
	});
	
	//console.log($("input[name='page\[title\]']"));
}