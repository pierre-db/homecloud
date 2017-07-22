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
		
	if(isset($_POST["dir"]))
	$dir = $_POST["dir"];
	else
		die('Wrong directory !');
		
	include('../includes/findname.php');
	
	if (!$fp = fopen($file, 'r')) {
		die("Can\'t read URL: $file");
	}

	$meta = stream_get_meta_data($fp);
	
	if(!empty($meta["wrapper_data"]))
	{
		foreach($meta["wrapper_data"] as $data)
		{
			if(strstr($data, 'Location'))
			{
				$filename = substr($data, strpos($data, ':') + 1);
				break;
			}
			elseif(strstr($data, 'filename'))
			{
				$filename = substr($data, strpos($data, '=') + 1);
				break;
			}
		}
		$filename = str_replace('"','',$filename);
	}
	else
		die('Can\'t find a fetched file in the link: '.$file);
	
	if($filename == '')
		$filename = 'unknown';
	else
	{		
		$loc_expl = explode('/',$filename);
		$filename = $loc_expl[count($loc_expl) - 1];
	}
	
	if(file_exists($dir.'/'.$filename))
		$filename = findname($filename, $dir);
		
	if(file_put_contents($dir.'/'.$filename, stream_get_contents($fp)))
		echo 'Downloaded successfully';

	else
		echo 'Error while downloading the file: '.$file;
	
	fclose($fp);
?>
