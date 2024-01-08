<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}

$sql = "SELECT * FROM aims_preset_location where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
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
    <h2>Edit Location</h2>
    <form action=".\module\setting\preset_location\location\editlocation_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Location ID: <?php echo $row['id']?></h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./preset_location" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- branch -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list="branchList" name="branch" value="<?php echo $row['branch'];?>" id="branch" class="form-control">
                                <datalist id="branchList">    
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
                                            <option value="<?php echo $branch['display_name']; ?>" <?php if($row['branch'] == $branch['display_name']) {echo 'selected';} ?>><?php echo $branch['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list="departmentList" name="department"  value="<?php echo $row['department'];?>" id="department" class="form-control">
                                <datalist id="departmentList">          
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
                                            <option value="<?php echo $department['display_name']; ?>" <?php if($row['display_name'] == $department['display_name']) {echo 'selected';} ?>><?php echo $department['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                    <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                                <datalist id="departmentList">  
                            </select>
                        </div>
                    </div>
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="display_name">Location</label>
                            <input type="text" id="display_name" name="display_name" placeholder="Name" value="<?php echo $row['display_name'];?>" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
// Submit the form using AJAX
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
                    text: 'Location edited successfully!',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function() {
                    window.location.href = './preset_location?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 5000
                }).then(function() {
                    window.location.href = './editlocation?id=<?php echo $row["id"];?>';
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