<?php 
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
?>

<style>
    .action-button {
        cursor: pointer;
    }

    /* Define styles for odd rows */
    #table_staff_details tbody tr:nth-child(odd) {
        background-color: #f2f2f2; /* Set the background color for odd rows */
    }

    /* Define styles for even rows */
    #table_staff_details tbody tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even rows */
    }

    /* Apply styles to the header row */
    #table_staff_details thead tr {
        background-color: #f2f2f2; /* Set the background color for the header row */
    }
</style>

<!-- Content -->
<div class="main">

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-staff_details" data-toggle="tab" href="#staff_details" role="tab" aria-controls="staff_details" aria-selected="true">Staff</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: Fixed Asset -->
        <div class="tab-pane fade show active" id="staff_details" role="tabpanel" aria-labelledby="tab-staff_details">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Staff</h2>
                        </div>
                        <div class="col-6">
                            <a href="./addstaff" class="btn btn-primary float-right">Add Staff</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_staff_details">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Employee Name</th>
                                <th>Email Address</th>
                                <th>Contact No.</th>
                                <th>Company</th>
                                <th>Department</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_asset table using pagination
                        $sql = "SELECT * FROM aims_people_staff GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1;
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>";
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['contact_no']."</td>";
                            echo "<td>".$row['branch']."</td>";
                            echo "<td>".$row['department']."</td>";
                            echo "<td>
                                    <a id='StaffEditBtn' href='./viewstaff?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='StaffEditBtn' href='./editstaff?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='StaffDeleteBtn' class='action-button mx-1' onclick='confirmDeleteStaff(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";

                            $rowNumber++;
                        }
                    ?>
                    </table>
                </div>            
            </div>
        </div>         
    </div>
</div>

<script>
    //datatable
    $(document).ready(function() {
        $('#table_staff_details').DataTable(
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

    function confirmDeleteStaff(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete staff with ID: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteStaff(id);
        }
        });
        }

    function deleteStaff(id) {
        $.ajax({
        url: "./module/people/staff/deletestaff_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The staff has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './staff';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the asset.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './staff';
            });
        }
        });
    }
</script>