<?php
// Check if a file was submitted
if ($_FILES["file"]["error"] == 0) {
    $fileName = $_FILES["file"]["name"];
    $fileContent = file_get_contents($_FILES["file"]["tmp_name"]);

    // Specify the backup directory
    $backupDirectory = 'backup_files/';

    // Create the backup directory if it doesn't exist
    if (!is_dir($backupDirectory)) {
        if (!mkdir($backupDirectory, 0777, true)) {
            die('Error: Unable to create the backup directory.');
        }
    }

    // Save the file content to the backup directory
    if (file_put_contents($backupDirectory . $fileName, $fileContent)) {
        echo "success";
    } else {
        echo "Error: Unable to save the file.";
    }
} else {
    echo "Error: " . $_FILES["file"]["error"];
}
?>