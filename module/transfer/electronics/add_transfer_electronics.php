<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';
?>

<style>
    span {
        height: 2.3rem;
    }

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

    .modal-backdrop {
        display: none;
    }

    .bold-option {
        font-weight: bold;
    }

        /* Style the modal background */
    .modal {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        margin-top:50px;
    }

    /* Style the modal content */
    .modal-content {
        background-color: #fff; /* White background */
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Box shadow for a slight elevation effect */
    }

    /* Style the modal header */
    .modal-header {
        background-color: #007bff; /* Blue header background */
        color: #fff; /* White text color */
        border-bottom: none; /* Remove the default border */
    }

    /* Style the close button in the header */
    .modal-header .close {
        color: #fff;
    }

    /* Style the modal title */
    .modal-title {
        font-weight: bold;
    }

    /* Style the "Add Category" button */
    .btn-primary {
        background-color: #007bff; /* Blue background for the button */
        color: #fff; /* White text color */
    }

    /* Style the "Close" button */
    .btn-secondary {
        background-color: #ccc; /* Gray background for the button */
        color: #333; /* Dark text color */
    }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%; /* Adjust the modal width for smaller screens */
        }
    }

</style>

<div class="main">
    <form action="./module/transfer/electronics/addelectronics_transfer_action.php" method="POST" id="transferForm">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Asset Transfer Data</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./add_transfer" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 75vh; overflow-y: scroll;">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Electronics Data</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                     <!-- Search Asset -->
                     <div class="col-3">
                        <div class="form-group">
                            <label for="name">Search Electronics</label>
                            <input type="text" id="name" name="name" class="form-control" oninput="searchAsset()" required>
                            <div id="searchResults"></div>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <span id="category" name="category" placeholder="" class="form-control" onchange="lol(this.value)"></span>
                            <!-- Hidden input for category -->
                            <input type="hidden" id="hidden_category" name="category">
                        </div>
                    </div>
                    <!-- asset_tag -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="asset_tag">Asset Tag</label>
                            <span id="asset_tag" name="asset_tag" placeholder="" class="form-control"></span>
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
                <div class = "row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <span id="branch" name="branch" value ="" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <span id="department" name="department" value ="" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <span id ="location" name="location" value ="" class="form-control">
                        </div>
                    </div>
                </div>

                </br>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>New Location</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                     <!-- type-->
                     <div class="col-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control">
                                <option value="Type" selected>Choose Transfer Type</option>
                                <option value="Permanent">Permanent</option>
                                <option value="Period">Period</option>
                                <!-- Add more options as needed -->
                            </select>
                        </div>
                    </div>
                    <!-- start_date -->
                    <div class="col-3" id="start_date_container" style="display: none;">
                        <div class="form-group">
                            <label for="start_date">Borrowed Date Start</label>
                            <input type="date" id="start_date" name="start_date" placeholder="" class="form-control">
                        </div>
                    </div>

                    <!-- end_date -->
                    <div class="col-3" id="end_date_container" style="display: none;">
                        <div class="form-group">
                            <label for="end_date">Borrowed Date End</label>
                            <input type="date" id="end_date" name="end_date" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- date_transfer-->
                    <div class="col-3" id="date_transfer_container" style="display: none;">
                        <div class="form-group">
                            <label for="date_transfer">Date Transfer</label>
                            <input type ="date" id="date_transfer" name="date_transfer" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- branch-->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="transfer_branch">Building/Branch</label>
                            <input list="branchList" name="transfer_branch" id="transfer_branch" class="form-control">
                                <datalist id="branchList">
                                    <option value="">Select Building/Branch</option>
                                    <?php 
                                    $sql_branchs = "SELECT * FROM aims_preset_computer_branch";
                                    $result_branchs = mysqli_query($con, $sql_branchs);
                                    while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                        $branchs[] = $row_branchs;
                                    }
                                    if ($branchs == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="transfer_department">Department</label>
                            <input list="departmentList" name="transfer_department" id="transfer_department" class="form-control">
                                <datalist id="departmentList">
                                    <option value="">Select Department</option>
                                    <?php 
                                    $sql_departments = "SELECT * FROM aims_preset_department";
                                    $result_departments = mysqli_query($con, $sql_departments);
                                    while ($row_departments = mysqli_fetch_assoc($result_departments)) {
                                        $departments[] = $row_departments;
                                    }
                                    if ($departments == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($departments as $department): ?>
                                        <option value="<?php echo $department['display_name']; ?>"><?php echo $department['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                                <datalist id="departmentList">
                            </select>
                        </div>
                    </div>
                    <!-- location -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="transfer_location">Location</label>
                            <input list="locationList" name ="transfer_location" id="transfer_location" class="form-control">
                                <datalist id="locationList">
                                    <option value="">Select Location</option>
                                    <?php 
                                    $sql_locations = "SELECT * FROM aims_preset_location";
                                    $result_locations = mysqli_query($con, $sql_locations);
                                    while ($row_locations = mysqli_fetch_assoc($result_locations)) {
                                        $locations[] = $row_locations;
                                    }
                                    if ($locations == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($locations as $location): ?>
                                        <option value="<?php echo $location['display_name']; ?>"><?php echo $location['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Location" data-action="addNewLocation">Add New Location</option>
                                <datalist id="locationList">
                            </select>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-4">
                        <label for="picture">Picture</label><br>
                        <?php
                        if (!empty($row['picture'])) {
                            $fileName = basename($row['picture']);
                            echo '<img id="picture" src="' . $row['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">';
                        } else {
                            // Add a placeholder image or message when there is no picture
                            echo '<img id="picture" src="path/to/placeholder-image.jpg" alt="No Picture Available" style="max-width: 100%; max-height: 300px;">';
                            // or echo 'No picture available.';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Modal for adding a new department -->
<form action=".\module\setting\preset_location\department\adddepartment_action.php" method="POST" id="addDepartmentForm">
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addDepartmentForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepartmentLabel">Add New Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class ="row">
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="branch">Building/Branch</label>
                                    <input list ="buildingList" name="branch" id="branch" class="form-control">
                                        <datalist id="buildingList">
                                            <?php 
                                            $sql_branchs = "SELECT * FROM aims_preset_computer_branch";
                                            $result_branchs = mysqli_query($con, $sql_branchs);
                                            $branchs=[];
                                            while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                                $branchs[] = $row_branchs;
                                            }
                                            if ($branchs == []) { ?>
                                                <option value="">No Selection Found</option>
                                            <?php } else
                                            foreach ($branchs as $branch): ?>
                                                <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                            <?php endforeach; ?>
                                        <datalist id="buildingList">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="display_name_department">Department Name</label>
                                    <input type="text" id="display_name_department" name="display_name" placeholder="Make sure to add Department at the end" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="noe">No. of employees</label>
                                    <input type="text" id="noe" name="noe" placeholder="Etc 12"  class="form-control">
                                </div>
                            </div>
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="staff_department">Person In Charge</label>
                                    <select name="staff" id="staff_department" class="form-control" autofocus onchange="getStaffDetails(this.value, 'staff_contact_no_department')">
                                        <option value="">Select Staff</option>
                                        <?php 
                                        $sql_staffs = "SELECT * FROM aims_people_staff";
                                        $result_staffs = mysqli_query($con, $sql_staffs);
                                        while ($row_staffs = mysqli_fetch_assoc($result_staffs)) {
                                            $staffs[] = $row_staffs;
                                        }
                                        if ($staffs == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php } else
                                        foreach ($staffs as $staff): ?>
                                            <option value="<?php echo $staff['display_name']; ?>"><?php echo $staff['display_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>                   
                                <div class="form-group">
                                    <label for="staff_contact_no_department">Contact Number</label>
                                    <span id="staff_contact_no_department" name="staff_contact_no" placeholder="" class="form-control"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addDepartmentButton" class="btn btn-primary">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new location -->
<form action=".\module\setting\preset_location\location\addlocation_action.php" method="POST"  id="addLocationForm">
    <div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="addLocationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addLocationForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLocationLabel">Add New Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list ="buildingList" name="branch" id="branch" class="form-control">
                                <datalist id="buildingList">
                                    <?php 
                                    $sql_branchs = "SELECT * FROM aims_preset_computer_branch";
                                    $result_branchs = mysqli_query($con, $sql_branchs);
                                    $branchs=[];
                                    while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                        $branchs[] = $row_branchs;
                                    }
                                    if ($branchs == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                    <?php endforeach; ?>
                                <datalist id="buildingList">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list ="sectorList" name="department" id="department" class="form-control">
                                <datalist id="sectorList">
                                    <option value="">Select Department</option>
                                    <?php 
                                    $sql_departments = "SELECT * FROM aims_preset_department";
                                    $result_departments = mysqli_query($con, $sql_departments);
                                    $departments=[];
                                    while ($row_departments = mysqli_fetch_assoc($result_departments)) {
                                        $departments[] = $row_departments;
                                    }
                                    if ($departments == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else
                                    foreach ($departments as $department): ?>
                                        <option value="<?php echo $department['display_name']; ?>"><?php echo $department['display_name']; ?></option>
                                    <?php endforeach; ?>
                                <datalist id="sectorList">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="display_name">Location</label>
                            <input type="text" id="display_name_location" name="display_name" placeholder="Location" class="form-control" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"  id="addLocationButton" class="btn btn-primary">Add Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new branch -->
<form action=".\module\setting\preset_location\branch\addbranch_action.php" method="POST" id="addBranchForm">
    <div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addBranchForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBranchModalLabel">Add New Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class ="row">
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="display_name">Building/Branch</label>
                                    <input type="text" class="form-control" id="display_name" name="display_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="branch_contact_no">Office No.</label>
                                    <input type="number" id="branch_contact_no" name="branch_contact_no"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="branch_email">Office Email</label>
                                    <input type="email" id="branch_email" name="branch_email"  class="form-control">
                                </div>
                            </div>
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="pic">Person In Charge</label>
                                    <input type="text" id="pic" name="pic"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="contact_no">Contact No.</label>
                                    <input type="number" id="contact_no" name="contact_no"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea cols="65" rows="4" type="text" id="address" name="address" placeholder="Full Address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addBranchButton" class="btn btn-primary">Add Building/Branch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {
    // Event listener for the 'type' dropdown change
    $('#type').change(function() {
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
});



function searchAsset() {
    var input = document.getElementById('name').value;
    var searchResultsDiv = document.getElementById('searchResults');
    var categorySpan = document.getElementById('category');
    var assetTagSpan = document.getElementById('asset_tag');
    var branchTagSpan = document.getElementById('branch'); // Add this line
    var departmentTagSpan = document.getElementById('department'); // Add this line
    var locationTagSpan = document.getElementById('location'); // Add this line
    var pictureTagSpan = document.getElementById('picture'); // Add this line

    // Check if the input is not empty
    if (input.trim() !== '') {
        // Make an AJAX request to the server to fetch asset names
        var xhr = new XMLHttpRequest();

        // Handle the state change
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Update the searchResults div with the fetched data
                    searchResultsDiv.innerHTML = xhr.responseText;
                    searchResultsDiv.style.display = 'block'; // Show the suggestions box

                    // Add click event listener to each suggestion
                    var suggestions = searchResultsDiv.getElementsByTagName('li');
                    for (var i = 0; i < suggestions.length; i++) {
                        suggestions[i].addEventListener('click', function() {
                            // Fill in the textbox with the clicked suggestion
                            document.getElementById('name').value = this.textContent;
                            // Hide the suggestions box
                            searchResultsDiv.style.display = 'none';

                            // Make another AJAX request to fetch category, asset tag, branch, department, and location
                            var selectedAssetName = this.textContent;
                            var xhrDetails = new XMLHttpRequest();
                            xhrDetails.onreadystatechange = function() {
                                if (xhrDetails.readyState === 4) {
                                    if (xhrDetails.status === 200) {
                                        // Update the category, asset tag, branch, department, and location spans with the fetched data

                                        var data = JSON.parse(xhrDetails.responseText);
                                        categorySpan.textContent = data.category;
                                        assetTagSpan.textContent = data.asset_tag;
                                        branchTagSpan.textContent = data.branch;
                                        departmentTagSpan.textContent = data.department;
                                        locationTagSpan.textContent = data.location;

                                        // Set the src attribute of the image element
                                        document.getElementById('picture').src = data.picture;

                                        // Also, update the hidden input fields so that they are sent with the form
                                        document.getElementById('hidden_category').value = data.category;
                                        document.getElementById('hidden_asset_tag').value = data.asset_tag;
                                        document.getElementById('hidden_branch').value = data.branch;
                                        document.getElementById('hidden_department').value = data.department;
                                        document.getElementById('hidden_location').value = data.location;
                                        document.getElementById('hidden_picture').value = data.picture;
                                    } else {
                                        // Handle the error
                                        console.error('Error fetching details:', xhrDetails.status, xhrDetails.statusText);
                                    }
                                }
                            };

                            // Assuming the server-side script is named getAssetDetails.php
                            xhrDetails.open('GET', 'module/transfer/getAssetDetails.php?name=' + selectedAssetName, true);
                            xhrDetails.send();
                        });
                    }
                } else {
                    // Handle the error (e.g., display an error message)
                    console.error('Error fetching data:', xhr.status, xhr.statusText);
                }
            }
        };

        // Assuming the server-side script is named searchAsset.php
        xhr.open('GET', 'module/transfer/electronics/smart_search.php?name=' + input, true);
        xhr.send();
    } else {
        // Clear the searchResults if the input is empty
        searchResultsDiv.innerHTML = '';
        searchResultsDiv.style.display = 'none'; // Hide the suggestions box

        // Clear the category, asset tag, branch, department, and location boxes
        categorySpan.textContent = '';
        assetTagSpan.textContent = '';
        branchTagSpan.textContent = '';
        departmentTagSpan.textContent = '';
        locationTagSpan.textContent = '';
        pictureTagSpan.textContent = '';
    }
}

function lol(category) {
    if (category == "computer") {
        var actionUrl = './module/transfer/' + category + '/add' + category + '_transfer_action.php';
        $('transferForm').attr('action', actionUrl);
    }
    
}

function selectAsset(assetName) {
    $('#name').val(assetName);
    $('#suggestedAssets').html(''); // Clear suggested assets
}

function getVendorsDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/vendors/get_vendors_details_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#pic").text(data["pic"]);
                $("#contact_no").text(data["contact_no"]);
                $("#email").text(data["email"]);
                $("#fax").text(data["fax"]);
            } catch (e) {
                $("#pic").text("");
                $("#contact_no").text("");
                $("#email").text("");
                $("#fax").text("");
            }
        }
    });
}

$(document).ready(function () {
    // Show the modal when "Add New Location" is selected
    $('#transfer_location').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Location') {
            $('#addLocationModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Location" option
    $('#locationList option[data-action="addNewLocation"]').click(function () {
        $('#addLocationModal').modal('show');
        $('#transfer_location').val(''); // Clear the input field after opening the modal
    });

    $('#addLocationButton').click(function() {

        var formData = new FormData($('#addLocationForm')[0]);

        $.ajax({
            url: './module/setting/preset_location/location/addlocation_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Location added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Location to the dropdown list
                        var newLocationName = $('#display_name_location').val();
                        $('#locationList').append('<option value="' + newLocationName + '">' + newLocationName + '</option>');

                        // Optionally, you can select the newly added Location
                        $('#transfer_location').val(newLocationName);

                        // Close the modal
                        $('#addLocationModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Category" is selected
    $('#transfer_department').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Department') {
                $('#addDepartmentModal').modal('show');
                $('#transfer_department').val('');
            }
        });

    // Handling the "Add New Department" option
    $('#departmentList option[data-action="addNewDepartment"]').click(function () {
        $('#addDepartmentModal').modal('show');
        $('#transfer_department').val(''); // Clear the input field after opening the modal
    });

    $('#addDepartmentButton').click(function() {
        var formData = new FormData($('#addDepartmentForm')[0]);

        $.ajax({
            url: './module/setting/preset_location/department/adddepartment_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Department added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new department to the dropdown list
                        var newDepartmentName = $('#display_name_department').val();
                        $('#departmentList').append('<option value="' + newDepartmentName + '">' + newDepartmentName + '</option>');

                        // Optionally, you can select the newly added department
                        $('#transfer_department').val(newDepartmentName);

                        // Close the modal
                        $('#addDepartmentModal').modal('hide');

                        // Update the nameList in addLocationModal
                        updateNameList();
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

// Function to update sectorList in addDepartmentModal
function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/asset/get_department_names.php',
            success: function(response) {
                // Update the sectorList with the new categories
                $('#sectorList').html(response);
            },
            error: function(error) {
                console.log('Error fetching department names: ' + error);
            }
        });
    }
});

$(document).ready(function () {
    // Show the modal when "Add New Building/Branch" is selected
    $('#transfer_branch').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Building/Branch') {
            $('#addBranchModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Building/Branch" option
    $('#branchList option[data-action="addNewBranch"]').click(function () {
        $('#addBranchModal').modal('show');
        $('#transfer_branch').val(''); // Clear the input field after opening the modal
    });

    $('#addBranchButton').click(function() {

        var formData = new FormData($('#addBranchForm')[0]);

        $.ajax({
            url: './module/setting/preset_location/branch/addbranch_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.includes("Branch added successfully")) {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Branch added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new branch to the dropdown list
                        var newBranchName = $('#display_name').val();
                        $('#branchList').append('<option value="' + newBranchName + '">' + newBranchName + '</option>');

                        // Optionally, you can select the newly added branch
                        $('#transfer_branch').val(newBranchName);

                        // Close the modal
                        $('#addBranchModal').modal('hide');

                        // Update the nameList in addDepartmentModal
                        updateNameList();
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    // Function to update buildingList in addDepartmentModal
    function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/asset/get_branch_names.php',
            success: function(response) {
                // Update the buildingList with the new categories
                $('#buildingList').html(response);
            },
            error: function(error) {
                console.log('Error fetching branch names: ' + error);
            }
        });
    }
});

function getStaffDetails(name, contactNoId) {
    $.ajax({
        type: "POST",
        url: "module/people/staff/get_staff_detail_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#" + contactNoId).text(data["contact_no"]);
            } catch (e) {
                $("#" + contactNoId).text("");
            }
        }
    });
}

// submit using ajax
$('form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('asset_tag', $('#asset_tag').text());

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response) {
            // console.log(response);
            if (response.trim() == "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Record added successfully!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './transfer';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 200000
                }).then(function() {
                    window.location.href = './transfer';
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

                // Add "Add New Department" option if it doesn't exist
                if (!$('#departmentList option[value="Add New Department"]').length) {
                    $('#departmentList').append('<option value="Add New Department" data-action="addNewDepartment">Add New Department</option>');
                }
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

                // Add ""Add New Location" option if it doesn't exist
                if (!$('#locationList option[value="Add New Location"]').length) {
                    $('#locationList').append('<option value="Add New Location" data-action="addNewLocation">Add New Location</option>');
                }
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