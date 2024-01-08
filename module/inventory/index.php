<?php 
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
?>

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

    #table_all_item img,
    #table_fixed_item img,
    #table_electronics img,
    #table_computer img,
    #table_vehicle img,
    #table_property img {
        max-width: 100px; /* Adjust the maximum width as needed */
        max-height: 100px; /* Adjust the maximum height as needed */
        width: auto;
        height: auto;
    }

    .item-image {
        max-width: 100%;
        max-height: 100%;
        width: auto;
        height: auto;
        cursor: pointer;
    }

    .modal-backdrop {
        display: none;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        margin-top: 50px;
        padding-top: 60px;
    }

    .modal-header {
        background-color: #007bff; /* Blue header background */
        color: #fff; /* White text color */
        border-bottom: none; /* Remove the default border */
    }

    .modal-header .close {
        color: #fff;
    }

    .modal-title {
        font-weight: bold;
    }

    /* Style the "Add Category" button */
    .btn-primary {
        background-color: #007bff; /* Blue background for the button */
        color: #fff; /* White text color */
    }

    /* Style the "Close" button */
    .btn-close {
        background-color: #ccc; /* Gray background for the button */
        color: #333; /* Dark text color */
    }

    .btn-close:hover {
        background-color: #ddd; /* Example background color on hover */
        color: #333; /* Example text color on hover */
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 70%;
        max-width: 500px;
    }

    /* Add this if you want to center the image horizontally in the modal */
    #modalImage {
        max-width: 370px;
        max-height: 250px;
        display: block;
        margin: auto;
    }

    .modal-content img {
        max-width: 370px; /* Set the maximum width to 100% of the container */
        max-height: 250px; /* Set the maximum height as desired */
        width: auto; /* Allow the image to scale proportionally */
        height: auto; /* Allow the image to scale proportionally */
    }

    .additional-images-container {
        display: flex;
        overflow-x: auto; /* Enable horizontal scrolling if needed */
        gap: 10px; /* Adjust the space between images */
        }

    .additional-images-container img {
        max-width: 100%;
        max-height: 100px;
        width: auto;
        height: auto;
        cursor: pointer;
        border: 5px solid transparent; /* Add a border to make images stand out */
        transition: border-color 0.3s ease; /* Smooth transition for border color */
    }

    .additional-images-container img:hover {
        border-color: #007bff; /* Change border color on hover */
    }

    .additional-images-container img.selected-image {
        border: 5px solid #007bff; /* Highlight the selected image with a blue border */
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%; /* Adjust the modal width for smaller screens */
        }
    }

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-all-item" data-toggle="tab" href="#all-item" role="tab" aria-controls="all-item" aria-selected="true">
                All (<?php
                        $sqlTotalAll = "SELECT
                            (SELECT COUNT(*) FROM aims_inventory) AS total_count;
                        ";
                        $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                        $totalAll = mysqli_fetch_assoc($queryTotalAll)['total_count'];
                    echo $totalAll;
                ?>)
            </a>
        </li>
        <!-- Add new branch tabs dynamically -->
        <?php
        $sqlBranches = "SELECT id, display_name FROM aims_preset_computer_branch";
        $resultBranches = mysqli_query($con, $sqlBranches);
        
        while ($rowBranch = mysqli_fetch_assoc($resultBranches)) {
            $branchId = $rowBranch['id'];
            $branchName = $rowBranch['display_name'];
            echo "<li class='nav-item' role='presentation'>
                    <a class='nav-link' id='tab-branch-$branchId-link' data-toggle='tab' href='#tab-branch-$branchId' role='tab' aria-controls='tab-branch-$branchId' aria-selected='false'>
                        $branchName
                    </a>
                </li>";
        }
        ?>
    </ul>


    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: All item -->
        <div class="tab-pane fade show active" id="all-item" role="tabpanel" aria-labelledby="tab-all-item">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>All item</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./addinventory" class="btn btn-info">Add item</a>
                                <!-- <a href="" onclick="history.back()" class="btn btn-danger">Back</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                    <table id="table_inventory" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Item Tag</th>
                                <th>Stock</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Class</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $items = array();

                        $sqlAll = "SELECT * FROM aims_inventory";
                        $queryAll = mysqli_query($con, $sqlAll);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            $itemTag = $row['item_tag'];
                            if (!isset($items[$itemTag])) {
                                $items[$itemTag] = array(
                                    'id' => $row['id'], // Add 'id' to the array
                                    'item_tag' =>  $row['item_tag'],
                                    'stock' => $row['stock'],
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'class' => $row['class'],
                                );
                            }
                        }
                        foreach ($items as $item) {
                            echo "<tr data-item-tag='" . $item['item_tag'] . "'>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$item['item_tag']."</td>";
                            echo "<td>".$item['stock']."</td>";
                            echo "<td>".$item['name']."</td>";
                            echo "<td>".$item['category']."</td>";
                            echo "<td>".$item['class']."</td>";
                            // Display the action column
                            echo "<td style='text-align:center;'>
                                    <a id='EditBtn' href='./viewinventory?id=".$item['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='EditBtn' href='./editinventory?id=".$item['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='DeleteBtn' class='action-button mx-1' onclick='confirmDeleteInventory(".$item['id']. ",\"".$item['item_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>   
        <!-- Add new branch tabs dynamically -->
        <?php
        $resultBranches = mysqli_query($con, $sqlBranches);

        // Initialize DataTable before the loop
        echo '<script>
            $(document).ready(function() {
                $(".dataTable").DataTable({
                    "paging": true,
                    "ordering": true,
                    "info": true,
                    "searching": true,
                    "columnDefs": [
                        { "orderable": false, "targets": 6 } // Adjust the target column index as needed
                    ]
                });
            });
        </script>';

        while ($rowBranch = mysqli_fetch_assoc($resultBranches)) {
            $branchId = $rowBranch['id'];
            $branchName = $rowBranch['display_name'];

            echo '<div class="tab-pane fade" id="tab-branch-'.$branchId.'" role="tabpanel" aria-labelledby="tab-branch-'.$branchId.'">
                    <div class="card shadow rounded">
                        <div class="card-header" style="background:white;">
                            <div class="row">
                                <div class="col-6">
                                    <h2>'.$branchName.'</h2>
                                </div>
                                <div class="col-6">
                                    <div class="float-right">
                                        <a href="./addinventory" class="btn btn-info">Add item</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                            <table class="dataTable striped-table" id="table_'.$branchName.'">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Item Tag</th>
                                        <th>Stock</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Class</th>
                                        <th style="text-align:center;">Action</th>
                                    </tr>
                                </thead>';

            $items = array();

            $sqlAll = "SELECT * FROM aims_inventory";
            $queryAll = mysqli_query($con, $sqlAll);

            $rowNumber = 1; // Initialize a row counter

            while ($row = mysqli_fetch_assoc($queryAll)) {
                $itemTag = $row['item_tag'];
                if (!isset($items[$itemTag])) {
                    $items[$itemTag] = array(
                        'id' => $row['id'],
                        'item_tag' => $row['item_tag'],
                        'stock' => $row['stock'],
                        'name' => $row['name'],
                        'category' => $row['category'],
                        'class' => $row['class'],
                    );
                }
            }

            foreach ($items as $item) {
                echo "<tr data-item-tag='" . $item['item_tag'] . "'>";
                echo "<td>".$rowNumber."</td>";
                echo "<td>".$item['item_tag']."</td>";
                echo "<td>".$item['stock']."</td>";
                echo "<td>".$item['name']."</td>";
                echo "<td>".$item['category']."</td>";
                echo "<td>".$item['class']."</td>";
                echo "<td style='text-align:center;'>
                        <a id='EditBtn' href='./viewinventory?id=".$item['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                        <a id='EditBtn' href='./editinventory?id=".$item['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                        <a id='DeleteBtn' class='action-button mx-1' onclick='confirmDeleteInventory(".$item['id']. ",\"".$item['item_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                    </td>";
                echo "</tr>";

                $rowNumber++;
            }

            echo '</table>
                </div>
            </div>
        </div>';
        }
        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>

    //datatable
    $(document).ready(function() {
        $('#table_inventory').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );
    });

    // Retrieve selected categories from local storage
    const selectedCategories = JSON.parse(localStorage.getItem('selectedCategories')) || [];

    // Function to update tab visibility based on selected categories

    function confirmDeleteInventory(id, item_tag) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete stock with Tag: " + item_tag + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteInventory(id);
        }
        });
        }

    function deleteInventory(id) {
        $.ajax({
        url: "./module/inventory/deleteinventory_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The stock has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './inventory';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the item.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './inventory';
            });
        }
        });
    }
</script>