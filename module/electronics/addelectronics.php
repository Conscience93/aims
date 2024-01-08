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

    .warranty-fields {
        display: none;
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
    <form action=".\module\electronics\addelectronics_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Add Electronics Data</h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./add" class="btn btn-danger">Discard</a>
                        <button type="button" id="importButton" class="btn btn-primary" style="background-color: green;">Import</button>
                        <button type="submit" class="btn btn-primary" style="">Submit</button>
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
                    <div class="col-2">
                        <div class="form-group">
                            <label for="assetType">Asset Type</label>
                            <div class="radio-buttons">
                                <div class="radio-option">
                                    <input type="radio" id="single" name="assetType" value="single" checked>
                                    <label for="single">Single</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="multiple" name="assetType" value="multiple">
                                    <label for="multiple">Multiple</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Select dropdown for quantity -->
                    <div id="quantityInput" class="col-2" style="display: none;">
                        <div class="form-group">
                            <label for="quantity"><b>Quantity</b></label>
                            <select id="quantity" name="quantity" class="form-control" onchange="limitInputToRange(this)">
                                <?php
                                    // Populate options from 2 to 50
                                    for ($i = 1; $i <= 50; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="dropdown">
                            <label for="smartSearch"><b>Smart Search</b></label>
                            <div class="input-container">
                                <input type="text" placeholder="Search.." id="myInput" oninput="filterFunction()">
                                <span class="clear-button" onclick="clearSearch()">x</span>
                            </div>
                            <div id="myDropdown" class="dropdown-content" style="display: none;">
                                <?php 
                                $sql_smartSearchs = "SELECT * FROM aims_electronics";
                                $result_smartSearchs = mysqli_query($con, $sql_smartSearchs);
                                $smartSearchs=[];
                                while ($row_smartSearchs = mysqli_fetch_assoc($result_smartSearchs)) {
                                    $smartSearchs[] = $row_smartSearchs;
                                }
                                if (empty($smartSearchs)) { ?>
                                    <p>No Selection Found</p>
                                <?php } else {
                                    foreach ($smartSearchs as $index => $smartSearch): ?>
                                        <p id="smartSearchItem_<?php echo $index; ?>" onclick="populateFormFields('<?php echo $smartSearch['name']; ?>', '<?php echo $smartSearch['category']; ?>')">
                                            <?php echo $smartSearch['name'] . ' - ' . $smartSearch['category'] ; ?>
                                        </p>
                                    <?php endforeach;
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group" style="display: flex; align-items: center;">
                            <label for="name" style="margin-right: 10px; margin-top: 0px; margin-bottom: 0;">Name</label>
                            <img id="infoImage" src='./include/action/info.png' alt='Info' title='Additional Information: This is the name field where you enter the name of the asset.' width='16' height='16' style="display: none;">
                        </div>
                        <div style="margin-top: -7px;">
                            <input type="text" id="name" name="name" placeholder="Name" class="form-control" required>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input list ="assetCategoryList" name="category" id="category" class="form-control" required>
                                <datalist id="assetCategoryList">
                                    <option value="">Select Category</option>
                                    <?php 
                                    $sql_categories = "SELECT category, display_name FROM aims_electronics_category_run_no";
                                    $result_categories = mysqli_query($con, $sql_categories);
                                    $categories=[];
                                    while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                        $categories[] = $row_categories;
                                    }
                                    if ($categories == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['display_name']; ?>"><?php echo $category['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Category" data-action="addNewCategory">Add New Category</option>
                                <datalist id="assetCategoryList">
                            </select>
                        </div>
                    </div>
                    <!-- po_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="po_number">P.O Number</label>
                            <input type="text" id="po_number" name="po_number" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- do_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="do_number">D.O Number</label>
                            <input type="text" id="do_number" name="do_number" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- brand -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="brand">Brand</label>
                            <input list ="electronicsBrandList" name="brand" id="brand" class="form-control">
                                <datalist id="electronicsBrandList">
                                    <option value="">Select Electronic Brand</option>
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
                                        <option value="<?php echo $brand['display_name']; ?>"><?php echo $brand['display_name']; ?></option>
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
                            <input type="text" id="model_no" name="model_no" placeholder="Model or Serial Number" class="form-control">
                        </div>
                    </div>
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" placeholder="Price in Ringgit"  class="form-control" step="any">
                        </div>
                    </div>
                    <!-- value  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="value">Value (RM)</label>
                            <input type="number" id="value" name="value" placeholder="To Be Determined" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- date purchase -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date_purchase">Date Purchase</label>
                            <input type="date" id="date_purchase" name="date_purchase" placeholder="Date Purchase"class="form-control">
                        </div>
                    </div>
                    <!-- user -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="user">User</label>
                            <input list ="userList" name="user" id="user" class="form-control">
                                <datalist id="userList">
                                    <option value="">Select User</option>
                                    <?php 
                                    $sql_users = "SELECT * FROM aims_people_staff";
                                    $result_users = mysqli_query($con, $sql_users);
                                    $users=[];
                                    while ($row_users = mysqli_fetch_assoc($result_users)) {
                                        $users[] = $row_users;
                                    }
                                    if ($users == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($users as $user): ?>
                                        <option value="<?php echo $user['display_name']; ?>"><?php echo $user['display_name']; ?></option>
                                    <?php endforeach; ?>
                                <datalist id="userList">
                            </select>
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
                                    $branchs=[];
                                    while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                        $branchs[] = $row_branchs;
                                    }
                                    if ($branchs == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list="departmentList" name="department" id="department" class="form-control">
                            <datalist id="departmentList">
                                <option value="">Select Department</option>
                                <?php 
                                $sql_departments = "SELECT * FROM aims_preset_department";
                                $result_departments = mysqli_query($con, $sql_departments);
                                $departments=[];
                                while ($row_departments = mysqli_fetch_assoc($result_departments)) {
                                    $departments[] = $row_departments;
                                }
                                if ($departments == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else foreach ($departments as $department): ?>
                                    <option value="<?php echo $department['display_name']; ?>"><?php echo $department['display_name']; ?></option>
                                <?php endforeach; ?>
                                <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                            </datalist>
                        </div>
                    </div>
                    <!-- location  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input list ="locationList" name="location" id="location" class="form-control">
                                <datalist id="locationList">
                                    <option value="">Select Location</option>
                                    <?php 
                                    $sql_locations = "SELECT * FROM aims_preset_location";
                                    $result_locations = mysqli_query($con, $sql_locations);
                                    $locations=[];
                                    while ($row_locations = mysqli_fetch_assoc($result_locations)) {
                                        $locations[] = $row_locations;
                                    }
                                    if ($locations == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($locations as $location): ?>
                                        <option value="<?php echo $location['display_name']; ?>"><?php echo $location['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Location" data-action="addNewLocation">Add New Location</option>
                                <datalist id="locationList">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-check form-check-inline">
                            <label class="form-check-label" for="warranty_checkbox"><b>Set Warranty</b></label>
                            <input type="checkbox" id="warranty_checkbox" name="warranty_checkbox" class="form-check-input" style="margin-left: 10px;">
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
                            <input list="supplierList" name="supplier" id="supplier" class="form-control" autofocus oninput  = "getSupplierDetails(this.value)">
                                <datalist id="supplierList">    
                                    <option value="">Select Supplier</option>
                                    <?php 
                                    $sql_suppliers = "SELECT * FROM aims_people_supplier";
                                    $result_suppliers = mysqli_query($con, $sql_suppliers);
                                    $suppliers=[];
                                    while ($row_suppliers = mysqli_fetch_assoc($result_suppliers)) {
                                        $suppliers[] = $row_suppliers;
                                    } if ($suppliers == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier['display_name']; ?>"><?php echo $supplier['display_name']; ?></option>
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
                            <h4>Electronic Specification</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-6">
                        <label for="remark">Remark</label><br>
                        <textarea id="remark" name="remark" placeholder="Additional Notes" class="form-control"></textarea>
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
                    <tbody>
                        <tr>
                            <td><input type="text" name="view[]" class="form-control" ></td>
                            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control"></td>                                    
                        </tr>
                    </tbody>
                    <tbody id="picture-table">
                    </tbody>
                </table>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <!-- invoices -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="invoice"><b>Invoice</b></label>
                            <input type="file" id="invoice" name="invoice" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                    <!-- documents -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="document"><b>Document</b></label>
                            <input type="file" id="document" name="document" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- ELECTRONICS MODAL -->
<?php include 'electronics_modal.php' ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function downloadTemplate() {
    var link = document.createElement('a');
    link.href = './include/upload/templates/electronics/template_electronics.xlsx';
    link.download = 'template_electronics.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Ensure the iframe src is empty initially
$('#importModal').on('show.bs.modal', function () {
    document.getElementById('downloadFrame').src = '';
});

// Trigger the modal when the import button is clicked
document.getElementById('importButton').addEventListener('click', function () {
    document.getElementById('openModalBtn').click();
});

$(document).ready(function () {
    // Function to handle the click event of the "Add" button
    $("#importModalAddBtn").click(function () {
        // Get the selected file
        var fileInput = document.getElementById('import');
        var file = fileInput.files[0];

        // Create a FormData object and append the file to it
        var formData = new FormData();
        formData.append('import', file);

        // Send an AJAX request to the server to handle the file upload
        $.ajax({
            type: 'POST',
            url: './module/electronics/upload.php', // Replace with the actual server-side script handling the file upload
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                // Handle the server response here (if needed)
                console.log(response);

                // Handle the response based on success or error
                if (response.status === 'success') {
                    // Success
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Electronics added successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        // Optionally, redirect or perform additional actions after success
                        // For example, reload the page
                        window.location.reload();
                    });
                } else {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding data: ' + response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        // Handle error as needed
                    });
                }
            },
            error: function (error) {
                // Handle errors (if any)
                console.log(error);
            }
        });
    });
});

// JavaScript to show/hide the quantity input and info image based on the radio button selection
document.addEventListener('DOMContentLoaded', function () {
    var singleRadio = document.getElementById('single');
    var multipleRadio = document.getElementById('multiple');
    var quantityInput = document.getElementById('quantityInput');
    var infoImage = document.getElementById('infoImage');

    function updateVisibility() {
        quantityInput.style.display = multipleRadio.checked ? 'block' : 'none';
        infoImage.style.display = multipleRadio.checked ? 'inline' : 'none';
    }

    singleRadio.addEventListener('change', updateVisibility);
    multipleRadio.addEventListener('change', updateVisibility);

    // Initialize visibility based on the default state
    updateVisibility();
});

// Tooltip for info image
$(document).ready(function() {
    $('#infoImage').attr('title', 'When selecting multiple, system will add number according to the quantity to the back of the name.');
});

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
    var categoryInput = document.getElementById('display_name_asset_category');
    var prefixInput = document.getElementById('prefix');

    if (categoryInput.value.length >= 2) {
        prefixInput.value = 'E' + categoryInput.value.substring(0, 2).toUpperCase();
    } else if (categoryInput.value.length === 1) {
        prefixInput.value = 'E' + categoryInput.value.toUpperCase() + 'X';
        // The 'X' or any other letter is added to ensure a minimum length of 3 characters.
    } else {
        prefixInput.value = 'E';
    }
}

function limitInputToRange(inputElement) {
  // Get the min and max values from the input attributes
  const min = parseFloat(inputElement.getAttribute('min'));
  const max = parseFloat(inputElement.getAttribute('max'));

  // Add an event listener to the input element
  inputElement.addEventListener('input', function() {
    // Get the current value of the input
    let inputValue = parseFloat(inputElement.value);

    // Check if the input is a valid number
    if (isNaN(inputValue)) {
      // If not a valid number, set the value to the minimum
      inputElement.value = min;
    } else {
      // If the input is less than the minimum, set it to the minimum
      if (inputValue < min) {
        inputElement.value = min;
      }
      // If the input is greater than the maximum, set it to the maximum
      else if (inputValue > max) {
        inputElement.value = max;
      }
    }
  });
}

function clearSearch() {
    var input = document.getElementById('myInput');
    input.value = '';
    filterFunction(); // Call your filter function after clearing the input

    // Clear related fields and hide the dropdown
    resetRelatedFields();
}

function resetRelatedFields() {
    // Clear the fields you want to reset
    document.getElementById("name").value = "";
    document.getElementById("category").value = "";
    document.getElementById("date_purchase").value = "";
    document.getElementById("price").value = "";
    document.getElementById("branch").value = "";
    document.getElementById("department").value = "";
    document.getElementById("location").value = "";
    document.getElementById("user").value = "";
    document.getElementById("brand").value = "";
    document.getElementById("supplier").value = "";
    // Clear the smart search input
    document.getElementById("myInput").value = "";
}

function filterFunction() {
    var input, filter, div, p, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    p = div.getElementsByTagName("p");

    // Show or hide the dropdown based on the filter
    if (filter === "") {
        div.style.display = "none";
    } else {
        div.style.display = "block";
    }

    for (i = 0; i < p.length; i++) {
        txtValue = p[i].textContent || p[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            p[i].style.display = "";
        } else {
            p[i].style.display = "none";
        }
    }
}

document.getElementById("myInput").addEventListener("input", function(event) {
    var selectedText = event.target.value;
    var selectedItem = findSmartSearchItem(selectedText);

    if (selectedItem) {
        // Call populateFormFields with the selected name
        populateFormFields(selectedItem.item.name, selectedItem.item.category);
        // Hide the dropdown after selection
        document.getElementById("myDropdown").style.display = "none";
        // Display selected data in the input field
        document.getElementById("myInput").value = selectedText;
    }
});

function populateFormFields(name, category) {
    $.ajax({
        type: "POST",
        url: "module/electronics/get_electronics_ajax.php",
        data: { name: name, category: category },
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#name").val(data["name"]);
                $("#category").val(data["category"]);
                $("#brand").val(data["brand"]);
                $("#date_purchase").val(data["date_purchase"]);
                $("#price").val(data["price"]);
                $("#user").val(data["user"]);
                $("#branch").val(data["branch"]);
                $("#department").val(data["department"]);
                $("#location").val(data["location"]);
                $("#supplier").val(data["supplier"]);

                // Set the selected data in the smart search input
                document.getElementById("myInput").value = name + ' - ' + category;
                // Hide the dropdown after selection
                document.getElementById("myDropdown").style.display = "none";

            } catch (e) {
                // Handle any errors or clear the fields as needed
                $("#name").val("");
                $("#category").val("");
                $("#brand").val("");
                $("#date_purchase").val("");
                $("#price").val("");
                $("#user").val("");
                $("#branch").val("");
                $("#department").val("");
                $("#location").val("");
                $("#supplier").val("");
                // Clear other form fields here

                // Set the selected data in the smart search input
                document.getElementById("myInput").value = name + ' - ' + category;
                // Hide the dropdown after selection
                document.getElementById("myDropdown").style.display = "none";
            }
        }
    });
}

function findSmartSearchItem(selectedText) {
    var smartSearchs = <?php echo json_encode($smartSearchs); ?>;
    for (var i = 0; i < smartSearchs.length; i++) {
        var item = smartSearchs[i];
        var itemText = item.name + ' - ' + item.category;
        if (itemText === selectedText) {
            return { index: i, item: item };
        }
    }
    return null;
}


// Add an event listener to the checkbox to toggle the display of warranty fields
document.getElementById('warranty_checkbox').addEventListener('change', function() {
    var warrantyFields = document.querySelectorAll('.warranty-fields');
    warrantyFields.forEach(function(field) {
        field.style.display = this.checked ? 'block' : 'none';
    }, this);
});

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

// submit using ajax
$(document).ready(function () {
    $('form').submit(function (e) {
        e.preventDefault();

        // Show a confirmation dialog
        Swal.fire({
            title: 'Confirm',
            text: 'Are you sure you want to submit this form?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, submit it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // User confirmed, proceed with AJAX request

                // Disable the submit button to prevent multiple submissions
                $('button[type="submit"]').prop('disabled', true);

                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    success: function (response) {
                        // Handle the response as before
                        if (response.trim() == "true") {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Asset added successfully!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                window.location.href = './addelectronics';
                            });
                        } else if (response.trim() == "duplicate") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There is duplicate name! Please try again or use another name.',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                return false;
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!' + response,
                                showConfirmButton: false,
                                timer: 20000
                            }).then(function () {
                                window.location.href = './addelectronics';
                            });
                        }
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            }
        });
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
            url: './module/setting/preset_location/location/addlocation_action.php',
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
            url: './module/setting/preset_location/department/adddepartment_action.php',
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

                        // Update the nameList in addLocationModal
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

    // Function to update sectionList in addDepartmentModal
    function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/asset/get_department_names.php',
            success: function(response) {
                // Update the sectionList with the new categories
                $('#sectionList').html(response);
            },
            error: function(error) {
                console.log('Error fetching department names: ' + error);
            }
        });
    }
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

    // Function to update buildingList in addDepartmentModal
    function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/asset/get_branch_names.php',
            success: function(response) {
                // Update the buildingList with the new categories
                $('#buildingList').html(response);
            },
            error: function(error) {
                console.log('Error fetching branch names: ' + error);
            }
        });
    }
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
            <td><input type="text" name="view[]" class="form-control" ></td>
            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control"></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deletePicture(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deletePicture(input) {
    document.getElementById('picture-table').removeChild(input.parentNode.parentNode);
}

function getStaffDetails(name, contactNoId) {
    $.ajax({
        type: "POST",
        url: "module/people/staff/get_staff_detail_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#" + contactNoId).text(data["contact_no"]);
            } catch (e) {
                $("#" + contactNoId).text("");
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

                // Add "Add New Department" option if it doesn't exist
                if (!$('#departmentList option[value="Add New Department"]').length) {
                    $('#departmentList').append('<option value="Add New Department" data-action="addNewDepartment">Add New Department</option>');
                }
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

                // Add ""Add New Location" option if it doesn't exist
                if (!$('#locationList option[value="Add New Location"]').length) {
                    $('#locationList').append('<option value="Add New Location" data-action="addNewLocation">Add New Location</option>');
                }
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

