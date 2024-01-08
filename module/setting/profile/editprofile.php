<?php
include_once 'include/db_connection.php';

// Function to escape user input
function escapeInput($input) {
    global $con;
    return mysqli_real_escape_string($con, $input);
}

$id = $_SESSION['aims_id'];

$sql = mysqli_query($con, "SELECT * FROM aims_user WHERE id = '$id'");

$row = mysqli_fetch_assoc($sql);

?>

<style>
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
    <form action=".\module\setting\profile\editprofile_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
            <div class="col-6">
                <h4>Edit User Profile</h4>
            </div>
            <div class="col-6">
                <div class="float-right">
                    <a href="./profile" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>  
        </div>
    </div>
        <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
        <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
            <div class ="mb-3">
                <div class = "row">
                    <div class="col-6">
                        <h4>Edit User Details</h4>
                    </div>
                </div>
            </div>
            <div class = "row">
                <div class="col-2">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="<?php echo $row['full_name']; ?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email'];?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="number" id="contact_no" name="contact_no" value="<?php echo $row['contact_no'];?>"  class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="company_name">Company</label>
                        <input type="text" id="company_name" name="company_name" value="<?php echo $row['company_name']; ?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="department">Department</label>
                        <input type="text" id="department" name="department" value="<?php echo $row['department'];?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="<?php echo $row['city'];?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="state">State</label>
                        <input type="text" id="state" name="state" value="<?php echo $row['state'];?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="country">Country</label>
                        <input type="text" id="country" name="country" value="<?php echo $row['country'];?>" class="form-control" >
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Staff's Address" class="form-control" ><?php echo $row['address'];?></textarea>
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
        success: function(response){
            // console.log(response);
            if(response.trim()=="true"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Profile edited successfully!' + response,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './profile?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './editprofile?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>

