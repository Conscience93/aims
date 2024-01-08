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

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-all-asset" data-toggle="tab" href="#all-asset" role="tab" aria-controls="all-asset" aria-selected="true">
                All (<?php
                        $sqlTotalAll = "SELECT id FROM aims_maintenance WHERE approval = 'APPROVE'";
                        $queryTotalAll = mysqli_query($con, $sqlTotalAll);
                        $totalAll = mysqli_num_rows($queryTotalAll);
                    echo $totalAll;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-with_fee" data-toggle="tab" href="#with_fee" role="tab" aria-controls="with_fee" aria-selected="false">
                Vendor Service (<?php
                    $sqlTotalWith = "SELECT (SELECT COUNT(*) FROM aims_maintenance WHERE type = 'with' AND approval = 'APPROVE') AS total";
                    $queryTotalWith = mysqli_query($con, $sqlTotalWith);
                    $totalWith = mysqli_fetch_assoc($queryTotalWith)['total'];
                    echo $totalWith;
                ?>)
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-without_fee" data-toggle="tab" href="#without_fee" role="tab" aria-controls="without_fee" aria-selected="false">
                Internal Service (<?php
                    $sqlTotalWithout = "SELECT (SELECT COUNT(*) FROM aims_maintenance WHERE type = 'without' AND approval = 'APPROVE')AS total";
                    $queryTotalWithout = mysqli_query($con, $sqlTotalWithout);
                    $totalWithout = mysqli_fetch_assoc($queryTotalWithout)['total'];
                    echo $totalWithout;
                ?>)
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-preventive" data-toggle="tab" href="#preventive" role="tab" aria-controls="preventive" aria-selected="false">
                Preventive Maintenance (<?php
                    $sqlTotalpreventive = "SELECT (SELECT COUNT(*) FROM aims_maintenance WHERE type = 'preventive' AND approval = 'APPROVE')AS total";
                    $queryTotalpreventive = mysqli_query($con, $sqlTotalpreventive);
                    $totalpreventive = mysqli_fetch_assoc($queryTotalpreventive)['total'];
                    echo $totalpreventive;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-cleaning" data-toggle="tab" href="#cleaning" role="tab" aria-controls="cleaning" aria-selected="false">
                Cleaning Maintenance (<?php
                    $sqlTotalcleaning = "SELECT (SELECT COUNT(*) FROM aims_maintenance WHERE type = 'cleaning' AND approval = 'APPROVE')AS total";
                    $queryTotalcleaning = mysqli_query($con, $sqlTotalcleaning);
                    $totalcleaning = mysqli_fetch_assoc($queryTotalcleaning)['total'];
                    echo $totalcleaning;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-inspection" data-toggle="tab" href="#inspection" role="tab" aria-controls="inspection" aria-selected="false">
                Inspection Maintenance (<?php
                    $sqlTotalinspection = "SELECT (SELECT COUNT(*) FROM aims_maintenance WHERE type = 'inspection' AND approval = 'APPROVE')AS total";
                    $queryTotalinspection = mysqli_query($con, $sqlTotalinspection);
                    $totalinspection = mysqli_fetch_assoc($queryTotalinspection)['total'];
                    echo $totalinspection;
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
                            <h2>All Asset Maintenance</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./add_maintenance" class="btn btn-info">Add Record</a>
                                <!-- <a href="" onclick="history.back()" class="btn btn-danger">Back</a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_all_asset" class="striped-table">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, category, maintenance_date FROM aims_maintenance WHERE approval = 'APPROVE'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            echo "<tr>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
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
                            <h2>Maintenance With Fee</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./add_maintenance" class="btn btn-info">Add Record</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_with_fee" class="striped-table">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, category, maintenance_date FROM aims_maintenance WHERE type = 'with' AND approval = 'APPROVE'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            echo "<tr>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
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

        <!-- Tab 3: Maintenance Without Fee -->
        <div class="tab-pane fade" id="without_fee" role="tabpanel" aria-labelledby="tab-without_fee">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Maintenance Without Fee</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./add_maintenance" class="btn btn-info">Add Record</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_without_fee" class="striped-table">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, category, maintenance_date FROM aims_maintenance WHERE type = 'without'AND approval = 'APPROVE'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            echo "<tr>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
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
        
        <!-- Tab 4: Preventive Maintenance -->
        <div class="tab-pane fade" id="preventive" role="tabpanel" aria-labelledby="tab-preventive">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Preventive Maintenance</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./add_maintenance" class="btn btn-info">Add Record</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_preventive" class="striped-table">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, category, maintenance_date FROM aims_maintenance WHERE type = 'preventive' AND approval = 'APPROVE'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            echo "<tr>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
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
        <!-- Tab 5: Cleaning Maintenance -->
        <div class="tab-pane fade" id="cleaning" role="tabpanel" aria-labelledby="tab-cleaning">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Cleaning Maintenance</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./add_maintenance" class="btn btn-info">Add Record</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_cleaning" class="striped-table">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, category, maintenance_date FROM aims_maintenance WHERE type = 'cleaning' AND approval = 'APPROVE'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            echo "<tr>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
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
        <!-- Tab 6: Inspection Maintenance -->
        <div class="tab-pane fade" id="inspection" role="tabpanel" aria-labelledby="tab-inspection">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Inspection Maintenance</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./add_maintenance" class="btn btn-info">Add Record</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_inspection" class="striped-table">
                        <thead>
                            <tr>
                                <th>Asset Tag</th>
                                <th>Maintenance Tag</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Date</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                    <?php
                        $sqlAll = "SELECT id, asset_tag, maintenance_tag, name, title, category, maintenance_date FROM aims_maintenance WHERE type = 'inspection' AND approval = 'APPROVE'";
                        $queryAll = mysqli_query($con, $sqlAll);
                        
                        while ($row = mysqli_fetch_assoc($queryAll)) {
                            echo "<tr>";
                            echo "<td>".$row['asset_tag']."</td>";
                            echo "<td>".$row['maintenance_tag']."</td>";
                            echo "<td>".$row['category']."</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['title']."</td>";
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
        $('#table_without_fee').DataTable(
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
        $('#table_preventive').DataTable(
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
        $('#table_cleaning').DataTable(
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
        $('#table_inspection').DataTable(
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
                window.location.href = './maintenance';
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
                window.location.href = './maintenance';
            });
        }
        });
    }
</script>