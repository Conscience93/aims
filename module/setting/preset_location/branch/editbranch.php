<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_preset_computer_branch where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

?>

<style>
textarea {
  resize: none;
}

.card-body {
  max-height: 650px; /* Adjust the height as needed */
  overflow-y: scroll;
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
        <h4>Edit Building/Branch</h4>
        <form action=".\module\setting\preset_location\branch\editbranch_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Building/Branch ID: <?php echo $row['id']?></h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./preset_location" class="btn btn-danger">Back</a>
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
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="display_name">Building/Branch</label>
                            <input type="text" id="display_name" name="display_name"  value="<?php echo $row['display_name'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch_contact_no">Office Contact No.</label>
                            <input type="number" id="branch_contact_no" name="branch_contact_no"  value="<?php echo $row['branch_contact_no'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch_email">Office Email</label>
                            <input type="email" id="branch_email" name="branch_email"  value="<?php echo $row['branch_email'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="pic">Person In Charge</label>
                            <input type="text" id="pic" name="pic"  value="<?php echo $row['pic'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="contact_no">Contact No.</label>
                            <input type="number" id="contact_no" name="contact_no"  value="<?php echo $row['contact_no'];?>" class="form-control">
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
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                        text: 'Location edited successfully!',
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './preset_location?id=<?php echo $row["id"];?>';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './editbranch?id=<?php echo $row["id"];?>';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

</script>