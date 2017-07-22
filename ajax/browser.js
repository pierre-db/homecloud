/* Copyright 2016 Pierre DAL BIANCO | http://www.gnu.org/licenses/gpl.txt */

$(document).ready(function(){
	function post_action(a)
	{
		var posturl = a.attr("href");
		var var1, var2, var3;
		var var1_name, var2_name, var3_name;
		
		var prompt_txt = "";
		
		if(posturl == "php/edit.php")
		{
			var1 = a.attr("dir"); var1_name = "dir";
			var2 = a.attr("file"); var2_name = "old_name";
			var3 = var2; var3_name = "new_name";
			prompt_txt = "New name:";
		}
		else if(posturl == "php/move.php")
		{
			var1 = a.attr("file"); var1_name = "file";
			var2 = a.attr("dir"); var2_name = "old_path";
			var3 = var2; var3_name = "new_path";
			prompt_txt = "Destination folder:";
		}
		else if(posturl == "php/delete.php")
		{
			var1 = a.attr("file"); var1_name = "file";
			var2 = a.attr("dir"); var2_name = "dir";
			var3 = "empty"; var3_name = "empty";
			
			if(!(confirm('Delete this element ?'))) 
				return false;
		}
		else if(posturl == "php/new.php")
		{
			var1 = a.attr("dir"); var1_name = "dir";
			var2 = "New"; var2_name = "empty";
			var3 = a.attr("new_dir"); var3_name = "new_dir";
			prompt_txt = "New folder\'s name:";
		}
		else if(posturl == "php/download.php")
		{
			var1 = a.attr("dir"); var1_name = "dir";
			var2 = ""; var2_name = "empty";
			var3 = ""; var3_name = "file";
			prompt_txt = "File\'s URL:";
		}
		else if(posturl == "php/unzip.php")
		{
			var1 = a.attr("dir"); var1_name = "dir";
			var2 = a.attr("file"); var2_name = "file";
			var3 = "empty"; var3_name = "empty";
		}	
		
		if(prompt_txt != "")
		{
			input = prompt(prompt_txt, var2);
			if(input!=null)
				var3 = input;
			else
				return false;
		}
		
		var postdata = var1_name+"="+var1+"&"+var2_name+"="+var2+"&"+var3_name+"="+var3;

		$.ajax({  
				url: posturl,  
				type: "POST",  
				data: postdata,   
				success: function (res) {
					if(res.indexOf('successfully') != -1)
						location.reload();
					else
						alert(res);
				}  
		});
	}
	
	$('a.ajax').click(function() {
		post_action($(this));
		return false;
	});
	
	$('td.filename').click(function() {
		if($(this).children('a').attr("href").indexOf('php/get.php') == -1)
			location.href = $(this).children('a').attr("href");
		else
		{
			 window.open($(this).children('a').attr("href"));
			 return false;
		}
	});
});
