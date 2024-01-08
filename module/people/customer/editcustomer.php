<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_people_customer where id ='".$_GET['id']."'";
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
    <form action=".\module\people\customer\editcustomer_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
                    <div class="col-6">
                        <h4>Edit Customer Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./customer" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                    <!-- SMART SEARCH 
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="smart">Smart Search</label>
                                <input type="text" id="" name="" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div> -->

                    <div class ="mb-3">
                        <div class = "row">
                            <div class="col-6">
                                <h4>Customer Details</h4>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <!-- Customer's name -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="display_name">Customer Name</label>
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
                        <!-- Customer's nric -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="nric">NRIC</label>
                                <input type="number" id="nric" name="nric" value="<?php echo $row['nric'];?>" class="form-control">
                            </div>
                        </div>
                        <!-- Customer's address -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" rows="3" placeholder="Customer's Address" class="form-control"><?php echo $row['address'];?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
                    text: 'Asset edited successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './customer?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './customer?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>