<?php
if ($submodule_access['asset']['view'] != 1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_inventory WHERE id ='" . $_GET['id'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
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
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
         <!-- Tab 1: Basic Information -->
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="tab-information">
            <div class="card shadow rounded">
                <div class="card-header" style="Background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="item_tag" name="item_tag"><?php echo $row['item_tag']; ?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./inventory" class="btn btn-danger">Back</a>
                                <a class="btn btn-primary" href='./module/inventory/print.php?id=<?php echo $row['id']; ?>' target="_blank" title="Print">Print</a>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-body" style="max-height: 75vh;">
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-7">
                                <h4>Basic Information</h4>
                                <div class="row">
                                    <label class="col-2" for="stock"><b>Stock#: </b></label>
                                    <span class="col-3" id="stock" name="stock"><?php echo $row['stock']; ?></span>
                                    <label class="col-2" for="name"><b>Name: </b></label>
                                    <span class="col-3" id="name" name="name"><?php echo $row['name']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="do_number"><b>D.O Number: </b></label>
                                    <span class="col-3" id="do_number" name="do_number"><?php echo $row['do_number']; ?></span>
                                    <label class="col-2" for="po_number"><b>P.O Number: </b></label>
                                    <span class="col-3" id="po_number" name="po_number"><?php echo $row['po_number']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="created_date"><b>Created Date: </b></label>
                                    <span class="col-3" id="created_date" name="created_date"><?php echo $row['created_date']; ?></span>
                                    <label class="col-2" for="default_location"><b>Default Location: </b></label>
                                    <span class="col-3" id="default_location" name="default_location"><?php echo $row['default_location']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="category"><b>Category: </b></label>
                                    <span class="col-3" id="category" name="category"><?php echo $row['category']; ?></span>
                                    <label class="col-2" for="type"><b>Type: </b></label>
                                    <span class="col-3" id="type" name="type"><?php echo $row['type']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="class"><b>Class: </b></label>
                                    <span class="col-3" id="class" name="class"><?php echo $row['class']; ?></span>
                                    <label class="col-2" for="uom"><b>UOM: </b></label>
                                    <span class="col-4" id="uom" name="uom"><?php echo $row['uom']; ?></span>
                                </div>    
                            </div>

                            <!-- <div class="row">
                                <div class="col-12">
                                    <h4>Image Gallery</h4>
                                    <div id="mainPictureContainer">
                                         Main Picture Display
                                        <?php
                                            // Debugging: Log session contents
                                            error_log("Session Contents: " . print_r($_SESSION, true));

                                            // Check if there is a stored image URL for the asset in the session
                                            $assetTag = $row['asset_tag'];
                                            $storedImageUrl = isset($_SESSION[$assetTag]) ? $_SESSION[$assetTag] : null;

                                            // Debugging: Log values
                                            error_log("Asset Tag: " . $assetTag);
                                            error_log("Stored Image URL: " . $storedImageUrl);

                                            // Display the stored image
                                            if ($storedImageUrl) {
                                                echo '<img id="mainPicture" src="' . $storedImageUrl . '" alt="Main Picture" style="max-width: 325px; height: 270px;">';
                                            } else {
                                                echo '<img id="mainPicture" src="placeholder.jpg" alt="Main Picture" style="max-width: 325px; height: 270px;">';
                                            }
                                        ?>
                                    </div>
                                     Thumbnail Images 
                                    <?php
                                    // Fetch all pictures from aims_all_asset_picture
                                    $sqlPictures = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag = '" . $row['asset_tag'] . "'";
                                    $resultPictures = mysqli_query($con, $sqlPictures);

                                    while ($picture = mysqli_fetch_assoc($resultPictures)) {
                                        echo '<img class="thumbnail" src="' . $picture['picture'] . '" alt="Thumbnail" style="max-width: 100px; height: auto; cursor: pointer;" onclick="changeMainPicture(\'' . $picture['picture'] . '\');">';
                                    }
                                    ?>
                                </div>
                            </div> -->
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
                                <span class="col-5" id="supplier_address" name="supplier_address" placeholder=""><?php if($supplier) {echo $supplier['address']; }?></span>
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