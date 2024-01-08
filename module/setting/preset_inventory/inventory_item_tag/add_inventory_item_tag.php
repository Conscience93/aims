<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

?>

<style>
    textarea {
    resize: none;
    }

    .card-body {
    max-height: 650px; /* Adjust the height as needed */
    overflow-y: scroll;
    }

    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .row .float-right button {
        margin-left: 5px; /* Adjust the margin as needed */
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

</style>

<div class="main">
        <form action=".\module\setting\preset_inventory\inventory_item_tag\add_inventory_item_tag_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add New Inventory Item Tag</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./preset_inventory" class="btn btn-danger">Discard</a>
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>New Inventory Item Tag</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <div class="input-group">
                                <input list="inventoryCategoryList" name="category" id="category" class="form-control" required onchange="autoFillPrefix()">
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
                    <div class="col-4">
                        <div class="form-group">
                            <label for="display_name">Inventory Display Name</label>
                            <input type="text" id="display_name" name="display_name" class="form-control" oninput="autoFillPrefix()">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="prefix">Prefix</label>
                            <input type="text" id="prefix" name="prefix" class="form-control" oninput="capitalizeAndLimitTo3()">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            // Log the response for debugging
            console.log(response);

            if(response.trim() === "true"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Item Tag added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './add_inventory_item_tag';
                });
            } else {
                // Display an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! ' + response, // Display the response from the server for debugging
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './add_inventory_item_tag';
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors here
            console.error(xhr.responseText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
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
    var categoryInput = document.getElementById('display_name');
    var prefixInput = document.getElementById('prefix');

    // Take the first three characters of the categoryInput and convert to uppercase
    prefixInput.value = categoryInput.value.substring(0, 3).toUpperCase();
}

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
