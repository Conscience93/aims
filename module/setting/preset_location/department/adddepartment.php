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
    <h2>Add Department</h2>
    <form action=".\module\setting\preset_location\department\adddepartment_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Department Information</h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./preset_location" class="btn btn-danger">Back</a>
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
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
                <!-- name -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="display_name">Department Name</label>
                        <input type="text" id="display_name" name="display_name" placeholder="" class="form-control">
                    </div>
                </div>
                <!-- no. of employees -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="noe">No. of employees</label>
                        <input type="text" id="noe" name="noe" placeholder="Etc 12"  class="form-control">
                    </div>
                </div>
                <!-- person in charge -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="staff">Person In Charge</label>
                        <select name="staff" id="staff" class="form-control" autofocus onchange="getStaffDetails(this.value)">
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
                </div>
                <!-- contact_number -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="staff_contact_no">Contact Number</label>
                        <span id="staff_contact_no" name="staff_contact_no" placeholder="" class="form-control"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
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
        success: function(response) {
            console.log(response);
            if (response.trim() == "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Department added successfully!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './adddepartment';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 20000
                }).then(function() {
                    window.location.href = './adddepartment';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

function getStaffDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/staff/get_staff_detail_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#staff_contact_no").text(data["contact_no"]);
            } catch (e) {
                $("#staff_contact_no").text("");
            }
        }
    });
}
</script>
    