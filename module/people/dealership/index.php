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
    #table_dealership_details tbody tr:nth-child(odd) {
        background-color: #f2f2f2; /* Set the background color for odd rows */
    }

    /* Define styles for even rows */
    #table_dealership_details tbody tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even rows */
    }

    /* Apply styles to the header row */
    #table_dealership_details thead tr {
        background-color: #f2f2f2; /* Set the background color for the header row */
    }
</style>

<!-- Content -->
<div class="main">

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-dealership_details" data-toggle="tab" href="#dealership_details" role="tab" aria-controls="dealership_details" aria-selected="true">Dealership</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: Fixed Asset -->
        <div class="tab-pane fade show active" id="dealership_details" role="tabpanel" aria-labelledby="tab-dealership_details">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Dealership</h2>
                        </div>
                        <div class="col-6">
                            <a href="./adddealership" class="btn btn-primary float-right">Add Dealership</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_dealership_details">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Dealership</th>
                                <th>Person in Charge</th>
                                <th>Company Contact No.</th>
                                <th>Company Email</th>
                                <th>Fax Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_asset table using pagination
                        $sql = "SELECT * FROM aims_people_dealership GROUP BY id";
                        $query = mysqli_query($con, $sql);

                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$rowNumber."</td>"; // Display the row number
                            echo "<td>".$row['display_name']."</td>";
                            echo "<td>".$row['pic']."</td>";
                            echo "<td>".$row['contact_no']."</td>";
                            echo "<td>".$row['email']."</td>";
                            echo "<td>".$row['fax']."</td>";
                            echo "<td>
                                    <a id='dealershipEditBtn' href='./viewdealership?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='dealershipEditBtn' href='./editdealership?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='dealershipDeleteBtn' class='action-button mx-1' onclick='confirmDeletedealership(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
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
    //datatable
    $(document).ready(function() {
        $('#table_dealership_details').DataTable(
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

    function confirmDeletedealership(id, asset_tag) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete dealership with ID: " + id,
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteDealership(id);
        }
        });
        }

    function deleteDealership(id) {
        $.ajax({
        url: "./module/people/dealership/deletedealership_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The asset has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './dealership';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the dealership.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './dealership';
            });
        }
        });
    }
</script>