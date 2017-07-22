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
		
	if(!isset($_POST["dir"]))
		die('Wrong directory !');
	else
		$dir = $_POST["dir"];
	
	include('../includes/findname.php');
	
	if(!file_exists($dir.'/'.$file))
		die('Can\'t find the file: '.$dir.'/'.$file);
	elseif(!is_writable($dir))
		die('Permission denied: '.$dir);
	if(strtolower(strrchr($file, '.')) != '.zip')
		die('This is not a zip archive: '.$dir.'/'.$file);

	$foldername = substr($file, 0, -strlen(strrchr($file, '.')));
	if(file_exists($dir.'/'.$foldername))
		$foldername = findname($foldername, $dir);
		
	$zip = new ZipArchive;
	if ($zip->open($dir.'/'.$file) === true) {
		if(!mkdir($dir.'/'.$foldername))
			die('Can\'t create the appropriate folder');
		$zip->extractTo($dir.'/'.$foldername);
		$zip->close();
	}
	else
		die('Can\'t extract the archive: '.$filename);
		
	echo 'Extracted successfully';
?>
