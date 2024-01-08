<?php
	if ($submodule_access['asset']['edit'] != 1) {
		header('location: logout.php');
	}

	$hostname = 'localhost'; // Set your database hostname
	$username = 'root';
	$password = '';
	$database = 'aims';

	// Establish the database connection
	$connection = mysqli_connect($hostname, $username, $password, $database);

	// Check the connection
	if (!$connection) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$tableCount = 0;
	$tableSizes = [];
	$totalSize = 0;

	$aims = 'aims';

	// Retrieve the number of tables in the database
	$result = $connection->query("SELECT COUNT(*) as table_count FROM information_schema.tables WHERE table_schema = '$aims'");
	$row = $result->fetch_assoc();
	$tableCount = $row['table_count'];

	// Calculate the size of each table and total size
	$tableSizes = [];
	$totalSize = 0;

	$tableListQuery = "SHOW TABLES";
	$tableListResult = $connection->query($tableListQuery);

	while ($table = $tableListResult->fetch_array()) {
		$tableName = $table[0];
		$sizeQuery = "SELECT SUM(DATA_LENGTH + INDEX_LENGTH) AS size 
					FROM information_schema.TABLES 
					WHERE TABLE_NAME = '$tableName' AND TABLE_SCHEMA = '$aims'";
		$sizeResult = $connection->query($sizeQuery);
		$sizeRow = $sizeResult->fetch_assoc();
		$tableSize = $sizeRow['size'];

		$tableSizes[$tableName] = $tableSize;
		$totalSize += $tableSize;
	}
?>


<div class="main">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Database Details</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./backup" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height:720px; overflow-y:scroll;">
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <?php
                        $directory = 'module/setting/backup_restore/files/';
                        if (is_dir($directory)) {
                            // Get a list of all filenames in the directory
                            $files = scandir($directory);

                            // Remove "." and ".." entries from the list and reassign array indices
                            $files = array_values(array_diff($files, array('.', '..')));

                            // Loop through the filenames and do something with each file
                            for ($i = 0, $len = count($files); $i < $len; $i++) {
                                $filename = $files[$i];
                                $file_path = $directory . '/' . $filename;
                                $modification_time = date('Y-m-d H:i:s', filemtime($file_path));
                        ?>
                        <h4><?php echo $filename; ?> Details</h4>
                        <?php }
                        } // Close the loop and PHP block here ?>
                    </div>
                </div>
            </div>
            <!-- Display Database Comparison Results -->
            <p>Number of tables in the database: <?php echo $tableCount; ?></p>
            <p>Table sizes:</p>
            <ul>
                <?php foreach ($tableSizes as $tableName => $size): ?>
                    <li><?php echo "$tableName: $size bytes"; ?></li>
                <?php endforeach; ?>
            </ul>
            <p>Total database size:  <?php echo $totalSize; ?>  bytes</p>
        </div>
    </div>
</div>
