<?php 
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_transfer_asset WHERE id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

$sql2 = "SELECT * FROM aims_asset WHERE asset_tag = '" . $row['asset_tag'] . "'";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);

$sql3 = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag = '" . $row['asset_tag'] . "'";
$result3 = mysqli_query($con, $sql3);
$row3 = mysqli_fetch_assoc($result3);
?>


<style>
    /* Add this style to your CSS file or within a <style> tag in your HTML */
    .suggested-names {
        list-style-type: none;
        padding: 0;
        margin: 0;
        max-height: 150px; /* Set a fixed height for the suggestion box */
        overflow-y: auto; /* Enable vertical scrolling if there are too many suggestions */
        background-color: #fff; /* Set a background color for the suggestion box */
        border: 1px solid #ccc; /* Add a border for a similar look to a select dropdown */
        border-radius: 4px; /* Optional: Add border-radius for rounded corners */
        position: absolute; /* Set the position to absolute */
        z-index: 1; /* Ensure the suggestion box appears above other elements */
        width: 90%; /* Make the suggestion box full width */
    }

    .suggested-names li {
        padding: 8px;
    }

    .suggested-names a {
        text-decoration: none;
        color: #333;
    }

    .suggested-names a:hover {
        background-color: #f0f0f0; /* Optional: Add a background color on hover */
    }

    /* Add this style to the parent container of the suggestion box */
    .parent-container {
        position: relative;
    }
</style>

<div class="main">
    <form action=".\module\transfer\asset\editasset_transfer_action.php" method="POST" id="transferForm">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./transfer" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                <input id="asset_tag" name="asset_tag" value="<?php echo $row['asset_tag'];?>" hidden>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Asset Data</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                   <!-- name -->
                   <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name'];?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- asset_tag -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="asset_tag">Asset Tag</label>
                            <input id="asset_tag" name="asset_tag" value="<?php echo $row['asset_tag'];?>"  class="form-control" readonly>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input id="category" name="category" value="<?php echo $row['category'];?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- status -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="status">Status</label>
                            <input id="status" name="status" value="<?php echo $row['status'];?>" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                </br>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Current Location</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- branch -->
                    <div class="col-4">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input type="text" id="branch" name="branch" value="<?php echo $row2['branch']; ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- department -->
                    <div class="col-4">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input type="text" id="department" name="department" value="<?php echo $row2['department']; ?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- location -->
                    <div class="col-4">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" id="location" name="location" value="<?php echo $row2['location']; ?>" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                </br>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Change Location</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- type -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Permanent"<?php if($row['type'] == 'Permanent') {echo 'selected';}?>>Permanent</option>
                                <option value="Period"<?php if($row['type'] == 'Period') {echo 'selected';}?>>Period</option>
                            </select>
                        </div>
                    </div>

                    <!-- start_date -->
                    <div class="col-3" id="start_date_container" style="display: none;">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" id="start_date" name="start_date" value="<?php echo $row['start_date'];?>" class="form-control">
                        </div>
                    </div>

                    <!-- end_date -->
                    <div class="col-3" id="end_date_container" style="display: none;">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" id="end_date" name="end_date" value="<?php echo $row['end_date'];?>" class="form-control">
                        </div>
                    </div>

                    <!-- date_transfer -->
                    <div class="col-3" id="date_transfer_container" style="display: none;">
                        <div class="form-group">
                            <label for="date_transfer">Date Transfer</label>
                            <input type="date" id="date_transfer" name="date_transfer" value="<?php echo $row['date_transfer'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- transfer_branch-->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="transfer_branch">Building/Branch</label>
                            <select name="transfer_branch" id="transfer_branch" class="form-control">
                                <option value="">Select Building/Branch</option>
                                <?php  
                                $sql_branchs = "SELECT * FROM aims_preset_computer_branch";
                                $result_branchs = mysqli_query($con, $sql_branchs);
                                while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                    $branchs[] = $row_branchs;
                                }
                                if ($branchs == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else {
                                    foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch['display_name']; ?>" <?php if($row['transfer_branch'] == $branch['display_name']) {echo 'selected';} ?>><?php echo $branch['display_name']; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                    <!-- transfer_department -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="transfer_department">Department</label>
                            <select name="transfer_department" id="transfer_department" class="form-control">
                                <option value="">Select Department</option>
                                <?php 
                                $sql_departments = "SELECT * FROM aims_preset_department";
                                $result_departments = mysqli_query($con, $sql_departments);
                                while ($row_departments = mysqli_fetch_assoc($result_departments)) {
                                    $departments[] = $row_departments;
                                }
                                if ($departments == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else {
                                    foreach ($departments as $department): ?>
                                        <option value="<?php echo $department['display_name']; ?>" <?php if($row['transfer_department'] == $department['display_name']) {echo 'selected';} ?>><?php echo $department['display_name']; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                    <!-- location -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="transfer_location">Location</label>
                            <select name="transfer_location" id="transfer_location" class="form-control">
                                <option value="">Select Location</option>
                                <?php 
                                $sql_locations = "SELECT * FROM aims_preset_location";
                                $result_locations = mysqli_query($con, $sql_locations);
                                while ($row_locations = mysqli_fetch_assoc($result_locations)) {
                                    $locations[] = $row_locations;
                                }
                                if ($locations == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else {
                                    foreach ($locations as $location): ?>
                                        <option value="<?php echo $location['display_name']; ?>" <?php if($row['transfer_location'] == $location['display_name']) {echo 'selected';} ?>><?php echo $location['display_name']; ?></option>
                                    <?php endforeach;
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <!-- picture -->
                    <div class="col-4">
                        <label for="picture">Picture</label><br>
                        <?php
                        if (!empty($row3['picture'])) {
                            $fileName = basename($row3['picture']);
                            echo '<img id="picture" src="' . $row3['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">';
                        } else {
                            // Add a placeholder image or message when there is no picture
                            echo '<img id="picture" src="path/to/placeholder-image.jpg" alt="No Picture Available" style="max-width: 100%; max-height: 300px;">';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

$(document).ready(function () {
    // Event listener for the 'type' dropdown change
    $('#type').change(function () {
        var selectedValue = $(this).val();

        // Hide all date fields by default
        $('#start_date_container').hide();
        $('#end_date_container').hide();
        $('#date_transfer_container').hide();

        // Show the date fields based on the selected option
        if (selectedValue === 'Period') {
            $('#start_date_container').show();
            $('#end_date_container').show();
        } else if (selectedValue === 'Permanent') {
            $('#date_transfer_container').show();
        }
    });

    // Trigger the change event on page load to show/hide fields based on the initial value
    $('#type').trigger('change');
});


// submit using ajax
$('form').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response){
            // console.log(response);
            if(response.trim()=="true"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Asset edited successfully!',
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './transfer';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './edit_transfer_asset?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).ready(function() {
    // Event handler for branch selection
    $('#transfer_branch').change(function() {
        var selectedBranch = $(this).val();

        // AJAX request to fetch departments based on the selected branch
        $.ajax({
            type: 'POST',
            url: './module/setting/preset_location/location/get_departments_by_branch.php',
            data: { branch: selectedBranch },
            success: function(response) {
                // Update the department dropdown with the new options
                $('#departmentList').html(response);
            },
            error: function(error) {
                console.log('Error fetching departments: ' + error);
            }
        });
    });

    // Event handler for clearing branch value
    $('#transfer_branch').on('input', function() {
        // If the branch value is empty, clear the department options
        if ($(this).val() === '') {
            $('#departmentList').empty();
        }
    });
});

$(document).ready(function() {
    // Event handler for department selection
    $('#transfer_department').change(function() {
        var selectedDepartment = $(this).val();

        // AJAX request to fetch locations based on the selected department
        $.ajax({
            type: 'POST',
            url: './module/setting/preset_location/location/get_location_by_department.php',
            data: { department: selectedDepartment },
            success: function(response) {
                // Update the location dropdown with the new options
                $('#locationList').html(response);
            },
            error: function(error) {
                console.log('Error fetching locations: ' + error);
            }
        });
    });

    // Event handler for clearing department value
    $('#transfer_department').on('input', function() {
        // If the department value is empty, clear the location options
        if ($(this).val() === '') {
            $('#locationList').empty();
        }
    });
});
</script>