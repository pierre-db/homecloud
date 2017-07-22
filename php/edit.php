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
	
	if(!isset($_POST["old_name"]))
		die('Wrong old name !');
	else
		$old_name = $_POST["old_name"];
	
	if(!isset($_POST["new_name"]))
		die('Wrong new name !');
	else
		$new_name = $_POST["new_name"];
	
	if(!file_exists($dir.'/'.$old_name))
		die('This file doesn\'t exist: '.$dir.'/'.$old_name);
	elseif(!is_writable($dir.'/'.$old_name))
		die('Permission denied: '.$dir.'/'.$old_name);
	elseif(file_exists($dir.'/'.$new_name))
		die('This file already exists: '.$dir.'/'.$new_name);
	elseif(is_dir($dir.'/'.$old_name) && strrchr($new_name, '/')) // This is a directory, we won't allow '/' caracters
		die('The new name can\'t contain a \'/\' character: '.$new_name);
	
	if(rename($dir.'/'.$old_name, $dir.'/'.$new_name))
		echo 'Renamed successfully';
	else
		echo 'Error: '.strtolower($type).' not renamed';
?>
