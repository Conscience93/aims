<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_webpage where id ='".$_GET['id']."'";
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

    .dropdown {
        display: inline-block;
        position: relative;
    }

    #myDropdown {
        display: none;
        position: absolute;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        max-height: 200px;
        width: 250%;
        overflow-y: auto;
        z-index: 1;
    }

    #myDropdown p {
        padding: 8px;
        margin: 0;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #myDropdown p:hover {
        background-color: #f1f1f1;
    }

    /* Optional: Style for the label */
    label {
        display: block;
        margin-bottom: 8px;
    }

    .form-group {
    margin-bottom: 15px; /* Add some space below the form group */
    }

    .radio-buttons {
        display: flex;
    }

    .radio-option {
        margin-right: 20px; /* Adjust the margin as needed */
    }

    /* Optional: Add some styling for the selected radio option */
    .radio-option input[type="radio"]:checked + label {
        font-weight: bold;
        color: #007bff; /* Change the color as needed */
    }

    .input-container {
        position: relative;
        width: 100%;
        }

    .table thead th {
        border-bottom: none;
    }

    .table td, .table th, tbody td, #picture-table {
        border-top: none;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 250%;
        padding-right: 20px; /* Space for the 'x' button */
    }
</style>

<div class="main">
    <form action=".\module\intangible\webpage\editwebpage_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./intellectual" class="btn btn-danger">Discard</a>
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px">Save</button> 
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
                            <label for="name">Name<span style="color: red;"> *</span></label>
                            <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name'];?>" class="form-control" required>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category<span style="color: red;"> *</span></label>
                            <input list="assetCategoryList" name="category" value="<?php echo $row['category'];?>" id="category" class="form-control">
                                <datalist id="assetCategoryList">
                                    <?php 
                                    $sql_categories = "SELECT * FROM aims_webpage_category_run_no";
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
                                    <option value="Add New Category" data-action="addNewCategory">Add New Category</option>
                                </datalist>
                            </select>
                        </div>
                    </div>
                    <!-- date purchase -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date purchase">Date Purchase</label>
                            <input type="date" id="date purchase" name="date purchase" placeholder="Date Purchase" value="<?php echo $row['date_purchase'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" value="<?php echo $row['price'];?>" class="form-control"  step="any">
                        </div>
                    </div>
                    <!-- user  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input list ="userList" name="user" value="<?php echo $row['user'];?>" id="user" class="form-control">
                                <datalist id="userList">
                                    <option value="">Select User</option>
                                    <?php 
                                    $sql_users = "SELECT * FROM aims_people_staff";
                                    $result_users = mysqli_query($con, $sql_users);
                                    while ($row_users = mysqli_fetch_assoc($result_users)) {
                                        $users[] = $row_users;
                                    }
                                    if ($users == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($users as $user): ?>
                                        <option value="<?php echo $user['display_name']; ?>" <?php if($row['user'] == $user['display_name']) {echo 'selected';} ?>><?php echo $user['display_name']; ?></option>
                                    <?php endforeach; ?>
                                <datalist id="userList">
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
                    <!-- server -->
                    <div class="col-2" id="server_nameContainer">
                        <div class ="form-group">
                            <label for="server_name">Server</label>
                            <input list ="serverNameList" id="server_name" name="server_name" value="<?php echo $row['server_name'];?>" class="form-control">
                                <datalist id="serverNameList">
                                    <?php 
                                        $sql_categories = "SELECT name FROM aims_computer WHERE category = 'Server'";
                                        $result_categories = mysqli_query($con, $sql_categories);
                                        
                                        if (!$result_categories) {
                                            echo "Error: " . mysqli_error($con); // Add error handling as needed
                                        } else {
                                            if (mysqli_num_rows($result_categories) > 0) {
                                                while ($row_category = mysqli_fetch_assoc($result_categories)) {
                                                    echo '<option value="' . $row_category['name'] . '">' . $row_category['name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No Selection Found</option>';
                                            }
                                        }
                                    ?>
                                <datalist id="serverNameList">
                            </select>
                        </div>
                    </div>
                    <!-- link  -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="link">Link/URL</label>
                            <input type ="text" id="link" name="link" placeholder="Link/URL to webpage" value="<?php echo $row['link']; ?>" class="form-control">
                        </div>
                    </div>
                    <!-- particulars  -->
                    <div class="col-5">
                        <div class="form-group">
                            <label for="particular">Particular</label>
                            <textarea id="particular" name="particular" placeholder="Additional Notes" class="form-control"><?php echo $row['particular']; ?></textarea>
                        </div>
                    </div>
                </div>

                <br><hr>
                
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Supplier Details</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- supplier -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier">Name</label>
                            <input list="supplierList" name="supplier" value="<?php echo $row['supplier'];?>" id="supplier" class="form-control" autofocus oninput = "getSupplierDetails(this.value)">
                                <datalist id="supplierList">                      
                                    <?php 
                                    $sql_suppliers = "SELECT * FROM aims_people_supplier";
                                    $result_suppliers = mysqli_query($con, $sql_suppliers);
                                    while ($row_suppliers = mysqli_fetch_assoc($result_suppliers)) {
                                        $suppliers[] = $row_suppliers;
                                    } if ($suppliers == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier['display_name']; ?>" <?php if($row['supplier'] == $supplier['display_name']) {echo 'selected';} ?>><?php echo $supplier['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Supplier" data-action="addNewSupplier">Add New Supplier</option>
                                <datalist id="supplierList">
                            </select>
                        </div>
                    </div>
                    <!-- supplier pic -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier_pic">Contact Person</label>
                            <span id="supplier_pic" name="supplier_pic" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- supplier phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier_contact_no">Contact Number</label>
                            <span id="supplier_contact_no" name="supplier_contact_no" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                     <!-- supplier email -->
                     <div class="col-3">
                        <div class="form-group">
                            <label for="supplier_email">Email</label>
                            <span id="supplier_email" name="supplier_email" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- supplier fax number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier_fax">Fax Number</label>
                            <span id="supplier_fax" name="supplier_fax" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- supplier location -->
                    <div class="col-10">
                        <div class="form-group">
                            <label for="supplier_address">Address</label>
                            <span id="supplier_address" name="supplier_address" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                </div>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Files</h4>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <!-- invoice -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="invoice">Invoice</label>
                            <?php
                            if (!empty($row['invoice'])) {
                                $fileName = basename($row['invoice']);
                                echo '<div class="md-3 form-control"><a href="' . $row['invoice'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo 
                                '<form id="delete-invoice-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="invoice">
                                    <input type="hidden" name="invoice_id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-invoice-form" onclick="confirmDeleteFile('.$row['id'].',\'invoice\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="invoice" name="invoice" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- document -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="document">Document</label>
                            <?php
                            if (!empty($row['document'])) {
                                $fileName = basename($row['document']);
                                echo '<div class="md-3 form-control"><a href="' . $row['document'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo 
                                '<form id="delete-document-form" action="./module/asset/deletefile_action.php" method="POST">
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

                    <!-- warranty card -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="warranty">Warranty</label>
                            <?php
                            if (!empty($row['warranty'])) {
                                $fileName = basename($row['warranty']);
                                echo '<div class="md-3 form-control"><a href="' . $row['warranty'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo 
                                '<form id="delete-warranty-form" action="./module/asset/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="warranty">
                                    <input type="hidden" name="warrenty_id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-warranty-form" onclick="confirmDeleteFile('.$row['id'].',\'warranty\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="warranty" name="warranty" accept="" value="" class="form-control" />';
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
                                    echo 
                                    '<form id="delete-picture-form" action="./module/computer/deletefile_action.php" method="POST">
                                        <input type="hidden" name="fileType" value="picture">
                                        <input type="hidden" name="picture_id" value="'.$row_picture['id'].'">
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

<!-- MODAL FOR ASSET -->
<?php include 'asset_modal.php' ?>

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
                        text: 'Asset edited successfully!',
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './intellectual  ';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './editwebpage?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    $(document).ready(function () {
    // Show the modal when "Add New Category" is selected
    $('#category').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Category') {
            $('#addAssetCategoryModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Category" option
    $('#categoryList option[data-action="addNewCategory"]').click(function () {
        $('#addAssetCategoryModal').modal('show');
        $('#category').val(''); // Clear the input field after opening the modal
    });

    $('#addAssetCategoryButton').click(function() {
        var prefixValue = $('#prefix').val();
        if (!/^W/.test(prefixValue)) {
            // Show an error message for the prefix
            $('#prefixError').text("The prefix must start with the letter 'A'");
        } else {
            // Prefix is valid, proceed with form submission
            // Clear any previous error message
            $('#prefixError').text("");
            $('#successMessage').text("");

            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            var formData = new FormData($('#addAssetCategoryForm')[0]);

            $.ajax({
                url: './module/intangible/webpage/addwebpage_category_run_no.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.trim() === "true") {
                        // Success message
                        $('#successMessage').text('Asset Category added successfully!');
                        // Optionally, you can clear the prefix input or reset the form
                        $('#prefix').val('');
                        
                        // Add the new AssetCategory to the dropdown list
                        var newAssetCategoryName = $('#display_name_asset_category').val();
                        $('#assetCategoryList').append('<option value="' + newAssetCategoryName + '">' + newAssetCategoryName + '</option>');

                        // Optionally, you can select the newly added AssetCategory
                        $('#category').val(newAssetCategoryName);
                    } else {
                        // Error message
                        $('#prefixError').text('Something went wrong. Please try again.');
                    }

                    // Enable the button after processing
                    $('#addAssetCategoryButton').prop('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Supplier" is selected
    $('#supplier').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Supplier') {
            $('#addSupplierModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Supplier" option
    $('#supplierList option[data-action="addNewSupplier"]').click(function () {
        $('#addSupplierModal').modal('show');
        $('#supplier').val(''); // Clear the input field after opening the modal
    });

    $('#addSupplierButton').click(function() {

        var formData = new FormData($('#addSupplierForm')[0]);

        $.ajax({
            url: './module/people/supplier/addsupplier_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Supplier added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Supplier to the dropdown list
                        var newSupplierName = $('#display_name_supplier').val();
                        $('#supplierList').append('<option value="' + newSupplierName + '">' + newSupplierName + '</option>');

                        // Optionally, you can select the newly added Supplier
                        $('#supplier').val(newSupplierName);

                        // Close the modal
                        $('#addSupplierModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
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

function getSupplierDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/supplier/get_supplier_details_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#supplier_pic").text(data["pic"]);
                $("#supplier_contact_no").text(data["contact_no"]);
                $("#supplier_email").text(data["email"]);
                $("#supplier_fax").text(data["fax"]);
                $("#supplier_address").text(data["address"]);
            } catch (e) {
                $("#supplier_pic").text("");
                $("#supplier_contact_no").text("");
                $("#supplier_email").text("");
                $("#supplier_fax").text("");
                $("#supplier_address").text("");
            }
        }
    });
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
        url: "./module/intangible/webpage/deletefile_action.php", // Update the URL to your PHP script
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
                window.location.href = './editwebpage?id=' + id;
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
                window.location.href = './editwebpage?id=' + id;
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
        url: "./module/intangible/webpage/deletepicture_action.php",
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
                window.location.href = './editwebpage?id=' + asset_id;
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