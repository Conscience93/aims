<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_people_staff where id ='".$_GET['id']."'";
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
</style>

<div class="main">
    <form action=".\module\people\staff\editstaff_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Staff Details</h4>
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
        <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
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
                        <input type="text" id="display_name" name="display_name" value="<?php echo $row['display_name'];?>" class="form-control">
                    </div>
                </div>
                <!-- company email -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email'];?>" class="form-control">
                    </div>
                </div>
                <!-- phone number -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="number" id="contact_no" name="contact_no" value="<?php echo $row['contact_no'];?>" class="form-control">
                    </div>
                </div>
                <!-- staff's nric -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="nric">NRIC</label>
                        <input type="number" id="nric" name="nric" value="<?php echo $row['nric'];?>" class="form-control">
                    </div>
                </div>
                <!-- branch -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="branch">Company</label>
                        <select name="branch" id="branch" class="form-control">
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
                                    <option value="<?php echo $branch['display_name']; ?>" <?php if($row['branch'] == $branch['display_name']) {echo 'selected';} ?>><?php echo $branch['display_name']; ?></option>
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
                <!-- staff's address -->
                <div class="col-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Staff's Address" class="form-control"><?php echo $row['address'];?></textarea>
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
                        <label for="profile">Staff's Picture</label></br>
                        <?php
                        if (!empty($row['profile'])) {
                            $fileName = basename($row['profile']);
                            echo '<div class="md-3 form-control"><a href="' . $row['profile'] . '" target="_blank">' . $fileName . '</a></div>';
                            echo '<br>';
                            echo 
                            '<form id="delete-profile-form" action="./module/people/staff/deletefile_action.php" method="POST">
                                <input type="hidden" name="fileType" value="profile">
                                <input type="hidden" name="id" value="'.$row['id'].'">
                                <button class="btn btn-danger btn-delete-file" type="button" form="delete-profile-form" onclick="confirmDeleteFile('.$row['id'].',\'profile\')">Delete</button>
                            </form>';
                        } else {
                            echo '<input type="file" id="profile" name="profile" accept="" value="" class="form-control" />';
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
                    text: 'Staff Profile edited successfully!',
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './staff?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './staff?id=<?php echo $row["id"];?>';
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
        url: "./module/people/staff/deletefile_action.php", // Update the URL to your PHP script
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
                window.location.href = './editstaff?id=' + id;
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
                window.location.href = './editstaff?id=' + id;
            });
        }
    });
}
</script>