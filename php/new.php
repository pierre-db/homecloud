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

	if(!isset($_POST["dir"]))
		die('Wrong path !');
	else
		$dir = $_POST["dir"];
	
	if(!isset($_POST["new_dir"]))
		die('Wrong new directory !');
	else
		$new_dir = $_POST["new_dir"];
		
	include('../includes/findname.php');
	
	if(!file_exists($dir))
		die('Destination directory doesn\'t exist: '.$dir);
	elseif(!is_writable($dir))
		die('Permission denied: '.$dir);
	elseif(file_exists($dir.'/'.$new_dir)) // This directory already exists
		$new_dir = $filename = findname($new_dir, $dir);
		
	if(mkdir($dir.'/'.$new_dir, 0777, true))
		echo 'New directory created successfully';
	else
		echo 'Error while creating the directory '.$dir.'/'.$new_dir;
?>
