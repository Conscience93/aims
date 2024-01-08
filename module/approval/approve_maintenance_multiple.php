<?php
include_once '../../include/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['asset_asset_tag']) && is_array($_POST['asset_asset_tag'])) {
        foreach ($_POST['asset_asset_tag'] as $asset_tag) {
            $escaped_asset_tag = mysqli_real_escape_string($con, $asset_tag);

            // Determine the table based on the asset tag prefix
            $table = 'aims_maintenance';

            // Fetch the vendor's display name based on the asset tag
            $sqlVendor = "SELECT vendors FROM $table WHERE asset_tag = '$escaped_asset_tag'";
            $resultVendor = mysqli_query($con, $sqlVendor);
            $rowVendor = mysqli_fetch_assoc($resultVendor);
            $vendorDisplayName = $rowVendor['vendors'];

            // Fetch the contact number based on the vendor's display name
            $sqlContact = "SELECT contact_no FROM aims_people_supplier WHERE display_name = '$vendorDisplayName'";
            $resultContact = mysqli_query($con, $sqlContact);
            $rowContact = mysqli_fetch_assoc($resultContact);
            $vendorContact = $rowContact['contact_no'];

            // Update the 'approval' attribute to 'APPROVE'
            $sqlUpdate = "UPDATE $table SET approval = 'APPROVE' WHERE asset_tag = '$escaped_asset_tag'";
            $resultUpdate = mysqli_query($con, $sqlUpdate);

            if ($resultUpdate) {
                echo "Asset with asset tag $escaped_asset_tag approved successfully in $table.<br>";

                // Sending WhatsApp message using Waboxapp
                $toNumber = $vendorContact; // Use the retrieved contact number
                $message = "Asset with asset tag $escaped_asset_tag has been approved for maintenance.";
                
                sendWhatsAppMessage($toNumber, $message);
            } else {
                echo "Error updating asset with asset tag $escaped_asset_tag in $table: " . mysqli_error($con) . "<br>";
            }
        }
    } else {
        echo "No assets selected for approval.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}

// Close the database connection
mysqli_close($con);

function sendWhatsAppMessage($toNumber, $message) {
    $apiKey = "2d4dae3b57e7fed7954dfc4739551a55625523e740402";

    $url = 'https://www.waboxapp.com/api/send/chat';
    $data = array(
        'token' => $apiKey,
        'uid' => '60176036630',
        "to" => $toNumber, 
        'custom_uid' => 'whatsapp:' . $toNumber . uniqid(), // Optional // Replace '' with your actual phone number
        'text' => $message,
    );


    // Use cURL to send the POST request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    $response = curl_exec($ch);
    curl_close($ch);

    // Check the response from Waboxapp
    $responseData = json_decode($response, true);
    if (isset($responseData['success']) && $responseData['success']) {
        echo "WhatsApp message sent to $toNumber.<br>";
    } else {
        echo "Error sending WhatsApp message: " . $responseData['error'] . "<br>";
    }
}
?>