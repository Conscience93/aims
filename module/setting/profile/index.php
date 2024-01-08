<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = mysqli_query($con, "SELECT * FROM aims_user WHERE id = '$_SESSION[aims_id]'");
$row = mysqli_fetch_assoc($sql);
    $email = $row['email'];
    $full_name = $row['full_name'];
    $company_name = $row['company_name'];
    $contact_no = $row['contact_no'];
    $date_created = $row['date_created'];
    $department = $row['department'];
    $position = $row['position'];
    $address = $row['address'];
    $city = $row['city'];
    $state = $row['state'];
    $country = $row['country'];
?>


<style>
textarea {
  resize: none;
}
</style>

<div class="main">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
            <div class="col-6">
                <h4>User Profile</h4>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <a href="./editprofile" class="btn btn-primary float-right">Edit Profile</a>
                </div>
            </div>
        </div>
        </div>
    <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
    <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>

            <div class ="mb-3">
                <div class = "row">
                    <div class="col-6">
                        <h4>User Details</h4>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo $full_name; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email'];?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="text" id="contact_no" name="contact_no" value="<?php echo $row['contact_no'];?>"  class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="company">Company</label>
                        <input type="text" id="company" name="company" value="<?php echo $company_name; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" id="department" name="department" value="<?php echo $row['department'];?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo $row['city'];?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" value="<?php echo $row['state'];?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" value="<?php echo $row['country'];?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Staff's Address" class="form-control" readonly><?php echo $row['address'];?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>