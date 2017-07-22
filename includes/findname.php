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

	function findname($filename, $dir)
	{
		$extention = strrchr($filename, '.');
		if($extention != '')
			$filename = substr($filename, 0, -strlen($extention));
			
		$i=1;
		while(file_exists($dir.'/'.$filename.'('.$i.')'.$extention))
			$i++;
		
		return $filename.'('.$i.')'.$extention;
	}
?>
