<?php 
include_once '../../include/db_connection.php';

$sql = "SELECT * FROM aims_inventory where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

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
                    <th colspan="3" class="table-header">Inventory <?php echo $row['item_tag'];?> Details</th>
                </tr>
                <tr>
                    <td colspan="1" class="table-header"><strong>Stock#: </strong><?php echo $row['stock'];?></td>
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
                    <td class="table-header"><strong>Name: </strong><?php echo $row['name'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Category: </strong><?php echo $row['category'];?></td>
                    <td class="table-header"><strong>P.O Number: </strong><?php echo $row['po_number'];?></td>
                    <td class="table-header"><strong>D.O Number: </strong><?php echo $row['do_number'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Type: </strong><?php echo $row['type'];?></td>
                    <td class="table-header"><strong>Purchase Price: </strong><?php echo $row['purchase_price'];?></td>
                    <td class="table-header"><strong>Sales Price: </strong><?php echo $row['sales_price'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>UOM: </strong><?php echo $row['uom'];?></td>
                    <td class="table-header"><strong>Created Date </strong><?php echo $row['created_date'];?></td>
                    <td class="table-header"><strong>Default Location: </strong><?php echo $row['default_location'];?></td>
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