<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

?>

<style>
textarea {
  resize: none;
}

.card-body {
  max-height: 650px; /* Adjust the height as needed */
  overflow-y: scroll;
}

.row .float-right {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
</style>

<div class="main">
        <form action=".\module\people\staff\addstaff_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Staff Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./staff" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Staff Details</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- staff's name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="display_name">Employee Name</label>
                            <input type="text" id="display_name" name="display_name"  class="form-control">
                        </div>
                    </div>
                    <!-- company email -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                    </div>
                    <!-- phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="contact_no">Contact Number</label>
                            <input type="number" id="contact_no" name="contact_no" class="form-control">
                        </div>
                    </div>
                    <!-- staff's nric -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="nric">NRIC</label>
                            <input type="number" id="nric" name="nric"  class="form-control">
                        </div>
                    </div>
                    <!-- branch  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list ="branchList" name="branch" id="branch" class="form-control">
                                <datalist id="branchList">
                                    <option value="">Select Building/Branch</option>
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
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list ="departmentList" name="department" id="department" class="form-control">
                                <datalist id="departmentList">
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
                                    <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                                <datalist id="departmentList">
                            </select>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3" placeholder="Staff's Address" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <br>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="profile"><b>Staff's Picture </b></label>
                            <input type="file" id="profile" name="profile" accept="image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
// submit using ajax
$('form').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response){
            // Log the response for debugging
            console.log(response);

            if (response.trim() === "Staff details added successfully!") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response, // Display the response from the server
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './staff';
                });
            } else {
                // Display an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response, // Display the response from the server for debugging
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './staff';
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors here
            console.error(xhr.responseText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).ready(function() {
    // Event handler for branch selection
    $('#branch').change(function() {
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
    $('#branch').on('input', function() {
        // If the branch value is empty, clear the department options
        if ($(this).val() === '') {
            $('#departmentList').empty();
        }
    });
});
</script>