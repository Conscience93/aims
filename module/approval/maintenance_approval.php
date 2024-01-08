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

    .sorting_asc, .sorting_desc, .sorting {
        background-image: none !important;  
    }
    
    .green-button {
        background-color: green;
    }

    .custom-swal-container .swal2-cancel {
        background-color: #007bff !important;  /* Red color for Reject button */
    }

    .custom-swal-container .swal2-confirm {
        background-color: #dc3545 !important;  /* Blue color for Approve button */
    }

    .custom-swal-confirm {
        background-color: #dc3545 !important; /* Blue color for Approve button */
    }

    .custom-swal-cancel {
        background-color: #007bff !important; /* Red color for Reject button */
    }

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-all-asset" data-toggle="tab" href="#all-asset" role="tab" aria-controls="all-asset" aria-selected="true">
                All (<?php
                        $sqlTotalAll = "SELECT id FROM aims_maintenance WHERE approval = 'PENDING'";
                        $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                        $totalAll = mysqli_num_rows($queryTotalAll);
                    echo $totalAll;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-with_fee" data-toggle="tab" href="#with_fee" role="tab" aria-controls="with_fee" aria-selected="false">
                Reject (<?php
                    $sqlTotalWith = "SELECT (SELECT COUNT(*) FROM aims_maintenance WHERE approval = 'REJECT') AS total";
                    $queryTotalWith = mysqli_query($con, $sqlTotalWith);
                    $totalWith = mysqli_fetch_assoc($queryTotalWith)['total'];
                    echo $totalWith;
                ?>)
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: All Asset -->
        <div class="tab-pane fade show active" id="all-asset" role="tabpanel" aria-labelledby="tab-all-asset">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>All Pending Asset Maintenance</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-primary green-button" onclick="confirmMultipleActions()">Approval</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_all_asset" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Vendor</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, vendors, category, maintenance_date FROM aims_maintenance WHERE approval = 'PENDING'";
                        $queryAll = mysqli_query($con, $sqlAll);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            $assetTag = $row['asset_tag'];
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='approve_asset_tag[]' value='" . $assetTag . "'></td>";
                            echo "<td><input type='checkbox' name='reject_asset_tag[]' value='" . $assetTag . "'></td>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['vendors']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['maintenance_date']."</td>";
                            echo "<td style='text-align:center;'>
                                    <a id='EditBtn' href='./view_maintenance?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='EditBtn' href='./edit_maintenance?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='DeleteBtn' class='action-button mx-1' onclick='confirmDelete(".$row['id']. ",\"".$row['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";
                            echo "</tr>";
                            
                        }
                    ?>
                    </table>
                </div>            
            </div>
        </div>   

        <!-- Tab 2: Maintenance With Fee -->
        <div class="tab-pane fade" id="with_fee" role="tabpanel" aria-labelledby="tab-with_fee">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Rejected Maintenance</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmAction()">Finalize</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_with_fee" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Vendor</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, vendors, category, maintenance_date FROM aims_maintenance WHERE approval = 'REJECT'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            $assetTag = $row['asset_tag'];
                            echo "<tr>";
                            echo "<td><input type='checkbox' name='selected_asset_tag' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
                            echo "<td>".$row['vendors']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['maintenance_date']."</td>";
                            echo "<td style='text-align:center;'>
                                    <a id='EditBtn' href='./view_maintenance?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='EditBtn' href='./edit_maintenance?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='DeleteBtn' class='action-button mx-1' onclick='confirmDelete(".$row['id']. ",\"".$row['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                </td>";
                            echo "</tr>";
                            
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
        $('#table_all_asset').DataTable(
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

        $('#table_with_fee').DataTable(
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

    function confirmMultipleActions() {
        var selectedAssetTags = $('input[name="approve_asset_tag[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (selectedAssetTags.length > 0) {
            Swal.fire({
                title: "Select Action",
                icon: "question",
                showCancelButton: true,
                cancelButtonText: "Approve",
                confirmButtonText: "Reject",
                customClass: {
                    container: 'custom-swal-container'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleMultipleActions(selectedAssetTags, 'reject');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    handleMultipleActions(selectedAssetTags, 'approve');
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'No assets maintenance selected for approval/rejection.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function handleMultipleActions(assetTags, action) {
        var actionUrl = (action === 'approve') ? './module/approval/approve_maintenance_multiple.php' : './module/approval/reject_maintenance_multiple.php';

        $.ajax({
            url: actionUrl,
            type: "POST",
            data: { asset_asset_tag: assetTags },
            success: function(response) {
                // Handle the server response here if needed
                var successMessage = (action === 'approve') ? 'approved' : 'rejected';
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The selected assets have been ' + successMessage + '.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_maintenance';
                });
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                var errorMessage = (action === 'approve') ? 'approving' : 'rejecting';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while ' + errorMessage + ' the selected assets.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_maintenance';
                });
            }
        });
    }

    function confirmAction() {
        var selectedAssetTag = $('input[name="selected_asset_tag"]:checked').val();

        if (selectedAssetTag) {
            Swal.fire({
                title: "Select Action",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Approve",
                cancelButtonText: "Delete",
                reverseButtons: true, // Add this line
                customClass: {
                    confirmButton: 'custom-swal-cancel', // Swap classes due to reverseButtons
                    cancelButton: 'custom-swal-confirm' // Swap classes due to reverseButtons
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    handleMultipleActions([selectedAssetTag], 'approve');
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    handleMultipleActions([selectedAssetTag], 'delete');
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'No asset maintenance selected for approval/delete.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function handleMultipleActions(assetTags, action) {
        var actionUrl = (action === 'approve') ? "./module/approval/approve_maintenance_multiple.php" : "./module/asset/delete_maintenance_multiple.php";

        $.ajax({
            url: actionUrl,
            type: "POST",
            data: { asset_asset_tag: assetTags },
            success: function(response) {
                var successMessage = (action === 'approve') ? 'approved' : 'deleted';
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The selected asset has been ' + successMessage + '.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_asset';
                });
            },
            error: function(xhr, status, error) {
                var errorMessage = (action === 'approve') ? 'approving' : 'deleting';
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while ' + errorMessage + ' the selected asset.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './approval_asset';
                });
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete record with Tag: " + id + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteMaintenance(id);
        }
        });
        }

    function deleteMaintenance(id) {
        $.ajax({
        url: "./module/maintenance/delete_maintenance_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The record has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './approval_maintenance';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the record.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './approval_maintenance';
            });
        }
        });
    }
</script>