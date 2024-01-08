<?php 
include_once '../../include/db_connection.php';

$sql = "SELECT * FROM aims_property_residential where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sql3 = "SELECT * FROM aims_izzat WHERE asset_tag = '" . $row['asset_tag'] . "'";
$result3 = mysqli_query($con, $sql3);
$asset_tag = mysqli_fetch_assoc($result3);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Asset Info</title>
    
    <!-- Include your custom CSS for printing -->
    <link rel="stylesheet" type="text/css" href="print-styles.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0; /* Remove default margin */
        }

        .wrapper {
            flex: 1;
            position: relative;
            display: flex;
            flex-direction: column;
        }

        /* Center the header content */
        .header-content {
            margin: 0 auto;
            text-align: center;
            max-width: 600px; /* Adjust the maximum width as needed */
        }

        /* Add CSS styles for the footer */
        footer {
            text-align: center;
            padding: 10px;
            width: 100%;
            position: absolute;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header Section -->
        <div class="header-content">
            <h4>SOFTWORLD SOFTWARE SDN BHD</h4>
            <div class="info">
                <h>1st Floor, Lot 182, Jalan Song Thian Cheok</h><br>
                <h>93100 Kuching, Sarawak, Malaysia.</h><br>
                <h>Tel: +6082-507070 Fax: +6082-507007</h><br>
                <h>URL: -  Email: admin@softworld.com.my</h><br><br>
                <hr>
            </div>
        </div>

        <!-- Body Section -->
        <main>
            <!-- Retrieve and display customer details here -->
            <table class="customer-table">
                <tr>
                    <th colspan="3" class="table-header">Asset <?php echo $row['asset_tag'];?> Details</th>
                </tr>
                <tr>
                    <td colspan="1" class="table-header"><strong>Asset: </strong><?php echo $row['name'];?></td>
                    <td colspan="2" rowspan="2" class="table-header">
                        <!-- Display the picture here -->
                        <?php
                        if (!empty($row['picture'])) {
                            $fileName = basename($row['picture']);
                            echo '<img src="' . $row['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">'; // This line displays the picture
                        } else {
                            echo 'No picture available.';
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Status: </strong><?php echo $row['status'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>NFC Code: </strong>
                        <?php echo isset($izzat_data['nfc_code']) ? $izzat_data['nfc_code'] : 'N/A'; ?>
                    </td>
                    <td class="table-header"><strong>QR Code: </strong>
                        <?php echo isset($izzat_data['qr_code']) ? $izzat_data['qr_code'] : 'N/A'; ?>
                    </td>
                    <td class="table-header"><strong>Price: </strong>RM<?php echo $row['price'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Furnish: </strong><?php echo $row['furnish'];?></td>
                    <td class="table-header"><strong>No. of Room: </strong><?php echo $row['room'];?></td>
                    <td class="table-header"><strong>No. of Bathroom: </strong><?php echo $row['bathroom'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Built Up Size: </strong><?php echo $row['built_up_size'];?>sq. ft</td>
                    <td class="table-header"><strong>Built Up Price: </strong>RM<?php echo $row['built_up_price'];?>per sq. ft.</td>
                    <td class="table-header"><strong>Parking Space: </strong><?php echo $row['parking'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Land Area Size: </strong><?php echo $row['land_area_size'];?>sq. ft</td>
                    <td class="table-header"><strong>Land Area Price: </strong>RM<?php echo $row['land_area_price'];?>per sq. ft.</td>
                    <td class="table-header"><strong>Remarks: </strong><?php echo $row['remarks'];?></td>
                </tr>
                <tr>
                    <td colspan="3" class="table-header"><strong>Address: </strong><?php echo $row['address'];?></td>
                </tr>
            </table>
            <!-- Include additional customer details as needed -->
        </main>

        <!-- Footer Section -->
        <footer>
            <hr>
            <h>This is computer generated document, no signature is required.</h>
        </footer>
    </div>
</body>
</html>