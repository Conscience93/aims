<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

// Query for the maintenance
$sql = "SELECT * FROM aims_maintenance WHERE id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Query for the picture based on asset tag from another table (assuming the table is aims_asset)
$assetTag = mysqli_real_escape_string($con, $row['asset_tag']);
$sql2 = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag ='$assetTag'";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);

// Vendor
$sql3 = "SELECT * FROM aims_people_supplier where display_name ='".$row['vendors']."'";
$result3 = mysqli_query($con, $sql3);
$vendors = mysqli_fetch_assoc($result3);
?>

<style>
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
                    <h4>View Maintenance</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./maintenance" class="btn btn-danger">Back</a>
                        <a class="btn btn-primary" href='./module/maintenance/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
            <div class="mb-3">
                <h4>Data</h4>
                <div class="row">
                    <div class="col-3">
                        <?php
                            if (!empty($row2['picture'])) {
                                $fileName = basename($row2['picture']);
                                echo '<img src="' . $row2['picture'] . '" alt="Picture" style="max-width: 100%; max-height: 300px;">'; // Display the picture from another table
                            } else {
                                echo 'No picture available.';
                            }
                        ?>
                    </div>
                    <div class="col-9">
                        <div class="row">
                            <label class="col-3" for="name"><b>Name: </b></label>
                            <span class="col-3" id="name" name="name" ><?php echo $row['name'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="category"><b>Category: </b></label>
                            <span class="col-3" id="category" name="category"><?php echo $row['category'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="type"><b>Type: </b></label>
                            <span class="col-3" id="type" name="type"><?php echo $row['type'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="asset_tag"><b>Asset Tag: </b></label>
                            <span class="col-3" id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="maintenance_date"><b>Maintenance Date: </b></label>
                            <span class="col-3" id="maintenance_date" name="maintenance_date"><?php echo $row['maintenance_date'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="expenses"><b>Expenses: </b></label>
                            <span class="col-3" id="expenses" name="expenses"><?php echo $row['expenses'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="title"><b>Title: </b></label>
                            <span class="col-3" id="title" name="title"><?php echo $row['title'];?></span>
                        </div>
                        <div class="row">
                            <label class="col-3" for="remark"><b>Remark: </b></label>
                            <span class="col-3" id="remark" name="remark"><?php echo $row['remark'];?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
        </div>

        <div class="mb-3">
            <hr>
            <div class="row">
                <div class="col-6">
                    <h4>Vendor</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="row">
                    <label class="col-3" for="vendors"><b>Name: </b></label>
                    <span class="col-3" id="vendors" name="vendors" placeholder=""><?php if($vendors) {echo $vendors['display_name']; }?></span>
                </div>
                <div class="row">
                    <label class="col-3" for="pic"><b>Contact Person: </b></label>
                    <span class="col-3" id="pic" name="pic" placeholder=""><?php if($vendors) {echo $vendors['pic']; }?></span>
                </div>
                <div class="row">
                    <label class="col-3" for="contact_no"><b>Contact Number: </b></label>
                    <span class="col-3" id="contact_no" name="contact_no" placeholder=""><?php if($vendors) { echo $vendors['contact_no']; }?></span>
                </div>
                <div class="row">
                    <label class="col-3" for="email"><b>Email: </b></label>
                    <span class="col-3" id="email" name="email" placeholder=""><?php if($vendors) {echo $vendors['email']; }?></span>
                </div>
                <div class="row">
                    <label class="col-3" for="fax"><b>Fax Number: </b></label>
                    <span class="col-3" id="fax" name="fax" placeholder=""><?php if($vendors) {echo $vendors['fax']; }?></span>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <hr>
            <div class="row">
                <div class="col-6">
                    <h4>Files</h4>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="maintenance"><b>Invoice</b></label><br>
                    <?php
                    if (!empty($row['maintenance'])) {
                        $fileName = basename($row['maintenance']);
                        echo '<a href="' . $row['maintenance'] . '" target="_blank">' . $fileName . '</a>';
                    } else {
                        echo 'No file is uploaded.';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>