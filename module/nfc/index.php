<?php 
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
?>

<style>
	.action-button {
		cursor: pointer;
	}
    
    table#table_nfc_details tr:nth-child(odd) {
        background-color: #f2f2f2;
    }

    table#table_nfc_details tr:nth-child(even) {
        background-color: #ffffff;
    }
</style>

<!-- Content -->
<div class="main">

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-nfc_details" data-toggle="tab" href="#nfc_details" role="tab" aria-controls="nfc_details" aria-selected="true">NFC/QR</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: Fixed Asset -->
        <div class="tab-pane fade show active" id="nfc_details" role="tabpanel" aria-labelledby="tab-nfc_details">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>NFC & QR tag</h2>
                        </div>
                        <!-- <div class="col-6">
                            <a href="./addnfc" class="btn btn-primary float-right">Add nfc</a>
                        </div> -->
                    </div>
                </div>
                <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                    <!-- generate table from query with pagination -->
                    <table id="table_nfc_details" >
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NFC Code</th>
                                <th>QR Code</th>
                                <th>Asset Tag</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_asset table using pagination
                        $sql = "SELECT i.*, 
                                ac.display_name AS asset_category_display_name,
                                cc.display_name AS computer_category_display_name,
                                ec.display_name AS electronics_category_display_name
                            FROM aims_izzat i
                            LEFT JOIN aims_asset_category_run_no ac ON LEFT(i.asset_tag, 3) = ac.prefix
                            LEFT JOIN aims_computer_category_run_no cc ON LEFT(i.asset_tag, 3) = cc.prefix
                            LEFT JOIN aims_electronics_category_run_no ec ON LEFT(i.asset_tag, 3) = ec.prefix
                            GROUP BY i.id";

                    $query = mysqli_query($con, $sql);

                    $rowNumber = 1; // Initialize a row counter

                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$rowNumber."</td>"; // Display the row number
                        echo "<td>".$row['nfc_code']."</td>";
                        echo "<td>".$row['qr_code']."</td>";
                        echo "<td>".$row['asset_tag']."</td>";
                        echo "<td>";
                        
                        // Check which category display_name to use based on the prefix
                        if (!empty($row['asset_category_display_name'])) {
                            echo $row['asset_category_display_name'];
                        } elseif (!empty($row['computer_category_display_name'])) {
                            echo $row['computer_category_display_name'];
                        } elseif (!empty($row['electronics_category_display_name'])) {
                            echo $row['electronics_category_display_name'];
                        } else {
                            echo "Unknown Category";
                        }
                        
                        echo "</td>";
                        echo "<td>".$row['name']."</td>";
                        echo "<td>
                                <a id='nfcEditBtn' href='./editnfc?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
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
        $('#table_nfc_details').DataTable(
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
</script>