<?php
/*
Copyright 2016 Pierre DAL BIANCO

    This file is part of Home Cloud.

    Home Cloud is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Home Cloud is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Home Cloud.  If not, see <http://www.gnu.org/licenses/>.
*/

	if(isset($_FILES['file']))
		$file = $_FILES['file'];
	else
		die('Wrong files !');
		
	if(isset($_POST['dir']))
		$dir = $_POST['dir'];
	else
		die('Wrong directory !');
	
		
	if(!file_exists($dir))
		die('Destination directory doesn\'t exist: '.$dir);
	elseif(!is_writable($dir))
		die('Permission denied: '.$dir);
	
	if(!is_uploaded_file($file['tmp_name']))
		die('Error: file not uploaded');
	
	include('../includes/findname.php');
	define("UPLOAD_ERR_EMPTY", 5);
	$upload_errors = array( 
	 UPLOAD_ERR_OK        => "No error", 
	 UPLOAD_ERR_INI_SIZE    => "The uploaded file exceeds the upload_max_filesize directive in php.ini", 
	 UPLOAD_ERR_FORM_SIZE    => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form", 
	 UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded", 
	 UPLOAD_ERR_NO_FILE        =>"No file was uploaded", 
	 UPLOAD_ERR_CANT_WRITE    => "Failed to write file to disk", 
	 UPLOAD_ERR_EXTENSION     => "File upload stopped by extension", 
	 UPLOAD_ERR_EMPTY        => "File is empty" // add this to avoid an offset 
	);
	
	$filename = $file['name'];
	if($filename == '')
		$filename = 'unknown';
	
	if(file_exists($dir.'/'.$filename))
		$filename = findname($filename, $dir);
	
	if(!($file['error'] === UPLOAD_ERR_OK)) // Check that there is no error
		die('Error with file '.$file['name'].': '.$upload_errors[$file['error']]);
		
	if(!move_uploaded_file($file['tmp_name'], $dir.'/'.$filename))
		die('Upload failed for file: '.$file['name']);
	
	echo 'Uploaded successfully';
?>
