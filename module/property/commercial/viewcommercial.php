<?php
if ($submodule_access['asset']['view'] != 1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_property_commercial WHERE id ='" . $_GET['id'] . "'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sql3 = "SELECT * FROM aims_izzat WHERE asset_tag = '" . $row['asset_tag'] . "'";
$result3 = mysqli_query($con, $sql3);
$asset_tag = mysqli_fetch_assoc($result3);
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
                                <a class="btn btn-primary" href='./module/property/commercial/print.php?id=<?php echo $row['id']; ?>' target="_blank" title="Print">Print</a>
                                <a href="./property" class="btn btn-danger">Back</a>
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
                                    <label class="col-2" for="category"><b>Category: </b></label>
                                    <span class="col-3" id="category" name="category"><?php echo $row['category']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="built_up_size"><b>Built Up Size: </b></label>
                                    <span class="col-3" id="built_up_size" name="built_up_size"><?php echo $row['built_up_size']; ?>sq. ft</span>
                                    <label class="col-2" for="built_up_price"><b>Built Up Price: </b></label>
                                    <span class="col-3" id="built_up_price" name="built_up_price">RM<?php echo $row['built_up_price']; ?>per sq. ft.</span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="land_area_size"><b>Land Area Size: </b></label>
                                    <span class="col-3" id="land_area_size" name="land_area_size"><?php echo $row['land_area_size']; ?>sq. ft</span>
                                    <label class="col-2" for="land_area_price"><b>Land Area Price: </b></label>
                                    <span class="col-4" id="land_area_price" name="land_area_price">RM<?php echo $row['land_area_price']; ?>per sq. ft.</span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="floor"><b>No. of Floor(s): </b></label>
                                    <span class="col-3" id="floor" name="floor"><?php echo $row['floor']; ?></span>
                                    <label class="col-2" for="remarks"><b>Remarks: </b></label>
                                    <span class="col-3" id="remarks" name="remarks"><?php echo $row['remarks']; ?></span>
                                </div>
                                <div class="row">
                                    <label class="col-2" for="address"><b>Address: </b></label>
                                    <span class="col-4" id="address" name="address"><?php echo $row['address']; ?></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <h4>Image Gallery</h4>
                                    <div id="mainPictureContainer">
                                        <?php
                                        // Fetch the first picture from aims_all_property_picture
                                        $sqlFirstPicture = "SELECT picture FROM aims_all_property_picture WHERE asset_tag = '" . $row['asset_tag'] . "' LIMIT 1";
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
                                    // Fetch all pictures from aims_all_property_picture
                                    $sqlPictures = "SELECT picture FROM aims_all_property_picture WHERE asset_tag = '" . $row['asset_tag'] . "'";
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

        <!-- Tab: Files -->
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
                    </div>
                </div>           
            </div>
        </div>
    </div>
</div>

<script>
    //JavaScript function to change the main picture when a thumbnail is clicked
    function changeMainPicture(pictureUrl) {
        document.getElementById('mainPicture').src = pictureUrl;

    }
</script>