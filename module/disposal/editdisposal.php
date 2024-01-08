<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_all_asset_disposal where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
.main span {
    height: 2.3rem;
}

form .btn-delete-file {
    width: 75px !important;
}

.row .float-right {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
</style>

<div class="main">
    <form action=".\module\disposal\editdisposal_action.php" method="POST" enctype="multipart/form-data">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./disposal" class="btn btn-danger">Discard</a>
                            <button type="submit" class="btn btn-primary">Save</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                <input id="asset_tag" name="asset_tag" value="<?php echo $row['asset_tag'];?>" hidden>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>Data</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- name -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name'];?>" class="form-control">
                            </div>
                        </div>
                        <!-- category -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" id="category" name="category" placeholder="" value="<?php echo $row['category'];?>" class="form-control">
                            </div>
                        </div>
                        <!-- status -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" id="status" name="status" placeholder="" value="<?php echo $row['status'];?>" class="form-control">
                            </div>
                        </div>
                        <!-- value -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="value">Value</label>
                                <input type="number" id="value" name="value" placeholder="" value="<?php echo $row['value'];?>" class="form-control">
                            </div>
                        </div>
                        <!-- expected_date -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="expected_date">Expected Disposed Date</label>
                                <input type="date" id="expected_date" name="expected_date" placeholder="" value="<?php echo $row['expected_date'];?>" class="form-control">
                            </div>
                        </div>
                        <!-- reason -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="reason">Reason</label>
                                <input type="text" id="reason" name="reason" placeholder="" value="<?php echo $row['reason'];?>" class="form-control">
                            </div>
                        </div>
                    </div>   
                    
                    <hr>

                    <div class ="mb-3">
                        <div class = "row">
                            <div class="col-6">
                                <h4>Disposed To</h4>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <!-- company -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="company">Location</label>
                                <input type="text" id="company" name="company" placeholder="" value="<?php echo $row['company'];?>"  class="form-control">
                            </div>
                        </div>
                        <!-- phone_no -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="phone_no">Company Phone No.</label>
                                <input type="number" id="phone_no" name="phone_no" placeholder="" value="<?php echo $row['phone_no'];?>"  class="form-control">
                            </div>
                        </div>
                        <!-- email -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="email">Company Email</label>
                                <input type="text" id="email" name="email" placeholder="" value="<?php echo $row['email'];?>"  class="form-control">
                            </div>
                        </div>
                        <!-- pic -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="pic">Person In Charge</label>
                                <input type="text" id="pic" name="pic" placeholder="" value="<?php echo $row['pic'];?>"  class="form-control">
                            </div>
                        </div>
                        <!-- pic_phone_no -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="pic_phone_no">Phone No.</label>
                                <input type="text" id="pic_phone_no" name="pic_phone_no" placeholder="" value="<?php echo $row['pic_phone_no'];?>"  class="form-control">
                            </div>
                        </div>
                        <!-- address -->
                        <div class="col-4">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" id="address" name="address" placeholder="" value="<?php echo $row['address'];?>"  class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

<!-- DISPOSAL MODAL -->
<?php include 'disposal_modal.php' ?>

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
                        text: 'Disposed Asset edited successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = './disposal';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './editdisposal?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

</script>