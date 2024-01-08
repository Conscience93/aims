<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_inventory where id ='".$_GET['id']."'";
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

    .dropdown {
        display: inline-block;
        position: relative;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 250%;
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

    #myInput {
        padding-right: 20px; /* Space for the 'x' button */
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
        left: 240%;
        right: 8px; /* Adjust the distance from the right edge */
        transform: translateY(-50%);
        cursor: pointer;
        color: #888; /* Color of the 'x' button */
        font-weight: bold;
        font-size: 20px;
    }

    .clear-button:hover {
        color: #333;
    }

    .category-clear-button{
        position: absolute;
        top: 55%;
        left: 90%;
        right: 8px; /* Adjust the distance from the right edge */
        transform: translateY(-50%);
        cursor: pointer;
        color: #888; /* Color of the 'x' button */
        font-weight: bold;
        font-size: 20px;
    }

    .green-button {
        background-color: green;
    }
</style>

<div class="main">
    <form action=".\module\inventory\editinventory_action.php" method="POST" enctype="multipart/form-data">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Inventory: <?php echo $row['item_tag']?></h4>
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
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
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
                            <input type="text" id="stock" name="stock" value="<?php echo $row['stock'];?>" class="form-control" >
                        </div>
                    </div>
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?php echo $row['name'];?>" class="form-control" >
                        </div>
                    </div>
                    <!-- po_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="po_number">PO Number</label>
                            <input type="text" id="po_number" name="po_number" value="<?php echo $row['po_number'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- do_number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="do_number">DO Number</label>
                            <input type="text" id="do_number" name="do_number" value="<?php echo $row['do_number'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- created_date -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="created_date">Created Date</label>
                            <input type="date" id="created_date" name="created_date" value="<?php echo $row['created_date'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- default_location -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="default_location">Default Location</label>
                            <input type="text" id="default_location" name="default_location" value="<?php echo $row['default_location'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input list="inventoryCategoryList" name="category" value="<?php echo $row['category'];?>" id="category" class="form-control">
                                <datalist id="inventoryCategoryList">
                                    <?php 
                                    $sql_categories = "SELECT name FROM aims_inventory_category";
                                    $result_categories = mysqli_query($con, $sql_categories);
                                    while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                        $categories[] = $row_categories;
                                    }
                                    if ($categories == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['name']; ?>" <?php if($row['category'] == $category['name']) {echo 'selected';} ?>><?php echo $category['name']; ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </select>
                        </div>
                    </div>
                    <!-- type -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input list="itemTagList" name="type" value="<?php echo $row['type'];?>" id="type" class="form-control">
                                <datalist id="itemTagList">
                                    <?php 
                                    $sql_types = "SELECT display_name FROM aims_inventory_category_run_no";
                                    $result_types = mysqli_query($con, $sql_types);
                                    while ($row_types = mysqli_fetch_assoc($result_types)) {
                                        $types[] = $row_types;
                                    }
                                    if ($types == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($types as $type): ?>
                                        <option value="<?php echo $type['display_name']; ?>" <?php if($row['type'] == $type['display_name']) {echo 'selected';} ?>><?php echo $type['display_name']; ?></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </select>
                        </div>
                    </div>
                    <!-- class -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="class">Class</label>
                            <input type="text" id="class" name="class" value="<?php echo $row['class'];?>" class="form-control" >
                        </div>
                    </div>
                    <!-- uom -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="uom">UOM#</label>
                            <input type="text" id="uom" name="uom" value="<?php echo $row['uom'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- sales_price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="sales_price">Sales Price(RM)</label>
                            <input type="number" id="sales_price" name="sales_price" value="<?php echo $row['sales_price'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- purchase_price -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="purchase_price">Purchase Price(RM)</label>
                            <input type="number" id="purchase_price" name="purchase_price" value="<?php echo $row['purchase_price'];?>" class="form-control">
                        </div>
                    </div>
                </div>
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
                        text: 'Stock edited successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = './inventory';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './editinventory?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
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
});
</script>