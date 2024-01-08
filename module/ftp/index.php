<?php
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
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
</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-files" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">
                FTP
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
       <!-- Tab 2: Files -->
		<div class="tab-pane fade show active" id="files" role="tabpanel" aria-labelledby="tab-files">
			<div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
							<h2>File Transfer Protocol</h2>
						</div>
						<div class="col-6">
							<div class="float-right">
								<button type="button" class="btn btn-danger" onclick="history.back();">Discard</button>
								<button type="button" class="btn btn-success" onclick="uploadFile()">Upload</button>
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
							$directory = 'module/ftp/backup_files/';
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
                                    $html .= '<a class="btn" title="View" href="./viewfile?id=' . $row['id'] . '"><img src="./include/action/review.png"></a>';
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
		$('#tbl-backupfiles').DataTable();
	});

	function deleteFile2(filename) {
    console.log('Deleting file:', filename); // Log filename to console
		$.ajax({
			url: 'module/ftp/delete_file2_ajax.php',
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
				url: 'module/ftp/backup.php',
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