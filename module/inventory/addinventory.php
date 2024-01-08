<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
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

    .dropdown {
        display: inline-block;
        position: relative;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 300%;
    }

    #myDropdown {
        display: none;
        position: absolute;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        max-height: 200px;
        width: 300%;
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

    .input-container {
        position: relative;
        width: 100%;
        }

    #myInput {
        padding-right: 20px; /* Space for the 'x' button */
    }

    .clear-button {
        position: absolute;
        top: 50%;
        left: 290%;
        right: 8px; /* Adjust the distance from the right edge */
        transform: translateY(-50%);
        cursor: pointer;
        color: #888; /* Color of the 'x' button */
        font-weight: bold;
        font-size: 20px;
    }

    .input-container {
        position: relative;
        width: 100%;
        }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%; /* Adjust the modal width for smaller screens */
        }
    }
</style>

<div class="main">
    <form action=".\module\inventory\addinventory_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Enter Stock Information</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./inventory" class="btn btn-danger">Discard</a>
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
                    <!-- stock -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="stock">Stock#</label>
                            <input type="text" id="stock" name="stock" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- po_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="po_number">PO Number</label>
                            <input type="text" id="po_number" name="po_number" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- do_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="do_number">DO Number</label>
                            <input type="text" id="do_number" name="do_number" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- created_date -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="created_date">Created Date</label>
                            <input type="date" id="created_date" name="created_date" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- default_location -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="default_location">Default Location</label>
                            <input type="text" id="default_location" name="default_location" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <div class="input-group">
                                <input list="inventoryCategoryList" name="category" id="category" class="form-control" required>
                            </div>
                            <datalist id="inventoryCategoryList">
                                <?php 
                                $sql_categories = "SELECT name FROM aims_inventory_category";
                                $result_categories = mysqli_query($con, $sql_categories);
                                $categories=[];
                                while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                    $categories[] = $row_categories;
                                }
                                if ($categories == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else
                                foreach ($categories as $category): ?>
                                    <option value="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></option>
                                <?php endforeach; ?>
                                <option value="Add New Category" data-action="addNewCategory">Add New Category</option>
                            </datalist>
                        </div>
                    </div>
                    <!-- type -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <div class="input-group">
                                <input list="itemTagList" name="type" id="type" class="form-control" required>
                            </div>
                            <datalist id="itemTagList">
                                <?php 
                                $sql_types = "SELECT display_name FROM aims_inventory_category_run_no";
                                $result_types = mysqli_query($con, $sql_types);
                                $types=[];
                                while ($row_types = mysqli_fetch_assoc($result_types)) {
                                    $types[] = $row_types;
                                }
                                if ($types == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else
                                foreach ($types as $type): ?>
                                    <option value="<?php echo $type['display_name']; ?>"><?php echo $type['display_name']; ?></option>
                                <?php endforeach; ?>
                                <option value="Add New Item Tag" data-action="addNewItemTag">Add New Item Tag</option>
                            </datalist>
                        </div>
                    </div>
                    <!-- class -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="class">Class</label>
                            <input type="text" id="class" name="class" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- uom -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="uom">UOM</label>
                            <input type="text" id="uom" name="uom" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- sales_price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="sales_price">Sales Price</label>
                            <input type="number" id="sales_price" name="sales_price" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- purchase_price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="purchase_price">Purchase Price</label>
                            <input type="text" id="purchase_price" name="purchase_price" placeholder="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for adding a new Category -->
<form action="./module/setting/preset_inventory/inventory_category/add_inventory_item_category_action.php" method="POST" enctype="multipart/form-data" id="addCategoryForm">
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addCategoryForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryLabel">Add New Asset Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name_name">Inventory Item Category</label>
                            <input type="text" id="display_name_name" name="name"  class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addCategoryButton" class="btn btn-primary">Add New Category</button>
                        <div id="successMessage" class="text-success"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new Item Tag -->
<form action="./module/setting/preset_inventory/inventory_item_tag/add_inventory_item_tag_action.php" method="POST" enctype="multipart/form-data" id="addItemTagForm">
    <div class="modal fade" id="addItemTagModal" tabindex="-1" role="dialog" aria-labelledby="addItemTagLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemTagLabel">Add New Item Tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <div class="input-group">
                            <input list="nameList" name="category" id="category" class="form-control" required onchange="autoFillPrefix()">
                        </div>
                        <datalist id="nameList">
                            <?php 
                            $sql_categories = "SELECT name FROM aims_inventory_category";
                            $result_categories = mysqli_query($con, $sql_categories);
                            $categories=[];
                            while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                $categories[] = $row_categories;
                            }
                            if ($categories == []) { ?>
                                <option value="">No Selection Found</option>
                            <?php } else
                            foreach ($categories as $category): ?>
                                <option value="<?php echo $category['name']; ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>
                    <div class="form-group">
                        <label for="display_name_item_tag">Inventory Display Name</label>
                        <input type="text" id="display_name_item_tag" name="display_name" class="form-control" oninput="autoFillPrefix()">
                    </div>
                    <div class="form-group">
                        <label for="prefix">Prefix</label>
                        <input type="text" id="prefix" name="prefix" class="form-control" oninput="capitalizeAndLimitTo3()">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="addItemTagButton" class="btn btn-primary">Add New Item Tag</button>
                    <div id="successMessage" class="text-success"></div>
                </div>
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

function autoFillPrefix() {
    var categoryInput = document.getElementById('display_name_item_tag');
    var prefixInput = document.getElementById('prefix');

    // Take the first three characters of the categoryInput and convert to uppercase
    prefixInput.value = categoryInput.value.substring(0, 3).toUpperCase();
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
                    text: 'Stock Added Successfully!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './addinventory';
                });
            }else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 20000
                }).then(function() {
                    window.location.href = './addinventory';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).ready(function() {
    // Make an AJAX request to fetch the display_name from aims_default_location
    $.ajax({
        url: "./module/inventory/fetch_display_name.php", // Update the path to your server script
        type: "GET",
        dataType: "json",
        success: function(response) {
            // Check if the response contains the display_name
            if (response.status === 'success' && response.display_name) {
                // Set the value of the input field with the fetched display_name
                $('#default_location').val(response.display_name);
            }
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            console.error('Error fetching display_name: ' + error);
        }
    });
});

$(document).ready(function() {
    // Event handler for category selection
    $('#category').change(function() {
        var selectedCategory = $(this).val();

        // AJAX request to fetch type based on the selected category
        $.ajax({
            type: 'POST',
            url: './module/inventory/get_item_tag_by_category.php',
            data: { category: selectedCategory },
            success: function(response) {
                // Update the type dropdown with the new options
                $('#itemTagList').html(response);

                // Add "Add New Item Tag" option if it doesn't exist
                if (!$('#itemTagList option[value="Add New Item Tag"]').length) {
                    $('#itemTagList').append('<option value="Add New Item Tag" data-action="addNewItemTag">Add New Item Tag</option>');
                }
            },
            error: function(error) {
                console.log('Error fetching type: ' + error);
            }
        });
    });

    // Event handler for clearing category value
    $('#category').on('input', function() {
        // If the category value is empty, clear the type options
        if ($(this).val() === '') {
            $('#itemTagList').empty();
        }
    });
});


$(document).ready(function () {
    // Show the modal when "Add New Category" is selected
    $('#category').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Category') {
            $('#addCategoryModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Category" option
    $('#inventoryCategoryList option[data-action="addNewCategory"]').click(function () {
        $('#addCategoryModal').modal('show');
        $('#category').val(''); // Clear the input field after opening the modal
    });

    $('#addCategoryButton').click(function() {
        var formData = new FormData($('#addCategoryForm')[0]);

        $.ajax({
            url: './module/setting/preset_inventory/inventory_category/add_inventory_item_category_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Category added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Category to the dropdown list
                        var newName = $('#display_name_name').val();
                        $('#inventoryCategoryList').append('<option value="' + newName + '">' + newName + '</option>');

                        // Optionally, you can select the newly added Category
                        $('#category').val(newName);

                        // Close the modal
                        $('#addCategoryModal').modal('hide');

                        // Update the nameList in addItemTagModal
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

    // Function to update nameList in addItemTagModal
    function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/inventory/get_category_names.php',
            success: function(response) {
                // Update the nameList with the new categories
                $('#nameList').html(response);
            },
            error: function(error) {
                console.log('Error fetching category names: ' + error);
            }
        });
    }
});

$(document).ready(function () {
    // Show the modal when "Add New Item Tag" is selected
    $('#type').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Item Tag') {
            $('#addItemTagModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New ItemTag" option
    $('#itemTagList option[data-action="addNewItemTag"]').click(function () {
        $('#addItemTagModal').modal('show');
        $('#type').val(''); // Clear the input field after opening the modal
    });

    $('#addItemTagButton').click(function(e) {
        e.preventDefault();
        var formData = new FormData($('#addItemTagForm')[0]);

        $.ajax({
            url: './module/setting/preset_inventory/inventory_item_tag/add_inventory_item_tag_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Item Tag added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Category to the dropdown list
                        var newItemTag = $('#display_name_item_tag').val();
                        $('#itemTagList').append('<option value="' + newItemTag + '">' + newItemTag + '</option>');

                        // Optionally, you can select the newly added Category
                        $('#type').val(newItemTag);

                        // Close the modal
                        $('#addItemTagModal').modal('hide');
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
</script>