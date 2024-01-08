<?php
	$filename = $_POST['filename'];
	$file_path = './files/' . $filename; // Replace with the actual path to the file

	if (file_exists($file_path)) {
		if (unlink($file_path)) {
			echo 'true';
		} else {
			echo 'false';
		}
	} else {
		echo 'false';
	}
	
?>