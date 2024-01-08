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
            <a class="nav-link active" id="tab-branch" data-toggle="tab" href="#branch" role="tab" aria-controls="branch" aria-selected="false">
                Branch (<?php
                        $sqlTotalBranch = "SELECT id FROM aims_preset_computer_branch";
                        $queryTotalBranch = mysqli_query($con, $sqlTotalBranch);
                        $totalBranch = mysqli_num_rows($queryTotalBranch);
                    echo $totalBranch;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-department" data-toggle="tab" href="#department" role="tab" aria-controls="department" aria-selected="false">
                Department (<?php
                        $sqlTotalDepartment = "SELECT id FROM aims_preset_department";
                        $queryTotalDepartment = mysqli_query($con, $sqlTotalDepartment);
                        $totalDepartment = mysqli_num_rows($queryTotalDepartment);
                    echo $totalDepartment;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-location" data-toggle="tab" href="#location" role="tab" aria-controls="location" aria-selected="true">
                Location (<?php
                        $sqlTotalLocation = "SELECT id FROM aims_preset_location";
                        $queryTotalLocation = mysqli_query($con, $sqlTotalLocation);
                        $totalLocation = mysqli_num_rows($queryTotalLocation);
                    echo $totalLocation;
                ?>)
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Tab: Branch --> 
        <div class="tab-pane fade show active" id="branch" role="tabpanel" aria-labelledby="tab-branch">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Building/Branch</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addbranch" class="btn btn-primary">Add Building/Branch</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_branch" class="striped-table">
                        <thead>
                            <tr>
                                <th>Default Location</th>
                                <th>No.</th>
                                <th>Branch</th>
                                <th>Office Contact No.</th>
                                <th>Office Email</th>
                                <th>Person In Charge</th>  
                                <th>Contact No.</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                            //query vehicle from aim_asset table using pagination
                            $sql = "SELECT * FROM aims_preset_computer_branch GROUP BY id";
                            $query = mysqli_query($con, $sql);

                            $rowNumber = 1; // Initialize a row counter
                            
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td><input type='radio' name='branch_radio' data-id='".$row['id']."' data-name='".$row['display_name']."' onclick='confirmSetDefaultLocation(".$row['id']. ", \"".$row['display_name']."\")'></td>";
                                echo "<td>".$rowNumber."</td>";
                                echo "<td>".$row['display_name']."</td>";
                                echo "<td>".$row['branch_contact_no']."</td>";
                                echo "<td>".$row['branch_email']."</td>";
                                echo "<td>".$row['pic']."</td>";
                                echo "<td>".$row['contact_no']."</td>";
                                echo "<td style='text-align:center;'>";
                                echo "
                                        <a id='BranchEditBtn' href='./viewbranch?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                        <a id='BranchEditBtn' href='./editbranch?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                        <a id='BranchDeleteBtn' class='action-button mx-1' onclick='confirmDeleteBranch(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                    </td>";    
                                echo "</tr>";
                            
                                $rowNumber++;
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 
        
        <!-- Tab 2: Department -->
        <div class="tab-pane fade" id="department" role="tabpanel" aria-labelledby="tab-department">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Department</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./adddepartment" class="btn btn-primary">Add Department</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_department" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Branch</th>
                                <th>Department</th>
                                <th>Head of Department</th>
                                <th>No. of Employees</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_department table using pagination
                        $sql = "SELECT * FROM aims_preset_department GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['branch']."</td>";
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>".$row['staff']."</td>";
                            echo "<td>".$row['noe']."</td>";
                            echo "<td>
                                    <a id='departmentViewBtn' href='./viewdepartment?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='departmentEditBtn' href='./editdepartment?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='departmentDeleteBtn' class='action-button mx-1'  onclick='confirmDeletedepartment(".$row['id']. ",\"\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";

                            $rowNumber++; // Increment the row counter
                        }
                    ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 1: Location -->
        <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="tab-location">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Location</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addlocation" class="btn btn-primary">Add Location</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_location" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Branch/Building</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <?php
                        // Query location information with manager's contact number
                        $sql = "SELECT * FROM aims_preset_location GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            // Query the contact number for the staff/manager
                            $sql2 = "SELECT contact_no FROM aims_people_staff WHERE display_name = '" . $row['staff'] . "'";
                            $result2 = mysqli_query($con, $sql2);
                            $staff = mysqli_fetch_assoc($result2);

                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['branch']."</td>";
                            echo "<td>".$row['department']."</td>";
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>
                                    <a id='locationViewBtn' href='./viewlocation?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='locationEditBtn' href='./editlocation?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='locationDeleteBtn' class='action-button mx-1' onclick='confirmDeleteLocation(".$row['id']. ",\"\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
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
                    { "orderable": false, "targets": 3 }
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
        // Retrieve the selected branchId from session storage
        var selectedBranchId = sessionStorage.getItem('selectedBranchId');

        // If a branchId is stored, set the corresponding radio button as checked
        if (selectedBranchId) {
            $("input[name='branch_radio'][data-id='" + selectedBranchId + "']").prop('checked', true);
        }

        // Initialize DataTables
        $('#table_branch').DataTable({
            "paging": true,
            "ordering": true,
            "info": true,
            "searching": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });
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
        url: "module/setting/preset_location/location/deletelocation_action.php", // Update the URL to your PHP script
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
                window.location.href = './preset_location';
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
        url: "module/setting/preset_location/department/deletedepartment_action.php", // Update the URL to your PHP script
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
                window.location.href = './preset_location';
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
        url: "module/setting/preset_location/branch/deletebranch_action.php", // Update the URL to your PHP script
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
                window.location.href = './preset_location';
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

    // Function to handle radio button click
    function confirmSetDefaultLocation(branchId) {
        var displayName = $("input[name='branch_radio'][data-id='" + branchId + "']").data('name');

        Swal.fire({
            title: "Set Default Location",
            text: "Are you sure you want to set " + displayName + " as the default location?",
            icon: "info",
            showCancelButton: true,
            confirmButtonText: "Yes, set as default!",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                // Store the selected branch information in session storage
                sessionStorage.setItem('selectedBranchId', branchId);
                sessionStorage.setItem('selectedBranchName', displayName);

                // Make an AJAX request to update the default location
                setDefaultLocation(branchId, displayName);
            } else {
                // If the user canceled, do nothing
            }
        });
    }

    function setDefaultLocation(branchId, displayName) {
        $.ajax({
            url: "module/setting/preset_location/branch/update_default_location.php",
            type: "POST",
            data: { branchId: branchId },
            success: function(response) {
                // Insert the selected branch information into aims_default_location table
                insertDefaultLocation(branchId, displayName);

                // Handle the server response here if needed
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The branch has been set as the default location.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    // Optionally, you can reload or update the UI as needed
                });
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while setting the default location.' + error,
                    showConfirmButton: true,
                    timer: 2000
                });
            }
        });
    }

    function insertDefaultLocation(branchId, displayName) {
        // Make an AJAX request to insert data into aims_default_location table
        $.ajax({
            url: "module/setting/preset_location/branch/insert_default_location.php",
            type: "POST",
            data: { branchId: branchId, displayName: displayName },
            success: function(response) {
                // Handle the server response here if needed
                console.log('Data inserted into aims_default_location table.');
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                console.error('Error inserting data into aims_default_location table: ' + error);
            }
        });
    }
</script>