<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_user where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
textarea {
  resize: none;
}
</style>

<div class="main">
    <form action=".\module\setting\iam\edituser_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit User Staff Details</h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
                        <a href="./iam?tab=user-staff" class="btn btn-danger">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
        <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
            <div class ="mb-3">
                <div class = "row">
                    <div class="col-6">
                        <h4>User Staff Details</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <label class="col-2" for="username"><b>Username: </b></label>
                <span class="col-4" id="username" name="username" ><?php echo $row['username'];?></span>
            </div>
            <div class="row">
                <label class="col-2" for="email"><b>Email: </b></label>
                <span class="col-4" id="email" name="email" ><?php echo $row['email'];?></span>
            </div>
            <div class="row">
                <label class="col-2" for="date_created"><b>Date Created: </b></label>
                <span class="col-4" id="date_created" name="date_created" ><?php echo $row['date_created'];?></span>
            </div>
            <div class="row mb-4">
                <label class="col-2" for="date_modified"><b>Date Modified: </b></label>
                <span class="col-4" id="date_modified" name="date_modified" ><?php echo $row['date_modified'];?></span>
            </div>
            <div class = "row">
                <!-- staff's name -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="full_name">Employee Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo $row['full_name'];?>" class="form-control">
                    </div>
                </div>
                <!-- phone number -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?php echo $row['contact_no'];?>" class="form-control">
                    </div>
                </div>
                <!-- staff's nric -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="nric">NRIC</label>
                        <input type="text" id="nric" name="nric" value="<?php echo $row['nric'];?>" class="form-control">
                    </div>
                </div>
                <!-- company -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="company_name">Company</label>
                        <select name="company_name" id="company_name" class="form-control">
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
                                    <option value="<?php echo $branch['display_name']; ?>" <?php if($row['company_name'] == $branch['display_name']) {echo 'selected';} ?>><?php echo $branch['display_name']; ?></option>
                                <?php endforeach;
                            } ?>
                        </select>                    
                    </div>
                </div>
                <!-- staff's department -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="department">Department</label>
                        <select name="department" id="department" class="form-control">
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
                                    <option value="<?php echo $department['display_name']; ?>" <?php if($row['department'] == $department['display_name']) {echo 'selected';} ?>><?php echo $department['display_name']; ?></option>
                                <?php endforeach;
                            } ?>
                        </select>
                    </div>
                </div>
                <!-- staff's position -->
                <div class="col-2">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" id="position" name="position" class="form-control" value="<?php echo $row['position'];?>">
                        </div>
                    </div>
                <!-- staff's address -->
                <div class="col-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="" class="form-control"><?php echo $row['address'];?></textarea>
                    </div>
                </div>
            </div>

            <br>

            <div class ="mb-3">
                <div class = "row">
                    <div class="col-6">
                        <h4>User Permission</h4>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <!-- staff's user group -->
                <div class="col-2">
                        <div class="form-group">
                            <label for="position">User Group</label>
                            <select name="user_group" id="user_group" class="form-control" required>
                                <option value="">Select User Group</option>
                                <?php 
                                $sql_user_groups = "SELECT * FROM aims_user_group WHERE id != '1' AND status = 'ACTIVE'";
                                $result_user_groups = mysqli_query($con, $sql_user_groups);
                                while ($row_user_groups = mysqli_fetch_assoc($result_user_groups)) {
                                    $user_groups[] = $row_user_groups;
                                }
                                if ($user_groups == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else
                                foreach ($user_groups as $user_group): ?>
                                    <option value="<?php echo $user_group['id']; ?>" <?php if($user_group['id'] == $row['user_group_id']) {echo 'selected';} ?>><?php echo $user_group['user_group_name']; ?></option>
                                <?php endforeach; 
                                ?>
                            </select>
                        </div>
                    </div>
            </div>

            <br>

            <div class ="mb-3">
                <div class = "row">
                    <div class="col-6">
                        <h4>Files</h4>
                    </div>
                </div>
            </div>
            <div class="row mb-5">
                <div class="col-3">
                    <div class="form-group">
                        <label for="profile_picture">Staff's Picture</label></br>
                        <?php
                        if (!empty($row['profile_picture'])) {
                            $fileName = basename($row['profile_picture']);
                            echo '<div class="md-3 form-control"><a href="' . $row['profile_picture'] . '" target="_blank">' . $fileName . '</a></div>';
                            echo '<br>';
                            echo 
                            '<form id="delete-profile-form" action="./module/people/staff/deletefile_action.php" method="POST">
                                <input type="hidden" name="fileType">
                                <input type="hidden" name="id" value="'.$row['id'].'">
                                <button class="btn btn-danger btn-delete-file" type="button" form="delete-profile-form" onclick="confirmDeleteFile('.$row['id'].',\'profile\')">Delete</button>
                            </form>';
                        } else {
                            echo '<input type="file" id="profile_picture" name="profile_picture" accept="" value="" class="form-control" />';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
</div>

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
            // console.log(response);
            if(response.trim()=="true"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User Staff edited successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './iam?tab=user-staff';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './edituser?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

// Files
function confirmDeleteFile(id, fileType) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete the " + fileType + " file. This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteFile(id, fileType);
        }
    });
}

function deleteFile(id, fileType) {
    $.ajax({
        url: "./module/setting/iam/deletefile_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id, fileType: fileType}, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The file has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './edituser?id=' + id;
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the file.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './edituser?id=' + id;
            });
        }
    });
}
</script>