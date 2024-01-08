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

    /* Style for checkboxes */
    input[type="checkbox"] {
        width: 20px; /* Set width of the checkbox */
        height: 20px; /* Set height of the checkbox */
        border: 2px solid #555; /* Set border color and thickness */
        border-radius: 4px; /* Add border-radius for rounded corners */
        cursor: pointer; /* Change cursor to pointer on hover */
        margin-left: 33px;
    }

    /* Style for checked checkboxes */
    input[type="checkbox"]:checked {
        background-color: #2196F3; /* Set background color when checked */
        border-color: #2196F3; /* Set border color when checked */
        color: #fff; /* Set text color when checked */
    }

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-disposal" data-toggle="tab" href="#disposal" role="tab" aria-controls="disposal" aria-selected="false">
                Disposal (<?php
                        $sqlTotalDisposal = "SELECT id FROM aims_all_asset_disposal WHERE status = 'DISPOSED' AND approval = 'APPROVE'";
                        $queryTotalDisposal = mysqli_query($con, $sqlTotalDisposal);
                        $totalDisposal = mysqli_num_rows($queryTotalDisposal);
                    echo $totalDisposal;
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
                            <h2>Disposed Asset</h2>
                        </div>
                        <div class="col-6">
                            <div class="row float-right">
                                <button type="button" class="btn btn-danger" onclick="confirmDeleteMultiple()">Delete</button>
                                <a href="/aims/adddisposal" class="btn btn-info">Add Disposed Asset</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 72vh; overflow-y: scroll;">
                    <table id="table_disposal" class="striped-table">
                        <thead>
                            <tr>
                                <th style="padding-left: 50px;">#</th>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Asset Tag</th>
                                <th style="text-align:center;">Name</th>
                                <th style="text-align:center;">Category</th>
                                <th style="text-align:center;">Value</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $assets = array();
                        $totalValue = 0; // Initialize total value

                        // Query assets from aims_all_asset_disposal table with pictures from aims_all_asset_picture table
                        $sqlAsset = "SELECT * FROM aims_all_asset_disposal WHERE status='DISPOSED'";
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
                                    'value' => $row['value'],
                                );
                                $totalValue += $row['value']; // Update total value
                            }
                        }

                        foreach ($assets as $asset) {
                            echo "<tr data-asset-tag='" . $asset['asset_tag'] . "'>";
                            echo "<td><input type='checkbox' name='asset_asset_tag[]' value='" . $asset['asset_tag'] . "'></td>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['asset_tag'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['name'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['category'] . "</td>";
                            echo "<td style='text-align:center;'>" . $asset['value'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='disposalEditBtn' href='./viewdisposal?id=".$asset['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='disposalEditBtn' href='./editdisposal?id=".$asset['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
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
    });

    function confirmDeleteMultiple() {
        var selectedAssetTags = $('input[name="asset_asset_tag[]"]:checked').map(function() {
            return this.value;
        }).get();

        if (selectedAssetTags.length > 0) {
            Swal.fire({
                title: "Are you sure?",
                text: "You are about to delete selected assets. This process is irreversible!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete them!",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteMultiple(selectedAssetTags);
                }
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'Info',
                text: 'No assets selected for deletion.',
                showConfirmButton: true,
                timer: 2000
            });
        }
    }

    function deleteMultiple(assetTags) {
        $.ajax({
            url: "./module/disposal/delete_multiple.php",
            type: "POST",
            data: { asset_asset_tag: assetTags },
            success: function(response) {
                // Handle the server response here if needed
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'The selected assets have been deleted.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './disposal';
                });
            },
            error: function(xhr, status, error) {
                // Handle errors here if needed
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while deleting the selected assets.' + error,
                    showConfirmButton: true,
                    timer: 2000
                }).then(function() {
                    window.location.href = './disposal';
                });
            }
        });
    }
</script>
