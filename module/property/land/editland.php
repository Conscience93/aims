<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_property_land where id ='".$_GET['id']."'";
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

    .row .float-right button {
        margin-left: 5px; /* Adjust the margin as needed */
    }
</style>

<div class="main">
    <form action=".\module\property\land\editland_action.php" method="POST" enctype="multipart/form-data">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Save</button> 
                        <a href="./property" class="btn btn-danger">Discard</a>
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
                                $sql_categories = "SELECT * FROM aims_land_category_run_no";
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
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price"  value="<?php echo $row['price'];?>" class="form-control" step="any" min="0">
                        </div>
                    </div>
                    <!-- land_area_price  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="land_area_price">Land Area Price(per sq. ft.)</label>
                            <input type ="text" id="land_area_price" name="land_area_price" value="<?php echo $row['land_area_price'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- land_area_size  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="land_area_size">Land Area Size(sq. ft)</label>
                            <input type ="text" id="land_area_size" name="land_area_size" value="<?php echo $row['land_area_size'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- remarks  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="remarks">Any Remarks</label>
                            <input type ="text" id="remarks" name="remarks" value="<?php echo $row['remarks'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- address  -->
                    <div class="col-8">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type ="text" id="address" name="address" value="<?php echo $row['address'];?>" class="form-control">
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
                    <!-- document -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="document">Document</label>
                            <?php
                            if (!empty($row['document'])) {
                                $fileName = basename($row['document']);
                                echo '<div class="md-3 form-control"><a href="' . $row['document'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo 
                                '<form id="delete-document-form" action="./module/property/land/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="document">
                                    <input type="hidden" name="document_id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-document-form" onclick="confirmDeleteFile('.$row['id'].',\'document\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="document" name="document" accept="" value="" class="form-control" />';
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
                        $sql_picture = "SELECT * FROM aims_all_property_picture";
                        $result_picture = mysqli_query($con, $sql_picture);
                        while ($row_picture = mysqli_fetch_assoc($result_picture)) {
                            $pictures[] = $row_picture;
                        }

                        $sql_picture = "SELECT * FROM aims_all_property_picture where asset_tag ='".$row['asset_tag']."'";
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
                        text: 'Property edited successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = './property';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './editland?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


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
        url: "./module/property/land/deletefile_action.php", // Update the URL to your PHP script
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
                window.location.href = './editland?id=' + id;
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
                window.location.href = './editland?id=' + id;
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
        url: "./module/property/land/deletepicture_action.php",
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
                window.location.href = './editland?id=' + asset_id;
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