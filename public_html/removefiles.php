<?php
	$dir = "tmpfiles/";
	if (is_dir($dir)) {
		if ($dh = opendir($dir)) {
			while (($imgfile = readdir($dh)) !== false) {
				if(strlen($imgfile) >= 5) {
					unlink("tmpfiles/$imgfile");
				}
			}
			closedir($dh);
		}
	}
?>