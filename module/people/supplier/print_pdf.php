<?php 
include_once '../../../include/db_connection.php';

$sql = "SELECT * FROM aims_people_supplier where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Supplier Info</title>
    
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
            <!-- Retrieve and display customer details here -->
            <table class="customer-table">
                <tr>
                    <th colspan="3" class="table-header">Supplier <?php echo $row['id'];?> Details</th>
                </tr>
                <tr>
                    <td colspan="1" class="table-header"><strong>Supplier: </strong><?php echo $row['display_name'];?></td>
                    <td colspan="2" class="table-header"><strong>Manager: </strong><?php echo $row['pic'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Email: </strong><?php echo $row['email'];?></td>
                    <td class="table-header"><strong>Phone No: </strong><?php echo $row['contact_no'];?></td>
                    <td class="table-header"><strong>Fax: </strong><?php echo $row['fax'];?></td>
                </tr>
                <tr>
                    <td colspan="3" class="table-header"><strong>Location: </strong><?php echo $row['location'];?></td>
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