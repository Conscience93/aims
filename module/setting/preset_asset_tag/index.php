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
            <a class="nav-link active" id="tab-fixed_asset" data-toggle="tab" href="#fixed_asset" role="tab" aria-controls="fixed_asset" aria-selected="false">
                Fixed Asset (<?php
                    $sqlTotalFixedAsset = "SELECT id FROM aims_asset_category_run_no";
                    $queryTotalFixedAsset = mysqli_query($con, $sqlTotalFixedAsset);
                    $totalFixedAsset = mysqli_num_rows($queryTotalFixedAsset);
                    echo $totalFixedAsset;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-electronics" data-toggle="tab" href="#electronics" role="tab" aria-controls="electronics" aria-selected="false">
                Electronics (<?php
                        $sqlTotalElectronics = "SELECT id FROM aims_electronics_category_run_no";
                        $queryTotalElectronics = mysqli_query($con, $sqlTotalElectronics);
                        $totalElectronics = mysqli_num_rows($queryTotalElectronics);
                    echo $totalElectronics;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-computer" data-toggle="tab" href="#computer" role="tab" aria-controls="computer" aria-selected="true">
                Computer (<?php
                        $sqlTotalComputer = "SELECT id FROM aims_computer_category_run_no";
                        $queryTotalComputer = mysqli_query($con, $sqlTotalComputer);
                        $totalComputer = mysqli_num_rows($queryTotalComputer);
                    echo $totalComputer;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-vehicle" data-toggle="tab" href="#vehicle" role="tab" aria-controls="vehicle" aria-selected="true">
                Vehicle (<?php
                        $sqlTotalVehicle = "SELECT id FROM aims_vehicle_category_run_no";
                        $queryTotalVehicle = mysqli_query($con, $sqlTotalVehicle);
                        $totalVehicle = mysqli_num_rows($queryTotalVehicle);
                    echo $totalVehicle;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-property" data-toggle="tab" href="#property" role="tab" aria-controls="property" aria-selected="true">
                Property (<?php
                        $sqlTotalProperty = "SELECT id FROM aims_property_category_run_no";
                        $queryTotalProperty = mysqli_query($con, $sqlTotalProperty);
                        $totalProperty = mysqli_num_rows($queryTotalProperty);
                    echo $totalProperty;
                ?>)
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Tab: Fixed Asset --> 
        <div class="tab-pane fade show active" id="fixed_asset" role="tabpanel" aria-labelledby="tab-fixed_asset">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Fixed Asset</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addfixedasset" class="btn btn-primary">Add New Asset Tag</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_fixed_asset" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Prefix</th>
                                <!-- <th style="text-align:center;">Action</th> -->
                            </tr>
                        </thead>
                        <?php
                            //query vehicle from aims_asset_category_run_no table using pagination
                            $sql = "SELECT * FROM aims_asset_category_run_no GROUP BY id";
                            $query = mysqli_query($con, $sql);

                            $rowNumber = 1; // Initialize a row counter
                            
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>".$rowNumber."</td>";
                                echo "<td>".$row['display_name']."</td>";
                                echo "<td>".$row['prefix']."</td>";
                                // echo "<td style='text-align:center;'>";
                                // echo "
                                //         <a id='FixedAssetEditBtn' href='./viewfixedasset?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                //         <a id='FixedAssetEditBtn' href='./editfixedasset?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                //         <a id='FixedAssetDeleteBtn' class='action-button mx-1' onclick='confirmDeleteFixedAsset(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                //     </td>";    
                                echo "</tr>";
                            
                                $rowNumber++;
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 
        
        <!-- Tab Electronics -->
        <div class="tab-pane fade" id="electronics" role="tabpanel" aria-labelledby="tab-electronics">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Electronics</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addelectronicsassettag" class="btn btn-primary">Add New Asset Tag</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_electronics" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Prefix</th>
                                <!-- <th style="text-align:center;">Action</th> -->
                            </tr>
                        </thead>
                        <?php
                            //query vehicle from aims_electronics_category_run_no table using pagination
                            $sql = "SELECT * FROM aims_electronics_category_run_no GROUP BY id";
                            $query = mysqli_query($con, $sql);

                            $rowNumber = 1; // Initialize a row counter
                            
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>".$rowNumber."</td>";
                                echo "<td>".$row['display_name']."</td>";
                                echo "<td>".$row['prefix']."</td>";
                                // echo "<td style='text-align:center;'>";
                                // echo "
                                //         <a id='ElectronicsEditBtn' href='./viewelectronics?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                //         <a id='ElectronicsEditBtn' href='./editelectronics?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                //         <a id='ElectronicsDeleteBtn' class='action-button mx-1' onclick='confirmDeleteElectronics(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                //     </td>";    
                                echo "</tr>";
                            
                                $rowNumber++;
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 

        <!-- Tab Computer -->
        <div class="tab-pane fade" id="computer" role="tabpanel" aria-labelledby="tab-computer">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Computer</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addcomputerassettag" class="btn btn-primary">Add New Asset Tag</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_computer" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Prefix</th>
                                <!-- <th style="text-align:center;">Action</th> -->
                            </tr>
                        </thead>
                        <?php
                            //query vehicle from aims_computer_category_run_no table using pagination
                            $sql = "SELECT * FROM aims_computer_category_run_no GROUP BY id";
                            $query = mysqli_query($con, $sql);

                            $rowNumber = 1; // Initialize a row counter
                            
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>".$rowNumber."</td>";
                                echo "<td>".$row['display_name']."</td>";
                                echo "<td>".$row['prefix']."</td>";
                                // echo "<td style='text-align:center;'>";
                                // echo "
                                //         <a id='ComputerEditBtn' href='./viewfcomputer?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                //         <a id='ComputerEditBtn' href='./editfcomputer?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                //         <a id='ComputerDeleteBtn' class='action-button mx-1' onclick='confirmDeleteComputer(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                //     </td>";    
                                echo "</tr>";
                            
                                $rowNumber++;
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 

        <!-- Tab Vehicle -->
        <div class="tab-pane fade" id="vehicle" role="tabpanel" aria-labelledby="tab-vehicle">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Vehicle</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addvehicleassettag" class="btn btn-primary">Add New Asset Tag</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_vehicle" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Prefix</th>
                                <!-- <th style="text-align:center;">Action</th> -->
                            </tr>
                        </thead>
                        <?php
                            //query vehicle from aims_vehicle_category_run_no table using pagination
                            $sql = "SELECT * FROM aims_vehicle_category_run_no GROUP BY id";
                            $query = mysqli_query($con, $sql);

                            $rowNumber = 1; // Initialize a row counter
                            
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>".$rowNumber."</td>";
                                echo "<td>".$row['display_name']."</td>";
                                echo "<td>".$row['prefix']."</td>";
                                // echo "<td style='text-align:center;'>";
                                // echo "
                                //         <a id='VehicleEditBtn' href='./viewfvehicle?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                //         <a id='VehicleEditBtn' href='./editfvehicle?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                //         <a id='VehicleDeleteBtn' class='action-button mx-1' onclick='confirmDeleteVehicle(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                //     </td>";    
                                echo "</tr>";
                            
                                $rowNumber++;
                            }
                        ?>
                    </table>
                </div>            
            </div>
        </div> 

        <!-- Tab Property -->
        <div class="tab-pane fade" id="property" role="tabpanel" aria-labelledby="tab-property">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Property</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./setting" class="btn btn-danger">Back</a>
                                <a href="./addpropertyassettag" class="btn btn-primary">Add New Asset Tag</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_property" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Category</th>
                                <th>Prefix</th>
                                <!-- <th style="text-align:center;">Action</th> -->
                            </tr>
                        </thead>
                        <?php
                            //query vehicle from aims_property_category_run_no table using pagination
                            $sql = "SELECT * FROM aims_property_category_run_no GROUP BY id";
                            $query = mysqli_query($con, $sql);

                            $rowNumber = 1; // Initialize a row counter
                            
                            while ($row = mysqli_fetch_assoc($query)) {
                                echo "<tr>";
                                echo "<td>".$rowNumber."</td>";
                                echo "<td>".$row['display_name']."</td>";
                                echo "<td>".$row['prefix']."</td>";
                                // echo "<td style='text-align:center;'>";
                                // echo "
                                //         <a id='PropertyEditBtn' href='./viewfproperty?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                //         <a id='PropertyEditBtn' href='./editfproperty?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                //         <a id='PropertyDeleteBtn' class='action-button mx-1' onclick='confirmDeleteProperty(".$row['id']. ")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                                //     </td>";    
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
    $(document).ready(function() {
        $('#table_fixed_asset').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 2 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_electronics').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 2 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_computer').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 2 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_vehicle').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 2 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_property').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 2 }
                ]
            }
        );
    });


</script>