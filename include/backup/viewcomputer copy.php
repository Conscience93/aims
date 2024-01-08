<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_computer where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// vendor
$sql3 = "SELECT * FROM aims_people_vendor where display_name ='".$row['vendor_name']."'";
$result3 = mysqli_query($con, $sql3);
$vendor = mysqli_fetch_assoc($result3);
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
        <div class="tab-pane fade show active" id="view-computer" role="tabpanel" aria-labelledby="tab-view-computer">
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
                            <div class="col-6">
                                <h4>Device Information</h4>
                                <?php
                                    if (!empty($row['picture'])) {
                                        $fileName = basename($row['picture']);
                                        echo '<img src="' . $row['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">'; // This line displays the picture
                                    } else {
                                        echo 'No picture available.';
                                    }
                                ?>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="remark">Remark</label>
                                    <input type="text" id="remark" name="remark" value="<?php echo $row['remark'];?>" class="form-control" readonly>
                                </div>
                            </div>
                        </div>

                        </br>
                    
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>Asset Information</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" value="<?php echo $row['name'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" id="department" name="department" value="<?php echo $row['department'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input type="text" id="location" name="location" value="<?php echo $row['location'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="price">Price (RM)</label>
                                <input type="number" id="price" name="price" value="<?php echo $row['price'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="start">Start Warranty</label>
                                <input type="text" id="start_warranty" name="start_warranty" value="<?php echo $row['start_warranty'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="end">End Warranty</label>
                                <input type="text" id="end_warranty" name="end_warranty" value="<?php echo $row['end_warranty'];?>" class="form-control" readonly>
                            </div>  
                        </div>
                    </div>

                    </br>

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
                        <div class="row">
                            <div class="col-6">
                                <h4>Hardware Specification</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="h_brand">Computer/PC Brand</label>
                                <input type ="text" id="h_brand" name="h_brand" value="<?php echo $row['h_brand'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="p_brand">Mobile Device Brand</label>
                                <input type ="text" id="p_brand" name="p_brand" value="<?php echo $row['p_brand'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="ram">Installed RAM</label>
                                <input type="text" id="ram" name="ram"  value="<?php echo $row['ram'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="hard_drive">Hard Drive</label>
                                <input type="text" id="hard_drive" value="<?php echo $row['hard_drive'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="storage">Storage</label>
                                <input type="text" id="storage" name="storage"  value="<?php echo $row['storage'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="processor">Processor</label>
                                <input type="text" id="processor" name="processor" value="<?php echo $row['processor'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="graphic_card">Graphic Card</label>
                                <input type="text" id="graphic_card" name="graphic_card"  value="<?php echo $row['graphic_card'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="casing">Casing</label>
                                <input type="text" id="casing" name="casing"  value="<?php echo $row['casing'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="psu">Power Supply Unit</label>
                                <input type="text" id="psu" name="psu" value="<?php echo $row['psu'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="motherboard">Motherboard</label>
                                <input type="text" id="motherboard" name="motherboard"  value="<?php echo $row['motherboard'];?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <br>
                    
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>Network</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="ip_address">IP Address</label>
                                <input type="text" id="ip_address" name="ip_address" value="<?php echo $row['ip_address'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="mac_address">MAC Address</label>
                                <input type="text" id="mac_address" name="mac_address" value="<?php echo $row['mac_address'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="vpn_address">VPN Address</label>
                                <input type="text" id="vpn_address" name="vpn_address" value="<?php echo $row['vpn_address'];?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    </br>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>Software Specification</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="s_category">Category</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="s_name">Software Name</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="s_brand">Brand</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="license_key">License Key</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="expiry_date">Expiry Date</label>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $sqlSoftware = "SELECT * FROM aims_software where asset_tag ='".$row['asset_tag']."'";
                    $resultSoftware = mysqli_query($con, $sqlSoftware);
                    while ($rowSoftware = mysqli_fetch_assoc($resultSoftware)) {
                    ?>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="s_category" name="s_category" value="<?php echo $rowSoftware['s_category'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" name="s_name" value="<?php echo $rowSoftware['s_name'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="s_brand" name="s_brand" value="<?php echo $rowSoftware['s_brand'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="license_key" name="license_key" value="<?php echo $rowSoftware['license_key'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="date" id="expiry_date" name="expiry_date" value="<?php echo $rowSoftware['expiry_date'];?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <?php } ?>

                    </br>

                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>User Account</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="username">Username</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="user">Current User</label>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="user">Role</label>
                            </div>
                        </div>
                    </div>
                    <?php 
                    $sqlUserAccount = "SELECT * FROM aims_user_account where asset_tag ='".$row['asset_tag']."'";
                    $resultUserAccount = mysqli_query($con, $sqlUserAccount);
                    while ($rowUserAccount = mysqli_fetch_assoc($resultUserAccount)) {
                    ?>
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="username" name="username" value="<?php echo $rowUserAccount['username'];?>" class="form-control" readonly>
                            </div>
                        </div> 
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="password" name="password" value="<?php echo $rowUserAccount['password'];?>" class="form-control" readonly>
                            </div>
                        </div> 
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="user" name="user" value="<?php echo $rowUserAccount['user'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <input type="text" id="user" name="user" value="<?php echo $rowUserAccount['role'];?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    
                    </br>
               
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
                                <label for="invoice"><b>Invoice: </b></label><br>
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
                                <label for="document"><b>Document: </b></label><br>
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
                        <div class="col-3">
                            <div class="form-group">
                                <label for="warranty"><b>Warranty: </b></label><br>
                                <?php
                                if (!empty($row['warranty'])) {
                                    $fileName = basename($row['warranty']);
                                    echo '<a href="' . $row['warranty'] . '" target="_blank">' . $fileName . '</a>';
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