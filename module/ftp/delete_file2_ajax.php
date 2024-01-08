<?php
$filename = $_POST['filename'];
$file_path = './backup_files/' . $filename;

try {
    if (file_exists($file_path)) {
        if (unlink($file_path)) {
            echo 'true';
        } else {
            throw new Exception('Error deleting file: unlink operation failed.');
        }
    } else {
        throw new Exception('Error deleting file: file not found at ' . $file_path);
    }
} catch (Exception $e) {
    $error_message = 'Caught exception: ' . $e->getMessage();
    error_log($error_message);
    echo $error_message;
    echo 'false';
}
?>