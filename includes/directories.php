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
?>
<?php
$homedir = "/home/user"; // The folder were you want your cloud files to be
$limit_dir = $homedir; // The user won't be allowed to go further

function del_forbidden_chars($name, $id)
{
	$bad_char = array("<", ">", ":", '"', "/", "\\", "|", "?", "*","'");
	$name  = str_replace($bad_char, "_", $name);
	

	return  $name;
}
?>
