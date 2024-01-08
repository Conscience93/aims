<?php 
include_once '../../include/db_connection.php';

$sql = "SELECT * FROM aims_transfer_computer where id ='".$_GET['id']."'";
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
    <title>Print Computer Info</title>
    
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

        @media print {
            .pagebreak { 
                page-break-before: always; 
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Header Section -->
        <header class="header-content">
            <h4>SOFTWORLD SOFTWARE SDH BHD</h4>
            <div class="info">
                <h>1st Floor, Lot 182, Jalan Song Thian Cheok</h><br>
                <h>93100 Kuching, Sarawak, Malaysia.</h><br>
                <h>Tel: +6082-507070 Fax: +6082-507007</h><br>
                <h>Email: admin@softworld.com.my</h><br>
                <h>Website: www.softworld.com.my</h>
            </div>
            <hr>
        </header>

         <!-- Body Section -->
         <main>
            <!-- Retrieve and display customer details here -->
            <table class="customer-table">
                <tr>
                    <th colspan="3" class="table-header">Asset <?php echo $row['asset_tag'];?> Transfer Details</th>
                </tr>
                <tr>
                    <td colspan="1" class="table-header"><strong>Name: </strong><?php echo $row['name'];?></td>
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
                <!-- <tr>
                    <td class="table-header"><strong>Status: </strong><?php echo $row['status'];?></td>
                </tr> -->
            </table>
            <!-- Transfer Detail Section -->
            <table class="transfer-table">
                <tr>
                    <th colspan="4" class="table-header">Transfer Details</th>
                </tr>
                <tr>
                    <th>Date Transfer</th>
                    <th>Building/Branch</th>
                    <th>Department</th>
                    <th>Location</th>
                </tr>
                <?php
                $sqlTransfer = "SELECT * FROM aims_transfer_computer where asset_tag ='" . $row['asset_tag'] . "'";
                $resultTransfer = mysqli_query($con, $sqlTransfer);
                while ($rowTransfer = mysqli_fetch_assoc($resultTransfer)) {
                    echo '<tr>';
                    echo '<td>' . ($rowTransfer['date_transfer'] ? $rowTransfer['date_transfer'] : '-') . '</td>';
                    echo '<td>' . ($rowTransfer['transfer_branch'] ? $rowTransfer['transfer_branch'] : '-') . '</td>';
                    echo '<td>' . ($rowTransfer['transfer_department'] ? $rowTransfer['transfer_department'] : '-') . '</td>';
                    echo '<td>' . ($rowTransfer['transfer_location'] ? $rowTransfer['transfer_location'] : '-') . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <!-- Include additional customer details as needed -->
        </main>

        <!-- Footer Section -->
        <footer>
            <hr>
            <h>This is a computer-generated document, no signature is required.</h>
        </footer>
    </div>
</body>
</html>