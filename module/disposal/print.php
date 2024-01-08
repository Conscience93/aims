<?php
include_once "../../include/db_connection.php";
require_once "../../include/vendor/autoload.php";

// Start output buffering
ob_start();

// Include the PHP code you want to add to the MPDF document
include('print_pdf.php');

// Get the captured output
$html = ob_get_contents();

// End output buffering and clean up the buffer
ob_end_clean();

$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 10,
    'margin_bottom' => 10,
    'margin_header' => 10,
    'margin_footer' => 10,
]);

$css = file_get_contents('print_pdf.css');

$mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
// Add the HTML to the document
$mpdf->WriteHTML($html);

$mpdf->Output();

?>