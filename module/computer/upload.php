<?php
include_once '../../include/db_connection.php';
session_start();

require '../../include/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;

// Function to escape user input
function escapeInput($con, $input) {
    if (is_array($input)) {
        $escapedInput = [];
        foreach ($input as $value) {
            $escapedInput[] = mysqli_real_escape_string($con, $value);
        }
        return $escapedInput;
    } else {
        return mysqli_real_escape_string($con, $input);
    }
}

// Load your Excel file using a library like PhpSpreadsheet
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['import'])) {
    $inputFileType = 'Xlsx';
    $uploadDirectory = '../../include/upload/excel/';
    $fileName = str_replace(".xlsx", "", basename($_FILES['import']['name']));
    $targetFile = $uploadDirectory . $fileName . uniqid() . "." . $inputFileType;

    if (move_uploaded_file($_FILES['import']['tmp_name'], $targetFile)) {
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $ctr = 1;
        $spreadsheet = $reader->load($targetFile);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();
        $success=true;
        // Assuming your data array structure is consistent
        foreach ($data as $row) {
            if ($ctr == 1) {
                $ctr++;
                continue;
            }
            $category =$row[1];
            // Fetch the updated running number
            $sqlRunningNo = mysqli_query($con, "SELECT * FROM aims_computer_category_run_no WHERE category LIKE '$category'");
            
            $resultRunningNo = mysqli_fetch_assoc($sqlRunningNo);
            $asset_running_no = $resultRunningNo['next_no'];
            // Your existing logic to generate asset_tag
            $asset_tag = $resultRunningNo['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);

            $sqlInsert = "INSERT INTO aims_computer 
                (name, category, branch, department, location, price, remark, supplier, computer_brand, phone_brand, ram, processor, graphic_card, casing, psu, motherboard, ip_address, mac_address, vpn_address, port, asset_tag ) VALUES (
                    '" . mysqli_real_escape_string($con, $row[0]) . "',
                    '" . mysqli_real_escape_string($con, $row[1]) . "',
                    '" . mysqli_real_escape_string($con, $row[2]) . "',
                    '" . mysqli_real_escape_string($con, $row[3]) . "',
                    '" . mysqli_real_escape_string($con, $row[4]) . "',
                    '" . mysqli_real_escape_string($con, $row[5]) . "',
                    '" . mysqli_real_escape_string($con, $row[6]) . "',
                    '" . mysqli_real_escape_string($con, $row[7]) . "',
                    '" . mysqli_real_escape_string($con, $row[8]) . "',
                    '" . mysqli_real_escape_string($con, $row[9]) . "',
                    '" . mysqli_real_escape_string($con, $row[10]) . "',
                    '" . mysqli_real_escape_string($con, $row[11]) . "',
                    '" . mysqli_real_escape_string($con, $row[12]) . "',
                    '" . mysqli_real_escape_string($con, $row[13]) . "',
                    '" . mysqli_real_escape_string($con, $row[14]) . "',
                    '" . mysqli_real_escape_string($con, $row[15]) . "',
                    '" . mysqli_real_escape_string($con, $row[16]) . "',
                    '" . mysqli_real_escape_string($con, $row[17]) . "',
                    '" . mysqli_real_escape_string($con, $row[18]) . "',
                    '" . mysqli_real_escape_string($con, $row[19]) . "',
                    '" . mysqli_real_escape_string($con, $asset_tag) . "'
                )";

            // Execute the SQL query
            $result = mysqli_query($con, $sqlInsert);

            // Your existing logic to update running number
            $next_no = $asset_running_no + 1;
            $update_running_no = mysqli_query($con, "UPDATE aims_computer_category_run_no SET next_no = '$next_no' WHERE category = '$category'");
            $ctr++;
            // Echo success response
            if(!$result){
                $success=false;
                
            }
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error uploading file.']);
    }
    if($success){
        echo json_encode(['status' => 'success']);

    }else{
        echo json_encode(['status' => 'error', 'message' => 'Something Went Wrong']);
    }
} else {
    echo 'Invalid request.';
}

?>