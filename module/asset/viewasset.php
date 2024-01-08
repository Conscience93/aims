<?php
if ($submodule_access['asset']['view'] != 1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_asset WHERE id ='" . $_GET['id'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Supplier
$sql2 = "SELECT * FROM aims_people_supplier WHERE display_name ='" . $row['supplier'] . "'";
$result2 = mysqli_query($con, $sql2);
$supplier = mysqli_fetch_assoc($result2);

$sql3 = "SELECT * FROM aims_izzat WHERE asset_tag = '" . $row['asset_tag'] . "'";
$result3 = mysqli_query($con, $sql3);
$asset_tag = mysqli_fetch_assoc($result3);

$sqlTransfer = "SELECT * FROM aims_transfer_asset WHERE asset_tag = '" . $row['asset_tag'] . "'";
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
                Basic Information 
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-supplier" data-toggle="tab" href="#supplier" role="tab" aria-controls="supplier" aria-selected="false">
                Supplier Details
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link " id="tab-transfer" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="true">
                Transfer Details 
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
        <!-- Tab 1: Basic Information -->
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="tab-information">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag']; ?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./asset" class="btn btn-danger">Back</a>
                                <a class="btn btn-primary" href='./module/asset/print.php?id=<?php echo $row['id']; ?>' target="_blank" title="Print">Print</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                        <!-- Basic Information -->
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
                                <div class ="row">
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
                                    <label class="col-2" for="price"><b>Price (RM): </b></label>
                                    <span class="col-3" id="price" name="price"><?php echo $row['price']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="do_number"><b>D.O Number: </b></label>
                                    <span class="col-3" id="do_number" name="do_number"><?php echo $row['do_number']; ?></span>
                                    <label class="col-2" for="po_number"><b>P.O Number: </b></label>
                                    <span class="col-3" id="po_number" name="po_number"><?php echo $row['po_number']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="date_purchase"><b>Date Purchase: </b></label>
                                    <span class="col-3" id="date_purchase" name="date_purchase"><?php echo $row['date_purchase']; ?></span>
                                    <label class="col-2" for="c_category"><b>Category: </b></label>
                                    <span class="col-3" id="c_category" name="c_category"><?php echo $row['category']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="start_warranty"><b>Start Warranty: </b></label>
                                    <span class="col-3" id="start_warranty" name="start_warranty"><?php echo $row['start_warranty']; ?></span>
                                    <label class="col-2" for="end_warranty"><b>End Warranty: </b></label>
                                    <span class="col-3" id="end_warranty" name="end_warranty"><?php echo $row['end_warranty']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="user"><b>Current User: </b></label>
                                    <span class="col-3" id="user" name="user"><?php echo $row['user']; ?></span>
                                    <label class="col-2" for="particular"><b>Particular: </b></label>
                                    <span class="col-4" id="particular" name="particular"><?php echo $row['particular']; ?></span>
                                </div>

                                </br>

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

        <!-- Tab 2: Supplier Details -->
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
        
        <!-- Tab 3: Files -->
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

        <!-- Tab 5: Maintenance -->
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
                </div>
                <div class="card-body">
                    <table id="table_maintenance" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Vendors</th>
                                <th>Title</th>
                                <th>Remark</th>
                                <th>Expenses</th>
                                <th>Date</th>
                                <th style='text-align:center'>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $sqlMaintenance = "SELECT * FROM aims_maintenance WHERE asset_tag ='" . $row['asset_tag'] . "'";
                        $queryMaintenance = mysqli_query($con, $sqlMaintenance);

                        $rowCount = 1; // Initialize the row counter
                        $totalExpenses = 0; // Initialize the total expenses variable

                        while ($rowMaintenance = mysqli_fetch_assoc($queryMaintenance)) {
                            echo "<tr>";
                            echo "<td>" . $rowCount . "</td>";
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

                            $rowCount++; // Increment the row counter
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
    </div>
</div>

<script>
    //datatable
    $(document).ready(function() {
        $('#table_maintenance').DataTable(
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

        $('#table_transfer').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });

        $('#table_original_location').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
    });
    
    // JavaScript function to change the main picture when a thumbnail is clicked
    function changeMainPicture(pictureUrl) {
        document.getElementById('mainPicture').src = pictureUrl;

    }
</script>