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
            <a class="nav-link active" id="tab-disposal" data-toggle="tab" href="#disposal" role="tab" aria-controls="disposal" aria-selected="false">
                Disposal (<?php
                        $sqlTotalDisposal = "SELECT id FROM aims_all_asset_disposal WHERE status = 'DISPOSED' AND approval = 'PENDING'";
                        $queryTotalDisposal = mysqli_query($con, $sqlTotalDisposal);
                        $totalDisposal = mysqli_num_rows($queryTotalDisposal);
                    echo $totalDisposal;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-reject" data-toggle="tab" href="#reject" role="tab" aria-controls="reject" aria-selected="false">
                Reject (<?php
                        $sqlTotalReject = "SELECT id FROM aims_all_asset_disposal WHERE status = 'DISPOSED' AND approval = 'REJECT'";
                        $queryTotalReject = mysqli_query($con, $sqlTotalReject);
                        $totalReject = mysqli_num_rows($queryTotalReject);
                    echo $totalReject;
                ?>)
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab: Disposal -->
        <div class="tab-pane fade show active" id="disposal" role="tabpanel" aria-labelledby="tab-disposal">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Pending Disposed Assets</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right"> 
                                <button type="button" class="btn btn-primary green-button" onclick="confirmMultipleActions()">Approve</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_disposal" class="striped-table">
                        <thead>
                            <tr> 
                                <th style="padding-left: 50px;">#</th>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Asset Tag</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Category</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Value</th>
                                <th style="text-align:center;">Reason</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $assets = array();
                        $totalValue = 0; // Initialize total value

                        // Query assets from aims_all_asset_disposal table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT * FROM aims_all_asset_disposal WHERE approval='PENDING'";
                        $queryAsset = mysqli_query($con, $sqlAsset);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAsset)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'],
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'status' => $row['status'],
                                    'value' => $row['value'],
                                    'reason' => $row['reason'],
                                );
                                $totalValue += $row['value']; // Update total value
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='approve_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['asset_tag'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['name'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['category'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['status'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['value'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['reason'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='disposalEditBtn' href='./viewdisposal?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='disposalEditBtn' href='./editdisposal?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='disposalDeleteBtn' class='action-button mx-1' onclick='confirmDeleteDisposal(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                    <div>
                        <strong>Total Asset Disposal Value:</strong>RM<?php echo $totalValue; ?>
                    </div>
                </div>            
            </div>
        </div>

        <div class="tab-pane fade show" id="reject" role="tabpanel" aria-labelledby="tab-reject">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Rejected Assets</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">   
                                <button type="button" class="btn btn-danger" onclick="confirmAction()">Finalize</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_reject_disposal" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Asset Tag</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Category</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Value</th>
                                <th style="text-align:center;">Reason</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $assets = array();
                        $totalValue = 0; // Initialize total value

                        // Query assets from aims_all_asset_disposal table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT * FROM aims_all_asset_disposal WHERE approval='REJECT'";
                        $queryAsset = mysqli_query($con, $sqlAsset);

                        $rowNumber = 1; // Initialize a row counter

                        while ($row = mysqli_fetch_assoc($queryAsset)) {
                            $assetTag = $row['asset_tag'];
                            if (!isset($assets[$assetTag])) {
                                $assets[$assetTag] = array(
                                    'id' => $row['id'],
                                    'asset_tag' => $assetTag,
                                    'name' => $row['name'],
                                    'category' => $row['category'],
                                    'status' => $row['status'],
                                    'value' => $row['value'],
                                    'reason' => $row['reason'],
                                );
                                $totalValue += $row['value']; // Update total value
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='selected_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['asset_tag'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['name'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['category'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['status'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['value'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['reason'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='rejectEditBtn' href='./viewreject?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='rejectEditBtn' href='./editreject?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='rejectDeleteBtn' class='action-button mx-1' onclick='confirmDeleteDisposal(".$asset['id']. ",\"".$asset['asset_tag']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                    <div>
                        <strong>Total Rejected Asset Disposal Value:</strong>RM<?php echo $totalValue; ?>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    //datatable
    $(document).ready(function() {
        $('#table_disposal').DataTable(
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

        $('#table_reject_disposal').DataTable(
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
                text: 'No disposed assets selected for approval/rejection.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function handleMultipleActions(assetTags, action) {
        var actionUrl = (action === 'approve') ? './module/approval/approve_disposal_multiple.php' : './module/approval/reject_disposal_multiple.php';

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
                    window.location.href = './approval_asset';
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
                    window.location.href = './approval_asset';
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
                text: 'No asset selected for approval/delete.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function handleMultipleActions(assetTags, action) {
        var actionUrl = (action === 'approve') ? "./module/approval/approve_multiple.php" : "./module/asset/delete_multiple.php";

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

    function confirmDeleteDisposal(id, asset_tag) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete disposed asset with Tag: " + asset_tag + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteDisposal(id);
        }
        });
        }

    function deleteDisposal(id) {
        $.ajax({
        url: "./module/disposal/deletedisposal_action.php", // Update the URL to your PHP script
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
                window.location.href = './approval_disposal';
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
                window.location.href = './approval_disposal';
            });
        }
        });
    }
</script>