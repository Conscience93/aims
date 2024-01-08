<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}

$sql = "SELECT * FROM aims_electronics where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .main span {
        height: 2.3rem;
    }

    form .btn-delete-file {
        width: 75px !important;
    }

    .modal-backdrop {
        display: none;
    }

    .bold-option {
        font-weight: bold;
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
    <form action=".\module\electronics\editelectronics_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <input id="asset_tag" name="asset_tag" value="<?php echo $row['asset_tag']?>" hidden>
                    <h4>Edit Electronics Data: <?php echo $row['asset_tag']?></h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./asset" class="btn btn-danger">Discard</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
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
                            <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name']; ?>" class="form-control" required>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input list="assetCategoryList" name="category" value="<?php echo $row['category'];?>" id="category" class="form-control">
                                <datalist id="assetCategoryList">
                                    <?php 
                                    $sql_categories = "SELECT * FROM aims_electronics_category_run_no";
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
                    <!-- po_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="po_number">P.O Number</label>
                            <input type="number" id="po_number" name="po_number" value="<?php echo $row['po_number'];?>" class="form-control"  step="any">
                        </div>
                    </div>
                    <!-- do_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="do_number">D.O Number</label>
                            <input type="number" id="do_number" name="do_number" value="<?php echo $row['do_number'];?>" class="form-control"  step="any">
                        </div>
                    </div>
                    <!-- brand -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input list ="electronicsBrandList" name="brand" value="<?php echo $row['brand'];?>" id="brand" class="form-control">
                                <datalist id="electronicsBrandList">
                                    <?php 
                                    $sql_brands = "SELECT * FROM aims_preset_electronics_brand";
                                    $result_brands = mysqli_query($con, $sql_brands);
                                    $brands=[];
                                    while ($row_brands = mysqli_fetch_assoc($result_brands)) {
                                        $brands[] = $row_brands;
                                    }
                                    if ($brands == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($brands as $brand): ?>
                                        <option value="<?php echo $brand['display_name']; ?>" <?php if($row['brand'] == $brand['display_name']) {echo 'selected';} ?>><?php echo $brand['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Electronic Brand" data-action="addNewElectronicBrnad">Add New Electronic Brand</option>
                                <datalist id="electronicsBrandList">
                            </select>
                        </div>
                    </div>
                    <!-- model_no -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="model_no">Model Number</label>
                            <input type="text" id="model_no" name="model_no" placeholder="Model or Serial Number" value="<?php echo $row['model_no']; ?>" class="form-control">
                        </div>
                    </div>
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" placeholder="Price in Ringgit" value="<?php echo $row['price']; ?>" class="form-control"  step="any">
                        </div>
                    </div>
                    <!-- value  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="value">Value (RM)</label>
                            <input type="number" id="value" name="value" placeholder="To Be Determined" value="<?php echo $row['value']; ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- date purchase -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date_purchase">Date Purchase</label>
                            <input type="date" id="date_purchase" name="date_purchase" placeholder="Date Purchase"  value="<?php echo $row['date_purchase']; ?>" class="form-control">
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
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list="departmentList" name="department"  value="<?php echo $row['department'];?>" id="department" class="form-control">
                                <datalist id="departmentList">          
                                    <option value="">Select Department</option>
                                        <?php 
                                        $sql_departments = "SELECT * FROM aims_preset_department";
                                        $result_departments = mysqli_query($con, $sql_departments);
                                        while ($row_departments = mysqli_fetch_assoc($result_departments)) {
                                            $departments[] = $row_departments;
                                        }
                                        if ($departments == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php } else {
                                            foreach ($departments as $department): ?>
                                                <option value="<?php echo $department['display_name']; ?>" <?php if($row['department'] == $department['display_name']) {echo 'selected';} ?>><?php echo $department['display_name']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                        <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                                <datalist id="departmentList">  
                            </select>
                        </div>
                    </div>
                    <!-- location -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input list="locationList" name="location" value="<?php echo $row['location'];?>" id="location" class="form-control">
                                <datalist id="locationList">                      
                                    <option value="">Select Location</option>
                                    <?php 
                                    $sql_locations = "SELECT * FROM aims_preset_location";
                                    $result_locations = mysqli_query($con, $sql_locations);
                                    while ($row_locations = mysqli_fetch_assoc($result_locations)) {
                                        $locations[] = $row_locations;
                                    }
                                    if ($locations == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else {
                                        foreach ($locations as $location): ?>
                                            <option value="<?php echo $location['display_name']; ?>" <?php if($row['location'] == $location['display_name']) {echo 'selected';} ?>><?php echo $location['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                    <option value="Add New Location" data-action="addNewLocation">Add New Location</option>
                                <datalist id="locationList">
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
                                    <option value="">Select supplier</option>
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

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Electronic Specification (Under Construction)</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-6">
                        <label for="remark">Remark</label>
                        <textarea id="remark" name="remark" placeholder="Additional Notes" class="form-control"><?php echo $row['remark']; ?></textarea>
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
                            <label for="invoice">Invoice</label></br>
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
                            <label for="document">Document</label></br>
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
                            <label for="warranty">Warranty</label></br>
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

                <br><hr>

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

<!-- ELECTRONICS MODAL -->
<?php include 'electronics_modal.php' ?>

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
                        text: 'Electronics edited successfully!',
                        showConfirmButton: false,
                        timer: 5000
                    }).then(function() {
                        window.location.href = './asset';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 5000
                    }).then(function() {
                        window.location.href = './editelectronics?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

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
        url: "./module/electronics/deletefile_action.php", // Update the URL to your PHP script
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
                window.location.href = './editelectronics?id=' + id;
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
                window.location.href = './editelectronics?id=' + id;
            });
        }
    });
}

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
        if (!/^E/.test(prefixValue)) {
            // Show an error message for the prefix
            $('#prefixError').text("The prefix must start with the letter 'E'");
        } else {
            // Prefix is valid, proceed with form submission
            // Clear any previous error message
            $('#prefixError').text("");
            $('#successMessage').text("");

            var formData = new FormData($('#addAssetCategoryForm')[0]);

            $.ajax({
                url: './module/electronics/addelectronics_category_run_no.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.trim() === "true") {
                        // Success message
                        $('#successMessage').text('Electronics Category added successfully!');
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
    // Show the modal when "Add New Category" is selected
    $('#brand').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Electronic Brand') {
            $('#addElectronicsBrandModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Electronic Brand" option
    $('#electronicsBrandtList option[data-action="addNewElectronicBrand"]').click(function () {
        $('#addElectronicsBrandModal').modal('show');
        $('#brand').val(''); // Clear the input field after opening the modal
    });

    $('#addElectronicsBrandButton').click(function() {

        var formData = new FormData($('#addElectronicsBrandForm')[0]);

        $.ajax({
            url: './module/setting/preset/electronics_brand/add_electronics_brand_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Electronics Brand added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new ElectronicsBrand to the dropdown list
                        var newElectronicsBrandName = $('#display_name_electronics').val();
                        $('#electronicsBrandList').append('<option value="' + newElectronicsBrandName + '">' + newElectronicsBrandName + '</option>');

                        // Optionally, you can select the newly added ElectronicsBrand
                        $('#brand').val(newElectronicsBrandName);

                        // Close the modal
                        $('#addElectronicsBrandModal').modal('hide');
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

$(document).ready(function () {
    // Show the modal when "Add New Location" is selected
    $('#location').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Location') {
            $('#addLocationModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Location" option
    $('#locationList option[data-action="addNewLocation"]').click(function () {
        $('#addLocationModal').modal('show');
        $('#location').val(''); // Clear the input field after opening the modal
    });

    $('#addLocationButton').click(function() {

        var formData = new FormData($('#addLocationForm')[0]);

        $.ajax({
            url: './module/setting/preset/location/addlocation_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Location added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Location to the dropdown list
                        var newLocationName = $('#display_name_location').val();
                        $('#locationList').append('<option value="' + newLocationName + '">' + newLocationName + '</option>');

                        // Optionally, you can select the newly added Location
                        $('#location').val(newLocationName);

                        // Close the modal
                        $('#addLocationModal').modal('hide');
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

$(document).ready(function () {
    // Show the modal when "Add New Category" is selected
    $('#department').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Department') {
            $('#addDepartmentModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Department" option
    $('#departmentList option[data-action="addNewDepartment"]').click(function () {
        $('#addDepartmentModal').modal('show');
        $('#department').val(''); // Clear the input field after opening the modal
    });


    $('#addDepartmentButton').click(function() {

        var formData = new FormData($('#addDepartmentForm')[0]);

        $.ajax({
            url: './module/setting/preset/department/adddepartment_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Department added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new department to the dropdown list
                        var newDepartmentName = $('#display_name_department').val();
                        $('#departmentList').append('<option value="' + newDepartmentName + '">' + newDepartmentName + '</option>');

                        // Optionally, you can select the newly added department
                        $('#department').val(newDepartmentName);

                        // Close the modal
                        $('#addDepartmentModal').modal('hide');
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


$(document).ready(function () {
    // Show the modal when "Add New Building/Branch" is selected
    $('#branch').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Building/Branch') {
            $('#addBranchModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Building/Branch" option
    $('#branchList option[data-action="addNewBranch"]').click(function () {
        $('#addBranchModal').modal('show');
        $('#branch').val(''); // Clear the input field after opening the modal
    });


    $('#addBranchButton').click(function() {
    
        var formData = new FormData($('#addBranchForm')[0]);

        $.ajax({
            url: './module/setting/preset/branch/addbranch_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Branch added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new branch to the dropdown list
                        var newBranchName = $('#display_name').val();
                        $('#branchList').append('<option value="' + newBranchName + '">' + newBranchName + '</option>');

                        // Optionally, you can select the newly added branch
                        $('#branch').val(newBranchName);

                        // Close the modal
                        $('#addBranchModal').modal('hide');
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
            error: function() {
                // Handle Ajax request error
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ajax request failed!',
                    showConfirmButton: false,
                    timer: 15000
                });
            },
            cache: false,
            contentType: false,
            processData: false
        });
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
            <td><input type="file" name="picture[]" accept="image/*" class="form-control" multiple></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deletePicture(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deletePicture(input) {
    // Remove the row from the table
    var tableRow = input.parentNode.parentNode;
    var tableBody = tableRow.parentNode;
    tableBody.removeChild(tableRow);
}

function confirmDeleteExistingPicture(input, id, view, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete picture with " + view + " view. This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingPicture(input, id, view, computer_id);
        }
    });
}

function deleteExistingPicture(input, id, view, computer_id) {
    $.ajax({
        url: "./module/electronics/deletepicture_action.php",
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
                window.location.href = './editelectronics?id=' + computer_id;
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

$(document).ready(function() {
    // Event handler for branch selection
    $('#branch').change(function() {
        var selectedBranch = $(this).val();

        // AJAX request to fetch departments based on the selected branch
        $.ajax({
            type: 'POST',
            url: './module/setting/preset_location/location/get_departments_by_branch.php',
            data: { branch: selectedBranch },
            success: function(response) {
                // Update the department dropdown with the new options
                $('#departmentList').html(response);
            },
            error: function(error) {
                console.log('Error fetching departments: ' + error);
            }
        });
    });

    // Event handler for clearing branch value
    $('#branch').on('input', function() {
        // If the branch value is empty, clear the department options
        if ($(this).val() === '') {
            $('#departmentList').empty();
        }
    });
});

$(document).ready(function() {
    // Event handler for department selection
    $('#department').change(function() {
        var selectedDepartment = $(this).val();

        // AJAX request to fetch locations based on the selected department
        $.ajax({
            type: 'POST',
            url: './module/setting/preset_location/location/get_location_by_department.php',
            data: { department: selectedDepartment },
            success: function(response) {
                // Update the location dropdown with the new options
                $('#locationList').html(response);
            },
            error: function(error) {
                console.log('Error fetching locations: ' + error);
            }
        });
    });

    // Event handler for clearing department value
    $('#department').on('input', function() {
        // If the department value is empty, clear the location options
        if ($(this).val() === '') {
            $('#locationList').empty();
        }
    });
});
</script>