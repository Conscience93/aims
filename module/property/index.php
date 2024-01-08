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

    #table_all_property img,
    #table_residential img,
    #table_commercial img,
    #table_specialized img,
    #table_land img {
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
            <a class="nav-link active" id="tab-all-property" data-toggle="tab" href="#all-property" role="tab" aria-controls="all-property" aria-selected="true">
                All (<?php
                    $sqlTotalAll = "SELECT
                        (SELECT COUNT(*) FROM aims_property_residential WHERE status='ACTIVE') +
                        (SELECT COUNT(*) FROM aims_property_commercial WHERE status='ACTIVE') +
                        (SELECT COUNT(*) FROM aims_property_specialized WHERE status='ACTIVE') +
                        (SELECT COUNT(*) FROM aims_property_land WHERE status='ACTIVE') AS total_count";
                    $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                    $totalAll = mysqli_fetch_assoc($queryTotalAll)['total_count'];
                    echo $totalAll;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-residential" data-toggle="tab" href="#residential" role="tab" aria-controls="residential" aria-selected="false">
                Residential (<?php
                        $sqlTotaResidential = "SELECT id FROM aims_property_residential WHERE status='ACTIVE'";
                        $queryTotaResidential = mysqli_query($con, $sqlTotaResidential);
                        $totaResidential = mysqli_num_rows($queryTotaResidential);
                    echo $totaResidential;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-commercial" data-toggle="tab" href="#commercial" role="tab" aria-controls="commercial" aria-selected="false">
                Commercial (<?php
                        $sqlTotalCommercial = "SELECT id FROM aims_property_commercial WHERE status='ACTIVE'";
                        $queryTotalCommercial = mysqli_query($con, $sqlTotalCommercial);
                        $totalCommercial = mysqli_num_rows($queryTotalCommercial);
                    echo $totalCommercial;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-specialized" data-toggle="tab" href="#specialized" role="tab" aria-controls="specialized" aria-selected="false">
                Specialized (<?php
                        $sqlTotalSpecialized = "SELECT id FROM aims_property_specialized WHERE status='ACTIVE'";
                        $queryTotalSpecialized = mysqli_query($con, $sqlTotalSpecialized);
                        $totalSpecialized = mysqli_num_rows($queryTotalSpecialized);
                    echo $totalSpecialized;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-land" data-toggle="tab" href="#land" role="tab" aria-controls="land" aria-selected="false">
                Land (<?php
                        $sqlTotalLand = "SELECT id FROM aims_property_land WHERE status='ACTIVE'";
                        $queryTotalLand = mysqli_query($con, $sqlTotalLand);
                        $totalLand = mysqli_num_rows($queryTotalLand);
                    echo $totalLand;
                ?>)
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: All Property -->
        <div class="tab-pane fade show active" id="all-property" role="tabpanel" aria-labelledby="tab-all-property">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>All Property</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="./addproperty" class="btn btn-info">Add Property</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_all_property" class="striped-table">
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

                        $sqlAll = "SELECT pr.id, pr.asset_tag, pr.name, pr.category, pr.status, pr.price, app.picture
                                FROM aims_property_residential pr
                                LEFT JOIN aims_all_property_picture app ON pr.asset_tag = app.asset_tag
                                WHERE pr.status='ACTIVE'
                                UNION

                                SELECT pc.id, pc.asset_tag, pc.name, pc.category, pc.status, pc.price, app.picture
                                FROM aims_property_commercial pc 
                                LEFT JOIN aims_all_property_picture app ON pc.asset_tag = app.asset_tag
                                WHERE pc.status='ACTIVE'
                                UNION

                                SELECT ps.id, ps.asset_tag, ps.name, ps.category, ps.status, ps.price, app.picture
                                FROM aims_property_specialized ps 
                                LEFT JOIN aims_all_property_picture app ON ps.asset_tag = app.asset_tag
                                WHERE ps.status='ACTIVE'
                                UNION
                                
                                SELECT pl.id, pl.asset_tag, pl.name, pl.category, pl.status, pl.price, app.picture
                                FROM aims_property_land pl 
                                LEFT JOIN aims_all_property_picture app ON pl.asset_tag = app.asset_tag
                                WHERE pl.status='ACTIVE'"; 
                                
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
                            echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            // Add your action buttons here
                            if (strpos($asset['asset_tag'], 'PR') === 0) {
                                echo "
                                    <a id='residentialEditBtn' href='./viewresidential?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='residentialEditBtn' href='./editresidential?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                ";
                            } elseif (strpos($asset['asset_tag'], 'PC') === 0) {
                                echo "
                                    <a id='commercialEditBtn' href='./viewcommercial?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='commercialEditBtn' href='./editcommercial?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                ";
                            } elseif (strpos($asset['asset_tag'], 'PS') === 0) {
                                echo "
                                    <a id='specializedEditBtn' href='./viewspecialized?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='specializedEditBtn' href='./editspecialized?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                ";
                            } elseif (strpos($asset['asset_tag'], 'PL') === 0) {
                                echo "
                                    <a id='landEditBtn' href='./viewland?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='landEditBtn' href='./editland?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
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

        <!-- Tab 2: Residential -->
        <div class="tab-pane fade" id="residential" role="tabpanel" aria-labelledby="tab-residential">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Residential</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="./addproperty" class="btn btn-info">Add Property</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_residential" class="striped-table">
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
                        // Query assets from aims_property_residential table with pictures from aims_all_property_picture table
                        $sqlResidential = "SELECT pr.id, pr.asset_tag, pr.name, pr.category, pr.price, app.picture
                                    FROM aims_property_residential pr
                                    LEFT JOIN aims_all_property_picture app ON pr.asset_tag = app.asset_tag
                                    WHERE pr.status='ACTIVE'";
                        $queryResidential = mysqli_query($con, $sqlResidential);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryResidential)) {
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
                            echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='residentialEditBtn' href='./viewresidential?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='residentialEditBtn' href='./editresidential?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 3: Commercial -->
        <div class="tab-pane fade" id="commercial" role="tabpanel" aria-labelledby="tab-commercial">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Commercial</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="./addproperty" class="btn btn-info">Add Property</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_commercial" class="striped-table">
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
                        // Query assets from aims_property_commercial table with pictures from aims_all_property_picture table
                        $sqlResidential = "SELECT pc.id, pc.asset_tag, pc.name, pc.category, pc.price, app.picture
                                    FROM aims_property_commercial pc
                                    LEFT JOIN aims_all_property_picture app ON pc.asset_tag = app.asset_tag
                                    WHERE pc.status='ACTIVE'";
                        $queryResidential = mysqli_query($con, $sqlResidential);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryResidential)) {
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
                            echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='commercialEditBtn' href='./viewcommercial?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='commercialEditBtn' href='./editcommercial?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 4: Specialized -->
        <div class="tab-pane fade" id="specialized" role="tabpanel" aria-labelledby="tab-specialized">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Specialized</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="./addproperty" class="btn btn-info" style="margin-left: 5px;">Add Property</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_specialized" class="striped-table">
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
                        // Query assets from aims_property_specialized table with pictures from aims_all_property_picture table
                        $sqlResidential = "SELECT ps.id, ps.asset_tag, ps.name, ps.category, ps.price, app.picture
                                    FROM aims_property_specialized ps
                                    LEFT JOIN aims_all_property_picture app ON ps.asset_tag = app.asset_tag
                                    WHERE ps.status='ACTIVE'";
                        $queryResidential = mysqli_query($con, $sqlResidential);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryResidential)) {
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
                            echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='specializedEditBtn' href='./viewspecialized?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='specializedEditBtn' href='./editspecialized?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tab 5: Land -->
        <div class="tab-pane fade" id="land" role="tabpanel" aria-labelledby="tab-land">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Land</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="./addproperty" class="btn btn-info" style="margin-left: 5px;">Add Property</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_land" class="striped-table">
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
                        // Query assets from aims_property_land table with pictures from aims_all_property_picture table
                        $sqlResidential = "SELECT pl.id, pl.asset_tag, pl.name, pl.category, pl.price, app.picture
                                    FROM aims_property_land pl
                                    LEFT JOIN aims_all_property_picture app ON pl.asset_tag = app.asset_tag
                                    WHERE pl.status='ACTIVE'";
                        $queryResidential = mysqli_query($con, $sqlResidential);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryResidential)) {
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
                            echo "<td><img class='asset-image' src='".$asset['images'][0]."' alt='Picture'></td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='landEditBtn' href='./viewland?id=" . $asset['id'] . "' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='landEditBtn' href='./editland?id=" . $asset['id'] . "' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
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

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    //datatable
    $(document).ready(function() {
        $('#table_all_property').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            }
        );
        $('#table_residential').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            }
        );
        $('#table_commercial').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            }
        );
        $('#table_specialized').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            }
        );
        $('#table_land').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 5 }
                ]
            }
        );
    });

    function confirmDeleteMultiple() {
        var selectedAssetTags = $('input[name="asset_asset_tag[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (selectedAssetTags.length > 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to delete selected property. This process is irreversible!",
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
                text: 'No property selected for deletion.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function deleteMultiple(assetTags) {
        $.ajax({
            url: "./module/property/delete_multiple.php",
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
                    window.location.href = './property';
                });
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the selected property.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './property';
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
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .residential-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .commercial-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .specialized-image').attr('src', newImageUrl);
                $('tr[data-asset-tag="' + selectedAssetTag + '"] .land-image').attr('src', newImageUrl);

                // Store the updated image source in PHP session
                $.ajax({
                    url: './module/property/store_image_session.php', // Replace with the actual URL to your server-side script
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
        $('#table_all_property, #table_commercial, #table_residential, #table_specialized, #table_land').on('click', '.asset-image', function () {
            var assetTag = $(this).closest('tr').data('asset-tag');
            var mainImageUrl = $(this).attr('src');

            // Fetch additional images using AJAX
            $.ajax({
                url: './module/property/fetch_additional_images.php', // Replace with the actual URL to your server-side script
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
                $('tr[data-asset-tag="' + assetTag + '"] .residential-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .commercial-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .specialized-image').attr('src', storedImageUrl);
                $('tr[data-asset-tag="' + assetTag + '"] .land-image').attr('src', storedImageUrl);
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
        xhr.open('GET', 'viewresidential.php?pictureSrc=' + encodeURIComponent(pictureSrc), true);
        xhr.send();
    }

</script>