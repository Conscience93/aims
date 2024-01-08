<?php 
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_preset_location where id ='".$_GET['id']."'";
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
    <div class="tab-content" id="myTabContent">
        <!-- View Location -->
        <div class="tab-pane fade show active" id="location-current" role="tabpanel" aria-labelledby="tab-location-current">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h4>Location ID: <?php echo $row['id']?></h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <a href="./preset_location" class="btn btn-danger">Cancel</a>
                                <a class="btn btn-primary" href='./module/setting/preset/location/print.php?id=<?php echo $row['id'];?>' target="_blank" title="Print">Print</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="printableContent">
                    <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                    <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                    <div class="row">
                <!-- name -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="display_name">Location</label>
                        <input type="text" id="display_name" name="display_name" placeholder="Name" value="<?php echo $row['display_name'];?>" class="form-control" readonly>
                    </div>
                </div>
                <!-- person in charge -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="pic">Person In Charge</label>
                        <input type="text" id="pic" name="pic" placeholder="Person In Charge or Manager name" value="<?php echo $row['pic'];?>" class="form-control" readonly>
                    </div>
                </div>
                <!-- contact_number -->
                <div class="col-2">
                    <div class="form-group">
                        <label for="contact_number">Contact Number</label>
                        <input type="number" id="contact_number" name="contact_number" placeholder="Etc 01234567789" value="<?php echo $row['contact_number'];?>" class="form-control" readonly>
                    </div>
                </div>
            </div>
        </div>            
    </div>
</div>  
