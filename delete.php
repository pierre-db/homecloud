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

	if(isset($_POST["dir"]))
		$dir = $_POST["dir"];
	else
		die('Wrong directory !');
	
	if(strlen($dir) == 0)
		$dir = '/';
		
	if($dir == '/')
		$dir='';
	
	if(isset($_POST["file"]))
		$file = $_POST["file"];
	else
		die('Wrong file !');
	
	$fullpath = $dir.'/'.$file;
	
	if(!file_exists($fullpath))
		die('This file doesn\'t exist: '.$fullpath);
	elseif(!is_writable($fullpath))
		die('Permission denied: '.$fullpath);
	elseif(is_dir($fullpath))
	{	// This is a directory
		include('../includes/rrmdir.php');
		rrmdir($fullpath);
	}
	else //This is a file
	{	
		if(!unlink($fullpath)) // We remove the file from the server	
			echo "Error: file not deleted";			
	}
	echo "Deleted successfully";
?>
