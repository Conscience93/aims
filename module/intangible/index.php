<?php 
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
?>

<style>
    .action-button {
        cursor: pointer;
    }

    /* Define styles for odd rows in striped-tables */
    table.striped-table tr:nth-child(odd) {
        background-color: #f2f2f2; /* Set the background color for odd data rows */
    }

    /* Define styles for even rows in striped-tables */
    table.striped-table tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even data rows */
    }

    #table_all_intangible img,
    #table_webpage img,
    #table_proprietary img,
    #table_licences img {
        max-width: 100px; /* Adjust the maximum width as needed */
        max-height: 100px; /* Adjust the maximum height as needed */
        width: auto;
        height: auto;
    }

    .asset-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        cursor: pointer;
    }

    .modal-backdrop {
        display: none;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        margin-top: 50px;
        padding-top: 60px;
    }

    .modal-header {
        background-color: #007bff; /* Blue header background */
        color: #fff; /* White text color */
        border-bottom: none; /* Remove the default border */
    }

    .modal-header .close {
        color: #fff;
    }

    .modal-title {
        font-weight: bold;
    }

    /* Style the "Add Category" button */
    .btn-primary {
        background-color: #007bff; /* Blue background for the button */
        color: #fff; /* White text color */
    }

    /* Style the "Close" button */
    .btn-close {
        background-color: #ccc; /* Gray background for the button */
        color: #333; /* Dark text color */
    }

    .btn-close:hover {
        background-color: #ddd; /* Example background color on hover */
        color: #333; /* Example text color on hover */
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 70%;
        max-width: 500px;
    }

    /* Add this if you want to center the image horizontally in the modal */
    #modalImage {
        max-width: 370px;
        max-height: 250px;
        display: block;
        margin: auto;
    }

    .modal-content img {
        max-width: 370px; /* Set the maximum width to 100% of the container */
        max-height: 250px; /* Set the maximum height as desired */
        width: auto; /* Allow the image to scale proportionally */
        height: auto; /* Allow the image to scale proportionally */
    }

    .additional-images-container {
        display: flex;
        overflow-x: auto; /* Enable horizontal scrolling if needed */
        gap: 10px; /* Adjust the space between images */
        }

    .additional-images-container img {
        max-width: 100%;
        max-height: 100px;
        width: auto;
        height: auto;
        cursor: pointer;
        border: 5px solid transparent; /* Add a border to make images stand out */
        transition: border-color 0.3s ease; /* Smooth transition for border color */
    }

    .additional-images-container img:hover {
        border-color: #007bff; /* Change border color on hover */
    }

    .additional-images-container img.selected-image {
        border: 5px solid #007bff; /* Highlight the selected image with a blue border */
    }

    /* Style for Transfer History Modal */
    #transferModal {
        max-width: 200%; /* Adjust the percentage for the max-width as needed */
        width: auto;
        margin: 0 auto;
        margin-top: 50px;
        padding-top: 60px;
        transition: max-width 0.3s ease; /* Add transition for max-width */
    }

    #transferModal .modal-content {
        margin: auto;
        display: block;
        width: 100%;
        max-width: 800px;
    }

    #table_transfer,
    #table_original_location {
        width: 100%;
        border-collapse: collapse; /* Add border-collapse property */
        transition: width 0.3s ease;
    }

    #table_transfer th,
    #table_transfer td,
    #table_original_location th,
    #table_original_location td {
        text-align: left;
        padding: 12px;
        border: 1px solid #ddd; /* Add border property */
    }

    #table_transfer td,
    #table_original_location td{
        width:500px;
    }

    #table_transfer th,
    #table_original_location th {
        background-color: #f2f2f2;
    }

    #table_transfer td,
    #table_original_location td {
        border-bottom: 1px solid #ddd;
        background-color: transparent; /* Set the background color of td to transparent */
    }

    .branch-link:hover {
        color: #ff6600;
        text-decoration: underline;
        cursor: pointer;
    }

    /* Style for checkboxes */
    input[type="checkbox"] {
        width: 20px; /* Set width of the checkbox */
        height: 20px; /* Set height of the checkbox */
        border: 2px solid #555; /* Set border color and thickness */
        border-radius: 4px; /* Add border-radius for rounded corners */
        cursor: pointer; /* Change cursor to pointer on hover */
        margin-left: 33px;
    }

    /* Style for checked checkboxes */
    input[type="checkbox"]:checked {
        background-color: #2196F3; /* Set background color when checked */
        border-color: #2196F3; /* Set border color when checked */
        color: #fff; /* Set text color when checked */
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        #transferModal {
            max-width: 100%;
        }
    }

    .green-button {
        background-color: green;
    }

    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .sorting_asc, .sorting_desc, .sorting {
        background-image: none !important;  
    }

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-all-intangible" data-toggle="tab" href="#all-intangible" role="tab" aria-controls="all-intangible" aria-selected="true">
                All (<?php
                    $sqlTotalAll = "SELECT
                        (SELECT COUNT(*) FROM aims_webpage WHERE approval = 'APPROVE') +
                        (SELECT COUNT(*) FROM aims_proprietary WHERE approval = 'APPROVE') +
                        (SELECT COUNT(*) FROM aims_licences WHERE approval = 'APPROVE') AS total_count";
                    $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                    $totalAll = mysqli_fetch_assoc($queryTotalAll)['total_count'];
                    echo $totalAll;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-webpage" data-toggle="tab" href="#webpage" role="tab" aria-controls="webpage" aria-selected="false">
                Webpage (<?php
                        $sqlTotalAsset = "SELECT id FROM aims_webpage WHERE approval = 'APPROVE'";
                        $queryTotalAsset = mysqli_query($con, $sqlTotalAsset);
                        $totalAsset = mysqli_num_rows($queryTotalAsset);
                    echo $totalAsset;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-proprietary" data-toggle="tab" href="#proprietary" role="tab" aria-controls="proprietary" aria-selected="false">
                Proprietary (<?php
                        $sqlTotalComputer = "SELECT id FROM aims_proprietary WHERE approval = 'APPROVE'";
                        $queryTotalComputer = mysqli_query($con, $sqlTotalComputer);
                        $totalComputer = mysqli_num_rows($queryTotalComputer);
                    echo $totalComputer;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-licences" data-toggle="tab" href="#licences" role="tab" aria-controls="licences" aria-selected="false">
                Licences (<?php
                        $sqlTotalComputer = "SELECT id FROM aims_licences WHERE approval = 'APPROVE'";
                        $queryTotalComputer = mysqli_query($con, $sqlTotalComputer);
                        $totalComputer = mysqli_num_rows($queryTotalComputer);
                    echo $totalComputer;
                ?>)
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: All Intangible -->
        <div class="tab-pane fade show active" id="all-intangible" role="tabpanel" aria-labelledby="tab-all-intangible">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>All Intangible Asset</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="./addintangible" class="btn btn-info">Add Intangible Asset</a>
                                <!-- <a href="" onclick="history.back()" class="btn btn-danger">Back</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_all_intangible" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>No.</th> 
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $assets = array();

                        $sqlAll = "SELECT aw.id, aw.asset_tag, aw.name, aw.category, aw.price, aap.picture
                                FROM aims_webpage aw
                                LEFT JOIN aims_all_asset_picture aap ON aw.asset_tag = aap.asset_tag
                                WHERE aw.approval = 'APPROVE'
                                UNION

                                SELECT ap.id, ap.asset_tag, ap.name, ap.category, ap.price, aap.picture
                                FROM aims_proprietary ap 
                                LEFT JOIN aims_all_asset_picture aap ON ap.asset_tag = aap.asset_tag
                                WHERE ap.approval = 'APPROVE'
                                UNION

                                SELECT al.id, al.asset_tag, al.name, al.category, al.price, aap.picture
                                FROM aims_licences al 
                                LEFT JOIN aims_all_asset_picture aap ON al.asset_tag = aap.asset_tag
                                WHERE al.approval = 'APPROVE' "; 
                                
                        $queryAll = mysqli_query($con, $sqlAll);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'], // Add 'id' to the array
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'price' => $row['price'],
                                    'images' => array($row['picture']) // Store the first image in the array
                                );
                            } else {
                                // If the asset already exists in the array, add the additional image
                                $assets[$assetTag]['images'][] = $row['picture'];
                            }
                        }
                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='asset_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$asset['asset_tag']."</td>";
                            echo "<td>".$asset['name']."</td>";
                            echo "<td>".$asset['category']."</td>";
                            echo "<td>".$asset['price']."</td>";
                            // Displaying only the first image in the table
                            echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            // Add your action buttons here
                            if ($asset['asset_tag'][0] == 'W') {
                                echo "
                                    <a id='assetEditBtn' href='./viewwebpage?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='assetEditBtn' href='./editwebpage?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                ";
                            } elseif ($asset['asset_tag'][0] == 'P') {
                                echo "
                                    <a id='computerEditBtn' href='./viewproprietary?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='computerEditBtn' href='./editproprietary?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                ";
                            } elseif ($asset['asset_tag'][0] == 'L') {
                                echo "
                                    <a id='electronicsEditBtn' href='./viewlicences?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='electronicsEditBtn' href='./editlicences?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                ";
                            } 
                            echo "</td>";
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>   

        <!-- Tab 2: Webpage -->
        <div class="tab-pane fade" id="webpage" role="tabpanel" aria-labelledby="tab-webpage">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Webpage</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <!-- <button type="button" id="exportAssetButton" onclick="exportDataAsset()" class="btn btn-primary green-button">Export</button> -->
                                <a href="./addwebpage" class="btn btn-info">Add Webpage</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_webpage" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>No.</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price(RM)</th>
                                <th>Server</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $assets = array();
                        // Query assets from aims_asset table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT aw.id, aw.asset_tag, aw.name, aw.category, aw.price, aw.server_name, aap.picture
                                    FROM aims_webpage aw
                                    LEFT JOIN aims_all_asset_picture aap ON aw.asset_tag = aap.asset_tag
                                    WHERE aw.approval = 'APPROVE'";
                        $queryAsset = mysqli_query($con, $sqlAsset);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAsset)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'],
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'price' => $row['price'],
                                    'server_name' => $row['server_name'],
                                    'images' => array($row['picture'])
                                );
                            } else {
                                $assets[$assetTag]['images'][] = $row['picture'];
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='asset_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td>" . $rowNumber . "</td>";
                            echo "<td>" . $asset['asset_tag'] . "</td>";
                            echo "<td>" . $asset['name'] . "</td>";
                            echo "<td>" . $asset['category'] . "</td>";
                            echo "<td>" . $asset['price'] . "</td>";
                            echo "<td>" . $asset['server_name'] . "</td>";
                            echo "<td><img class='asset-image' src='" . $asset['images'][0] . "' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='fixedAssetEditBtn' href='./viewwebpage?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='fixedAssetEditBtn' href='./editwebpage?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 3: Proprietary -->
        <div class="tab-pane fade" id="proprietary" role="tabpanel" aria-labelledby="tab-proprietary">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Proprietary</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <!-- <button type="button" id="exportElectronicsButton" onclick="exportDataElectronics()" class="btn btn-primary green-button">Export</button> -->
                                <a href="/aims/addelectronics" class="btn btn-info">Add Proprietary</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_proprietary" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>No.</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Current Location</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $assets = array();
                        // Query assets from aims_electronics table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT al.id, al.asset_tag, al.name, al.category, aap.picture
                                    FROM aims_proprietary al
                                    LEFT JOIN aims_all_asset_picture aap ON al.asset_tag = aap.asset_tag
                                    WHERE al.approval = 'APPROVE'";
                        $queryAsset = mysqli_query($con, $sqlAsset);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAsset)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'],
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'price' => $row['price'],
                                    'branch' => $row['branch'],
                                    'images' => array($row['picture'])
                                );
                            } else {
                                $assets[$assetTag]['images'][] = $row['picture'];
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='asset_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td>" . $rowNumber . "</td>";
                            echo "<td>" . $asset['asset_tag'] . "</td>";
                            echo "<td>" . $asset['name'] . "</td>";
                            echo "<td>" . $asset['category'] . "</td>";
                            echo "<td>" . $asset['price'] . "</td>";
                            echo "<td><a class='branch-link' data-asset-tag='" . $asset['asset_tag'] . "' href='#'> " . $asset['branch'] . "</a></td>";
                            echo "<td><img class='asset-image' src='" . $asset['images'][0] . "' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='electronicsEditBtn' href='./viewelectronics?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='electronicsEditBtn' href='./editelectronics?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>
        
        <!-- Tab 4: Licences -->
        <div class="tab-pane fade" id="licences" role="tabpanel" aria-labelledby="tab-licences">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Licences</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <!-- <button type="button" id="exportComputerButton" onclick="exportDataComputer()" class="btn btn-primary green-button">Export</button> -->
                                <a href="/aims/addcomputer" class="btn btn-info">Add Licences</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_licences" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>No.</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Current Location</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $assets = array();
                        // Query assets from aims_computer table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT ap.id, ap.asset_tag, ap.name, ap.category, aap.picture
                                    FROM aims_licences ap
                                    LEFT JOIN aims_all_asset_picture aap ON ap.asset_tag = aap.asset_tag
                                    WHERE ap.approval = 'APPROVE'";
                        $queryAsset = mysqli_query($con, $sqlAsset);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAsset)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'],
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'price' => $row['price'],
                                    'branch' => $row['branch'],
                                    'images' => array($row['picture'])
                                );
                            } else {
                                $assets[$assetTag]['images'][] = $row['picture'];
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='asset_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td>" . $rowNumber . "</td>";
                            echo "<td>" . $asset['asset_tag'] . "</td>";
                            echo "<td>" . $asset['name'] . "</td>";
                            echo "<td>" . $asset['category'] . "</td>";
                            echo "<td>" . $asset['price'] . "</td>";
                            echo "<td><a class='branch-link' data-asset-tag='" . $asset['asset_tag'] . "' href='#'> " . $asset['branch'] . "</a></td>";
                            echo "<td><img class='asset-image' src='" . $asset['images'][0] . "' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='computerEditBtn' href='./viewcomputer?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='computerEditBtn' href='./editcomputer?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>
    </div>
</div>

<!-- Modal Trigger Button (Hidden) -->
<!-- <button type="button" id="openModalBtn" data-toggle="modal" data-target="#exportAsset" style="display: none;">Open Modal</button> -->

<!-- Modal Asset-->
<!-- <div class="modal" id="exportAsset" tabindex="-1" role="dialog" aria-labelledby="exportAssetLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="download modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportAssetLabel">Export Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> -->
                <!-- Download Template Button -->
                <!-- <iframe style="display:none;" id="downloadAsset"></iframe>
                <a href="javascript:void(0);" onclick="downloadAsset()" class="btn btn-info mt-2">Download</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal Trigger Button (Hidden) -->
<!-- <button type="button" id="openModalBtn" data-toggle="modal" data-target="#exportElectronics" style="display: none;">Open Modal</button> -->

<!-- Modal Electronics-->
<!-- <div class="modal" id="exportElectronics" tabindex="-1" role="dialog" aria-labelledby="exportElectronicsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="download modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportElectronicsLabel">Export Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> -->
                <!-- Download Template Button -->
                <!-- <iframe style="display:none;" id="downloadElectronics"></iframe>
                <a href="javascript:void(0);" onclick="downloadElectronics()" class="btn btn-info mt-2">Download</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal Trigger Button (Hidden) -->
<!-- <button type="button" id="openModalBtn" data-toggle="modal" data-target="#exportComputer" style="display: none;">Open Modal</button> -->

<!-- Modal Computer -->
<!-- <div class="modal" id="exportComputer" tabindex="-1" role="dialog" aria-labelledby="exportComputerLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="download modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportComputerLabel">Export Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> -->
                <!-- Download Template Button -->
                <!-- <iframe style="display:none;" id="downloadComputer"></iframe>
                <a href="javascript:void(0);" onclick="downloadComputer()" class="btn btn-info mt-2">Download</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal for changing picture -->
<div class="modal" id="myModal">
    <div class="picture modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="changedPictureLabel">View/Change Displayed Picture</h5>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <img id="modalImage" src="" alt="Modal Image" class="main-image">
            </div>
            <div class="additional-images-container">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-close" data-dismiss="modal">Close</button>
            <button type="button" id="changedPictureButton" class="btn btn-primary">Swap Picture</button>
        </div>
    </div>
</div>

<!-- Modal for Transfer History -->
<div class="modal" id="transferModal">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="transferModalLabel">Transfer History</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="transferModalBody">
            <table id="table_transfer">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Type</th>
                        <th id="start_date_container" style="display: none;">Date Borrowed</th>
                        <th id="end_date_container" style="display: none;">End Date Borrowed</th>
                        <th id="date_transfer_container" style="display: none;">Date Transfer</th>
                        <th>Branch</th>
                        <th>Department</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <?php
                 $sqlTransfer = "SELECT * FROM aims_transfer_asset
                                UNION 
                                SELECT * FROM aims_transfer_computer
                                UNION
                                SELECT * FROM aims_transfer_electronics  
                                WHERE asset_tag = '$assetTag'";
                $queryTransfer = mysqli_query($con, $sqlTransfer);

                $rowCount = 1; // Initialize the row counter

                while ($rowTransfer = mysqli_fetch_assoc($queryTransfer)) {
                    // Move the following code inside the loop
                    $sqlTransfer = "SELECT * FROM aims_transfer_asset
                                    UNION
                                    SELECT * FROM aims_transfer_computer
                                    UNION
                                    SELECT * FROM aims_transfer_electronics 
                                    WHERE name = '" . $rowTransfer['name'] . "'";
                    $resultTransfer = mysqli_query($con, $sqlTransfer);
                    $name = mysqli_fetch_assoc($resultTransfer);

                    echo "<tr>";
                    echo "<td>" . $rowCount . "</td>";
                    echo "<td>" . $rowTransfer['type'] . "</td>";
                    echo "<td>" . $rowTransfer['start_date'] . "</td>";
                    echo "<td>" . $rowTransfer['end_date'] . "</td>";
                    echo "<td>" . $rowTransfer['date_transfer'] . "</td>";
                    echo "<td>" . $rowTransfer['branch'] . "</td>";
                    echo "<td>" . $rowTransfer['department'] . "</td>";
                    echo "<td>" . $rowTransfer['location'] . "</td>";
                    echo "</tr>";
                    $rowCount++; // Increment the row counter
                }
                ?>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary" id="printTransferBtn">Print</button> -->
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    //datatable
    $(document).ready(function() {
        $('#table_all_intangible').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 6 }
                ]
            }
        );
        $('#table_webpage').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 7 }
                ]
            }
        );
        $('#table_proprietary').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 7 }
                ]
            }
        );
        $('#table_licences').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 7 }
                ]
            }
        );
    });

    $(document).ready(function () {
        // Event listener for the 'type' dropdown change
        $('#type').change(function () {
            var selectedValue = $(this).val();

            // Hide all date fields by default
            $('#start_date_container').hide();
            $('#end_date_container').hide();
            $('#date_transfer_container').hide();

            // Show the date fields based on the selected option
            if (selectedValue === 'Period') {
                $('#start_date_container').show();
                $('#end_date_container').show();
            } else if (selectedValue === 'Permanent') {
                $('#date_transfer_container').show();
            }
        });

        // Trigger the change event on page load to show/hide fields based on the initial value
        $('#type').trigger('change');
    });

    // function downloadAsset() {
    //     var link = document.createElement('a');
    //     link.href = './module/asset/export_data/asset/exportedAsset_data.xlsx';
    //     link.download = 'exportedAsset_data.xlsx';
    //     document.body.appendChild(link);
    //     link.click();
    //     document.body.removeChild(link);
    // }

    // // Ensure the iframe src is empty initially
    // $('#exportAsset').on('show.bs.modal', function () {
    //     document.getElementById('downloadAsset').src = '';
    // });

    // // Trigger the modal when the export button is clicked
    // document.getElementById('exportAssetButton').addEventListener('click', function () {
    //     $('#exportAsset').modal('show');
    // });

    // // Function to handle the click event of the "Export" button
    // function exportDataAsset() {
    //     // Send an AJAX request to the server to handle the export
    //     $.ajax({
    //         type: 'POST',
    //         url: './module/asset/exportAsset.php', // Replace with the actual server-side script handling the export
    //         dataType: 'json',
    //         success: function (response) {
    //             // Handle the server response here (if needed)
    //             console.log(response);

    //             // Handle the response based on success or error
    //             if (response.status === 'success') {
                    
    //             } else {
                    
    //             }
    //         },
    //         error: function (error) {
    //             // Handle errors (if any)
    //             // console.log(error);
    //         }
    //     });
    // }

    // function downloadElectronics() {
    //     var link = document.createElement('a');
    //     link.href = './module/asset/export_data/electronics/exportedElectronics_data.xlsx';
    //     link.download = 'exportedElectronics_data.xlsx';
    //     document.body.appendChild(link);
    //     link.click();
    //     document.body.removeChild(link);
    // }

    // // Ensure the iframe src is empty initially
    // $('#exportElectronics').on('show.bs.modal', function () {
    //     document.getElementById('downloadElectronics').src = '';
    // });

    // // Trigger the modal when the export button is clicked
    // document.getElementById('exportElectronicsButton').addEventListener('click', function () {
    //     $('#exportElectronics').modal('show');
    // });

    // function exportDataElectronics() {
    // // Send an AJAX request to the server to handle the export
    //     $.ajax({
    //         type: 'POST',
    //         url: './module/asset/exportElectronics.php', // Replace with the actual server-side script handling the export
    //         dataType: 'json',
    //         success: function (response) {
    //             // Handle the server response here (if needed)
    //             console.log(response);

    //             // Handle the response based on success or error
    //             if (response.status === 'success') {
                    
    //             } else {
                    
    //             }
    //         },
    //         error: function (error) {
    //             // Handle errors (if any)
    //             // console.log(error);
    //         }
    //     });
    // }

    // function downloadComputer() {
    //     var link = document.createElement('a');
    //     link.href = './module/asset/export_data/computer/exportedComputer_data.xlsx';
    //     link.download = 'exportedComputer_data.xlsx';
    //     document.body.appendChild(link);
    //     link.click();
    //     document.body.removeChild(link);
    // }

    // // Ensure the iframe src is empty initially
    // $('#exportComputer').on('show.bs.modal', function () {
    //     document.getElementById('downloadComputer').src = '';
    // });

    // // Trigger the modal when the export button is clicked
    // document.getElementById('exportComputerButton').addEventListener('click', function () {
    //     $('#exportComputer').modal('show');
    // });

    // function exportDataComputer() {
    //     // Send an AJAX request to the server to handle the export
    //     $.ajax({
    //         type: 'POST',
    //         url: './module/asset/exportComputer.php', // Replace with the actual server-side script handling the export
    //         dataType: 'json',
    //         success: function (response) {
    //             // Handle the server response here (if needed)
    //             console.log(response);

    //             // Handle the response based on success or error
    //             if (response.status === 'success') {
                    
    //             } else {
                    
    //             }
    //         },
    //         error: function (error) {
    //             // Handle errors (if any)
    //             console.log(error);
    //         }
    //     });
    // }

    // Retrieve selected categories from local storage
    const selectedCategories = JSON.parse(localStorage.getItem('selectedCategories')) || [];

    // Function to update tab visibility based on selected categories
    function updateTabsVisibility() {
        const tabs = document.querySelectorAll('.nav-tabs .nav-item');
        tabs.forEach(tab => {
            const tabId = tab.querySelector('.nav-link').id;
            if (selectedCategories.includes(tabId.replace('tab-', '')) || tab.querySelector('.nav-link').classList.contains('active')) {
                tab.style.display = 'block';
            } else {
                tab.style.display = 'none';
            }
        });
    }
    

    // Initial update based on stored selected categories
    updateTabsVisibility();

    function confirmDeleteMultiple() {
        var selectedAssetTags = $('input[name="asset_asset_tag[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (selectedAssetTags.length > 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to delete selected assets. This process is irreversible!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete them!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteMultiple(selectedAssetTags);
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'No assets selected for deletion.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function deleteMultiple(assetTags) {
        $.ajax({
            url: "./module/intangible/delete_multiple.php",
            type: "POST",
            data: { asset_asset_tag: assetTags },
            success: function(response) {
                // Handle the server response here if needed
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The selected assets have been deleted.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './intellectual';
                });
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the selected assets.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './intellectual';
                });
            }
        });
    }

    function confirmDeleteAsset(id, asset_tag) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete asset with Tag: " + asset_tag + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteAsset(id);
        }
        });
        }

    function deleteAsset(id) {
        $.ajax({
        url: "./module/asset/deleteasset_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The asset has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the asset.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
        }
        });
    }

    function confirmDeleteElectronics(id, asset_tag) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete electronics with Tag: " + asset_tag + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteElectronics(id);
        }
        });
        }

    function deleteElectronics(id) {
        $.ajax({
        url: "./module/electronics/deleteelectronics_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The electronics has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the electronics.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
        }
        });
    }

    function confirmDeleteComputer(id, asset_tag) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete computer with Tag: " + asset_tag + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteComputer(id);
        }
        });
        }

    function deleteComputer(id) {
        $.ajax({
        url: "./module/computer/deletecomputer_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The computer has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the computer.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
        }
        });
    }

    function deleteDisposal(id) {
        $.ajax({
        url: "./module/disposal/deletedisposal_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The asset has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the asset.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './asset';
            });
        }
        });
    }

    $(document).ready(function () {
        // Click event for branch links
        $('.branch-link').on('click', function (e) {
            e.preventDefault();

            // Get the asset tag from the clicked link
            var assetTag = $(this).data('asset-tag');

            // Load transfer details via AJAX
            $.ajax({
                type: 'GET',
                url: './module/asset/load_transfer_details.php',
                data: { assetTag: assetTag },
                success: function (data) {
                    // Update modal body with transfer details
                    $('#transferModalBody').html(data);

                    // Show the modal
                    $('#transferModal').modal('show');
                },
                error: function () {
                    console.error('Error loading transfer details');
                }
            });
        });
    });

    $(document).ready(function () {
        var selectedImage; // Variable to keep track of the selected image
        var selectedAssetTag; // Variable to keep track of the selected asset tag

        // Function to open the modal and load images
        function openModal(assetTag, mainImageUrl, additionalImages) {
            selectedAssetTag = assetTag;

            // Display the main image in the modal
            $('#modalImage').attr('src', mainImageUrl);

            // Update the additional images container in the modal
            updateAdditionalImages(additionalImages);

            // Display the modal
            $('#myModal').css('display', 'block');
        }

        // Function to close the modal
        function closeModal() {
            // Hide the modal
            $('#myModal').css('display', 'none');
        }

        // Function to update the modal with additional images
        function updateAdditionalImages(images) {
            var additionalImagesContainer = $('.additional-images-container');
            additionalImagesContainer.empty(); // Clear previous additional images

            // Add each additional image to the container
            images.forEach(function (imageUrl) {
                var additionalImage = $('<img>').attr('src', imageUrl).addClass('additional-image');
                additionalImagesContainer.append(additionalImage);
            });
        }

        // Handle click event on the "Swap Picture" button
        $('#changedPictureButton').on('click', function () {
            console.log("Swap Picture button clicked");
            // Check if an image is selected
            if (selectedImage) {
                // Get the source of the selected additional image in the modal
                var newImageUrl = selectedImage.attr('src');

                // Update the source of the main image in the modal
                $('#modalImage').attr('src', newImageUrl);

                // Update the image in both tables
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .asset-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .fixed-asset-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .electronics-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .computer-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .vehicle-image').attr('src', newImageUrl);

                // Store the updated image source in PHP session
                $.ajax({
                    url: './module/asset/store_image_session.php', // Replace with the actual URL to your server-side script
                    type: 'POST',
                    data: {
                        assetTag: selectedAssetTag,
                        newImageUrl: newImageUrl
                    },
                    success: function (response) {
                        console.log(response); // Log the response from the server
                    },
                    error: function () {
                        console.log('Error storing image in session');
                    }
                });
                
                // Store the updated image source in local storage
                localStorage.setItem(selectedAssetTag, newImageUrl);

                // Close the modal
                closeModal();
            }
        });

        // Handle click event on the asset images to trigger the modal
        $('#table_all_asset, #table_fixed_asset, #table_electronics, #table_computer, #table_vehicle').on('click', '.asset-image', function () {
            var assetTag = $(this).closest('tr').data('asset-tag');
            var mainImageUrl = $(this).attr('src');

            // Fetch additional images using AJAX
            $.ajax({
                url: './module/asset/fetch_additional_images.php', // Replace with the actual URL to your server-side script
                type: 'GET',
                data: { assetTag: assetTag },
                success: function (data) {
                    // Parse the response data
                    var additionalImages = JSON.parse(data);

                    // Open the modal with the selected image and additional images
                    openModal(assetTag, mainImageUrl, additionalImages);
                },
                error: function () {
                    console.log('Error fetching additional images');
                }
            });
        });

        // Handle click event on the modal close button
        $('.btn-close').on('click', function () {
            // Close the modal
            closeModal();
        });

        // Handle click event on additional images in the modal
        $('.additional-images-container').on('click', '.additional-image', function () {
            // Remove the border from the previously selected image
            if (selectedImage) {
                selectedImage.removeClass('selected-image');
            }

            // Set the border on the clicked image
            $(this).addClass('selected-image');
            selectedImage = $(this);

            // Update the main image with the selected additional image
            var selectedImageUrl = $(this).attr('src');
            $('#modalImage').attr('src', selectedImageUrl);
        });

        // Check local storage on page load and update images in both tables
        for (var i = 0; i < localStorage.length; i++) {
            var assetTag = localStorage.key(i);
            var storedImageUrl = localStorage.getItem(assetTag);

            if (storedImageUrl) {
                $('tr[data-asset-tag="' + assetTag + '"] .asset-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .fixed-asset-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .electroncis-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .computer-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .vehicle-image').attr('src', storedImageUrl);
            }
        }
    });

    // Function to change the main picture in viewasset.php
  function changeMainPicture(pictureSrc) {
    // Update the main picture container using AJAX
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Replace the content of mainPictureContainer with the new picture
        document.getElementById('mainPictureContainer').innerHTML = xhr.responseText;
      }
    };

    // Send an AJAX request to viewasset.php with the selected picture source
    xhr.open('GET', 'viewasset.php?pictureSrc=' + encodeURIComponent(pictureSrc), true);
    xhr.send();
  }
</script>