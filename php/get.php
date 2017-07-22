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

	if(isset($_GET["file"]))
		$file = $_GET["file"];
	else
		die('Wrong file !');
	
	if(!file_exists($file))
	{
		header("HTTP/1.0 404 Not Found");
		die('Can\'t find the file: '.$file);
	}

	header('Content-Description: File Transfer');
	//header('Content-Transfer-Encoding: binary');
	header('Content-Type: '.mime_content_type($file));
	header('Content-Disposition: attachment; filename="'.basename($file).'"');
    header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
    header('Content-Length: ' . filesize($file));
	set_time_limit(0);
	ob_end_flush();
    flush();
	readfile($file);
	exit;
?>
