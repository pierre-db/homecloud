/* Copyright 2016 Pierre DAL BIANCO | http://www.gnu.org/licenses/gpl.txt */

$(document).ready(function(){	
	$('input[name=file]').change(function() {
	
	var filesarray = this.files; 
	for (var i=0; i<filesarray.length; i++)
		post_file(filesarray[i]);

	});
	
	
	function post_file(file)
	{
		var formdata = false;
		var max_size = $('form[name=upload] input[name=MAX_FILE_SIZE]').val();
		
		if(file.size >= max_size) 
		{	
			alert('Max size supported: '+max_size+' B');
			return false;
		}
		
		if (window.FormData)
			formdata = new FormData();

		formdata.append('file', file);
		formdata.append('dir', $('form[name=upload] input[name=dir]').val());	
		
		if (formdata) {
			$.ajax({  
					url: "php/upload.php",  
					type: "POST",  
					data: formdata,  
					processData: false, 
					contentType: false,
					timeout: 0,
					success: function (res) {  
						$('span#dropzone').html('Current: '+file.name);
						if(res.indexOf('successfully') != -1)
							location.reload();
						else
						{
							$('span#dropzone').html('Drop files in the window');
							alert(res);
						}
					},
					error : function(res, statut, err){
						alert(err);
					}
			});
			
		}
		else {
			alert('Sorry but your browser doesn\'t support this feature');
			return false;
		}
	}
	
	$('a[name=upload]').click(function() {
		if($("div#upload").css("display") != "none")
			$("div#upload").hide('fast');
		else
			$("div#upload").show('fast');
		return false;
	});
	
	$('div#main').on('dragover dragcenter', function(event) {
		event.stopPropagation();
		event.preventDefault();
		
		$("div#upload").show('fast');
    });
	
	$('div#main').on('dragout dragleave', function(event) {
		event.stopPropagation();
		event.preventDefault();
		
		$("div#upload").hide('fast');
    });
	
	 $('div#main').on('drop', function(event) {
		event.stopPropagation();
		event.preventDefault();
		
		var filesarray = event.originalEvent.dataTransfer.files;
		for (var i=0; i<filesarray.length; i++)
			post_file(filesarray[i]);

	});
});
