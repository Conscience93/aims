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
    #table_supplier_details tbody tr:nth-child(odd) {
        background-color: #f2f2f2; /* Set the background color for odd rows */
    }

    /* Define styles for even rows */
    #table_supplier_details tbody tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even rows */
    }

    /* Apply styles to the header row */
    #table_supplier_details thead tr {
        background-color: #f2f2f2; /* Set the background color for the header row */
    }
</style>

<!-- Content -->
<div class="main">

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-supplier_details" data-toggle="tab" href="#supplier_details" role="tab" aria-controls="supplier_details" aria-selected="true">Vendor List</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 2: Fixed Asset -->
        <div class="tab-pane fade show active" id="supplier_details" role="tabpanel" aria-labelledby="tab-supplier_details">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Service Request</h2>
                        </div>
                        <div class="col-6">
                            <a href="./request_supplier" class="btn btn-primary float-right">Request</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_supplier_details">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Vendor.</th>
                                <th>Person in Charge</th>
                                <th>Company Contact No.</th>
                                <th>Company Email</th>
                                <th>Fax Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_asset table using pagination
                        $sql = "SELECT * FROM aims_people_supplier GROUP BY id";
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
                                    <a id='supplierEditBtn' href='./viewsupplier?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='supplierRequestBtn' href='./request_supplier?id=".$row['id']."' title='Request'><img class='actionbtn' src='./include/action/return.png'></a>&nbsp;
                                    
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
        $('#table_supplier_details').DataTable(
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