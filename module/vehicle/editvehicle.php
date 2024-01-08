<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_vehicle where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    .main span {
        height: 2.3rem;
    }

    form .btn-delete-file {
        width: 75px !important;
    }

    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
</style>

<div class="main">
    <form action=".\module\vehicle\editvehicle_action.php" method="POST" enctype="multipart/form-data">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./vehicle" class="btn btn-danger">Discard</a>
                        <button type="submit" class="btn btn-primary">Save</button> 
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
            <input id="asset_tag" name="asset_tag" value="<?php echo $row['asset_tag'];?>" hidden>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name'];?>" class="form-control" required>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">Select Category</option>
                                <?php 
                                $sql_categories = "SELECT * FROM aims_vehicle_category_run_no";
                                $result_categories = mysqli_query($con, $sql_categories);
                                while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                    $categories[] = $row_categories;
                                }
                                if ($categories == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else
                                foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['display_name']; ?>" <?php if($row['category'] == $category['display_name']) {echo 'selected';} ?>><?php echo $category['display_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                     <!-- plate_no -->
                     <div class="col-2">
                        <div class="form-group">
                            <label for="plate_no">Plate No.</label>
                            <input type="text" id="plate_no" name="plate_no" placeholder="" value="<?php echo $row['plate_no'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- brand -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" id="brand" name="brand" placeholder="" value="<?php echo $row['brand'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- roadtax_expiry -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="roadtax_expiry">Roadtax Expiry Date</label>
                            <input type="date" id="roadtax_expiry" name="roadtax_expiry" placeholder="" value="<?php echo $row['roadtax_expiry'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- date purchase -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date purchase">Date Purchase</label>
                            <input type="datetime-local" id="date purchase" name="date purchase" placeholder="Date Purchase" value="<?php echo $row['date_purchase'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" placeholder="Price in Ringgit" value="<?php echo $row['price'];?>" class="form-control"  step="any">
                        </div>
                    </div>
                    <!-- value -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="value">Value (RM)</label>
                            <input type="number" id="value" name="value" placeholder=""  value="<?php echo $row['value'];?>" class="form-control" step="any">
                        </div>
                    </div>
                    <!-- branch -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list="branchList" name="branch" value="<?php echo $row['branch'];?>" id="branch" class="form-control">
                                <datalist id="branchList">    
                                    <option value="">Select Building/Branch</option>
                                    <?php  
                                    $sql_branchs = "SELECT * FROM aims_preset_computer_branch";
                                    $result_branchs = mysqli_query($con, $sql_branchs);
                                    while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                        $branchs[] = $row_branchs;
                                    }
                                    if ($branchs == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else {
                                        foreach ($branchs as $branch): ?>
                                            <option value="<?php echo $branch['display_name']; ?>" <?php if($row['branch'] == $branch['display_name']) {echo 'selected';} ?>><?php echo $branch['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- start_warranty  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="warranty">Start Warranty</label>
                            <input type="date" id="start_warranty" name="start_warranty" placeholder="Start Date of Warranty" value="<?php echo $row['start_warranty']; ?>" class="form-control">
                        </div>
                    </div>
                    <!-- end_warranty -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="end_warranty">End Warranty</label>
                            <input type="date" id="end_warranty" name="end_warranty" placeholder="End Date of Warranty" value="<?php echo $row['end_warranty']; ?>" class="form-control">
                        </div>
                    </div>
                    <!-- remarks  -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="remarks">Remarks</label><br>
                            <textarea id="remarks" name="remarks" placeholder="Additional Notes" class="form-control"><?php echo $row['remarks']; ?></textarea>
                        </div>
                    </div>
                </div>   
                
                <hr>

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Dealership Details</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- dealership -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="dealership">Name</label>
                            <input list="dealershipList" name="dealership" value="<?php echo $row['dealership'];?>" id="dealership" class="form-control" autofocus oninput = "getDealershipDetails(this.value)">
                                <datalist id="dealershipList">                      
                                    <option value="">Select dealership</option>
                                    <?php 
                                    $sql_dealerships = "SELECT * FROM aims_people_dealership";
                                    $result_dealerships = mysqli_query($con, $sql_dealerships);
                                    while ($row_dealerships = mysqli_fetch_assoc($result_dealerships)) {
                                        $dealerships[] = $row_dealerships;
                                    } if ($dealerships == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($dealerships as $dealership): ?>
                                        <option value="<?php echo $dealership['display_name']; ?>" <?php if($row['dealership'] == $dealership['display_name']) {echo 'selected';} ?>><?php echo $dealership['display_name']; ?></option>
                                    <?php endforeach; ?>
                                <datalist id="dealershipList">
                            </select>
                        </div>
                    </div>
                    <!-- dealership pic -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="dealership_pic">Contact Person</label>
                            <span id="dealership_pic" name="dealership_pic" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- dealership phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="dealership_contact_no">Contact Number</label>
                            <span id="dealership_contact_no" name="dealership_contact_no" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                     <!-- dealership email -->
                     <div class="col-3">
                        <div class="form-group">
                            <label for="dealership_email">Email</label>
                            <span id="dealership_email" name="dealership_email" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- dealership fax number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="dealership_fax">Fax Number</label>
                            <span id="dealership_fax" name="dealership_fax" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- dealership location -->
                    <div class="col-10">
                        <div class="form-group">
                            <label for="dealership_address">Address</label>
                            <span id="dealership_address" name="dealership_address" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                </div>


                <hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Files</h4>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="invoice">Invoice</label></br>
                            <?php
                            if (!empty($row['invoice'])) {
                                $fileName = basename($row['invoice']);
                                echo '<div class="md-3 form-control"><a href="' . $row['invoice'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-invoice-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="invoice">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-invoice-form" onclick="confirmDeleteFile('.$row['id'].',\'invoice\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="invoice" name="invoice" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-3">
                        <div class="form-group">
                            <label for="document">Document</label></br>
                            <?php
                            if (!empty($row['document'])) {
                                $fileName = basename($row['document']);
                                echo '<div class="md-3 form-control"><a href="' . $row['document'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-document-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="document">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-document-form" onclick="confirmDeleteFile('.$row['id'].',\'document\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="document" name="document" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="warranty">Warranty</label></br>
                            <?php
                            if (!empty($row['warranty'])) {
                                $fileName = basename($row['warranty']);
                                echo '<div class="md-3 form-control"><a href="' . $row['warranty'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-warranty-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="warranty">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-warranty-form" onclick="confirmDeleteFile('.$row['id'].',\'warranty\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="warranty" name="warranty" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="roadtax">Roadtax</label></br>
                            <?php
                            if (!empty($row['roadtax'])) {
                                $fileName = basename($row['roadtax']);
                                echo '<div class="md-3 form-control"><a href="' . $row['roadtax'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-roadtax-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="roadtax">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-roadtax-form" onclick="confirmDeleteFile('.$row['id'].',\'roadtax\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="roadtax" name="roadtax" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="form-group">
                            <label for="insurance">Insurance</label></br>
                            <?php
                            if (!empty($row['insurance'])) {
                                $fileName = basename($row['insurance']);
                                echo '<div class="md-3 form-control"><a href="' . $row['insurance'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-insurance-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="insurance">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-insurance-form" onclick="confirmDeleteFile('.$row['id'].',\'insurance\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="insurance" name="insurance" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Picture</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button class="btn btn-info" type="button" onclick="createPicture()">Add More Picture</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>View</th>
                            <th>Picture</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="existing-picture-table">
                    <?php 
                        $sql_picture = "SELECT * FROM aims_all_asset_picture";
                        $result_picture = mysqli_query($con, $sql_picture);
                        while ($row_picture = mysqli_fetch_assoc($result_picture)) {
                            $pictures[] = $row_picture;
                        }

                        $sql_picture = "SELECT * FROM aims_all_asset_picture where asset_tag ='".$row['asset_tag']."'";
                        $result_picture = mysqli_query($con, $sql_picture);
                        $j = 0;
                        while ($row_picture = mysqli_fetch_assoc($result_picture)) {
                        ?>
                        <tr>
                            <input type="text" id="picture_id[]" name="picture_id[]" value="<?php echo $row_picture['id'];?>" hidden>
                            <td>
                                <input type="text" id="view[]" name="view[]" value="<?php echo $row_picture['view'];?>" class="form-control" >
                            </td>
                            <td>
                                <?php
                                if (!empty($row_picture['picture'])) {
                                    $fileName = basename($row_picture['picture']);
                                    echo '<div class="md-3 form-control"><a href="' . $row_picture['picture'] . '" target="_blank">' . $fileName . '</a></div>';
                                    echo '<br>';
                                    echo 
                                    '<form id="delete-picture-form" action="./module/computer/deletefile_action.php" method="POST">
                                        <input type="hidden" name="fileType" value="picture">
                                        <input type="hidden" name="id" value="'.$row_picture['id'].'">
                                    </form>';
                                } else {
                                    echo '<input type="file" id="picture" name="picture" accept="" value="" class="form-control" />';
                                }
                                ?>
                            </td>                       
                            <td>
                                <button class="btn btn-danger btn-delete-file" type="button" onclick="
                                confirmDeleteExistingPicture(
                                    this,
                                    '<?php echo $row_picture['id'];?>',
                                    '<?php echo $row_picture['view'];?>',
                                    '<?php echo $row['id'];?>',
                                    )">Delete</button></td>
                                <?php  ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="picture-table">
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<script>
// submit using ajax
$('form').submit(function(e){
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            success: function(response){
                // console.log(response);
                if(response.trim()=="true"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Vehicle edited successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = './vehicle';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './editvehicle?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

function getDealershipDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/dealership/get_dealership_details_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#dealership_pic").text(data["pic"]);
                $("#dealership_contact_no").text(data["contact_no"]);
                $("#dealership_email").text(data["email"]);
                $("#dealership_fax").text(data["fax"]);
                $("#dealership_address").text(data["address"]);
            } catch (e) {
                $("#dealership_pic").text("");
                $("#dealership_contact_no").text("");
                $("#dealership_email").text("");
                $("#dealership_fax").text("");
                $("#dealership_address").text("");
            }
        }
    });
}


function createPicture() {
    var table = document.getElementById("picture-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <input type="text" id="picture_id[]" name="picture_id[]" value="" hidden>
            <td><input type="text" name="view[]" class="form-control"></td>
            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control"></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deletePicture(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deletePicture(input) {
    document.getElementById('picture-table').removeChild(input.parentNode.parentNode);
}
        
function confirmDeleteFile(id, fileType) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete the " + fileType + " file?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteFile(id, fileType);
        }
    });
}

function deleteFile(id, fileType) {
    $.ajax({
        url: "./module/vehicle/deletefile_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id, fileType: fileType}, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The file has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './editvehicle?id=' + id;
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the file.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './editvehicle?id=' + id;
            });
        }
    });
}

function confirmDeleteExistingPicture(input, id, view, asset_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete picture with " + view + " view. This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingPicture(input, id, view, asset_id);
        }
    });
}

function deleteExistingPicture(input, id, view, asset_id) {
    $.ajax({
        url: "./module/vehicle/deletepicture_action.php",
        type: "POST",
        data: {id:id, view: view},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-picture-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editvehicle?id=' + asset_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}

function confirmDeletePicture(id, fileType) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete the " + fileType + " file?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            // Pass the fileType parameter to deletePicture
            deletePicture(id, fileType);
        }
    });
}

</script>