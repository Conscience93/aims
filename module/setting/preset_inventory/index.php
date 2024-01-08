<style>
	.action-button {
		cursor: pointer;
	}

    /* Define styles for odd rows in striped-tables */
    table.striped-table tr:nth-child(odd) {
        background-color: #f2f2f2; /* Set the background color for odd data rows */
    }

    /* Define styles for even rows in striped-tables */
    table.striped-table tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even data rows */
    }

    /* Style for radioboxes */
    input[type="radio"] {
        border-radius: 4px; /* Add border-radius for rounded corners */
        cursor: pointer; /* Change cursor to pointer on hover */
        margin-left: 50px;
    }

    /* Style for checked radioboxes */
    input[type="radio"]:checked {
        background-color: #2196F3; /* Set background color when checked */
        border-color: #2196F3; /* Set border color when checked */
        color: #fff; /* Set text color when checked */
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

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-inventory_category" data-toggle="tab" href="#inventory_category" role="tab" aria-controls="inventory_category" aria-selected="false">
                Inventory Category (<?php
                        $sqlTotalinventory_category = "SELECT id FROM aims_inventory_category";
                        $queryTotalinventory_category = mysqli_query($con, $sqlTotalinventory_category);
                        $totalinventory_category = mysqli_num_rows($queryTotalinventory_category);
                    echo $totalinventory_category;
                ?>)
            </a>
        </li>
        <li>
            <a class="nav-link" id="tab-inventory_item_tag" data-toggle="tab" href="#inventory_item_tag" role="tab" aria-controls="inventory_item_tag" aria-selected="false">
                Inventory Type (<?php
                        $sqlTotalinventory_item_tag = "SELECT id FROM aims_inventory_category_run_no";
                        $queryTotalinventory_item_tag = mysqli_query($con, $sqlTotalinventory_item_tag);
                        $totalinventory_item_tag = mysqli_num_rows($queryTotalinventory_item_tag);
                    echo $totalinventory_item_tag;
                ?>)
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Tab Inventory Category -->
        <div class="tab-pane fade show active" id="inventory_category" role="tabpanel" aria-labelledby="tab-inventory_category">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Inventory Item Category</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_inventory_category_item" class="btn btn-primary">Add Category</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_inventory_category" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        // Query location information with manager's contact number
                        $sql = "SELECT * FROM aims_inventory_category GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['name']."</td>";
                            echo "<td>
                                    <a id='inventoryCategoryViewBtn' href='./view_inventory_item_category?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='inventoryCategoryEditBtn' href='./edit_inventory_item_category?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='inventoryCategoryDeleteBtn' class='action-button mx-1' onclick='confirmDeleteInventoryCategory(".$row['id']. ",\"\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 

        <!-- Tab Inventory Item Tag -->
        <div class="tab-pane fade" id="inventory_item_tag" role="tabpanel" aria-labelledby="tab-inventory_item_tag">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Inventory Item Category</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_inventory_item_tag" class="btn btn-primary">Add Type</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_inventory_item_tag" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Type</th>
                                <th>Display Name</th>
                                <th>Prefix</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        // Query location information with manager's contact number
                        $sql = "SELECT * FROM aims_inventory_category_run_no GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>".$row['prefix']."</td>";
                            echo "<td>
                                    <a id='inventoryTypeViewBtn' href='./view_inventory_item_type?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='inventoryTypeEditBtn' href='./edit_inventory_item_type?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='inventoryTypeDeleteBtn' class='action-button mx-1' onclick='confirmDeleteInventoryType(".$row['id']. ",\"\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 
    </div>  
</div>


<script>

    //inventory category
    $(document).ready(function() {
        $('#table_inventory_category').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 1 }
                ]
            }
        );
    });

    //inventory type
    $(document).ready(function() {
        $('#table_inventory_item_tag').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 1 }
                ]
            }
        );
    });

    //inventory category
    function confirmDeleteInventoryCategory(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete category with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteInventoryCategory(id);
        }
        });
        }

    function deleteInventoryCategory(id) {
        $.ajax({
        url: "module/setting/preset_inventory/inventory_category/delete_inventory_item_category.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The category has been deleted.',
                showConfirmButton: false,
                timer: 20000
            }).then(function() {
                window.location.href = './preset_inventory';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the category.' + error,
                showConfirmButton: true,
                timer: 20000
            }).then(function() {
                window.location.href = './preset_inventory';
            });
        }
        });
    }

    //inventory type
    function confirmDeleteInventoryType(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete type with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteInventoryType(id);
        }
        });
        }

    function deleteInventoryType(id) {
        $.ajax({
        url: "module/setting/preset_inventory/inventory_item_tag/delete_inventory_item_tag.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The type has been deleted.',
                showConfirmButton: false,
                timer: 20000
            }).then(function() {
                window.location.href = './preset_inventory';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the type.' + error,
                showConfirmButton: true,
                timer: 20000
            }).then(function() {
                window.location.href = './preset_inventory';
            });
        }
        });
    }
</script>