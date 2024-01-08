<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_asset where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// vendor
$sql2 = "SELECT * FROM aims_people_vendor where display_name ='".$row['vendor_name']."'";
$result2 = mysqli_query($con, $sql2);
$vendor = mysqli_fetch_assoc($result2);
?>

<style>
textarea {
    resize: none;
}

span {
    height: 2.5rem;
}
</style>


<div class="main">
    <div class="tab-content" id="myTabContent">
        <!-- View Asset -->
        <div class="tab-pane fade show active" id="asset-current" role="tabpanel" aria-labelledby="tab-asset-current">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-10">
                            <h2 id="asset_tag" name="asset_tag"><?php echo $row['asset_tag'];?></h2>
                        </div>
                        <div class="col-2">
                            <a onclick="printModalContent()" class="btn btn-primary float-right" style="color: white; margin-left: 10px">Print</a>
                            <a href="./asset" class="btn btn-danger float-right">Back</a>
                        </div>
                    </div>
                </div>
                <div id="printableContent">
                    <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                    <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-4">
                                <h4>Data</h4>
                                <?php
                                    if (!empty($row['picture'])) {
                                        $fileName = basename($row['picture']);
                                        echo '<img src="' . $row['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">'; // This line displays the picture
                                    } else {
                                        echo 'No picture available.';
                                    }
                                ?>
                            </div>
                            <!-- particulars  -->
                            <div class="col-8"><br>
                                <label for="particular">Particular</label><br>
                                <textarea id="particular" name="particular" cols="65" rows="7" placeholder="" class="form-control" readonly><?php echo $row['particular'];?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- asset tag -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="asset tag">Asset Tag</label>
                                <input type="text" id="asset tag" name="asset tag" placeholder="" value="<?php echo $row['asset_tag'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- name -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" placeholder="" value="<?php echo $row['name'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- category -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" id="category" name="category" placeholder="" value="<?php echo $row['category'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- status  -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <input type="text" id="status" name="status" placeholder="" value="<?php echo $row['status'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- date purchase -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="date purchase">Date Purchase</label>
                                <input type="datetime-local" id="date purchase" name="date purchase" placeholder="" value="<?php echo $row['date_purchase'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- price -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="price">Price (RM)</label>
                                <input type="number" id="price" name="price" placeholder="" value="<?php echo $row['price'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- user  -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="user">User</label>
                                <input type="text" id="user" name="user" placeholder="" value="<?php echo $row['user'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- department  -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" id="department" name="department" placeholder="" value="<?php echo $row['department'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- contact number  -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="contact number">Contact Number</label>
                                <input type="number" id="contact number" name="contact number" placeholder="" value="<?php echo $row['contact_number'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- location  -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" placeholder="" value="<?php echo $row['location'];?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <br>
                    <!-- vendor -->
                    <div class ="mb-3">
                        <div class = "row">
                            <div class="col-6">
                                <h4>Vendor Details</h4>
                            </div>
                        </div>
                    </div>
                    <!-- vendor name -->
                    <div class = "row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vendor_name">Name</label>
                                <span id="vendor_name" name="vendor_name" placeholder="" class="form-control"><?php if($vendor) {echo $vendor['display_name']; }?></span>
                            </div>
                        </div>
                        <!-- vendor pic -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vendor_pic">Contact Person</label>
                                <span id="vendor_pic" name="vendor_pic" placeholder="" class="form-control"><?php if($vendor) {echo $vendor['pic']; }?></span>
                            </div>
                        </div>
                        <!-- vendor phone number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vendor_contact_no">Contact Number</label>
                                <span id="vendor_contact_no" name="vendor_contact_no" placeholder="" class="form-control"><?php if($vendor) { echo $vendor['contact_no']; }?></span>
                            </div>
                        </div>
                        <!-- vendor email -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vendor_email">Email</label>
                                <span id="vendor_email" name="vendor_email" placeholder="" class="form-control"><?php if($vendor) {echo $vendor['email']; }?></span>
                            </div>
                        </div>
                        <!-- vendor fax number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vendor_fax">Fax Number</label>
                                <span id="vendor_fax" name="vendor_fax" placeholder="" class="form-control"><?php if($vendor) {echo $vendor['fax']; }?></span>
                            </div>
                        </div>
                        <!-- vendor location -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vendor_address">Address</label>
                                <span id="vendor_address" name="vendor_address" placeholder="" class="form-control"><?php if($vendor) {echo $vendor['address']; }?></span>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="mb-3">
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <h4>Files</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <label for="invoice"><b>Invoice</b></label><br>
                                <?php
                                if (!empty($row['invoice'])) {
                                    $fileName = basename($row['invoice']);
                                    echo '<a href="' . $row['invoice'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="document"><b>Document</b></label><br>
                                <?php
                                if (!empty($row['document'])) {
                                    $fileName = basename($row['document']);
                                    echo '<a href="' . $row['document'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </div>
                        </div>
                        <!-- Add this code inside the div with class="col-3" where you want to display the picture -->
                        <div class="col-3">
                            <div class="form-group">
                                <label for="picture"><b>Picture</b></label><br>
                                <?php
                                if (!empty($row['picture'])) {
                                    $fileName = basename($row['picture']);
                                    echo '<a href="' . $row['picture'] . '" target="_blank">' . $fileName . '</a>';
                                } else {
                                    echo 'No file is uploaded.';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>          
            </div>
        </div>            
    </div>
</div>  

<script>
function printModalContent() {
    var printContents = document.getElementById("printableContent").innerHTML;
    var originalContents = document.body.innerHTML;
    var printWindow = window.open('', '', 'width=1200,height=600');
    printWindow.document.open();
    printWindow.document.write('<html><head><title>Print</title></head><body>');
    printWindow.document.write('<hr>');
    printWindow.document.write(printContents);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
    printWindow.close();
}
</script>