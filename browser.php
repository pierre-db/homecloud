<!--
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
-->
<html>
<head>
<meta charset="UTF-8" > 
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="ajax/jquery-2.1.4.min.js"></script>
<script src="ajax/browser.js"></script>
<script src="ajax/main.js"></script>
<script src="ajax/upload.js"></script>
<link rel="icon" type="image/x-ico" href="images/favicon.ico" />
<link rel="stylesheet" href="css/main.css" type="text/css">
<link rel="stylesheet" href="css/browser.css" type="text/css">
</head>
<body>
<title>Home Cloud file browser</title>
<div id="scripts">
<table class="header"><tr><td><img src="images/scripts/homecloud-logo.png"/></td>
<td class="title">Home Cloud</td>
<td class="info"><a href="php/info.php" cmd="none" target="_blank"><img src="images/scripts/info.png"/></a></td></tr></table>
</div>
<div class="credits" style="display:none"></div>
<?php
	include("./includes/directories.php");

	$filetypes = array(
		array('ext' => array('.jpg', '.jpeg', '.gif', '.tiff', '.png', '.bmp', '.ico'), 'ico' => 'images/mimetypes/image.png'),
		array('ext' => array('.mpg', '.mpeg', '.mp4', '.mkv', '.avi','.mov'), 'ico' => 'images/mimetypes/video.png'),
		array('ext' => array('.mp3', '.wav', '.ogg', '.ma4', '.flac'), 'ico' => 'images/mimetypes/audio.png'),
		array('ext' => array('.rar', '.gz', '.zip', '.7z', '.tar'), 'ico' => 'images/mimetypes/archive.png'),
		array('ext' => array('.txt', '.srt', '.css', '.js', '.log'), 'ico' => 'images/mimetypes/text.png'),
		array('ext' => array('.sh', '.bin', '.bash', '.bat', '.exe', '.msi'), 'ico' => 'images/mimetypes/exec.png'),
		array('ext' => array('.html', '.htm', '.php'), 'ico' => 'images/mimetypes/www.png'));
	
	// Definition of the main directories :
		
	if(isset($_GET["dir"]) && file_exists($_GET["dir"]) && is_dir($_GET["dir"]))
		$dir = urldecode($_GET["dir"]);
	elseif(isset($_GET["dir"]) && strlen($_GET["dir"]) == 0)
		$dir = '/';
	else
		$dir = $homedir;
			
	if(!file_exists($dir) || !is_dir($dir))
		$dir = $homedir;
	elseif(!strstr($dir, $limit_dir))	// The user wants to go further than the limit directory
		$dir = $limit_dir;

	$dir_expl = explode('/',$dir);
	$prevdir = substr($dir, 0, -strlen($dir_expl[count($dir_expl) - 1]) - 1); // We substract the last directory url
?>
<div id="top">
	<form name="location" action="browser.php" method="get">
		<table class="container">
			<tr><td><a href="browser.php?dir=<?php echo $homedir;?>"><img src="images/actions/home.png"/></a>
			<a href="browser.php?dir=<?php echo $prevdir;?>"><img src="images/actions/folderup.png"/></a></td>
			<td><input type="text" name="dir" value="<?php echo $dir;?>"/></td>
			<td><a href="#" onclick="javascript:document.forms['location'].submit();" ><img src="images/actions/forward.png"/></a></td></tr>
		</table>
	</form>
	<span id="actions">
		<a href="php/download.php" dir="<?php echo $dir;?>" class="ajax"><img src="images/actions/download.png" alt="download file"/></a>
		<a href="#" name="upload"><img src="images/actions/upload.png" alt="upload file"></a>
		<a href="php/new.php" dir="<?php echo $dir;?>" new_dir="New" class="ajax"><img src="images/actions/newfolder.png" alt="new folder"/></a>
	</span>
</div>
<div id="upload">
	<form action="php/upload.php" name="upload" method="post" enctype="multipart/form-data">
		<table class="container">
			<tr><td>
			<input type="hidden" name="MAX_FILE_SIZE" value="1073741824" />
			<input type="file" name="file" multiple/>
			<input type="hidden" name="dir" value="<?php echo $dir;?>" /></td></tr>
		</table>
	</form>
	<span id="progress"></span>
    <span id="dropzone">Drop files in the window</span>
</div>
<div id="main">
<?php
	$unsorted_list = scandir($dir);
	$files = array();
	$directories = array();
	
	foreach($unsorted_list as $object) // We sort the object's list so the directories appear 1st, then the files
	{
		if(is_dir($dir.'/'.$object))
			$directories[] = $object;
		else
			$files[] = $object;
	}
	$list = array_merge($directories, $files);
	
	if($dir == '/') // It will simplify things for later
		$dir ='';
	
	echo '<table class="browser">';
	echo '<tr class="uneven"><th id="mimetype"><img src="images/mimetypes/document.png"></th><th>Name</th><th id="size">Size</th><th id="modify">Modify</th></tr>';
	$j=0;
	for($i = 0; $i < count($list); $i++)
	{	
		if(substr($list[$i], 0, 1) == '.') // a hidden file or directory
			continue;
		elseif(is_dir($dir.'/'.$list[$i])) // a common directory
			echo '<tr class="'.($j++%2 == 0? "even":"uneven").'"><td><img src="images/mimetypes/folder.png"></td><td class="filename"><a href="browser.php?dir='.$dir.'/'.$list[$i].'">'.$list[$i].'</a></td><td> </td>';
		else // This is a file
		{
			foreach($filetypes as $type)
			{
				if(in_array(strtolower(strrchr($list[$i], '.')), $type['ext']))
				{
					$image_src = $type['ico'];
					break;
				}
				else
					$image_src = 'images/mimetypes/unknown.png';
			}

			$filesize = filesize($dir.'/'.$list[$i]);
			if($filesize < 1024)
				$filesize = $filesize.' B';
			elseif($filesize >= 1024*1024*1024)
				$filesize = number_format($filesize/(1024*1024*1024), 1, ',', '').' GB';
			elseif($filesize >= 1024*1024)
				$filesize = number_format($filesize/(1024*1024), 1, ',', '').' MB';	
			elseif($filesize >= 1024)
				$filesize = number_format($filesize/1024, 1, ',', '').' kB';
		
				
			echo '<tr class="'.($j++%2 == 0? "even":"uneven").'"><td><img src="'.$image_src.'"></td><td class="filename"><a href="php/get.php?file='.$dir.'/'.$list[$i].'" target="_blank">'.$list[$i].'</a>'.(strtolower(strrchr($list[$i], '.')) == '.zip' ? ' (<a href="php/unzip.php" dir="'.$dir.'" file="'.$list[$i].'" class="ajax"><img src="images/actions/unzip.png" ></a>)':'').'</td>';
			echo '<td class="size">'.$filesize.'</td>';
		}
		echo '<td class="actions"><a href="php/edit.php" dir="'.$dir.'" file="'.$list[$i].'" class="ajax"><img src="images/actions/edit.png"/></a> <a href="php/move.php" dir="'.$dir.'" file="'.$list[$i].'" class="ajax"><img src="images/actions/move.png"/></a> <a href="php/delete.php" dir="'.$dir.'" file="'.$list[$i].'" class="ajax"><img src="images/actions/delete.png"/></a>'.'</td></tr>';
	}
	echo '</table>';
?>
</div>
</body>
</html>
