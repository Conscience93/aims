<?php 
include_once '../../include/db_connection.php';

$sql = "SELECT * FROM aims_asset where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM aims_people_supplier where display_name ='".$row['supplier']."'";
$result2 = mysqli_query($con, $sql2);
$supplier = mysqli_fetch_assoc($result2);
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
                    <td class="table-header"><strong>Category: </strong><?php echo $row['category'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>P.O Number: </strong><?php echo $row['po_number'];?></td>
                    <td class="table-header"><strong>D.O Number: </strong><?php echo $row['do_number'];?></td>
                    <td class="table-header"><strong>Date Purchase: </strong><?php echo $row['date_purchase'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>User: </strong><?php echo $row['user'];?></td>
                    <td class="table-header"><strong>Price: </strong><?php echo $row['price'];?></td>
                    <td class="table-header"><strong>Value: </strong><?php echo $row['value'];?></td>
                </tr>
                <tr>
                    <td colspan="3" class="table-header"><strong>Particular: </strong><?php echo $row['particular'];?></td>
                </tr>
                <tr>
                    <th colspan="3" class="table-header"><strong>Warranty</strong></th>
                </tr>
                <tr>
                    <td class="table-header"><strong>Start: </strong><?php echo $row['start_warranty'];?></td>
                    <td colspan="2" class="table-header"><strong>Expired: </strong><?php echo $row['end_warranty'];?></td>
                </tr>
                <tr>
                    <th colspan="3" class="table-header"><strong>Building/Branch</strong></th>
                </tr>
                <tr>
                    <td class="table-header"><strong>Branch: </strong><?php echo $row['branch'];?></td>
                    <td class="table-header"><strong>Department: </strong><?php echo $row['department'];?></td>
                    <td class="table-header"><strong>Location: </strong><?php echo $row['location'];?></td>
                </tr>
                <!-- Supplier Specification Section -->
                <tr>
                    <th colspan="3" class="table-header">Supplier Details</th>
                </tr>
                <tr>
                    <td class="table-header"><strong>Name: </strong><?php echo $row['supplier'];?></td>
                    <td class="table-header"><strong>Contact Person: </strong><?php if($supplier) {echo $supplier['pic']; }?></td>
                    <td class="table-header"><strong>Contact No: </strong><?php if($supplier) { echo $supplier['contact_no']; }?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Email: </strong><?php if($supplier) {echo $supplier['email']; }?></td>
                    <td class="table-header"><strong>Fax Number: </strong><?php if($supplier) {echo $supplier['fax']; }?></td>
                    <td class="table-header"><strong>Address: </strong><?php if($supplier) {echo $supplier['address']; }?></td>
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