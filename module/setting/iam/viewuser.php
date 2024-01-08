<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_user where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
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
                        <h4>User Staff Profile</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a class="btn btn-primary" href='./module/setting/iam/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                            <a href="./iam" class="btn btn-danger" style="margin-left: 5px;">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-7">
                            <h4>Staff Details</h4>
                        </div>
                        <div class="col-5">
                            <h4>Staff Profile Pic</h4>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-7">
                            <div class="row">
                                <label class="col-4" for="username"><b>Username: </b></label>
                                <span class="col-4" id="username" name="username" ><?php echo $row['username'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="date_created"><b>Date Created: </b></label>
                                <span class="col-4" id="date_created" name="date_created" ><?php echo $row['date_created'];?></span>
                            </div>
                            <div class="row mb-3">
                                <label class="col-4" for="date_modified"><b>Date Modified: </b></label>
                                <span class="col-4" id="date_modified" name="date_modified" ><?php echo $row['date_modified'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="full_name"><b>Employee Name: </b></label>
                                <span class="col-4" id="full_name" name="full_name" ><?php echo $row['full_name'];?></span>
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
                                <label class="col-4" for="company_name"><b>Company: </b></label>
                                <span class="col-4" id="company_name" name="company_name" ><?php echo $row['company_name'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="department"><b>Department: </b></label>
                                <span class="col-4" id="department" name="department" ><?php echo $row['department'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="position"><b>Position: </b></label>
                                <span class="col-4" id="position" name="position" ><?php echo $row['position'];?></span>
                            </div>
                            <div class="row">
                                <label class="col-4" for="address"><b>Address: </b></label>
                                <span class="col-4" id="address" name="address" ><?php echo $row['address'];?></span>
                            </div>
                        </div>
                        <div class="col-5">
                            </br><?php
                                if (!empty($row['profile_picture'])) {
                                    $fileName = basename($row['profile_picture']);
                                    echo '<img src="' . $row['profile_picture'] . '" alt="Staff Profile Pic" style="max-width: 100%; max-height: 300px;">'; // This line displays the picture
                                } else {
                                    echo 'No picture available.';
                                }
                            ?>
                        </div>
                    </div>            
                </div>
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>User Permission</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <label class="col-2" for="user_group_id"><b>User Group: </b></label>
                    <?php 
                        $sql_usergroup = "SELECT * FROM aims_user_group where id ='".$row['user_group_id']."'";
                        $result_usergroup = mysqli_query($con, $sql_usergroup);
                        $row_usergroup = mysqli_fetch_assoc($result_usergroup);
                    ?>
                    <span class="col-4" id="user_group_id" name="user_group_id" ><?php echo $row_usergroup['user_group_name'];?></span>
                </div>

            </div>
        </form>
    </div>
</div>