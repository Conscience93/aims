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

    #table_transfer_all_asset img,
    #table_transfer_fixed_asset img,
    #table_transfer_electronics img,
    #table_transfer_computer img,
    #table_transfer_vehicle img,
    #table_transfer_property img {
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

    .green-button {
        background-color: green;
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
            <a class="nav-link active" id="tab-transfer-all-asset" data-toggle="tab" href="#transfer-all-asset" role="tab" aria-controls="transfer-all-asset" aria-selected="true">
                All (<?php
                        $sqlTotalAll = "SELECT COUNT(DISTINCT asset_tag) as total
                                        FROM (
                                            SELECT asset_tag FROM aims_transfer_asset WHERE status = 'TRANSFER' AND approval = 'PENDING'
                                            UNION
                                            SELECT asset_tag FROM aims_transfer_electronics WHERE status = 'TRANSFER' AND approval = 'PENDING'
                                            UNION
                                            SELECT asset_tag FROM aims_transfer_computer WHERE status = 'TRANSFER' AND approval = 'PENDING'
                                        ) as combined_tags";
                        $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                        $totalAll = mysqli_fetch_assoc($queryTotalAll)['total'];
                    echo $totalAll;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-transfer-fixed-asset" data-toggle="tab" href="#transfer-fixed-asset" role="tab" aria-controls="transfer-fixed-asset" aria-selected="false">
                Fixed Asset (<?php
                    $sqlTotalAsset = "SELECT COUNT(DISTINCT asset_tag) as total
                                    FROM (
                                        SELECT asset_tag FROM aims_transfer_asset WHERE status = 'TRANSFER' AND approval = 'PENDING'
                                    ) as combined_tags";
                    $queryTotalAsset = mysqli_query($con, $sqlTotalAsset);

                    // Fetch the result as an associative array
                    $result = mysqli_fetch_assoc($queryTotalAsset);

                    // Access the 'total' key
                    $totalAsset = $result['total'];

                    echo $totalAsset;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-transfer-electronics" data-toggle="tab" href="#transfer-electronics" role="tab" aria-controls="transfer-electronics" aria-selected="false">
                Electronics (<?php
                    $sqlTotalElectronics = "SELECT COUNT(DISTINCT asset_tag) as total
                                            FROM (
                                                SELECT asset_tag FROM aims_transfer_electronics WHERE status = 'TRANSFER' AND approval = 'PENDING'
                                            ) as combined_tags";
                    $queryTotalElectronics = mysqli_query($con, $sqlTotalElectronics);

                    // Fetch the result as an associative array
                    $result = mysqli_fetch_assoc($queryTotalElectronics);

                    // Access the 'total' key
                    $totalElectronics = $result['total'];

                    echo $totalElectronics;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-transfer-computer" data-toggle="tab" href="#transfer-computer" role="tab" aria-controls="transfer-computer" aria-selected="false">
                Computer (<?php
                    $sqlTotalComputer = "SELECT COUNT(DISTINCT asset_tag) as total
                                            FROM (
                                                SELECT asset_tag FROM aims_transfer_computer WHERE status = 'TRANSFER' AND approval = 'PENDING'
                                            ) as combined_tags";
                    $queryTotalComputer = mysqli_query($con, $sqlTotalComputer);

                    // Fetch the result as an associative array
                    $result = mysqli_fetch_assoc($queryTotalComputer);

                    // Access the 'total' key
                    $totalComputer = $result['total'];

                    echo $totalComputer;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-transfer-all-reject" data-toggle="tab" href="#transfer-all-reject" role="tab" aria-controls="transfer-all-reject" aria-selected="false">
                Reject (<?php
                        $sqlTotalAll = "SELECT COUNT(DISTINCT asset_tag) as total
                                        FROM (
                                            SELECT asset_tag FROM aims_transfer_asset WHERE status = 'TRANSFER' AND approval = 'REJECT'
                                            UNION
                                            SELECT asset_tag FROM aims_transfer_electronics WHERE status = 'TRANSFER' AND approval = 'REJECT'
                                            UNION
                                            SELECT asset_tag FROM aims_transfer_computer WHERE status = 'TRANSFER' AND approval = 'REJECT'
                                        ) as combined_tags";
                        $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                        $totalAll = mysqli_fetch_assoc($queryTotalAll)['total'];
                    echo $totalAll;
                ?>)
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: All Asset -->
        <div class="tab-pane fade show active" id="transfer-all-asset" role="tabpanel" aria-labelledby="tab-transfer-all-asset">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Pending All Transfered Asset</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-primary green-button" onclick="confirmMultipleActions()">Approval</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_transfer_all_asset" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Date Transfer</th>
                                <th>Current Location</th>
                                <th>Images</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php

                            $assets = array();
                            
                            $sqlAll = "SELECT a.id, a.asset_tag, a.name, a.category, a.transfer_branch, a.date_transfer, aap.picture
                            FROM aims_transfer_asset AS a
                            LEFT JOIN aims_all_asset_picture aap ON a.asset_tag = aap.asset_tag
                            WHERE status = 'TRANSFER' AND (a.date_transfer, a.start_date) = (
                                SELECT MAX(b.date_transfer), MAX(b.start_date)
                                FROM aims_transfer_asset AS b
                                WHERE b.asset_tag = a.asset_tag AND a.approval = 'PENDING'
                            )
                            UNION
                            SELECT c.id, c.asset_tag, c.name, c.category, c.transfer_branch, c.date_transfer, aap.picture
                            FROM aims_transfer_computer AS c
                            LEFT JOIN aims_all_asset_picture aap ON c.asset_tag = aap.asset_tag
                            WHERE status = 'TRANSFER' AND (c.date_transfer, c.start_date) = (
                                SELECT MAX(d.date_transfer), MAX(d.start_date)
                                FROM aims_transfer_computer AS d 
                                WHERE d.asset_tag = c.asset_tag AND c.approval = 'PENDING'
                            )
                            UNION
                            SELECT e.id, e.asset_tag, e.name, e.category, e.transfer_branch, e.date_transfer, aap.picture
                            FROM aims_transfer_electronics AS e
                            LEFT JOIN aims_all_asset_picture aap ON e.asset_tag = aap.asset_tag
                            WHERE status = 'TRANSFER' AND (e.date_transfer, e.start_date) = (
                                SELECT MAX(f.date_transfer), MAX(f.start_date)
                                FROM aims_transfer_electronics AS f 
                                WHERE f.asset_tag = e.asset_tag AND e.approval = 'PENDING'
                            )";
                            $queryAll = mysqli_query($con, $sqlAll);

                            while ($row = mysqli_fetch_assoc($queryAll)) {
                                $assetTag = $row['asset_tag'];
                                if (!isset($assets[$assetTag])) {
                                    $assets[$assetTag] = array(
                                        'id' => $row['id'], // Add 'id' to the array
                                        'asset_tag' => $assetTag,
                                        'name' => $row['name'],
                                        'category' => $row['category'],
                                        'date_transfer' => $row['date_transfer'],
                                        'transfer_branch' => $row['transfer_branch'],
                                        'images' => array($row['picture']) // Store the first image in the array
                                    );
                                } else {
                                    // If the asset already exists in the array, add the additional image
                                    $assets[$assetTag]['images'][] = $row['picture'];
                                }
                            }
                            foreach ($assets as $asset) {
                                echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                                echo "<td><input type='checkbox' name='approve_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                                echo "<td>".$asset['asset_tag']."</td>";
                                echo "<td>".$asset['name']."</td>";
                                echo "<td>".$asset['category']."</td>";
                                echo "<td>".$asset['date_transfer']."</td>";
                                echo "<td>".$asset['transfer_branch']."</td>";
                                // Displaying only the first image in the table
                                echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                                // Display the action column
                                echo "<td style='text-align:center;'>";

                                // Your action buttons here
                                if ($asset['asset_tag'][0] == 'A') {
                                    echo "
                                        <a id='transferassetEditBtn' href='./viewtransferasset?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='transferassetEditBtn' href='./edittransferasset?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='transferassetDeleteBtn' class='action-button mx-1' onclick='confirmDeleteAsset(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                    ";
                                } else if ($asset['asset_tag'][0] == 'C') {
                                    echo "
                                        <a id='transfercomputerEditBtn' href='./viewtransfercomputer?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='transfercomputerEditBtn' href='./edittransfercomputer?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='transfercomputerDeleteBtn' class='action-button mx-1' onclick='confirmDeleteComputer(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                    ";
                                } else if ($asset['asset_tag'][0] == 'E') {
                                    echo "
                                        <a id='transferelectronicsEditBtn' href='./viewtransferelectronics?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='transferelectronicsEditBtn' href='./edittransferelectronics?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='transferelectronicsDeleteBtn' class='action-button mx-1' onclick='confirmDeleteElectronics(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div>   

        <!-- Tab 2: Fixed Asset -->
        <div class="tab-pane fade" id="transfer-fixed-asset" role="tabpanel" aria-labelledby="tab-transfer-fixed-asset">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Pending Transfered Fixed Asset</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-primary green-button" onclick="confirmMultipleActions()">Approval</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_transfer_fixed_asset" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Date Transfer</th>
                                <th>Current Location</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php

                        $assets = array();
                        // query assets from aims_transfer_asset table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT a.id, a.asset_tag, a.name, a.category, a.transfer_branch, a.date_transfer, aap.picture
                                    FROM aims_transfer_asset AS a
                                    LEFT JOIN aims_all_asset_picture aap ON a.asset_tag = aap.asset_tag
                                    WHERE status = 'TRANSFER' AND (a.date_transfer, a.start_date) = (
                                        SELECT MAX(b.date_transfer), MAX(b.start_date)
                                        FROM aims_transfer_asset AS b
                                        WHERE b.asset_tag = a.asset_tag AND a.approval = 'PENDING')";

                        $queryAsset = mysqli_query($con, $sqlAsset);

                        while ($row = mysqli_fetch_assoc($queryAsset)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'], // Add 'id' to the array
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'date_transfer' => $row['date_transfer'],
                                    'transfer_branch' => $row['transfer_branch'],
                                    'images' => array($row['picture']) // Store the first image in the array
                                );
                            } else {
                                // If the asset already exists in the array, add the additional image
                                $assets[$assetTag]['images'][] = $row['picture'];
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='approve_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td>" . $asset['asset_tag'] . "</td>";
                            echo "<td>" . $asset['name'] . "</td>";
                            echo "<td>" . $asset['category'] . "</td>";
                            echo "<td>" . $asset['date_transfer'] . "</td>";
                            echo "<td>" . $asset['transfer_branch'] . "</td>";
                            // Displaying only the first image in the table
                            echo "<td><img class='asset-image' src='" . $asset['images'][0] . "' alt='Picture'></td>";
                            // Display the action column
                            echo "<td style='text-align:center;'>";
                            echo "<a id='transferfixedAssetEditBtn' href='./viewtransferasset?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;";
                            echo "<a id='transferfixedAssetEditBtn' href='./edittransferasset?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;";
                            echo "<a id='transferfixedAssetDeleteBtn' class='action-button mx-1' onclick='confirmDeleteAsset(" . $asset['id'] . ",\"" . $asset['asset_tag'] . "\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;";
                            echo "</td>";
                            echo "</tr>";

                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 3: Electronics -->
        <div class="tab-pane fade" id="transfer-electronics" role="tabpanel" aria-labelledby="tab-transfer-electronics">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Pending Transfered Electronics</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-primary green-button" onclick="confirmMultipleActions()">Approval</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_transfer_electronics" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Date Transfer</th>
                                <th>Current Location</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                    $assets = array();

                    $sqlElectronics = " SELECT e.id, e.asset_tag, e.name, e.category, e.transfer_branch, e.date_transfer, aap.picture
                                        FROM aims_transfer_electronics AS e
                                        LEFT JOIN aims_all_asset_picture aap ON e.asset_tag = aap.asset_tag
                                        WHERE status = 'TRANSFER' AND (e.date_transfer, e.start_date) = (
                                            SELECT MAX(f.date_transfer), MAX(f.start_date)
                                            FROM aims_transfer_electronics AS f 
                                            WHERE f.asset_tag = e.asset_tag AND e.approval = 'PENDING')";
                    $queryElectronics = mysqli_query($con, $sqlElectronics);

                    while ($row = mysqli_fetch_assoc($queryElectronics)) {
                        $assetTag = $row['asset_tag'];
                        if (!isset($assets[$assetTag])) {
                            $assets[$assetTag] = array(
                                'id' => $row['id'], // Add 'id' to the array
                                'asset_tag' => $assetTag,
                                'name' => $row['name'],
                                'category' => $row['category'],
                                'date_transfer' => $row['date_transfer'],
                                'transfer_branch' => $row['transfer_branch'],
                                'images' => array($row['picture']) // Store the first image in the array
                            );
                        } else {
                            // If the asset already exists in the array, add the additional image
                            $assets[$assetTag]['images'][] = $row['picture'];
                        }
                    }
                    
                    foreach ($assets as $asset) {
                        echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                        echo "<td><input type='checkbox' name='approve_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                        echo "<td><input type='checkbox' name='reject_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                        echo "<td>" . $asset['asset_tag'] . "</td>";
                        echo "<td>" . $asset['name'] . "</td>";
                        echo "<td>" . $asset['category'] . "</td>";
                        echo "<td>" . $asset['date_transfer'] . "</td>";
                        echo "<td>" . $asset['transfer_branch'] . "</td>";
                        // Displaying only the first image in the table
                        echo "<td><img class='asset-image' src='" . $asset['images'][0] . "' alt='Picture'></td>";
                        // Display the action column
                        echo "<td style='text-align:center;'>";
                        echo "<a id='transferelectronicsEditBtn' href='./viewtransferelectronics?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;";
                        echo "<a id='transferelectronicsEditBtn' href='./edittransferelectronics?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;";
                        echo "<a id='transferelectronicsDeleteBtn' class='action-button mx-1' onclick='confirmDeleteElectronics(" . $asset['id'] . ",\"" . $asset['asset_tag'] . "\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </table>
                </div>            
            </div>
        </div>
        
        <!-- Tab 4: Computer -->
        <div class="tab-pane fade" id="transfer-computer" role="tabpanel" aria-labelledby="tab-transfer-computer">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Pending Transfered Computer</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-primary green-button" onclick="confirmMultipleActions()">Approval</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_transfer_computer" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Date Transfer</th>
                                <th>Current Location</th>
                                <th>Picture</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                    $assets = array();
                    
                    $sqlComputer = "SELECT c.id, c.asset_tag, c.name, c.category, c.transfer_branch, c.date_transfer, aap.picture 
                                    FROM aims_transfer_computer AS c
                                    LEFT JOIN aims_all_asset_picture aap ON c.asset_tag = aap.asset_tag
                                    WHERE status = 'TRANSFER' AND (c.date_transfer, c.start_date) = (
                                    SELECT MAX(d.date_transfer), MAX(d.start_date) 
                                    FROM aims_transfer_computer AS d 
                                    WHERE d.asset_tag = c.asset_tag AND c.approval = 'PENDING')";
                    $queryComputer = mysqli_query($con, $sqlComputer);
                    
                    while ($row = mysqli_fetch_assoc($queryComputer)) {
                        $assetTag = $row['asset_tag'];
                        if (!isset($assets[$assetTag])) {
                            $assets[$assetTag] = array(
                                'id' => $row['id'], // Add 'id' to the array
                                'asset_tag' => $assetTag,
                                'name' => $row['name'],
                                'category' => $row['category'],
                                'date_transfer' => $row['date_transfer'],
                                'transfer_branch' => $row['transfer_branch'],
                                'images' => array($row['picture']) // Store the first image in the array
                            );
                        } else {
                            // If the asset already exists in the array, add the additional image
                            $assets[$assetTag]['images'][] = $row['picture'];
                        }
                    }
                    
                    foreach ($assets as $asset) {
                        echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                        echo "<td><input type='checkbox' name='approve_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                        echo "<td>" . $asset['asset_tag'] . "</td>";
                        echo "<td>" . $asset['name'] . "</td>";
                        echo "<td>" . $asset['category'] . "</td>";
                        echo "<td>" . $asset['date_transfer'] . "</td>";
                        echo "<td>" . $asset['transfer_branch'] . "</td>";
                        // Displaying only the first image in the table
                        echo "<td><img class='asset-image' src='" . $asset['images'][0] . "' alt='Picture'></td>";
                        // Display the action column
                        echo "<td style='text-align:center;'>";
                        echo "<a id='transfercomputerEditBtn' href='./viewtransfercomputer?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;";
                        echo "<a id='transfercomputerEditBtn' href='./edittransfercomputer?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;";
                        echo "<a id='transfercomputerDeleteBtn' class='action-button mx-1' onclick='confirmDeleteComputer(" . $asset['id'] . ",\"" . $asset['asset_tag'] . "\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;";
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 5: All Rejects -->
        <div class="tab-pane fade show" id="transfer-all-reject" role="tabpanel" aria-labelledby="tab-transfer-all-reject">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>All Rejects</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmAction()">Finalize</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_transfer_all_reject" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Date Transfer</th>
                                <th>Current Location</th>
                                <th>Images</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php

                            $assets = array();
                            
                            $sqlAll = "SELECT a.id, a.asset_tag, a.name, a.category, a.transfer_branch, a.date_transfer, aap.picture
                            FROM aims_transfer_asset AS a
                            LEFT JOIN aims_all_asset_picture aap ON a.asset_tag = aap.asset_tag
                            WHERE status = 'TRANSFER' AND (a.date_transfer, a.start_date) = (
                                SELECT MAX(b.date_transfer), MAX(b.start_date)
                                FROM aims_transfer_asset AS b
                                WHERE b.asset_tag = a.asset_tag AND a.approval = 'REJECT'
                            )
                            UNION
                            SELECT c.id, c.asset_tag, c.name, c.category, c.transfer_branch, c.date_transfer, aap.picture
                            FROM aims_transfer_computer AS c
                            LEFT JOIN aims_all_asset_picture aap ON c.asset_tag = aap.asset_tag
                            WHERE status = 'TRANSFER' AND (c.date_transfer, c.start_date) = (
                                SELECT MAX(d.date_transfer), MAX(d.start_date)
                                FROM aims_transfer_computer AS d 
                                WHERE d.asset_tag = c.asset_tag AND c.approval = 'REJECT'
                            )
                            UNION
                            SELECT e.id, e.asset_tag, e.name, e.category, e.transfer_branch, e.date_transfer, aap.picture
                            FROM aims_transfer_electronics AS e
                            LEFT JOIN aims_all_asset_picture aap ON e.asset_tag = aap.asset_tag
                            WHERE status = 'TRANSFER' AND (e.date_transfer, e.start_date) = (
                                SELECT MAX(f.date_transfer), MAX(f.start_date)
                                FROM aims_transfer_electronics AS f 
                                WHERE f.asset_tag = e.asset_tag AND e.approval = 'REJECT'
                            )";
                            $queryAll = mysqli_query($con, $sqlAll);

                            while ($row = mysqli_fetch_assoc($queryAll)) {
                                $assetTag = $row['asset_tag'];
                                if (!isset($assets[$assetTag])) {
                                    $assets[$assetTag] = array(
                                        'id' => $row['id'], // Add 'id' to the array
                                        'asset_tag' => $assetTag,
                                        'name' => $row['name'],
                                        'category' => $row['category'],
                                        'date_transfer' => $row['date_transfer'],
                                        'transfer_branch' => $row['transfer_branch'],
                                        'images' => array($row['picture']) // Store the first image in the array
                                    );
                                } else {
                                    // If the asset already exists in the array, add the additional image
                                    $assets[$assetTag]['images'][] = $row['picture'];
                                }
                            }
                            foreach ($assets as $asset) {
                                echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                                echo "<td><input type='checkbox' name='selected_asset_tag' value='" . $asset['asset_tag'] . "'></td>";
                                echo "<td>".$asset['asset_tag']."</td>";
                                echo "<td>".$asset['name']."</td>";
                                echo "<td>".$asset['category']."</td>";
                                echo "<td>".$asset['date_transfer']."</td>";
                                echo "<td>".$asset['transfer_branch']."</td>";
                                // Displaying only the first image in the table
                                echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                                // Display the action column
                                echo "<td style='text-align:center;'>";

                                // Your action buttons here
                                if ($asset['asset_tag'][0] == 'A') {
                                    echo "
                                        <a id='transferassetEditBtn' href='./viewtransferasset?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='transferassetEditBtn' href='./edittransferasset?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='transferassetDeleteBtn' class='action-button mx-1' onclick='confirmDeleteAsset(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                    ";
                                } else if ($asset['asset_tag'][0] == 'C') {
                                    echo "
                                        <a id='transfercomputerEditBtn' href='./viewtransfercomputer?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='transfercomputerEditBtn' href='./edittransfercomputer?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='transfercomputerDeleteBtn' class='action-button mx-1' onclick='confirmDeleteComputer(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                    ";
                                } else if ($asset['asset_tag'][0] == 'E') {
                                    echo "
                                        <a id='transferelectronicsEditBtn' href='./viewtransferelectronics?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='transferelectronicsEditBtn' href='./edittransferelectronics?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='transferelectronicsDeleteBtn' class='action-button mx-1' onclick='confirmDeleteElectronics(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;";
                                }

                                echo "</td>";
                                echo "</tr>";
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div>   
    </div>
</div>

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


<script>
    //datatable
    $(document).ready(function() {
        $('#table_transfer_all_asset').DataTable(
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
        $('#table_transfer_fixed_asset').DataTable(
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
        $('#table_transfer_electronics').DataTable(
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
        $('#table_transfer_computer').DataTable(
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
        $('#table_transfer_all_reject').DataTable(
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

    function confirmMultipleActions() {
        var selectedAssetTags = $('input[name="approve_asset_tag[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (selectedAssetTags.length > 0) {
            Swal.fire({
                title: "Select Action",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "Approve",
                confirmButtonText: "Reject",
                customClass: {
                    container: 'custom-swal-container'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleMultipleActions(selectedAssetTags, 'reject');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    handleMultipleActions(selectedAssetTags, 'approve');
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'No pending transfer assets selected for approval/rejection.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function handleMultipleActions(assetTags, action) {
        var actionUrl = (action === 'approve') ? './module/approval/approve_transfer_multiple.php"' : './module/approval/reject_transfer_multiple.php';

        $.ajax({
            url: actionUrl,
            type: "POST",
            data: { asset_asset_tag: assetTags },
            success: function(response) {
                // Handle the server response here if needed
                var successMessage = (action === 'approve') ? 'approved' : 'rejected';
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The selected assets have been ' + successMessage + '.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_transfer';
                });
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                var errorMessage = (action === 'approve') ? 'approving' : 'rejecting';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while ' + errorMessage + ' the selected assets.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_transfer';
                });
            }
        });
    }

    function confirmAction() {
        var selectedAssetTag = $('input[name="selected_asset_tag"]:checked').val();

        if (selectedAssetTag) {
            Swal.fire({
                title: "Select Action",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Approve",
                cancelButtonText: "Delete",
                reverseButtons: true, // Add this line
                customClass: {
                    confirmButton: 'custom-swal-cancel', // Swap classes due to reverseButtons
                    cancelButton: 'custom-swal-confirm' // Swap classes due to reverseButtons
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleMultipleActions([selectedAssetTag], 'approve');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    handleMultipleActions([selectedAssetTag], 'delete');
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'No pending transfer asset selected for approval/delete.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function handleMultipleActions(assetTags, action) {
        var actionUrl = (action === 'approve') ? "./module/approval/approve_transfer_multiple.php" : "./module/approval/delete_transfer_multiple.php";

        $.ajax({
            url: actionUrl,
            type: "POST",
            data: { asset_asset_tag: assetTags },
            success: function(response) {
                var successMessage = (action === 'approve') ? 'approved' : 'deleted';
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The selected asset has been ' + successMessage + '.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_transfer';
                });
            },
            error: function(xhr, status, error) {
                var errorMessage = (action === 'approve') ? 'approving' : 'deleting';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while ' + errorMessage + ' the selected asset.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_transfer';
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
                deleteAsset(id, asset_tag);
            }
        });
    }

    function deleteAsset(id, asset_tag) {
        $.ajax({
            url: "./module/transfer/asset/deleteasset_transfer_action.php",
            type: "POST",
            data: { id: id, asset_tag: asset_tag }, // Pass both id and asset_tag as data
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The asset has been deleted.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function () {
                    window.location.href = './transfer';
                });
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the asset.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function () {
                    window.location.href = './transfer';
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
            deleteElectronics(id, asset_tag);
        }
        });
        }

    function deleteElectronics(id, asset_tag) {
        $.ajax({
        url: "./module/transfer/electronics/deleteelectronics_transfer_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id, asset_tag: asset_tag }, // Pass both id and asset_tag as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The electronics has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './transfer';
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
                window.location.href = './transfer';
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
            deleteComputer(id, asset_tag);
        }
        });
        }

    function deleteComputer(id, asset_tag) {
        $.ajax({
        url: "./module/transfer/computer/deletecomputer_transfer_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id, asset_tag: asset_tag }, // Pass both id and asset_tag as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The computer has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './transfer';
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
                window.location.href = './transfer';
            });
        }
        });
    }

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
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .property-image').attr('src', newImageUrl);

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
        $('#table_transfer_all_asset, #table_transfer_fixed_asset, #table_transfer_electronics, #table_transfer_computer, #table_transfer_vehicle, #table_transfer_property').on('click', '.asset-image', function () {
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
                $('tr[data-asset-tag="' + assetTag + '"] .property-image').attr('src', storedImageUrl);
            }
        }
    });

</script>