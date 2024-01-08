<?php 
include_once '../../include/db_connection.php';

$sql = "SELECT * FROM aims_maintenance where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Vendor
$sql2 = "SELECT * FROM aims_people_vendors where display_name ='".$row['vendors']."'";
$result2 = mysqli_query($con, $sql2);
$vendors = mysqli_fetch_assoc($result2);
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
            <h4>SOFTWORLD SOFTWARE SDH BHD</h4>
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
            <!-- Retrieve and display customer Maintenance here -->
            <table class="customer-table">
                <tr>
                    <th colspan="3" class="table-header">Computer <?php echo $row['asset_tag'];?> Maintenance</th>
                </tr>
                <tr>
                    <td colspan="3" class="table-header"><strong>Asset: </strong><?php echo $row['name'];?></td>
                    <!-- <td colspan="2" rowspan="2" class="table-header">
                        <?php
                        if (!empty($row['picture'])) {
                            $fileName = basename($row['picture']);
                            echo '<img src="' . $row['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">'; // This line displays the picture
                        } else {
                            echo 'No picture available.';
                        }
                        ?>
                    </td> -->
                </tr>
                <tr>
                    <td colspan="3" class="table-header"><strong>Category: </strong><?php echo $row['category'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Expenses: </strong><?php echo $row['expenses'];?></td>
                    <!-- <td class="table-header"><strong>Date Created: </strong><?php echo $row['date_created'];?></td> -->
                    <td  colspan="2" class="table-header"><strong>Date of Maintenance: </strong><?php echo $row['maintenance_date'];?></td>
                </tr>

                <tr>
                    <th colspan="3" class="table-header"><strong>Vendor</strong></th>
                </tr>
                <tr>
                    <td class="table-header"><strong>Name: </strong><?php if($vendors) {echo $vendors['display_name']; }?></td>
                    <td class="table-header"><strong>Contact Person: </strong><?php if($vendors) {echo $vendors['pic']; }?></td>
                    <td class="table-header"><strong>Contact Number: </strong><?php if($vendors) { echo $vendors['contact_no']; }?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Email: </strong><?php if($vendors) {echo $vendors['email']; }?></td>
                    <td  colspan="2" class="table-header"><strong>Fax Number: </strong><?php if($vendors) {echo $vendors['fax']; }?></td>
                </tr>

                <tr>
                    <th colspan="3" class="table-header"><strong>Reason</strong></th>
                </tr>
                <tr>
                    <td class="table-header"><strong>Title: </strong><?php echo $row['title'];?></td>
                    <td colspan="2" class="table-header"><strong>Remark: </strong><?php echo $row['remark'];?></td>
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
