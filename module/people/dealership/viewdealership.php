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
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
                <div class="col-6">
                    <h4>View Supplier Details</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./supplier" class="btn btn-danger">Cancel</a>
                        <a class="btn btn-primary" href='./module/people/supplier/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
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
                    <h4>Supplier Details</h4>
                </div>
            </div>
        </div>
        <div class = "row">
            <!-- location bought it from -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="display_name">Supplier</label>
                        <input type="text" id="display_name" name="display_name"  value="<?php echo $row['display_name'];?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="pic">Person in Charge</label>
                        <input type="text" id="pic" name="pic"  value="<?php echo $row['pic'];?>" class="form-control" readonly>
                    </div>
                </div>
                <!-- phone number -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="contact_no">Contact Number</label>
                        <input type="number" id="contact_no" name="contact_no" value="<?php echo $row['contact_no'];?>" class="form-control" readonly>
                    </div>
                </div>
                <!-- company email -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email'];?>" class="form-control" readonly>
                    </div>
                </div>
                <!-- company fax number -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="fax">Fax Number</label>
                        <input type="number" id="fax" name="fax" value="<?php echo $row['fax'];?>" class="form-control" readonly>
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
        </form>
    </div>
</div>