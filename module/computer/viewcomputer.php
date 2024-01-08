<?php 
// $id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['view'] != 1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_computer where id = '" . $_GET['id'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM aims_people_supplier where display_name = '" . $row['supplier'] . "'";
$result2 = mysqli_query($con, $sql2);
$supplier = mysqli_fetch_assoc($result2);

$sqlTransfer = "SELECT * FROM aims_transfer_computer WHERE asset_tag = '" . $row['asset_tag'] . "'";
$resultTransfer = mysqli_query($con, $sqlTransfer);
$queryTransfer = mysqli_query($con, $sqlTransfer);

if (!$queryTransfer) {
die('Error: ' . mysqli_error($con));
}

// Fetch all data into an array
$transferData = [];
while ($rowTransfer = mysqli_fetch_assoc($queryTransfer)) {
$transferData[] = $rowTransfer;
}

$rowCount = 1; // Initialize the row counter
$dateTransferHeaderPrinted = false; // Flag to check if Date Transfer header has been printed
?>

<style>
    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .row .float-right button {
        margin-left: 5px; /* Adjust the margin as needed */
    }
    
    .action-button {
        cursor: pointer;
    }

    textarea {
    resize: none;
    }

    .main span {
        height: 2.3rem;
    }

    /* Define styles for odd rows in striped-tables */
    table.striped-table tr:nth-child(odd) {
            Background-color: #f2f2f2; /* Set the Background color for odd data rows */
        }

    /* Define styles for even rows in striped-tables */
    table.striped-table tr:nth-child(even) {
        Background-color: #ffffff; /* Set the Background color for even data rows */
    }

    /* Main Picture Container */
    #mainPictureContainer {
        text-align: center;
        margin-bottom: 20px;
    }

    #mainPicture {
        max-width: 100%;
        height: auto;
        border: 5px solid #ddd; /* Add a border for a cleaner look */
    }

    /* Thumbnail Container */
    #thumbnailContainer {
        margin-top: 10px;
        text-align: center;
    }

    .thumbnail {
        max-width: 100px;
        height: auto;
        cursor: pointer;
        margin-right: 5px;
        border: 1px solid #ddd; /* Add a border for a cleaner look */
    }

    .thumbnail:hover {
        border: 2px solid #555; /* Highlight border on hover */
    }
</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-information" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="true">
                Information 
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-specs" data-toggle="tab" href="#specs" role="tab" aria-controls="specs" aria-selected="true">
                Specification
            </a>
        </li>
        <?php if ($row['category'] === 'Server'): ?>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-virtual_machine" data-toggle="tab" href="#virtual_machine" role="tab" aria-controls="virtual_machine" aria-selected="false">
                Virtual Machine
            </a>
        </li>
        <?php endif; ?>
        <li class="nav-item" role="presentation">
            <a class="nav-link " id="tab-transfer" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="true">
                Transfer Details 
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-supplier" data-toggle="tab" href="#supplier" role="tab" aria-controls="supplier" aria-selected="false">
                Supplier Details
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-network" data-toggle="tab" href="#network" role="tab" aria-controls="network" aria-selected="false">
                Network
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-remote_access" data-toggle="tab" href="#remote_access" role="tab" aria-controls="remote_access" aria-selected="false">
                Remote Access
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-software" data-toggle="tab" href="#software" role="tab" aria-controls="software" aria-selected="false">
                Software
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-hard" data-toggle="tab" href="#hard" role="tab" aria-controls="hard" aria-selected="false">
                Hard Drive
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-user" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-selected="false">
                User
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-maintenance" data-toggle="tab" href="#maintenance" role="tab" aria-controls="maintenance" aria-selected="false">
                Maintenance
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-files" data-toggle="tab" href="#files" role="tab" aria-controls="files" aria-selected="false">
                Files
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">

     <!-- Tab : Information -->
     <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="tab-information">
        <div class="card shadow rounded">
            <div class="card-header" style="Background:white;" >
                <div class="row">
                    <div class="col-6">
                        <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./asset" class="btn btn-danger">Back</a>
                            <a class="btn btn-primary" href='./module/computer/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <div class="row">
                        <div class="col-7">
                            <h4>Basic Information</h4>
                            <div class="row">
                                <label class="col-2" for="name"><b>Name: </b></label>
                                <span class="col-3" id="name" name="name"><?php echo $row['name']; ?></span>
                                <label class="col-2" for="nfc_code"><b>NFC Code: </b></label>
                                <span class="col-3" id="nfc_code" name="nfc_code">
                                    <?php
                                    // Fetch nfc_code from aims_izzat
                                    $sqlNFC = "SELECT nfc_code FROM aims_izzat WHERE asset_tag = '" . $row['asset_tag'] . "'";
                                    $resultNFC = mysqli_query($con, $sqlNFC);
                                    
                                    if ($resultNFC && $nfc_code = mysqli_fetch_assoc($resultNFC)) {
                                        echo $nfc_code['nfc_code'];
                                    } else {
                                        echo "NFC Code not found.";
                                    }
                                    ?>
                                </span>
                            </div>
                            <div class="row">
                                <label class="col-2" for="qr_code"><b>QR Code: </b></label>
                                <span class="col-3" id="qr_code" name="qr_code">
                                    <?php
                                    // Fetch qr_code from aims_izzat
                                    $sqlQR = "SELECT qr_code FROM aims_izzat WHERE asset_tag = '" . $row['asset_tag'] . "'";
                                    $resultQR = mysqli_query($con, $sqlQR);
                                    
                                    if ($resultQR && $qr_code = mysqli_fetch_assoc($resultQR)) {
                                        echo $qr_code['qr_code'];
                                    } else {
                                        echo "QR Code not found.";
                                    }
                                    ?>
                                </span>
                                <label class="col-2" for="date_purchase"><b>Date Purchase: </b></label>
                                <span class="col-3" id="date_purchase" name="date_purchase"><?php echo $row['date_purchase']; ?></span>
                            </div>
                            <div class="row">
                                <label class="col-2" for="category"><b>Category: </b></label>
                                <span class="col-3" id="category" name="category"><?php echo $row['category']; ?></span>
                                <label class="col-2" for="price"><b>Price (RM): </b></label>
                                <span class="col-3" id="price" name="price"><?php echo $row['price']; ?></span>
                            </div>
                            <div class="row">
                                <?php if ($row['category'] === 'Virtual Machine') : ?>
                                <label class="col-2" for="server_name"><b>Server: </b></label>
                                <span class="col-3" id="server_name" name="server_name"><?php echo $row['server_name']; ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="row">
                                <label class="col-2" for="start_warranty"><b>Start Warranty: </b></label>
                                <span class="col-3" id="start_warranty" name="start_warranty"><?php echo $row['start_warranty']; ?></span>
                                <label class="col-2" for="end_warranty"><b>End Warranty: </b></label>
                                <span class="col-3" id="end_warranty" name="end_warranty"><?php echo $row['end_warranty']; ?></span>
                            </div>
                            <div class="row">
                                <label class="col-2" for="value"><b>Value (RM): </b></label>
                                <span class="col-3" id="value" name="value"><?php echo $row['value']; ?></span>
                                <label class="col-2" for="remark"><b>Remark: </b></label>
                                <span class="col-4" id="remark" name="remark"><?php echo $row['remark']; ?></span>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <h4>Current Location</h4>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3" for="branch"><b>Building/Branch: </b></label>
                                <span class="col-3" id="branch" name="branch"><?php echo $row['branch']; ?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="department"><b>Department: </b></label>
                                <span class="col-3" id="department" name="department"><?php echo $row['department']; ?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="location"><b>Location: </b></label>
                                <span class="col-3" id="location" name="location"><?php echo $row['location']; ?></span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h4>Image Gallery</h4>
                                <div id="mainPictureContainer">
                                    <?php
                                    // Fetch the first picture from aims_all_asset_picture
                                    $sqlFirstPicture = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag = '" . $row['asset_tag'] . "' LIMIT 1";
                                    $resultFirstPicture = mysqli_query($con, $sqlFirstPicture);
                                    $firstPicture = mysqli_fetch_assoc($resultFirstPicture);

                                    // Display the first picture or a placeholder
                                    if ($firstPicture) {
                                        echo '<img id="mainPicture" src="' . $firstPicture['picture'] . '" alt="Main Picture" style="max-width: 325px; height: 270px;">';
                                    } else {
                                        echo '<img id="mainPicture" src="placeholder.jpg" alt="Main Picture" style="max-width: 325px; height: 270px;">';
                                    }
                                    ?>
                                </div>
                                <!-- Thumbnail Images -->
                                <?php
                                // Fetch all pictures from aims_all_asset_picture
                                $sqlPictures = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag = '" . $row['asset_tag'] . "'";
                                $resultPictures = mysqli_query($con, $sqlPictures);

                                while ($picture = mysqli_fetch_assoc($resultPictures)) {
                                    echo '<img class="thumbnail" src="' . $picture['picture'] . '" alt="Thumbnail" style="max-width: 100px; height: auto; cursor: pointer;" onclick="changeMainPicture(\'' . $picture['picture'] . '\');">';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

        <!-- Tab 1: Specs -->
        <div class="tab-pane fade show" id="specs" role="tabpanel" aria-labelledby="tab-specs">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                            <h4>Hardware Details</h4></br>
                                <?php
                                    $category = $row['category'];

                                    if ($category === 'Desktop' || $category === 'Laptop' || $category === 'Server') {
                                        ?>
                                        <div class="row">
                                            <label class="col-3" for="computer_brand"><b>Brand: </b></label>
                                            <span class="col-9" id="computer_brand" name="computer_brand"><?php echo $row['computer_brand']; ?></span>
                                        </div>
                                        <?php
                                    } elseif ($category === 'Smartphone' || $category === 'Tablet') {
                                        ?>
                                        <div class="row">
                                            <label class="col-3" for="phone_brand"><b>Brand: </b></label>
                                            <span class="col-9" id="phone_brand" name="phone_brand"><?php echo $row['phone_brand']; ?></span>
                                        </div>
                                        <?php
                                    } elseif ($category === 'Virtual machine') {
                                        ?>
                                        <div class="row">
                                            <label class="col-3" for="virtual_machine"><b>Brand: </b></label>
                                            <span class="col-9" id="virtual_machine" name="virtual_machine"><?php echo $row['virtual_machine']; ?></span>
                                        </div>
                                        <?php
                                    }
                                ?>
                                <div class="row">
                                    <label class="col-3" for="ram"><b>RAM: </b></label>
                                    <span class="col-9" id="ram" name="ram"><?php echo $row['ram'];?></span>
                                </div>
                                <div class="row">
                                    <label class="col-3" for="processor"><b>Processor (CPU): </b></label>
                                    <span class="col-9" id="processor" name="processor"><?php echo $row['processor'];?></span>
                                </div>
                                <div class="row">
                                    <label class="col-3" for="graphic_card"><b>Graphic Card: </b></label>
                                    <span class="col-9" id="graphic_card" name="graphic_card"><?php echo $row['graphic_card'];?></span>
                                </div>
                                <div class="row">
                                    <label class="col-3" for="casing"><b>Casing: </b></label>
                                    <span class="col-9" id="casing" name="casing"><?php echo $row['casing'];?></span>
                                </div>
                                <div class="row">
                                    <label class="col-3" for="psu"><b>Power Supply: </b></label>
                                    <span class="col-9" id="psu" name="psu"><?php echo $row['psu'];?></span>
                                </div>
                                <div class="row">
                                    <label class="col-3" for="motherboard"><b>Motherboard: </b></label>
                                    <span class="col-9" id="motherboard" name="motherboard"><?php echo $row['motherboard'];?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>         
            </div>
        </div> 
        
        <!-- Tab: Virtual Machine -->
        <?php if ($row['category'] === 'Server'): ?>
            <div class="tab-pane fade" id="virtual_machine" role="tabpanel" aria-labelledby="tab-virtual_machine">
                <div class="card shadow rounded">
                    <div class="card-header" style="Background:white;">
                        <div class="row">
                            <div class="col-6">
                                <h4>Virtual Machine</h4>
                            </div>
                            <div class="col-6">
                                <div class="float-right">
                                    <a href="./asset" class="btn btn-danger">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="table_virtual_machine" class="striped-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Asset Tag</th>
                                    <th>Name</th>
                                    <th>RAM</th>
                                    <th>Processor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch virtual machine data for the specific server (adjust the query according to your database structure)
                                $sqlVirtualMachine = "SELECT * FROM aims_computer WHERE category = 'Virtual Machine' AND server_name = '" . $row['name'] . "'";
                                $queryVirtualMachine = mysqli_query($con, $sqlVirtualMachine);

                                $rowCount = 1; // Initialize the row counter

                                while ($rowVirtualMachine = mysqli_fetch_assoc($queryVirtualMachine)) {
                                    echo "<tr>";
                                    echo "<td>" . $rowCount . "</td>";
                                    echo "<td>" . ($rowVirtualMachine['asset_tag'] ? $rowVirtualMachine['asset_tag'] : '-') . "</td>";
                                    echo "<td>" . ($rowVirtualMachine['name'] ? $rowVirtualMachine['name'] : '-') . "</td>";
                                    echo "<td>" . ($rowVirtualMachine['ram'] ? $rowVirtualMachine['ram'] : '-') . "</td>";
                                    echo "<td>" . ($rowVirtualMachine['processor'] ? $rowVirtualMachine['processor'] : '-') . "</td>";
                                    echo "</tr>";
                                    $rowCount++; // Increment the row counter
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Tab 4: Transfer --> 
        <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="tab-transfer">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h4>Transfer History</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Display table -->
                    <table id="table_transfer" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Type</th>
                                <?php
                                foreach ($transferData as $rowTransfer) {
                                    if ($rowTransfer['type'] == 'Permanent' && !$dateTransferHeaderPrinted) {
                                        echo "<th>Date Transfer</th>";
                                        $dateTransferHeaderPrinted = true; // Set the flag to true
                                    } elseif ($rowTransfer['type'] == 'Period') {
                                        echo "<th>Start Borrowed</th>";
                                        echo "<th>Stop Borrowed</th>";
                                    }
                                }
                                ?>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rowCount = 1; // Reset the row counter
                        foreach ($transferData as $rowTransfer) {
                            $showRow = ($rowTransfer['date_transfer'] || $rowTransfer['start_date'] || $rowTransfer['end_date'] ||
                                $rowTransfer['transfer_branch'] || $rowTransfer['transfer_department'] || $rowTransfer['transfer_location']);

                            if ($showRow) {
                                echo "<tr>";
                                echo "<td>" . $rowCount . "</td>";
                                echo "<td>" . $rowTransfer['type'] . "</td>";
                                if ($rowTransfer['type'] == 'Permanent') {
                                    echo "<td>" . $rowTransfer['date_transfer'] . "</td>";
                                } elseif ($rowTransfer['type'] == 'Period') {
                                    echo "<td>" . $rowTransfer['start_date'] . "</td>";
                                    echo "<td>" . $rowTransfer['end_date'] . "</td>";
                                }
                                echo "<td>" . $rowTransfer['transfer_branch'] . "</td>";
                                echo "<td>" . $rowTransfer['transfer_department'] . "</td>";
                                echo "<td>" . $rowTransfer['transfer_location'] . "</td>";
                                echo "</tr>";
                                $rowCount++; // Increment the row counter
                            }
                        }
                        ?>
                        </tbody>
                    </table>

                    <!-- Display card layout -->
                    <div class="row mt-4">
                        <?php
                        foreach ($transferData as $rowTransfer) {
                            $showRow = ($rowTransfer['branch'] || $rowTransfer['department'] || $rowTransfer['location']);

                            if ($showRow) {
                                echo '<div class="col-md-4 mb-3">';
                                echo '<div class="card">';
                                echo '<div class="card-body">';
                                echo '<h5 class="card-text"><strong>Original Location</strong></h5>';
                                echo '<p class="card-text"><strong>Branch:</strong> ' . $rowTransfer['branch'] . '</p>';
                                echo '<p class="card-text"><strong>Department:</strong> ' . $rowTransfer['department'] . '</p>';
                                echo '<p class="card-text"><strong>Location:</strong> ' . $rowTransfer['location'] . '</p>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $rowCount++; // Increment the row counter
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab : Supplier Details -->
        <div class="tab-pane fade" id="supplier" role="tabpanel" aria-labelledby="tab-supplier">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6">
                        <h4>Supplier Details</h4></br>
                            <div class="row">
                                <label class="col-3" for="supplier"><b>Name: </b></label>
                                <span class="col-5" id="supplier" name="supplier" placeholder=""><?php if($supplier) {echo $supplier['display_name']; }?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="supplier_pic"><b>Contact Person: </b></label>
                                <span class="col-5" id="supplier_pic" name="supplier_pic" placeholder=""><?php if($supplier) {echo $supplier['pic']; }?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="supplier_contact_no"><b>Contact Number: </b></label>
                                <span class="col-5" id="supplier_contact_no" name="supplier_contact_no" placeholder=""><?php if($supplier) { echo $supplier['contact_no']; }?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="supplier_email"><b>Email: </b></label>
                                <span class="col-5" id="supplier_email" name="supplier_email" placeholder=""><?php if($supplier) {echo $supplier['email']; }?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="supplier_fax"><b>Fax Number: </b></label>
                                <span class="col-5" id="supplier_fax" name="supplier_fax" placeholder=""><?php if($supplier) {echo $supplier['fax']; }?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="supplier_address"><b>Address: </b></label>
                                <span class="col-9" id="supplier_address" name="supplier_address" placeholder=""><?php if($supplier) {echo $supplier['address']; }?></span>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>
        </div>

        <!-- Tab : Network -->
        <div class="tab-pane fade" id="network" role="tabpanel" aria-labelledby="tab-network">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table id="table_network" class="striped-table">
                        <thead>
                        <tr>
                                <th>No.</th>
                                <th>IP Type</th>
                                <th>IP Address</th>
                                <th>Mac Address</th>
                                <th>Active Port</th>
                            </tr>
                        </thead>
                        <?php
                        $sqlNetwork = "SELECT * FROM aims_computer_network WHERE asset_tag ='" . $row['asset_tag'] . "'";
                        $queryNetwork = mysqli_query($con, $sqlNetwork);

                        $rowCountNetwork = 1; // Initialize the row counter

                        while ($rowNetwork = mysqli_fetch_assoc($queryNetwork)) {
                            // Move the following code inside the loop
                            $sql6 = "SELECT * FROM aims_computer_network WHERE asset_tag ='" . $rowNetwork['asset_tag'] . "'";
                            $result6 = mysqli_query($con, $sql6);
                            $Network = mysqli_fetch_assoc($result6);

                            echo "<tr>";
                            echo "<td>" . $rowCountNetwork . "</td>";
                            echo "<td>" . $rowNetwork['ip_type'] . "</td>";
                            echo "<td>" . $rowNetwork['ip_address'] . "</td>";
                            echo "<td>" . $rowNetwork['mac_address'] . "</td>";
                            echo "<td>" . $rowNetwork['port'] . "</td>";
                            echo "</tr>";
                            $rowCountNetwork++; // Increment the row counter
                        }
                        ?>
                    </table>
                </div> 
            </div>
        </div>

        <!-- Tab: remote access -->
        <div class="tab-pane fade" id="remote_access" role="tabpanel" aria-labelledby="tab-remote_access">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h4>Remote Access</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_remote_access" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Password</th>
                                <th>Port</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $sqlRemoteAccess = "SELECT * FROM aims_computer_remote_access WHERE asset_tag ='" . $row['asset_tag'] . "'";
                        $queryRemoteAccess = mysqli_query($con, $sqlRemoteAccess);

                        $rowCountRemoteAccess = 1; // Initialize the row counter

                        while ($rowRemoteAccess = mysqli_fetch_assoc($queryRemoteAccess)) {
                            // Move the following code inside the loop
                            $sqlRemoteAccess = "SELECT * FROM aims_computer_remote_access WHERE asset_tag ='" . $rowRemoteAccess['asset_tag'] . "'";
                            $resultRemoteAccess = mysqli_query($con, $sqlRemoteAccess);
                            $RemoteAccess = mysqli_fetch_assoc($resultRemoteAccess);

                            echo "<tr>";
                            echo "<td>" . $rowCountRemoteAccess . "</td>";
                            echo "<td>" . $rowRemoteAccess['remote_name'] . "</td>";
                            echo "<td>" . $rowRemoteAccess['remote_address'] . "</td>";
                            echo "<td>" . $rowRemoteAccess['remote_password'] . "</td>";
                            echo "<td>" . $rowRemoteAccess['remote_port'] . "</td>";
                            echo "</tr>";
                            $rowCountRemoteAccess++; // Increment the row counter
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab : Software -->
        <div class="tab-pane fade show" id="software" role="tabpanel" aria-labelledby="tab-software">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table id="table_software" class="striped-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Software Name</th>
                                <th>Brand</th>
                                <th>License Key</th>
                                <th>Expiry Date</th>
                                <!-- <th>Invoice</th> -->
                            </tr>
                        </thead>
                        <?php 
                        $sqlSoftware = "SELECT * FROM aims_software where asset_tag ='".$row['asset_tag']."'";
                        $resultSoftware = mysqli_query($con, $sqlSoftware);
                        $rowCountSoftware = 1; // Initialize the row counter for Software tab
                        while ($rowSoftware = mysqli_fetch_assoc($resultSoftware)) {
                        ?>
                        <tr>
                            <td><?php echo ($rowSoftware['software_category']) ? $rowSoftware['software_category'] : '-'; ?></td>
                            <td><?php echo ($rowSoftware['software_name']) ? $rowSoftware['software_name'] : '-'; ?></td>
                            <td><?php echo ($rowSoftware['brand']) ? $rowSoftware['brand'] : '-'; ?></td>
                            <td><?php echo ($rowSoftware['license_key']) ? $rowSoftware['license_key'] : '-'; ?></td>
                            <td><?php echo ($rowSoftware['expiry_date']) ? $rowSoftware['expiry_date'] : '-'; ?></td>
                            <!-- <td>
                                <label for="bill"></label><br>
                                <?php
                                if (!empty($row['bill'])) {
                                    $fileName = basename($row['bill']);
                                    echo '<a href="' . $row['bill'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </td> -->
                        </tr>
                        <?php 
                        $rowCountSoftware++; // Increment the row counter for Software tab
                        } 
                        ?>
                    </table>
                </div>         
            </div>
        </div>

        <!-- Tab : Hard Drive -->
        <div class="tab-pane fade show" id="hard" role="tabpanel" aria-labelledby="tab-hard">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table id="table_hard_drive" class="striped-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Brand</th>
                                <th>Storage</th>
                                <th>Purpose</th>
                            </tr>
                        </thead>
                        <?php 
                        $sqlHardDrive = "SELECT * FROM aims_computer_hard_drive where asset_tag ='".$row['asset_tag']."'";
                        $resultHardDrive = mysqli_query($con, $sqlHardDrive);
                        $rowCountHardDrive = 1; // Initialize the row counter for Hard Drive tab
                        while ($rowHardDrive = mysqli_fetch_assoc($resultHardDrive)) {
                        ?>
                        <tr>
                            <td><?php echo ($rowHardDrive['hard_disk_name']) ? $rowHardDrive['hard_disk_name'] : '-'; ?></td>
                            <td><?php echo ($rowHardDrive['hard_drive']) ? $rowHardDrive['hard_drive'] : '-'; ?></td>
                            <td><?php echo ($rowHardDrive['brand']) ? $rowHardDrive['brand'] : '-'; ?></td>
                            <td><?php echo ($rowHardDrive['storage']) ? $rowHardDrive['storage'] : '-'; ?></td>
                            <td><?php echo ($rowHardDrive['purpose']) ? $rowHardDrive['purpose'] : '-'; ?></td>
                        </tr>
                        <?php 
                        $rowCountHardDrive++; // Increment the row counter for Hard Drive tab
                        } 
                        ?>
                    </table>
                </div>         
            </div>
        </div> 
        
        <!-- Tab User -->
        <div class="tab-pane fade show" id="user" role="tabpanel" aria-labelledby="tab-user">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <table id="table_user" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>User</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <?php
                        $sqlUser = "SELECT * FROM aims_computer_user WHERE asset_tag ='" . $row['asset_tag'] . "'";
                        $queryUser = mysqli_query($con, $sqlUser);

                        $rowCountUser = 1; // Initialize the row counter

                        while ($rowUser = mysqli_fetch_assoc($queryUser)) {
                            // Move the following code inside the loop
                            $sql5 = "SELECT * FROM aims_computer_user WHERE asset_tag ='" . $rowUser['asset_tag'] . "'";
                            $result5 = mysqli_query($con, $sql5);
                            $user = mysqli_fetch_assoc($result5);

                            echo "<tr>";
                            echo "<td>" . $rowCountUser . "</td>";
                            echo "<td>" . $rowUser['username'] . "</td>";
                            echo "<td>" . $rowUser['password'] . "</td>";
                            echo "<td>" . $rowUser['user'] . "</td>";
                            echo "<td>" . $rowUser['role'] . "</td>";
                            echo "</tr>";
                            $rowCountUser++; // Increment the row counter
                        }
                        ?>
                    </table>  
                </div> 
            </div>
        </div>

        <!-- Tab : Maintenance --> 
        <div class="tab-pane fade" id="maintenance" role="tabpanel" aria-labelledby="tab-maintenance">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                        <table id="table_maintenance" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Vendors</th>
                                <th>Title</th>
                                <th>Remark</th>
                                <th>Expenses</th>
                                <th>Maintenance Date</th>
                                <th style='text-align:center'>Action</th>
                            </tr>
                        </thead>
                        <?php
                            $sqlMaintenance = "SELECT * FROM aims_maintenance WHERE asset_tag ='" . $row['asset_tag'] . "'";
                            $queryMaintenance = mysqli_query($con, $sqlMaintenance);

                            $rowCountMaintenance = 1; // Initialize the row counter
                            $totalExpenses = 0; // Initialize the total expenses variable

                            while ($rowMaintenance = mysqli_fetch_assoc($queryMaintenance)) {
                                // Move the following code inside the loop
                                $sql3 = "SELECT * FROM aims_maintenance where name ='" . $rowMaintenance['maintenance'] . "'";
                                $result3 = mysqli_query($con, $sql3);
                                $maintenance = mysqli_fetch_assoc($result3);

                                echo "<tr>";
                                echo "<td>" . $rowCountMaintenance . "</td>";
                                echo "<td>" . $rowMaintenance['vendors'] . "</td>";
                                echo "<td>" . $rowMaintenance['title'] . "</td>";
                                echo "<td>" . $rowMaintenance['remark'] . "</td>";
                                echo "<td>" . $rowMaintenance['expenses'] . "</td>";
                                echo "<td>" . $rowMaintenance['maintenance_date'] . "</td>";
                                echo "<td style='text-align:center;'>
                                        <a id='ViewBtn' href='./view_maintenance?id=".$rowMaintenance['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>
                                    </td>";
                                echo "</tr>";

                                // Add the expenses to the total
                                $totalExpenses += $rowMaintenance['expenses'];

                                $rowCountMaintenance++; // Increment the row counter
                            }
                        ?>

                        </table>

                    <!-- Display the total expenses outside the table -->
                    <div class="total-expenses">
                        <strong>Total Expenses:</strong> <?php echo $totalExpenses; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Tab : Files -->
        <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="tab-files">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="invoice"><b>Invoice</b></label><br>
                                <?php
                                if (!empty($row['invoice'])) {
                                    $fileName = basename($row['invoice']);
                                    echo '<a href="' . $row['invoice'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="document"><b>Document</b></label><br>
                                <?php
                                if (!empty($row['document'])) {
                                    $fileName = basename($row['document']);
                                    echo '<a href="' . $row['document'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="warranty"><b>Warranty: </b></label><br>
                                <?php
                                if (!empty($row['warranty'])) {
                                    $fileName = basename($row['warranty']);
                                    echo '<a href="' . $row['warranty'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </div>
                        </div>
                    </div>            
                </div>           
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#table_software').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );

        $('#table_hard_drive').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );

        $('#table_user').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );

        $('#table_network').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 3 }
                ]
            }
        );

        $('#table_remote_access').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );

        $('#table_maintenance').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });

        $('#table_transfer').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });

        $('#table_virtual_machine').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );
    });

    // JavaScript function to change the main picture when a thumbnail is clicked
    function changeMainPicture(pictureUrl) {
        document.getElementById('mainPicture').src = pictureUrl;

    }
</script>