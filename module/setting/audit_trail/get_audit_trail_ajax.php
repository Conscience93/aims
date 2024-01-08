<?php
	include_once '../../../include/db_connection.php';

	// Receive DataTables request parameters
	$draw = $_GET['draw'];
	$start = $_GET['start'];
	$length = $_GET['length'];
	$search_value = $_GET['search']['value'];
	$sort_column_index = $_GET['order'][0]['column'];
	$sort_direction = $_GET['order'][0]['dir'];

	// Define your database table and primary key
	$table = 'aims_audit_trail'; // Replace with your actual table name
	$primaryKey = 'id'; // Replace with your actual primary key column name

	// Define your database columns for sorting
	$columns = array(
		'datetime', // Column 0
		'name',     // Column 1
		'user_group',
		'module_display_name',
		'submodule_display_name',
		'action',
		'remark',
		'old_data',
		'new_data'
	);

	// Build the SQL query for server-side processing
	$sql = "SELECT * FROM $table WHERE 1=1";

	$from = isset($_GET['from']) ? $_GET['from'] : '';
	$to = isset($_GET['to']) ? $_GET['to'] : '';

	if ($from != '' && $to == '') {
		$sql .= " AND datetime >= '$from'";
	} else if ($from == '' && $to != '') {
		$sql .= " AND datetime <= '$to'";
	} else if ($from != '' && $to != '') {
		$sql .= " AND datetime >= '$from' AND datetime <= '$to'";
	}

	// Apply global search filter (if provided)
	if (!empty($search_value)) {
		$sql .= " AND (";
		for ($i = 0; $i < count($columns); $i++) {
			$column = $columns[$i];
			if ($i === 0) {
				$sql .= "$column LIKE '%$search_value%'";
			} else {
				$sql .= " OR $column LIKE '%$search_value%'";
			}
		}
		$sql .= ")";
	}

	// Get the total number of records (without filtering)
	$total_records = mysqli_query($con_audit, $sql);
	$total_records = mysqli_num_rows($total_records);

	// Apply default sorting to the 'datetime' column in descending order
	$sql .= " ORDER BY datetime DESC";

	// Apply pagination
	$sql .= " LIMIT $start, $length";

	// Execute the SQL query
	$query = mysqli_query($con_audit, $sql);

	// Prepare the response
	$response = array(
		"draw" => intval($draw),
		"recordsTotal" => intval($total_records),
		"recordsFiltered" => intval($total_records),
		"data" => array()
	);

	// Fetch and format the data
	while ($row = mysqli_fetch_assoc($query)) {
		$response['data'][] = array(
			'datetime' => $row['datetime'],
			'name' => $row['name'],
			'user_group' => $row['user_group'],
			'module_display_name' => $row['module_display_name'],
			'submodule_display_name' => $row['submodule_display_name'],
			'action' => $row['action'],
			'remark' => $row['remark'],
			'old_data' => $row['old_data'],
			'new_data' => $row['new_data']
		);
	}

	// Send the JSON response
	header('Content-Type: application/json');
	echo json_encode($response);
?>