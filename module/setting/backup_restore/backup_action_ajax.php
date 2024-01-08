<?php
include_once '../../../include/db_connection.php';

// Backup file settings
$datetime = date('Ymd_Hms');
$backup_db_filename = "aims_$datetime.sql";
$backup_db_audit_filename = "aims_audit_$datetime.sql";
$backup_dir = './files/';

if (!is_dir($backup_dir)) {
	mkdir($backup_dir, 0777, true);
}

// Construct the mysqldump command
exec("C:/xampp/mysql/bin/mysqldump --user=$dbuser --password=$dbpassword --host=$dbhost $dbname --result-file=$backup_dir$backup_db_filename 2>&1", $output_1, $return_code_1);
exec("C:/xampp/mysql/bin/mysqldump --user=$dbuser --password=$dbpassword --host=$dbhost $db_audit --result-file=$backup_dir$backup_db_audit_filename 2>&1", $output_2, $return_code_2);

if ($return_code_1 == 0 && $return_code_2 == 0) {
	echo 'true';
} else {
	echo 'false';
}
?>
