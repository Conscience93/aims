<?php 
include_once '../../include/db_connection.php';

$sql = "SELECT * FROM aims_computer where id ='".$_GET['id']."'";
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
            <h4>SOFTWORLD SOFTWARE SDN BHD</h4>
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
                    <th colspan="3" class="table-header">Computer <?php echo $row['asset_tag'];?> Details</th>
                </tr>
                <tr>
                    <td colspan="1" class="table-header"><strong>Computer: </strong><?php echo $row['name'];?></td>
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
                    <td class="table-header"><strong>Branch: </strong><?php echo $row['branch'];?></td>
                    <td class="table-header"><strong>Department: </strong><?php echo $row['department'];?></td>
                    <td class="table-header"><strong>Location: </strong><?php echo $row['location'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Price: </strong><?php echo $row['price'];?></td>
                    <td colspan="2" class="table-header"><strong>Value: </strong><?php echo $row['value'];?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Date Purchase: </strong><?php echo $row['date_purchase'];?></td>
                    <td colspan="2" class="table-header"><strong>Remark: </strong><?php echo $row['remark'];?></td>
                </tr>
                <tr>
                    <th colspan="3" class="table-header"><strong>Warranty</strong></th>
                </tr>
                <tr>
                    <td class="table-header"><strong>Start: </strong><?php echo $row['start_warranty'];?></td>
                    <td colspan="2" class="table-header"><strong>Expired: </strong><?php echo $row['end_warranty'];?></td>
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
                <!-- Hardware Specification Section -->
                <tr>
                    <th colspan="3" class="table-header">Hardware Information</th>
                </tr>
                <tr>
                <?php
                    $category = $row['category'];

                    if ($category === 'Desktop' || $category === 'Laptop' || $category === 'Server') {
                        ?>
                        <div class="row">
                            <td class="table-header"><strong>Brand: </strong><?php echo $row['computer_brand'];?></td>
                        </div>
                        <?php
                    } elseif ($category === 'Smartphone' || $category === 'Tablet') {
                        ?>
                        <div class="row">
                            <td class="table-header"><strong>Brand: </strong><?php echo $row['phone_brand'];?></td>
                        </div>
                        <?php
                    } elseif ($category === 'Virtual machine') {
                        ?>
                        <div class="row">
                            <td class="table-header"><strong>Brand: </strong><?php echo $row['virtual_machine'];?></td>
                        </div>
                        <?php
                    }
                ?>
                    <td class="table-header"><strong>RAM: </strong><?php echo $row['ram']; ?></td>
                    <td class="table-header"><strong>Casing: </strong><?php echo $row['casing']; ?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Processor: </strong><?php echo $row['processor']; ?></td>
                    <td colspan="2" class="table-header"><strong>Graphic Card: </strong><?php echo $row['graphic_card']; ?></td>
                </tr>
                <tr>
                    <td class="table-header"><strong>Power Supply: </strong><?php echo $row['psu']; ?></td>
                    <td colspan="2" class="table-header"><strong>Motherboard: </strong><?php echo $row['motherboard']; ?></td>
                </tr>   
            </table>  
            <!-- Hard Drive Detail Section -->
            <table class="hard-drive-table">
                <tr>
                    <th colspan="12" class="table-header">Hard Drive</th>
                </tr>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Brand</th>
                    <th>Storage</th>
                    <th>Purpose</th>
                    <th>End Warranty</th>
                </tr>
                <?php
                $sqlUser = "SELECT * FROM aims_computer_hard_drive where asset_tag ='" . $row['asset_tag'] . "'";
                $resultUser = mysqli_query($con, $sqlUser);
                while ($rowUser = mysqli_fetch_assoc($resultUser)) {
                    echo '<tr>';
                    echo '<td>' . ($rowUser['hard_disk_name'] ? $rowUser['hard_disk_name'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['hard_drive'] ? $rowUser['hard_drive'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['brand'] ? $rowUser['brand'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['storage'] ? $rowUser['storage'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['purpose'] ? $rowUser['purpose'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['end_warranty_disk'] ? $rowUser['end_warranty_disk'] : '-') . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <!-- Network Detail Section -->
            <table class="network-table">
                <tr>
                    <th colspan="4" class="table-header">Network</th>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <th>Mac Address</th>
                    <th>Port</th>
                </tr>
                <?php
                $sqlUser = "SELECT * FROM aims_computer_network where asset_tag ='" . $row['asset_tag'] . "'";
                $resultUser = mysqli_query($con, $sqlUser);
                while ($rowUser = mysqli_fetch_assoc($resultUser)) {
                    echo '<tr>';
                    echo '<td>' . ($rowUser['ip_address'] ? $rowUser['ip_address'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['mac_address'] ? $rowUser['mac_address'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['port'] ? $rowUser['port'] : '-') . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <!-- User Detail Section -->
            <table class="user-table">
                <tr>
                    <th colspan="4" class="table-header">User Account</th>
                </tr>
                <tr>
                    <th>Username</th>
                    <th>Password</th>
                    <th>User</th>
                    <th>Role</th>
                </tr>
                <?php
                $sqlUser = "SELECT * FROM aims_computer_user where asset_tag ='" . $row['asset_tag'] . "'";
                $resultUser = mysqli_query($con, $sqlUser);
                while ($rowUser = mysqli_fetch_assoc($resultUser)) {
                    echo '<tr>';
                    echo '<td>' . ($rowUser['username'] ? $rowUser['username'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['password'] ? $rowUser['password'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['user'] ? $rowUser['user'] : '-') . '</td>';
                    echo '<td>' . ($rowUser['role'] ? $rowUser['role'] : '-') . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
            <!-- Software Specification Section -->
            <table class="software-table">
                <tr>
                    <th colspan="5" class="table-header">Software Specification</th>
                </tr>
                <tr>
                    <th>Category</th>
                    <th>Software Name</th>
                    <th>Brand</th>
                    <th>License Key</th>
                    <th>Expiry Date</th>
                </tr>
                <?php
                $sqlSoftware = "SELECT * FROM aims_software where asset_tag ='" . $row['asset_tag'] . "'";
                $resultSoftware = mysqli_query($con, $sqlSoftware);
                while ($rowSoftware = mysqli_fetch_assoc($resultSoftware)) {
                    echo '<tr>';
                    echo '<td>' . ($rowSoftware['software_category'] ? $rowSoftware['software_category'] : '-') . '</td>';
                    echo '<td>' . ($rowSoftware['software_name'] ? $rowSoftware['software_name'] : '-') . '</td>';
                    echo '<td>' . ($rowSoftware['brand'] ? $rowSoftware['brand'] : '-') . '</td>';
                    echo '<td>' . ($rowSoftware['license_key'] ? $rowSoftware['license_key'] : '-') . '</td>';
                    echo '<td>' . ($rowSoftware['expiry_date'] ? $rowSoftware['expiry_date'] : '-') . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>
        </main>

        <!-- Footer Section -->
        <footer>
            <hr>
            <h>This is a computer-generated document, no signature is required.</h>
        </footer>
    </div>
</body>
</html>