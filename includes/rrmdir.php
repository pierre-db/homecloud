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

	function rrmdir($dir) //removes recursively a directory
	{
		if(!is_dir("$dir") AND !is_file("$dir"))
			return false;
		
		$objects = scandir($dir);
		
		foreach ($objects as $file)
		{ 
			if($file == "." OR $file == "..")
                continue;
				
			if(is_dir($dir."/".$file))
				rrmdir($dir."/".$file);
			elseif(is_file($dir."/".$file))
				unlink($dir."/".$file); 
		} 
		return rmdir($dir); 
	}
?>
