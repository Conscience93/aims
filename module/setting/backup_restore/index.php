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

<style>
    table {
		border-collapse: collapse;
		width: 100% !important;
		/* border: 1px solid black; */
	}

	th, td {
		/* border: 1px solid black; */
		padding: 8px;
		text-align: center;
	}

	/* Alternating Row Colors */
	#tbl-backup tbody tr:nth-child(even) {
		background-color: #f0f0f0;
	}

	.button-container {
		display: flex;
	}

	label {
		min-width: 50px;
		text-align: right;
	}

	.row .float-right {
		display: flex;
		justify-content: flex-end;
		align-items: center;
	}

	.row .float-right button {
		margin-left: 5px; /* Adjust the margin as needed */
	}

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-database" data-toggle="tab" href="#database" role="tab" aria-controls="database" aria-selected="false">
                Database
            </a>
        </li>
		<li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-compare" data-toggle="tab" href="#compare" role="tab" aria-controls="compare" aria-selected="false">
                Database Comparison
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-files" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">
                Files
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: Database -->
        <div class="tab-pane fade show active" id="database" role="tabpanel" aria-labelledby="tab-database">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Backup / Restore</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
								<button type="button" class="btn btn-danger" onclick="history.back();">Discard</button>
								<button type="button" class="btn btn-success" onclick="backup();">Backup</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="overflow-y:auto;">
					<table id="tbl-backup">
						<thead>
							<tr>
								<th>No.</th>
								<th>File Name</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
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
										<tr>
											<td><?php echo $i + 1; ?></td>
											<td><?php echo $filename; ?></td>
											<td><?php echo $modification_time; ?></td>
											<td>
												<a class="downloadbtn" title="Download" href="<?php echo $file_path; ?>" download="<?php echo $filename; ?>"><img src="./include/action/download.png"></a>
												<a class="deletebtn" title="Delete" onclick="deleteFile('<?php echo $filename; ?>');"><img src="./include/action/delete.png"></a>
												<a class="viewbtn" href="./viewdatabase?database=<?php echo $filename; ?>" title="More Info"><img class="actionbtn" src="./include/action/review.png"></a>&nbsp;
											</td>
										</tr>
							<?php
									}
								}						
							?>
						</tbody>
					</table>
				</div>           
            </div>
        </div>         

		<!-- Tab 2: Database Comparison -->
		<div class="tab-pane fade" id="compare" role="tabpanel" aria-labelledby="tab-compare" style ="overflow-y:scroll">
			<div class="card shadow rounded">
				<div class="card-header" style="background:white;">
					<div class ="row">
						<div class="col-6">
							<h2>Database Comparison Results</h2>
						</div>
					</div>
				</div>
				<div class="card-body" style="overflow-y:auto;">
					 Display Database Comparison Results
					<p>Database :<?php echo $filename;?></p>
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
		
       <!-- Tab 3: Files -->
		<div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="tab-files">
			<div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
							<h2>Files Backup</h2>
						</div>
						<div class="col-6">
							<div class="float-right">
								<button type="button" class="btn btn-danger" onclick="history.back();">Discard</button>
								<button type="button" class="btn btn-success" onclick="uploadFile()">Backup</button>
								<input type="file" id="fileInput" style="display: none;" onchange="handleFileSelect()">
							</div>
						</div>
					</div>
				</div>
				<div class="card-body" style="overflow-y:auto;">
					<!-- Display Uploaded Files -->
					<table id="tbl-backupfiles">
						<thead>
							<tr>
								<th>No.</th>
								<th>File Name</th>
								<th>Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<?php
							// Fetch and display the updated file table content
							$directory = 'module/setting/backup_restore/backup_files/';
							$html = '';

							if (is_dir($directory)) {
								$files = scandir($directory);
								$files = array_values(array_diff($files, array('.', '..')));

								for ($i = 0, $len = count($files); $i < $len; $i++) {
									$filename = $files[$i];
									$file_path = $directory . '/' . $filename;
									$modification_time = date('Y-m-d H:i:s', filemtime($file_path));

									$html .= '<tr>';
									$html .= '<td>' . ($i + 1) . '</td>';
									$html .= '<td style="text-align: left;">' . $filename . '</td>';
									$html .= '<td>' . $modification_time . '</td>';
									$html .= '<td>';
									$html .= '<a class="btn" title="Download" href="' . $file_path . '" download="' . $filename . '"><img src="./include/action/download.png"></a>';
									$html .= '<a class="btn" title="Delete" onclick="deleteFile2(\'' . $filename . '\');"><img src="./include/action/delete.png"></a>';
									$html .= '</td>';
									$html .= '</tr>';
								}
							}

							echo $html;
						?>
					</table>
				</div>
			</div>
		</div>
    </div>
</div>

<script>
    $(document).ready(function () {
		// Fetch data using AJAX
		$('#tbl-backup').DataTable();
		$('#tbl-compare').DataTable();
		$('#tbl-backupfiles').DataTable();
	});

	function backup() {
		$.ajax({
			url: 'module/setting/backup_restore/backup_action_ajax.php',
			dataType: 'text',
			success: function(response) {
				// console.log(response);
				if (response.trim() == 'true') {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Database backup completed.',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				} else {
					Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error: Database backup failed. Check the mysqldump command and credentials.',
                        showConfirmButton: false,
                        timer: 1500
                    });
				}
			},
			error: function(xhr, status, error) {
				console.error("Error sending POST request:", error);
			}
		});
	}

	function deleteFile(filename) {
		$.ajax({
			url: 'module/setting/backup_restore/delete_file_ajax.php',
			method: 'post',
			data: {
				filename: filename
			},
			dataType: 'text',
			success: function(response) {
				// console.log(response);
				if (response.trim() == 'true') {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'Backup file deleted.',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				} else {
					Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'An error occured when deleting the file.',
                        showConfirmButton: false,
                        timer: 1500
                    });
				}
			},
			error: function(xhr, status, error) {
				console.error("Error sending POST request:", error);
			}
		});
	}

	function deleteFile2(filename) {
    console.log('Deleting file:', filename); // Log filename to console
		$.ajax({
			url: 'module/setting/backup_restore/delete_file2_ajax.php',
			method: 'post',
			data: {
				filename: filename
			},
			dataType: 'text',
			success: function(response) {
				if (response.trim() == 'true') {
					Swal.fire({
						icon: 'success',
						title: 'Success',
						text: 'File deleted.',
						showConfirmButton: false,
						timer: 1000
					}).then(function() {
						location.reload();
					});
				} else {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'An error occurred when deleting the file' + response,
						showConfirmButton: false,
						timer: 1500000
					});
				}
			},
			error: function(xhr, status, error) {
				console.error("Error sending POST request:", error);
			}
		});
	}

	function uploadFile() {
		// Trigger the click event of the hidden file input
		$('#fileInput').click();
	}

	// Function to handle file selection
	function handleFileSelect() {
		var fileInput = document.getElementById('fileInput');
		
		if (fileInput.files.length > 0) {
			// File selected, proceed with the upload
			var formData = new FormData();
			formData.append('file', fileInput.files[0]);

			$.ajax({
				url: 'module/setting/backup_restore/backup.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response) {
					console.log(response);  // Log the response
					if (response.trim() == 'success') {
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: 'File uploaded successfully.',
							showConfirmButton: false,
							timer: 1000
						}).then(function() {
							// Reload the page after successful upload
							location.reload();
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: 'Oops...',
							text: 'Error uploading the file.',
							showConfirmButton: false,
							timer: 1500000
						});
					}
				},
				error: function(xhr, status, error) {
					console.error("Error sending POST request:", error);
				}
			});
		}
	}

</script>