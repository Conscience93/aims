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
  max-height: auto; /* Adjust the height as needed */
  overflow-y: scroll;
}

</style>

<div class="main">
        <form action=".\module\setting\iam\adduser_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add User Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
                            <a href="/aims/iam?tab=user-staff" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>User Staff</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- username -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="username">Username<span style="color: red;"> *</span></label>
                            <input type="text" id="username" name="username" class="form-control" required>
                        </div>
                    </div>
                    <!-- password -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="password">Password<span style="color: red;"> *</span></label>
                            <input type="password" id="password" name="password" class="form-control" value="aims12345" required>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label for="profile_picture"><b>Staff's Picture</b></label>
                            <input type="file" id="profile_picture" name="profile_picture" accept="image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- staff's name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="full_name">Employee Name<span style="color: red;"> *</span></label>
                            <input type="text" id="full_name" name="full_name" class="form-control" required>
                        </div>
                    </div>
                    <!-- company email -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="email">Email Address<span style="color: red;"> *</span></label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                    <!-- phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="contact_no">Contact Number</label>
                            <input type="text" id="contact_no" name="contact_no" class="form-control">
                        </div>
                    </div>
                    <!-- staff's nric -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="nric">NRIC</label>
                            <input type="number" id="nric" name="nric"  class="form-control">
                        </div>
                    </div>
                    <!-- staff's company_name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="company_name">Company Name</label>
                            <input type="text" id="company_name" name="company_name" class="form-control">
                        </div>
                    </div>
                    <!-- branch -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
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
                                <?php } else
                                foreach ($branchs as $branch): ?>
                                    <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                <?php endforeach; 
                                ?>
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
                                <?php } else
                                foreach ($departments as $department): ?>
                                    <option value="<?php echo $department['display_name']; ?>"><?php echo $department['display_name']; ?></option>
                                <?php endforeach; 
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- staff's position -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" id="position" name="position" class="form-control">
                        </div>
                    </div>
                </div>

                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3" placeholder="" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class ="mb-3">
                        <div class = "row">
                            <div class="col-6">
                                <h4>User Permission</h4>
                            </div>
                        </div>
                    </div>
                <div class = "row">
                    <!-- staff's user group -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="position">User Group<span style="color: red;"> *</span></label>
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
                                    <option value="<?php echo $user_group['id']; ?>" <?php if ($user_group['user_group_name'] == 'STAFF') {echo 'selected';} ?>><?php echo $user_group['user_group_name']; ?></option>
                                <?php endforeach; 
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <br>

            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$('form').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response){
            // Log the response for debugging
            // console.log(response);

            if (response.trim() === "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User Staff has been added successfully!', 
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './iam?tab=user-staff';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './adduser';
                });
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

</script>