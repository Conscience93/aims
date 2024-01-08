<?php
$user_group_id = $_SESSION['aims_user_group_id'];

if ($submodule_access['asset']['add'] != 1) {
    header('location: logout.php');
    exit; // Ensure script stops executing after redirect
}

include_once 'include/db_connection.php';  
?>

<style>
    .main span {
        height: 2.3rem;
    }

    .dropdown {
        display: inline-block;
        position: relative;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 250%;
        padding-right: 20px; /* Space for the 'x' button */
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
        width: 800px;
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

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%; /* Adjust the modal width for smaller screens */
        }
    }
</style>

<div class="main">
    <form action=".\module\property\land\addland_action.php" method="POST" enctype="multipart/form-data">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Add Land Property Information</h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <!-- Button styled like a button, triggers file input click -->
                        <button type="button" id="importButton" class="btn btn-primary" style="margin-right: 5px; background-color: green;">Import</button>
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button>
                        <a href="./addproperty" class="btn btn-danger">Discard</a>
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
                                    // Populate options from 1 to 50
                                    for ($i = 1; $i <= 50; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                     <!-- smartsearch -->
                    <div class="col-6">
                        <div class="dropdown">
                            <label for="smartSearch"><b>Smart Search</b></label>
                            <div class="input-container">
                                <input type="text" placeholder="Search.." id="myInput" oninput="filterFunction()">
                                <span class="clear-button" onclick="clearSearch()">x</span>
                            </div>
                            <div id="myDropdown" class="dropdown-content" style="display: none;">
                                <?php 
                                $sql_smartSearchs = "SELECT * FROM aims_property_land";
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
                            <label for="name" style="margin-right: 10px; margin-top: 0px; margin-bottom: 0;">Name<span style="color: red;"> *</span></label>
                            <img id="infoImage" src='./include/action/info.png' alt='Info' title='Additional Information: This is the name field where you enter the name of the asset.' width='16' height='16' style="display: none;">
                        </div>
                        <div style="margin-top: -7px;">
                            <input type="text" id="name" name="name" placeholder="Name" class="form-control" required>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category<span style="color: red;"> *</span></label>
                            <div class="input-group">
                                <input list="assetCategoryList" name="category" id="category" class="form-control" required>
                                <span class="category-clear-button" onclick="clearSearch()">x</span>
                            </div>
                            <datalist id="assetCategoryList">
                                <option value="">Select Category</option>
                                <?php 
                                $sql_categories = "SELECT category, display_name FROM aims_land_category_run_no";
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
                            </datalist>
                        </div>
                    </div>
                    <!-- price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" placeholder="Price in Ringgit"  class="form-control" step="any" min="0">
                        </div>
                    </div>
                    <!-- land_area_price  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="land_area_price">Land Area Price(per sq. ft.)</label>
                            <input type ="text" id="land_area_price" name="land_area_price" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- land_area_size  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="land_area_size">Land Area Size(sq. ft)</label>
                            <input type ="text" id="land_area_size" name="land_area_size" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- remarks  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="remarks">Any Remarks</label>
                            <input type ="text" id="remarks" name="remarks" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- address  -->
                    <div class="col-8">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type ="text" id="address" name="address" placeholder="" class="form-control">
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
                    
                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
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

<!-- Modal for adding a new AssetCategory -->
<form action="./module/property/land/addland_category_run_no.php" method="POST" enctype="multipart/form-data" id="addAssetCategoryForm">
    <div class="modal fade" id="addAssetCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addAssetCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addAssetCategoryForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAssetCategoryLabel">Add New Asset Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name_asset_category">Asset Category Name</label>
                            <input type="text" id="display_name_asset_category" name="display_name" placeholder="" class="form-control" oninput="autoFillPrefix()">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" placeholder="same as asset category name" class="form-control" oninput="convertToLowerCase(this)">
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
                        <button type="button" id="addAssetCategoryButton" class="btn btn-primary">Add Asset Category</button>
                        <div id="successMessage" class="text-success"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
function downloadTemplate() {
    var link = document.createElement('a');
    link.href = './include/upload/templates/asset/template_asset.xlsx';
    link.download = 'template_asset.xlsx';
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
            url: './module/asset/upload.php', // Replace with the actual server-side script handling the file upload
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
                        text: 'Asset added successfully!',
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

    if (categoryInput.value.length >= 1) {
        prefixInput.value = 'PL' + categoryInput.value.substring(0, 1).toUpperCase();
    } else if (categoryInput.value.length === 1) {
        prefixInput.value = 'PL' + categoryInput.value.toUpperCase() + 'X';
        // The 'X' or any other letter is added to ensure a minimum length of 3 characters.
    } else {
        prefixInput.value = 'PL';
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
        url: "module/asset/get_fixed_asset_ajax.php",
        data: { name: name, category: category },
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#name").val(data["name"]);
                $("#category").val(data["category"]);
                $("#date_purchase").val(data["date_purchase"]);
                $("#price").val(data["price"]);
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
                $("#date_purchase").val("");
                $("#price").val("");
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
                                text: 'Asset pending for approval!',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(function () {
                                window.location.href = './addland';
                            });
                        } else if (response.trim() == "duplicate") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'There is duplicate name! Please use another name and try again.',
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
                                window.location.href = './addland';
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
        if (!/^PL/.test(prefixValue)) {
            // Show an error message for the prefix
            $('#prefixError').text("The prefix must start with the letter 'PL'");
        } else {
            // Prefix is valid, proceed with form submission
            // Clear any previous error message
            $('#prefixError').text("");
            $('#successMessage').text("");

            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            var formData = new FormData($('#addAssetCategoryForm')[0]);

            $.ajax({
                url: './module/property/land/addland_category_run_no.php',
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
                        $('#prefixError').text('Duplicate Data.Please enter a non-existing data.');
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