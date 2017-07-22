/* Copyright 2016 Pierre DAL BIANCO | http://www.gnu.org/licenses/gpl.txt */

$(document).ready(function(){

	function post_cmd(a, b)
	{
		var posturl = a.attr("href");
		var cmd = a.attr("cmd");
		
		var postdata = "cmd="+cmd;
		var result = "";
		
		$.ajax({  
				url: posturl,  
				type: "POST",  
				data: postdata,   
				success: function (res) {
						b.html(res);
				}
		
		});
	}
	
	$('a[href="php/info.php"]').click(function() {
		post_cmd($(this), $('div.credits'));
		if($('div.credits').css('display') == 'none')
			$('div.credits').show("slow");
		else
			$('div.credits').hide(500);
		return false;
	});
});
