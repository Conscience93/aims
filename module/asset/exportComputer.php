<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../../include/db_connection.php';
require '../../include/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Create a new Excel spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add column headers for aims_asset table
$columns = ['Id', 'Asset Tag', 'Nfc_code', 'Status', 'Name', 'Category', 'Branch', 'Department', 
            'Location', 'Price', 'Value', 'Date Purchase', 'Remark', 'Supplier', 'Computer Brand', 
            'Phone Brand', 'Ram', 'Processor', 'Graphic Card', 'Casing', 'PSU', 'Motherboard', 'Start Warranty', 
            'End Warranty', 'Username', 'Invoice', 'Document', 'Warranty', 'Code', 'QR Code', 'Server Name', 'Virtual Machine'];
$colIndex = 1;
foreach ($columns as $column) {
    $sheet->setCellValueByColumnAndRow($colIndex++, 1, $column);
}

// Fetch data from the aims_asset table
$sqlAsset = "SELECT * FROM aims_computer";
$resultAsset = mysqli_query($con, $sqlAsset);

// Add data from the aims_asset table
$rowIndex = 2;
while ($row = mysqli_fetch_assoc($resultAsset)) {
    $colIndex = 1;
    foreach ($row as $cell) {
        $sheet->setCellValueByColumnAndRow($colIndex++, $rowIndex, $cell);
    }
    $rowIndex++;
}

// Save the Excel file to a specific directory on the server
$uploadDirectory = '../../module/asset/export_data/computer/'; // Change this to the desired directory
$filename = 'exportedComputer_data.xlsx'; // Change the filename as needed
$filePath = $uploadDirectory . $filename;

// Check if the directory exists, and create it if not
if (!is_dir($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

try {
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($filePath);

    // Provide the file path for the user to access
    // echo json_encode(array("status" => "success", "file_path" => $filePath, "file_name" => $filename));
} catch (\PhpOffice\PhpSpreadsheet\Writer\Exception $e) {
    // Output any exception messages
    // echo json_encode(array("status" => "error", "message" => $e->getMessage()));
}

exit();
?>