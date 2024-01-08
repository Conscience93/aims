<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_transfer_computer where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM aims_computer WHERE asset_tag = '" . $row['asset_tag'] . "'";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);

// Function to fetch pictures
function getPicture($con, $assetTag) {
    $pictures = array();
    $sql = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag = '$assetTag'";
    $result = mysqli_query($con, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $pictures[] = $row['picture'];
        }
    }

    return $pictures;
}
?>

<style>
    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    textarea {
        resize: none;
    }

    span {
        height: 2.5rem;
    }

    /* Define styles for odd rows in striped-tables */
    table.striped-table tr:nth-child(odd) {
            background-color: #f2f2f2; /* Set the background color for odd data rows */
    }

    /* Define styles for even rows in striped-tables */
    table.striped-table tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even data rows */
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


<div class="main">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-information" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="true">
                Information 
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link " id="tab-transfer" data-toggle="tab" href="#transfer" role="tab" aria-controls="transfer" aria-selected="true">
                Transfer Details 
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- View Asset -->
        <div class="tab-pane fade show active" id="information" role="tabpanel" aria-labelledby="tab-information">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./transfer" class="btn btn-danger">Cancel</a>
                                <a class="btn btn-primary" href='./module/transfer/computer/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="printableContent">
                    <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                    <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>

                    <div class = "row">
                        <div class="col-7">
                            <h4>Basic Information</h4>
                            <div class="row">
                                <label class="col-3" for="name"><b>Name: </b></label>
                                <span class="col-5" id="name" name="name" ><?php echo $row['name'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="c_category"><b>Category: </b></label>
                                <span class="col-5" id="c_category" name="c_category"><?php echo $row['category'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="date_transfer"><b>Date Transfer: </b></label>
                                <span class="col-5" id="date_transfer" name="date_transfer"><?php echo $row['date_transfer'];?></span>
                            </div>
                            
                            <br>

                            <div class="row">
                                <div class="col-7">
                                    <h4>Current Location</h4>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3" for="transfer_branch"><b>Building/Branch: </b></label>
                                <span class="col-5" id="transfer_branch" name="transfer_branch"><?php echo $row['transfer_branch'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="transfer_department"><b>Department: </b></label>
                                <span class="col-5" id="transfer_department" name="transfer_department"><?php echo $row['transfer_department'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-3" for="transfer_location"><b>Location: </b></label>
                                <span class="col-5" id="transfer_location" name="transfer_location"><?php echo $row['transfer_location'];?></span>
                            </div>

                            <br>

                            <div class="row">
                                <div class="col-7">
                                    <h4>Files</h4>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-3" for="invoice"><b>Invoice: </b></label>
                                <?php
                                if (!empty($row2['invoice'])) {
                                    $fileName = basename($row2['invoice']);
                                    echo '<a href="' . $row2['invoice'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>                            
                            </div>
                            <div class="row">
                                <label class="col-3" for="document"><b>Document: </b></label>
                                <?php
                                if (!empty($row2['document'])) {
                                    $fileName = basename($row2['document']);
                                    echo '<a href="' . $row2['document'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>                            
                            </div>
                            <div class="row">
                                <label class="col-3" for="warranty"><b>Warranty: </b></label>
                                <?php
                                if (!empty($row2['warranty'])) {
                                    $fileName = basename($row2['warranty']);
                                    echo '<a href="' . $row2['warranty'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
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
        
        <div class="tab-pane fade" id="transfer" role="tabpanel" aria-labelledby="tab-transfer">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h4>Transfer History</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a class="btn btn-primary" href='./module/transfer/computer/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                                <a href="./transfer" class="btn btn-danger">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_transfer" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date Transfer</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Location</th>
                            </tr>
                        </thead>
                        <?php
                        $sqlTransfer = "SELECT * FROM aims_transfer_computer WHERE asset_tag ='" . $row['asset_tag'] . "'";
                        $queryTransfer = mysqli_query($con, $sqlTransfer);

                        $rowCount = 1; // Initialize the row counter

                        while ($rowTransfer = mysqli_fetch_assoc($queryTransfer)) {
                            // Move the following code inside the loop
                            $sql4 = "SELECT * FROM aims_transfer_computer where name ='" . $rowTransfer['name'] . "'";
                            $result4 = mysqli_query($con, $sql4);
                            $name = mysqli_fetch_assoc($result4);

                            echo "<tr>";
                            echo "<td>" . $rowCount . "</td>";
                            echo "<td>" . $rowTransfer['date_transfer'] . "</td>";
                            echo "<td>" . $rowTransfer['transfer_branch'] . "</td>";
                            echo "<td>" . $rowTransfer['transfer_department'] . "</td>";
                            echo "<td>" . $rowTransfer['transfer_location'] . "</td>";
                            echo "</tr>";
                            $rowCount++; // Increment the row counter
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>  
</div> 

<script>
$(document).ready(function() {
    $('#table_transfer').DataTable({
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