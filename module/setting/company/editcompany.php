<?php
include_once 'include/db_connection.php';

$id = $_SESSION['aims_id'];

// Fetch data from the database based on the $id
$sql = mysqli_query($con, "SELECT * FROM aims_company");
$row = mysqli_fetch_assoc($sql);

if ($row) {
    $name = $row['name'] ?? '';
    $email = $row['email'] ?? '';
    $phone = $row['phone'] ?? '';
    $fax = $row['fax'] ?? '';
    $address = $row['address'] ?? '';
} else {
}
?>

<div class="main">
    <form action=".\module\setting\company\editcompany_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
            <div class="col-6">
                <h4>Edit Company Profile</h4>
            </div>
            <div class="col-6">
                <div class="row float-right">
                    <a href="./company" class="btn btn-danger">Back</a>
                    <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Save</button>
                </div>
            </div>  
        </div>
    </div>
        <div class="card-body" style="max-height: 75vh; overflow-y: scroll;">
        <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
            <div class ="mb-3">
                <div class = "row">
                    <div class="col-6">
                        <h4>Edit User Details</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group">
                        <label for="name">Company Name</label>
                        <input type="text" id="name" name="name" value="<?php echo $row['name'] ?? ''; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email'] ?? ''; ?>" class="form-control">
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="phone">Contact Number</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $row['phone'] ?? ''; ?>" class="form-control" >
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="fax">Fax Number</label>
                        <input type="text" id="fax" name="fax" value="<?php echo $row['fax'] ?? ''; ?>" class="form-control">
                    </div>
                </div>
                <!-- pictures -->
                <div class="col-3">
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" id="logo" name="logo" accept="image/png, image/jpg, image/webp" class="form-control" />
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Company's Address" class="form-control"><?php echo $row['address'] ?? ''; ?></textarea>
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
                    window.location.href = './company';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './editcompany';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>

