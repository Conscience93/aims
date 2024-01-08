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
    <h2>Add Location</h2>
    <form action=".\module\setting\preset_location\location\addlocation_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Location Information</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./preset_location" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary">Submit</button> 
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <h4>Data</h4>
                    </div>
                </div>
            </div>
            <div class="row">
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
                            <datalist id="departmentList">
                        </select>
                    </div>
                </div>
                <!-- name -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="display_name">Location</label>
                        <input type="text" id="display_name" name="display_name" placeholder="Location" class="form-control" >
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
        success: function(response) {
            console.log(response);
            if (response.trim() == "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Location added successfully!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './addlocation';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './addlocation';
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