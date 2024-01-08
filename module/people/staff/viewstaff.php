<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_people_staff where id ='".$_GET['id']."'";
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
                        <h4>Staff Profile</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./staff" class="btn btn-danger">Cancel</a>
                            <a class="btn btn-primary" href='./module/people/staff/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Staff Details</h4>
                        </div>
                        <div class="col-6">
                            <h4 style = "margin-left:14px;">Staff Profile Pic</h4>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="row">
                                <label class="col-4" for="display_name"><b>Employee Name: </b></label>
                                <span class="col-4" id="display_name" name="display_name" ><?php echo $row['display_name'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="email"><b>Email Address: </b></label>
                                <span class="col-4" id="email" name="email" ><?php echo $row['email'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="contact_no"><b>Contact Number: </b></label>
                                <span class="col-4" id="contact_no" name="contact_no Number" ><?php echo $row['contact_no'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="nric"><b>NRIC: </b></label>
                                <span class="col-4" id="nric" name="nric" ><?php echo $row['nric'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="branch"><b>Company: </b></label>
                                <span class="col-4" id="branch" name="branch" ><?php echo $row['branch'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="department"><b>Department: </b></label>
                                <span class="col-4" id="department" name="department" ><?php echo $row['department'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="address"><b>Address: </b></label>
                                <span class="col-4" id="address" name="address" ><?php echo $row['address'];?></span>
                            </div>
                        </div>
                        <div class="col-6">
                            <!-- Modified column width to col-6 -->
                            <div class="col-6">
                                <?php
                                if (!empty($row['profile'])) {
                                    $fileName = basename($row['profile']);
                                    echo '<img src="' . $row['profile'] . '" alt="Staff Profile Pic" style="max-width: 150%; max-height: 300px;">';
                                } else {
                                    echo 'No picture available.';
                                }
                                ?>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </form>
    </div>
</div>