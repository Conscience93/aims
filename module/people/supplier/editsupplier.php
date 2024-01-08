<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_people_supplier where id ='".$_GET['id']."'";
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
    <form action=".\module\people\supplier\editsupplier_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
                    <div class="col-6">
                        <h4>Edit Vendor Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./supplier" class="btn btn-danger">Cancel</a>
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
                                <h4>Vendor Details</h4> 
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <!-- location bought it from -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="display_name">Vendor</label>
                                <input type="text" id="display_name" name="display_name"  value="<?php echo $row['display_name'];?>" class="form-control" >
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="pic">Person in Charge</label>
                                <input type="text" id="pic" name="pic"  value="<?php echo $row['pic'];?>" class="form-control" >
                            </div>
                        </div>
                        <!-- phone number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="contact_no">Contact Number</label>
                                <input type="number" id="contact_no" name="contact_no" value="<?php echo $row['contact_no'];?>" class="form-control" >
                            </div>
                        </div>
                        <!-- company email -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" value="<?php echo $row['email'];?>" class="form-control" >
                            </div>
                        </div>
                        <!-- company fax number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="fax">Fax Number</label>
                                <input type="number" id="fax" name="fax" value="<?php echo $row['fax'];?>" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea cols="65" rows="4" id="address" name="address" class="form-control"><?php echo $row['address'];?></textarea>
                            </div>
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
                    text: 'Asset edited successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './supplier?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 30000
                }).then(function() {
                    window.location.href = './supplier?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>