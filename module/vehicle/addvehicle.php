<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';
?>

<style>
    .main span {
        height: 2.3rem;
    }

    .modal-backdrop {
        display: none;
    }

    /* Style the modal background */
    .modal {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        margin-top: 50px;
    }

    /* Style the modal content */
    .modal-content {
        background-color: #fff; /* White background */
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Box shadow for a slight elevation effect */
        max-height: 80vh; /* Adjust the maximum height as needed (e.g., 80% of the viewport height) */
        overflow-y: auto; /* Enable vertical scrolling if the content exceeds the modal height */
    }

    /* Style the modal header */
    .modal-header {
        background-color: #007bff; /* Blue header background */
        color: #fff; /* White text color */
        border-bottom: none; /* Remove the default border */
    }

    /* Style the close button in the header */
    .modal-header .close {
        color: #fff;
    }

    /* Style the modal title */
    .modal-title {
        font-weight: bold;
    }

    /* Style the "Add Category" button */
    .btn-primary {
        background-color: #007bff; /* Blue background for the button */
        color: #fff; /* White text color */
    }

    /* Style the "Close" button */
    .btn-secondary {
        background-color: #ccc; /* Gray background for the button */
        color: #333; /* Dark text color */
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%; /* Adjust the modal width for smaller screens */
        }
    }
</style>

<div class="main">
    <form action=".\module\vehicle\addvehicle_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Add Vehicle Information</h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./vehicle" class="btn btn-danger">Discard</a>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
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
                            <input type="text" id="name" name="name" placeholder="Name"  class="form-control" required>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input list ="vehicleCategoryList" name="category" id="category" class="form-control" required>
                                <datalist id="vehicleCategoryList">
                                    <option value="">Select Category</option>
                                    <?php 
                                    $sql_categories = "SELECT category, display_name FROM aims_vehicle_category_run_no";
                                    $result_categories = mysqli_query($con, $sql_categories);
                                    while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                        $categories[] = $row_categories;
                                    }
                                    if ($categories == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['display_name']; ?>"><?php echo $category['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <b><option value="Add New Category"></option></b>
                                <datalist id="vehicleCategoryList">
                            </select>
                        </div>
                    </div>
                     <!-- plate_no -->
                     <div class="col-2">
                        <div class="form-group">
                            <label for="plate_no">Plate No.</label>
                            <input type="text" id="plate_no" name="plate_no" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- brand -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input type="text" id="brand" name="brand" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- roadtax -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="roadtax">Roadtax</label>
                            <input type="file" id="roadtax" name="roadtax" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- roadtax_expiry -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="roadtax_expiry">Roadtax Expiry Date</label>
                            <input type="date" id="roadtax_expiry" name="roadtax_expiry" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- date purchase -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date_purchase">Date Purchase</label>
                            <input type="datetime-local" id="date_purchase" name="date_purchase" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" placeholder="Price in Ringgit"  class="form-control" step="any">
                        </div>
                    </div>
                    <!-- value -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="value">Value (RM)</label>
                            <input type="number" id="value" name="value" placeholder=""  class="form-control" step="any">
                        </div>
                    </div>
                    <!-- branch  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list ="branchList" name="branch" id="branch" class="form-control">
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
                                    <?php } else
                                    foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Building/Branch"></option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- remarks  -->
                    <div class="col-4">
                        <label for="remarks">Remarks</label><br>
                        <textarea id="remarks" name="remarks" rows="1" placeholder="Additional Notes" class="form-control"></textarea>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-12">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" id="warranty_checkbox" name="warranty_checkbox" class="form-check-input">
                            </div>
                            <label class="form-check-label" for="warranty_checkbox"><b>Set Warranty</b></label>
                        </div>
                    </div>
                    <!-- start_warranty -->
                    <div class="col-2 warranty-fields" style="display: none;">
                        <div class="form-group">
                            <label for="start_warranty">Start Warranty</label>
                            <input type="date" id="start_warranty" name="start_warranty" placeholder="Start Date of Warranty" class="form-control">
                        </div>
                    </div>
                    <!-- end_warranty -->
                    <div class="col-2 warranty-fields" style="display: none;">
                        <div class="form-group">
                            <label for="end_warranty">End Warranty</label>
                            <input type="date" id="end_warranty" name="end_warranty" placeholder="End Date of Warranty" class="form-control">
                        </div>
                    </div>
                    <!-- Upload warranty card -->
                    <div class="col-4 warranty-fields" style="display: none;">
                        <div class="form-group">
                            <label for="warranty"><b>Warranty Card</b></label>
                            <input type="file" id="warranty" name="warranty" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
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
                            <input list="dealershipList" name="dealership" id="dealership" class="form-control" autofocus oninput = "getDealershipDetails(this.value)">
                                <datalist id="dealershipList">    
                                    <option value="">Select Dealership</option>
                                    <?php 
                                    $sql_dealerships = "SELECT * FROM aims_people_dealership";
                                    $result_dealerships = mysqli_query($con, $sql_dealerships);
                                    $dealerships=[];
                                    while ($row_dealerships = mysqli_fetch_assoc($result_dealerships)) {
                                        $dealerships[] = $row_dealerships;
                                    } if ($dealerships == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($dealerships as $dealership): ?>
                                        <option value="<?php echo $dealership['display_name']; ?>"><?php echo $dealership['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Dealership" data-action="addNewDealership">Add New Dealership</option>
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
                    <tbody>
                        <tr>
                            <td><input type="text" name="view[]" class="form-control"></td>
                            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control"></td>                                    
                        </tr>
                    </tbody>
                    <tbody id="picture-table">
                    </tbody>
                </table>
                    
                <hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <!-- insurance -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="insurance">Insurance</label>
                            <input type="file" id="insurance" name="insurance" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                    <!-- invoices -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="invoice">Invoice</label>
                            <input type="file" id="invoice" name="invoice" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                    <!-- documents -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="document">Document</label>
                            <input type="file" id="document" name="document" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for adding a new VehicleCategory -->
<form action=".\module\vehicle\addvehicle_category_run_no.php" method="POST" id="addVehicleCategoryForm">
    <div class="modal fade" id="addVehicleCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addVehicleCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addVehicleCategoryForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addVehicleCategoryLabel">Add New Vehicle Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name_vehicle_category">Vehicle Category Name</label>
                            <input type="text" id="display_name_vehicle_category" name="display_name" placeholder="" class="form-control" oninput="autoFillPrefix()">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" placeholder="same as vehicle category name"  class="form-control" oninput="convertToLowerCase(this)">
                        </div>
                        <div class="form-group">
                            <label for="prefix" style="display: flex; align-items: center;">
                                Prefix
                                <img id="prefixInfo" src='./include/action/info.png' alt='Info' title='Will be the Running Number.' width='16' height='16' style="margin-left: 5px;">
                            </label>
                            <div style="display: flex; align-items: center;">
                                <input type="text" id="prefix" name="prefix" placeholder="3 letters" class="form-control" oninput="capitalizeAndLimitTo3()">
                            </div>
                            <div id="prefixError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addVehicleCategoryButton" class="btn btn-primary">Add Vehicle Category</button>
                        <div id="successMessage" class="text-success"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new branch -->
<form action=".\module\setting\preset\branch\addbranch_action.php" method="POST" id="addBranchForm">
    <div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addBranchForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBranchModalLabel">Add New Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class ="row">
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="display_name">Building/Branch</label>
                                    <input type="text" class="form-control" id="display_name" name="display_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="branch_contact_no">Office No.</label>
                                    <input type="number" id="branch_contact_no" name="branch_contact_no"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="branch_email">Office Email</label>
                                    <input type="email" id="branch_email" name="branch_email"  class="form-control">
                                </div>
                            </div>
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="pic">Person In Charge</label>
                                    <input type="text" id="pic" name="pic"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="contact_no">Contact No.</label>
                                    <input type="number" id="contact_no" name="contact_no"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea cols="65" rows="4" type="text" id="address" name="address" placeholder="Full Address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addBranchButton" class="btn btn-primary">Add Building/Branch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new dealership -->
<form action=".\module\people\dealership\adddealership_action.php" method="POST" id="addDealershipForm">
    <div class="modal fade" id="addDealershipModal" tabindex="-1" role="dialog" aria-labelledby="addDealershipLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addDealershipForm" >                    <div class="modal-header">
                        <h5 class="modal-title" id="addDealershipLabel">Add New Dealership</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class = "row">
                            <div class = "col md-6">
                                <div class="form-group">
                                    <label for="display_name">Dealership</label>
                                    <input type="text" id="display_name_dealership" name="display_name" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="pic">Person in Charge</label>
                                    <input type="text" id="pic" name="pic" class="form-control" >
                                </div>             
                                <div class="form-group">
                                    <label for="contact_no">Company Contact No.</label>
                                    <input type="number" id="contact_no" name="contact_no" class="form-control" >
                                </div>
                            </div>
                            <div class = "col md-6">
                                <div class="form-group">
                                    <label for="email">Company Email</label>
                                    <input type="email" id="email" name="email" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="fax">Fax Number</label>
                                    <input type="number" id="fax" name="fax" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea cols="65" rows="4" type="text" id="address" name="address" placeholder="Full Address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addDealershipButton" class="btn btn-primary">Add Dealership</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {
    $('#prefix').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
});

function capitalizeAndLimitTo3() {
    var input = document.getElementById('prefix');
    var value = input.value.toUpperCase(); // Convert to uppercase
    value = value.slice(0, 3); // Limit to 3 characters
    input.value = value;
}

function convertToLowerCase(inputElement) {
    inputElement.value = inputElement.value.toLowerCase();
}

function autoFillPrefix() {
    var categoryInput = document.getElementById('display_name_vehicle_category');
    var prefixInput = document.getElementById('prefix');

    if (categoryInput.value.length >= 2) {
        prefixInput.value = 'V' + categoryInput.value.substring(0, 2).toUpperCase();
    } else if (categoryInput.value.length === 1) {
        prefixInput.value = 'V' + categoryInput.value.toUpperCase() + 'X';
        // The 'X' or any other letter is added to ensure a minimum length of 3 characters.
    } else {
        prefixInput.value = 'V';
    }
}

// Add an event listener to the checkbox to toggle the display of warranty fields
document.getElementById('warranty_checkbox').addEventListener('change', function() {
var warrantyFields = document.querySelectorAll('.warranty-fields');
warrantyFields.forEach(function(field) {
    field.style.display = this.checked ? 'block' : 'none';
}, this);
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

// submit using ajax
$('form').submit(function(e){
        e.preventDefault();

        // Disable the submit button to prevent multiple submissions
        $('button[type="submit"]').prop('disabled', true);
        
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
                        text: 'Vehicle added successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location.href = './addvehicle';
                    });
                }else if(response.trim()=="duplicate"){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There is duplicate name! Please try again or use another name.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        return false;
                    });
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 20000
                    }).then(function() {
                        window.location.href = './addvehicle';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

$(document).ready(function() {
     // Show the modal when "Add New Category" is selected
     $('#category').change(function() {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Category') {
            $('#addVehicleCategoryModal').modal('show');
        }
    });

    $('#addVehicleCategoryButton').click(function() {
        var prefixValue = $('#prefix').val();
        if (!/^V/.test(prefixValue)) {
            // Show an error message for the prefix
            $('#prefixError').text("The prefix must start with the letter 'V'");
        } else {
            // Prefix is valid, proceed with form submission
            // Clear any previous error message
            $('#prefixError').text("");
            $('#successMessage').text("");

            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            var formData = new FormData($('#addVehicleCategoryForm')[0]);

            $.ajax({
                url: './module/vehicle/addvehicle_category_run_no.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.trim() === "true") {
                        // Success message
                        $('#successMessage').text('Vehicle Category added successfully!');
                        // Optionally, you can clear the prefix input or reset the form
                        $('#prefix').val('');
                        
                        // Add the new VehicleCategory to the dropdown list
                        var newVehicleCategoryName = $('#display_name_vehicle_category').val();
                        $('#vehicleCategoryList').append('<option value="' + newVehicleCategoryName + '">' + newVehicleCategoryName + '</option>');

                        // Optionally, you can select the newly added Vehicle Category
                        $('#category').val(newVehicleCategoryName);
                    } else {
                        // Error message
                        $('#prefixError').text('Something went wrong. Please try again.');
                    }

                    // Enable the button after processing
                    $('#addVehicleCategoryModal').prop('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
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
            url: './module/setting/preset_location/branch/addbranch_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                if (response.includes("Branch added successfully")) {
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

                        // Update the nameList in addDepartmentModal
                        updateNameList();
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
    // Show the modal when "Add New Dealership" is selected
    $('#dealership').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Dealership') {
            $('#addDealershipModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Dealership" option
    $('#dealershipList option[data-action="addNewDealership"]').click(function () {
        $('#addDealershipModal').modal('show');
        $('#dealership').val(''); // Clear the input field after opening the modal
    });

    $('#addDealershipButton').click(function() {

        var formData = new FormData($('#addDealershipForm')[0]);

        $.ajax({
            url: './module/people/dealership/adddealership_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Dealership added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Dealership to the dropdown list
                        var newDealershipName = $('#display_name_dealership').val();
                        $('#dealershipList').append('<option value="' + newDealershipName + '">' + newDealershipName + '</option>');

                        // Optionally, you can select the newly added Dealership
                        $('#dealership').val(newDealershipName);

                        // Close the modal
                        $('#addDealershipModal').modal('hide');
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
            <td><input type="text" name="view[]" class="form-control" required></td>
            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control" required></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deletePicture(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deletePicture(input) {
    document.getElementById('picture-table').removeChild(input.parentNode.parentNode);
}

</script>