<?php 
// for listing down categories
include_once 'include/db_connection.php';
$query = "SELECT category, display_name FROM aims_preset_category_run_no";
$result = mysqli_query($con, $query);
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
            <a class="nav-link active" id="tab-electronics_brand" data-toggle="tab" href="#electronics_brand" role="tab" aria-controls="electronics_brand" aria-selected="false">
                Electronics (<?php
                        $sqlTotalelectronics_brand = "SELECT id FROM aims_preset_electronics_brand";
                        $queryTotalelectronics_brand = mysqli_query($con, $sqlTotalelectronics_brand);
                        $totalelectronics_brand = mysqli_num_rows($queryTotalelectronics_brand);
                    echo $totalelectronics_brand;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-computer_brand" data-toggle="tab" href="#computer_brand" role="tab" aria-controls="computer_brand" aria-selected="false">
                Computer (<?php
                        $sqlTotalcomputer_brand = "SELECT id FROM aims_preset_devices_computer_brand";
                        $queryTotalcomputer_brand = mysqli_query($con, $sqlTotalcomputer_brand);
                        $totalcomputer_brand = mysqli_num_rows($queryTotalcomputer_brand);
                    echo $totalcomputer_brand;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-phone_brand" data-toggle="tab" href="#phone_brand" role="tab" aria-controls="phone_brand" aria-selected="false">
                Mobile (<?php
                        $sqlTotalphone_brand = "SELECT id FROM aims_preset_devices_phone_brand";
                        $queryTotalphone_brand = mysqli_query($con, $sqlTotalphone_brand);
                        $totalphone_brand = mysqli_num_rows($queryTotalphone_brand);
                    echo $totalphone_brand;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-virtual_machine" data-toggle="tab" href="#virtual_machine" role="tab" aria-controls="virtual_machine" aria-selected="false">
                Virtual Machine (<?php
                        $sqlTotalvirtual_machine = "SELECT id FROM aims_preset_virtual_machine";
                        $queryTotalvirtual_machine = mysqli_query($con, $sqlTotalvirtual_machine);
                        $totalvirtual_machine = mysqli_num_rows($queryTotalvirtual_machine);
                    echo $totalvirtual_machine;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-software_category" data-toggle="tab" href="#software_category" role="tab" aria-controls="software_category" aria-selected="false">
                Software Category (<?php
                        $sqlTotalsoftware_category = "SELECT id FROM aims_software_category";
                        $queryTotalsoftware_category = mysqli_query($con, $sqlTotalsoftware_category);
                        $totalsoftware_category = mysqli_num_rows($queryTotalsoftware_category);
                    echo $totalsoftware_category;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-remote_access" data-toggle="tab" href="#remote_access" role="tab" aria-controls="remote_access" aria-selected="false">
                Remote Access (<?php
                        $sqlTotalremote_access = "SELECT id FROM aims_preset_remote_access";
                        $queryTotalremote_access = mysqli_query($con, $sqlTotalremote_access);
                        $totalremote_access = mysqli_num_rows($queryTotalremote_access);
                    echo $totalremote_access;
                ?>)
            </a>
        </li>
    </ul>

   <div class="tab-content" id="myTabContent">
         <!-- Tab : Electronics Brand --> 
         <div class="tab-pane fade show active" id="electronics_brand" role="tabpanel" aria-labelledby="tab-electronics_brand">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Electronics Brand</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_electronics_brand" class="btn btn-primary">Add Electronic Brand</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_electronics_brand" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_asset table using pagination
                        $sql = "SELECT * FROM aims_preset_electronics_brand GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>
                                <!--<a id='Electronics_brandEditBtn' href='./viewelectronics_brand?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='Electronics_brandEditBtn' href='./editelectronics_brand?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp; -->
                                    <a id='Electronics_brandDeleteBtn' class='action-button mx-1' onclick='confirmDeleteElectronics_brand(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                    ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 4: Computer --> 
        <div class="tab-pane fade" id="computer_brand" role="tabpanel" aria-labelledby="tab-computer_brand">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Computer Brand</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_computer_brand" class="btn btn-primary">Add Computer Brand</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_computer_brand" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_asset table using pagination
                        $sql = "SELECT * FROM aims_preset_devices_computer_brand GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>
                                <!--<a id='computer_brandEditBtn' href='./viewcomputer_brand?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='computer_brandEditBtn' href='./editcomputer_brand?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp; -->
                                    <a id='computer_brandDeleteBtn' class='action-button mx-1' onclick='confirmDeletecomputer_brand(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                    ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 5: Mobile -->
        <div class="tab-pane fade" id="phone_brand" role="tabpanel" aria-labelledby="tab-phone_brand">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Smartphone/Tablet Brand</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_phone_brand" class="btn btn-primary">Add Mobile Brand</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_phone_brand" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Smartphone/Tablet Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    $sql = "SELECT * FROM aims_preset_devices_phone_brand GROUP BY id";
                    $query = mysqli_query($con, $sql);

                    $rowNumber = 1; // Initialize a row counter
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$rowNumber."</td>"; // Display the row number
                        echo "<td>".$row['display_name']."</td>";
                        echo "<td>
                        <!--    <a id='phone_brandEditBtn' href='./viewphone_brand?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='phone_brandEditBtn' href='./editphone_brand?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp; -->
                                <a id='phone_brandDeleteBtn' class='action-button mx-1' onclick='confirmDeletephone_brand(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";    
                        echo "</tr>";

                        $rowNumber++; // Increment the row counter
                    }
                ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab : Virtual Machine -->
        <div class="tab-pane fade" id="virtual_machine" role="tabpanel" aria-labelledby="tab-virtual_machine">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Virtual Machine Brand</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_virtual_machine" class="btn btn-primary">Add VM Brand</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_virtual_machine" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Virtual Machine Brand</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    $sql = "SELECT * FROM aims_preset_virtual_machine GROUP BY id";
                    $query = mysqli_query($con, $sql);

                    $rowNumber = 1; // Initialize a row counter
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$rowNumber."</td>"; // Display the row number
                        echo "<td>".$row['display_name']."</td>";
                        echo "<td>
                        <!--    <a id='virtual_machineEditBtn' href='./viewvirtual_machine?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='virtual_machineEditBtn' href='./editvirtual_machine?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp; -->
                                <a id='virtual_machineDeleteBtn' class='action-button mx-1' onclick='confirmDeletevirtual_machine(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";    
                        echo "</tr>";

                        $rowNumber++; // Increment the row counter
                    }
                ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 6: Software Category -->
        <div class="tab-pane fade" id="software_category" role="tabpanel" aria-labelledby="tab-software_category">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Software Category</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_software_category" class="btn btn-primary">Add Category</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_software_category" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Software Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    $sql = "SELECT * FROM aims_software_category GROUP BY id";
                    $query = mysqli_query($con, $sql);

                    $rowNumber = 1; // Initialize a row counter
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$rowNumber."</td>"; // Display the row number
                        echo "<td>".$row['display_name']."</td>";
                        echo "<td>
                        <!--    <a id='software_categoryEditBtn' href='./viewsoftware_category?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp; -->
                                <a id='software_categoryEditBtn' href='./edit_software_category?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='software_categoryDeleteBtn' class='action-button mx-1' onclick='confirmDeletesoftware_category(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";    
                        echo "</tr>";

                        $rowNumber++; // Increment the row counter
                    }
                ?>
                    </table>
                </div>            
            </div>
        </div>
         <!-- Tab 7: Remote Access -->
         <div class="tab-pane fade" id="remote_access" role="tabpanel" aria-labelledby="tab-remote_access">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Remote Access</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./add_remote_access" class="btn btn-primary">Add remote access</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_remote_access" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Remote Access</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    $sql = "SELECT * FROM aims_preset_remote_access GROUP BY id";
                    $query = mysqli_query($con, $sql);

                    $rowNumber = 1; // Initialize a row counter
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$rowNumber."</td>"; // Display the row number
                        echo "<td>".$row['display_name']."</td>";
                        echo "<td>
                        <!--    <a id='remote_accessEditBtn' href='./viewremote_access?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp; -->
                                <a id='remote_accessEditBtn' href='./edit_remote_access?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='remote_accessDeleteBtn' class='action-button mx-1' onclick='confirmDeleteremote_access(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
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
    //location
    $(document).ready(function() {
        $('#table_location').DataTable(
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

    //department
    $(document).ready(function() {
        $('#table_department').DataTable(
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

    //branch
    $(document).ready(function() {
        $('#table_branch').DataTable(
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

    $(document).ready(function() {
        $('#table_electronics_brand').DataTable(
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

    //computer
    $(document).ready(function() {
        $('#table_computer_brand').DataTable(
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

    //phone
    $(document).ready(function() {
        $('#table_phone_brand').DataTable(
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

    //virtual_machine
    $(document).ready(function() {
        $('#table_virtual_machine').DataTable(
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

     //software_category
     $(document).ready(function() {
        $('#table_software_category').DataTable(
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

    //remote access
    $(document).ready(function() {
        $('#table_remote_access').DataTable(
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

    //location
    function confirmDeleteLocation(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete location with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteLocation(id);
        }
        });
        }

    function deleteLocation(id) {
        $.ajax({
        url: "module/setting/preset/location/deletelocation_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The location has been deleted.',
                showConfirmButton: false,
                timer: 20000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the location.' + error,
                showConfirmButton: true,
                timer: 20000
            }).then(function() {
                window.location.href = './deletelocation_action.php';
            });
        }
        });
    }

    //department
    function confirmDeletedepartment(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete department with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteDepartment(id);
        }
        });
        }

    function deleteDepartment(id) {
        $.ajax({
        url: "module/setting/preset/department/deletedepartment_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The department has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the department.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './deletedepartment_action.php';
            });
        }
        });
    }

    //branch
    function confirmDeleteBranch(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete location with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteBranch(id);
        }
        });
        }

    function deleteBranch(id) {
        $.ajax({
        url: "module/setting/preset/branch/deletebranch_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The branch has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the branch.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './deletebranch_action.php';
            });
        }
        });
    }

    //electronics_brand
    function confirmDeleteElectronics_brand(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete brand with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteElectronics_brand(id);
        }
        });
        }

    function deleteElectronics_brand(id) {
        $.ajax({
        url: "module/setting/preset/electronics_brand/delete_electronics_brand_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The brand has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the brand.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './delete_electronics_brand_action.php';
            });
        }
        });
    }

    //computer
    function confirmDeletecomputer_brand(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete brand with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deletecomputer_brand(id);
        }
        });
        }

    function deletecomputer_brand(id) {
        $.ajax({
        url: "module/setting/preset/computer_brand/delete_computer_brand_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The brand has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the brand.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './delete_computer_brand_action.php';
            });
        }
        });
    }

    //phone
    function confirmDeletephone_brand(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete brand with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deletephone_brand(id);
        }
        });
        }

    function deletephone_brand(id) {
        $.ajax({
        url: "module/setting/preset/phone_brand/delete_phone_brand_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The brand has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the brand.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './delete_phone_brand_action.php';
            });
        }
        });
    }

    //virtual_machine
    function confirmDeletevirtual_machine(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete brand with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deletevirtual_machine(id);
        }
        });
        }

    function deletevirtual_machine(id) {
        $.ajax({
        url: "module/setting/preset/virtual_machine/delete_virtual_machine_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The brand has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the brand.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './delete_virtual_machine_brand_action.php';
            });
        }
        });
    }

     //software_category
     function confirmDeletesoftware_category(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete brand with id: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deletesoftware_category(id);
        }
        });
        }

    function deletesoftware_category(id) {
        $.ajax({
        url: "module/setting/preset/software_category/delete_software_category_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The preset has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the preset.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './delete_software_category_action.php';
            });
        }
        });
    }

    //remote_access
    function confirmDeleteremote_access(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete the preset: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteremote_access(id);
        }
        });
        }

    function deleteremote_access(id) {
        $.ajax({
        url: "module/setting/preset/remote_access/delete_remote_access_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The preset has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './preset';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './delete_remote_access_action.php';
            });
        }
        });
    }
</script>