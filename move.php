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

	if(isset($_POST["file"]))
		$file = $_POST["file"];
	else
		die('Wrong file !');
	
	if(!isset($_POST["old_path"]))
		die('Wrong old path !');
	else
		$old_path = $_POST["old_path"];
	
	if(!isset($_POST["new_path"]))
		die('Wrong new path !');
	else
		$new_path = $_POST["new_path"];
	
	include('../includes/findname.php');
	
	if(!file_exists($old_path.'/'.$file))
		die('This file doesn\'t exist: '.$old_path.'/'.$file);
	elseif(!is_writable($old_path.'/'.$file))
		die('Permission denied: '.$old_path.'/'.$file);
	
	$new_file = $file;
	
	if(!file_exists($new_path))
		die('Destination directory doesn\'t exist: '.$new_path);
	elseif(!is_writable($new_path))
		die('Permission denied: '.$new_path);
	elseif(file_exists($new_path.'/'.$new_file))
		$new_file = findname($new_file, $new_path);

	if(!rename($old_path.'/'.$file, $new_path.'/'.$new_file))
		die('Error while moving '.$old_path.'/'.$file);

	echo 'Moved successfully';
?>
