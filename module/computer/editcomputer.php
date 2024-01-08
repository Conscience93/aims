<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_computer where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

?>

<style>
    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .row .float-right button {
        margin-left: 5px; /* Adjust the margin as needed */
    }

    .card-body {
    max-height: 750px; /* Adjust the height as needed */
    overflow-y: scroll;
    }

    form .btn-delete-file {
        width: 75px !important;
    }

    .main span {
        height: 2.3rem;
    }

    .modal-backdrop {
        display: none;
    }

    .dropdown {
        display: inline-block;
        position: relative;
    }

    #myDropdown {
        display: none;
        position: absolute;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        max-height: 200px;
        width: 250%;
        overflow-y: auto;
        z-index: 1;
    }

    #myDropdown p {
        padding: 8px;
        margin: 0;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #myDropdown p:hover {
        background-color: #f1f1f1;
    }

    /* Optional: Style for the label */
    label {
        display: block;
        margin-bottom: 8px;
    }

    .form-group {
    margin-bottom: 15px; /* Add some space below the form group */
    }

    .radio-buttons {
        display: flex;
    }

    .radio-option {
        margin-right: 20px; /* Adjust the margin as needed */
    }

    /* Optional: Add some styling for the selected radio option */
    .radio-option input[type="radio"]:checked + label {
        font-weight: bold;
        color: #007bff; /* Change the color as needed */
    }

    .input-container {
        position: relative;
        width: 100%;
    }

    .clear-button {
        left: 390%;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 250%;
        padding-right: 20px; /* Space for the 'x' button */
    }
</style>

<div class="main">
    <form action=".\module\computer\editcomputer_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./asset" class="btn btn-danger">Discard</a>
                        <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Save</button> 
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
                            <h4>Asset Information</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?php echo $row['name'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input list="assetCategoryList" name="category" value="<?php echo $row['category'];?>" id="category" class="form-control" onchange="toggleBrands()">
                                <datalist id="assetCategoryList">
                                    <?php 
                                    $sql_categories = "SELECT * FROM aims_computer_category_run_no";
                                    $result_categories = mysqli_query($con, $sql_categories);
                                    while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                        $categories[] = $row_categories;
                                    }
                                    if ($categories == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else 
                                        foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['display_name']; ?>" <?php if($row['category'] == $category['display_name']) {echo 'selected';} ?>><?php echo $category['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Category" data-action="addNewCategory">Add New Category</option>
                                </datalist>
                            </select>
                        </div>
                    </div>
                    <!-- server name -->
                    <div class="col-2" id="serverNameField" style="display: none;">
                        <div class="form-group">
                            <label for="server_name">Server</label>
                            <input list ="serverNameList" name="server_name" value="<?php echo $row['server_name'];?>" id="server_name" class="form-control">
                                <datalist id="serverNameList"> 
                                    <option value="">Select Server</option>
                                    <?php  
                                    $sql_servernames = "SELECT name FROM aims_computer WHERE category = 'Server'";
                                    $result_servernames = mysqli_query($con, $sql_servernames);
                                    while ($row_servernames = mysqli_fetch_assoc($result_servernames)) {
                                        $servernames[] = $row_servernames;
                                    }
                                    if ($servernames == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else {
                                        foreach ($servernames as $servername): ?>
                                            <option value="<?php echo $servername['name']; ?>" <?php if($row['server_name'] == $servername['name']) {echo 'selected';} ?>><?php echo $servername['name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                 <datalist id="serverNameList">
                            </select>
                        </div>
                    </div>
                    <!-- branch -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list="branchList" name="branch" value="<?php echo $row['branch'];?>" id="branch" class="form-control">
                                <datalist id="branchList">    
                                    <option value="">Select Building/Branch</option>
                                    <?php  
                                    $sql_branchs = "SELECT * FROM aims_preset_computer_branch";
                                    $result_branchs = mysqli_query($con, $sql_branchs);
                                    while ($row_branchs = mysqli_fetch_assoc($result_branchs)) {
                                        $branchs[] = $row_branchs;
                                    }
                                    if ($branchs == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else {
                                        foreach ($branchs as $branch): ?>
                                            <option value="<?php echo $branch['display_name']; ?>" <?php if($row['branch'] == $branch['display_name']) {echo 'selected';} ?>><?php echo $branch['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list="departmentList" name="department"  value="<?php echo $row['department'];?>" id="department" class="form-control">
                                <datalist id="departmentList">          
                                    <option value="">Select Department</option>
                                        <?php 
                                        $sql_departments = "SELECT * FROM aims_preset_department";
                                        $result_departments = mysqli_query($con, $sql_departments);
                                        while ($row_departments = mysqli_fetch_assoc($result_departments)) {
                                            $departments[] = $row_departments;
                                        }
                                        if ($departments == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php } else {
                                            foreach ($departments as $department): ?>
                                                <option value="<?php echo $department['display_name']; ?>" <?php if($row['department'] == $department['display_name']) {echo 'selected';} ?>><?php echo $department['display_name']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                        <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                                <datalist id="departmentList">  
                            </select>
                        </div>
                    </div>
                    <!-- location -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input list="locationList" name="location" value="<?php echo $row['location'];?>" id="location" class="form-control">
                                <datalist id="locationList">                      
                                    <option value="">Select Location</option>
                                    <?php 
                                    $sql_locations = "SELECT * FROM aims_preset_location";
                                    $result_locations = mysqli_query($con, $sql_locations);
                                    while ($row_locations = mysqli_fetch_assoc($result_locations)) {
                                        $locations[] = $row_locations;
                                    }
                                    if ($locations == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php } else {
                                        foreach ($locations as $location): ?>
                                            <option value="<?php echo $location['display_name']; ?>" <?php if($row['location'] == $location['display_name']) {echo 'selected';} ?>><?php echo $location['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                    <option value="Add New Location" data-action="addNewLocation">Add New Location</option>
                                <datalist id="locationList">
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" value="<?php echo $row['price'];?>" class="form-control"  step="any"> 
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="value">Value (RM)</label>
                            <input type="number" id="value" name="value" placeholder="To Be Determined" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="date_purchase">Date Purchase</label>
                            <input type="date" id="date_purchase" name="date_purchase" value="<?php echo $row['date_purchase'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="start">Start Warranty</label>
                            <input type="date" id="start_warranty" name="start_warranty" value="<?php echo $row['start_warranty'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="end">End Warranty</label>
                            <input type="date" id="end_warranty" name="end_warranty" value="<?php echo $row['end_warranty'];?>" class="form-control">
                        </div>  
                    </div>
                </div>
                <div class = "row">
                    <div class="col-10">
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <input type="text" id="remark" name="remark" value="<?php echo $row['remark'];?>" class="form-control">
                        </div>
                    </div>
                </div>

                <br><hr>

                <!-- supplier -->
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Supplier Details</h4>
                        </div>
                    </div>
                </div>
                <!-- supplier -->
                <div class = "row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier">Name</label>
                            <input list="supplierList" name="supplier" value="<?php echo $row['supplier'];?>" id="supplier" class="form-control" autofocus oninput= "getSupplierDetails(this.value)">
                                <datalist id="supplierList">                      
                                    <?php 
                                    $sql_suppliers = "SELECT * FROM aims_people_supplier";
                                    $result_suppliers = mysqli_query($con, $sql_suppliers);
                                    while ($row_suppliers = mysqli_fetch_assoc($result_suppliers)) {
                                        $suppliers[] = $row_suppliers;
                                    } if ($suppliers == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier['display_name']; ?>" <?php if($row['supplier'] == $supplier['display_name']) {echo 'selected';} ?>><?php echo $supplier['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Supplier" data-action="addNewSupplier">Add New Supplier</option>
                                <datalist id="supplierList">
                            </select>
                        </div>
                    </div>
                    <!-- supplier pic -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier_pic">Contact Person</label>
                            <span id="supplier_pic" name="supplier_pic" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- supplier phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier_contact_no">Contact Number</label>
                            <span id="supplier_contact_no" name="supplier_contact_no" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- supplier email -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="supplier_email">Email</label>
                            <span id="supplier_email" name="supplier_email" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- supplier fax number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier_fax">Fax Number</label>
                            <span id="supplier_fax" name="supplier_fax" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- supplier location -->
                    <div class="col-10">
                        <div class="form-group">
                            <label for="supplier_address">Address</label>
                            <span id="supplier_address" name="supplier_address" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                </div>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Hardware Specification</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2" id= "computer_brand_div">
                        <div class="form-group">
                            <label for="computer_brand">Computer Brand</label>
                            <input list="computerBrandList" name="computer_brand" value="<?php echo $row['computer_brand'];?>" id="computer_brand" class="form-control">
                                <datalist id="computerBrandList">      
                                    <?php 
                                    $sqlcomputer_brands = "SELECT * FROM aims_preset_devices_computer_brand";
                                    $resultcomputer_brands = mysqli_query($con, $sqlcomputer_brands);
                                    while ($rowcomputer_brands = mysqli_fetch_assoc($resultcomputer_brands)) {
                                        $computer_brands[] = $rowcomputer_brands;
                                    } if ($computer_brands == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                        foreach ($computer_brands as $computer_brand): ?>
                                        <option value="<?php echo $computer_brand['display_name']; ?>" <?php if($row['computer_brand'] == $computer_brand['display_name']){ echo 'selected';}?>><?php echo $computer_brand['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Brand" data-action="addNewBrand">Add New Brand</option>
                                <datalist id="computerBrandList">      
                            </select>
                        </div>
                    </div>
                    <div class="col-2" id="phone_brand_div" style="display: none;">
                        <div class="form-group">
                            <label for="phone_brand">Mobile Devices Brand</label>
                            <input list="phoneBrandList" name="phone_brand"  value="<?php echo $row['phone_brand'];?>" id="phone_brand" class="form-control">
                                <datalist id="phoneBrandList">     
                                    <?php 
                                    $sqlphone_brands = "SELECT * FROM aims_preset_devices_phone_brand";
                                    $resultphone_brands = mysqli_query($con, $sqlphone_brands);
                                    while ($rowphone_brands = mysqli_fetch_assoc($resultphone_brands)) {
                                        $phone_brands[] = $rowphone_brands;
                                    } if ($phone_brands == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                        foreach ($phone_brands as $phone_brand): ?>
                                        <option value="<?php echo $phone_brand['name']; ?>" <?php if($row['phone_brand'] == $phone_brand['name']){ echo 'selected';}?>><?php echo $phone_brand['name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Brand" data-action="addNewBrand">Add New Brand</option>
                                <datalist id="phoneBrandList">  
                            </select>
                        </div>
                    </div>
                    <div class="col-2" id="virtual_machine_div" style="display: none;">
                        <div class="form-group">
                            <label for="virtual_machine">Virtual Machine Brand</label>
                            <input list="virtualMachineList" name="virtual_machine"  value="<?php echo $row['virtual_machine'];?>" id="virtual_machine" class="form-control">
                                <datalist id="virtualMachineList">     
                                    <?php 
                                    $sqlvirtual_machines = "SELECT * FROM aims_preset_virtual_machine";
                                    $resultvirtual_machines = mysqli_query($con, $sqlvirtual_machines);
                                    while ($rowvirtual_machines = mysqli_fetch_assoc($resultvirtual_machines)) {
                                        $virtual_machines[] = $rowvirtual_machines;
                                    } if ($virtual_machines == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                        foreach ($virtual_machines as $virtual_machine): ?>
                                        <option value="<?php echo $virtual_machine['name']; ?>" <?php if($row['virtual_machine'] == $virtual_machine['name']){ echo 'selected';}?>><?php echo $virtual_machine['name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Brand" data-action="addNewBrand">Add New Brand</option>
                                <datalist id="virtualMachineList">  
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="ram">Installed RAM</label>
                            <input type="text" id="ram" name="ram"  value="<?php echo $row['ram'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="processor">Processor</label>
                            <input type="text" id="processor" name="processor" value="<?php echo $row['processor'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="graphic_card">Graphic Card</label>
                            <input type="text" id="graphic_card" name="graphic_card"  value="<?php echo $row['graphic_card'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="casing">Casing</label>
                            <input type="text" id="casing" name="casing"  value="<?php echo $row['casing'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="psu">Power Supply Unit</label>
                            <input type="text" id="psu" name="psu" value="<?php echo $row['psu'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="motherboard">Motherboard</label>
                            <input type="text" id="motherboard" name="motherboard"  value="<?php echo $row['motherboard'];?>" class="form-control">
                        </div>
                    </div>
                </div>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Network</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                <?php 
                    $sql_network = "SELECT * FROM aims_computer_network";
                    $result_network = mysqli_query($con, $sql_network);
                    while ($row_network = mysqli_fetch_assoc($result_network)) {
                        $networks[] = $row_network;
                    }

                    $sql_network = "SELECT * FROM aims_computer_network where asset_tag ='".$row['asset_tag']."'";
                    $result_network = mysqli_query($con, $sql_network);
                    $j = 0;
                    while ($row_network = mysqli_fetch_assoc($result_network)) {
                    ?>
                    <input type="text" id="network_id[]" name="network_id[]" value="<?php echo $row_network['id'];?>" hidden>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="ip_type[]">IP Type</label>
                            <select name="ip_type[]" id="ip_type[]" value="<?php echo $row_network['ip_type'];?>" class="form-control">
                                <option value="Static"<?php if($row_network['ip_type'] == 'Static') {echo 'selected';}?>>Static</option>
                                <option value="Dynamic"<?php if($row_network['ip_type'] == 'Dynamic') {echo 'selected';}?>>Dynamic</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="ip_address[]">IP Address</label>
                            <input type="text" id="ip_address[]" name="ip_address[]"  value="<?php echo $row_network['ip_address'];?>" class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="mac_address[]">MAC Address</label>
                            <input type="text" id="mac_address[]" name="mac_address[]" value="<?php echo $row_network['mac_address'];?>"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="port[]">Active Port</label>
                            <input type="text" id="port[]" name="port[]"  value="<?php echo $row_network['port'];?>" class="form-control">
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Remote Access</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button class="btn btn-info" type="button" onclick="createRemoteAccess()">Add More Remote Access</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name of Software</th>
                            <th>Remote Address</th>
                            <th>Remote Password</th>
                            <th>Remote Port</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="existing-remote_access-table">
                        <?php 
                        $sql_remote_accesss = "SELECT * FROM aims_preset_remote_access";
                        $result_remote_accesss = mysqli_query($con, $sql_remote_accesss);
                        $remote_accesss=[];
                        while ($row_remote_accesss = mysqli_fetch_assoc($result_remote_accesss)) {
                            $remote_accesss[] = $row_remote_accesss;
                        }

                        $sql_remote_accesss = "SELECT * FROM aims_computer_remote_access where asset_tag ='".$row['asset_tag']."'";
                        $result_remote_accesss = mysqli_query($con, $sql_remote_accesss);
                        $i = 0;
                        while ($row_remote_accesss = mysqli_fetch_assoc($result_remote_accesss)) {
                        ?>
                        <tr>
                            <input type="text" id="remote_id[]" name="remote_id[]" value="<?php echo $row_remote_accesss['id'];?>" hidden>
                            <td>
                                <input list="remoteAccessList" name="remote_name[]"  value="<?php echo $row_remote_accesss['remote_name'];?>" id="remote_name[]" class="form-control">
                                    <datalist id="remoteAccessList">    
                                        <option value="">Select Type</option>
                                        <?php 
                                        if ($remote_accesss == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php } else
                                        foreach ($remote_accesss as $remote_access): ?>
                                            <option value="<?php echo $remote_access['display_name']; ?>" <?php if($row_remote_accesss['remote_name'] == $remote_access['display_name']){ echo 'selected';}?>><?php echo $remote_access['display_name']; ?></option>
                                        <?php endforeach; ?>
                                    <datalist id="remoteAccessList">
                                </select>
                            </td>
                            <td><input type="text" name="remote_address[]" value="<?php echo $row_remote_accesss['remote_address'];?>" class="form-control"></td>
                            <td><input type="text" name="remote_password[]" value="<?php echo $row_remote_accesss['remote_password'];?>" class="form-control"></td>
                            <td><input type="text" name="remote_port[]" value="<?php echo $row_remote_accesss['remote_port'];?>" class="form-control"></td>
                            <td>
                                <?php if($i++ == 0) {continue; } else { ?> <!-- Skip first row so it don't have delete button -->
                                <button class="btn btn-danger btn-delete-file" type="button" onclick="
                                confirmDeleteExistingRemoteAccess(
                                    this,
                                    '<?php echo $row_remote_accesss['id'];?>',
                                    '<?php echo $row_remote_accesss['remote_name'];?>',
                                    '<?php echo $row['id'];?>'
                                    )">Delete</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="remote_access-table">
                    </tbody>
                </table>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Hard Drive Specification</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button class="btn btn-info" type="button" onclick="createHardDrive()">Add More Hard Drive</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table id="hard_drive-table" class="table">
                    <thead>
                        <tr>
                            <th>Hard Disk Name</th>
                            <th>Hard Drive Type</th>
                            <th>Brand</th>
                            <th>Storage</th>
                            <th>Purpose</th>
                            <th>End Warranty</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="existing-hard_drive-table">
                    <?php 
                        $sql_hard_drive = "SELECT * FROM aims_computer_hard_drive";
                        $result_hard_drive = mysqli_query($con, $sql_hard_drive);
                        while ($row_hard_drive = mysqli_fetch_assoc($result_hard_drive)) {
                            $hard_drives[] = $row_hard_drive;
                        }

                        $sql_hard_drive = "SELECT * FROM aims_computer_hard_drive where asset_tag ='".$row['asset_tag']."'";
                        $result_hard_drive = mysqli_query($con, $sql_hard_drive);
                        $j = 0;
                        while ($row_hard_drive = mysqli_fetch_assoc($result_hard_drive)) {
                        ?>
                        <tr>
                            <input type="text" id="hard_drive_id[]" name="hard_drive_id[]" value="<?php echo $row_hard_drive['id'];?>" hidden>
                            <td>
                                <input type="text" id="hard_disk_name[]" name="hard_disk_name[]" value="<?php echo $row_hard_drive['hard_disk_name'];?>" class="form-control" >
                            </td>
                            <td> 
                                <select name="hard_drive[]" id="hard_drive[]" class="form-control">
                                    <option value="SSD"<?php if($row_hard_drive['hard_drive'] == 'SSD') {echo 'selected';}?>>SSD</option>
                                    <option value="HDD"<?php if($row_hard_drive['hard_drive'] == 'HDD') {echo 'selected';}?>>HDD</option>
                                    <option value="PCI"<?php if($row_hard_drive['hard_drive'] == 'PCI') {echo 'selected';}?>>PCI</option>
                                </select>
                            </td>
                            <td>
                                <input type="text" id="brand[]" name="brand[]" value="<?php echo $row_hard_drive['brand'];?>" class="form-control" >
                            </td>
                            <td>
                                <input type="text" id="storage[]" name="storage[]" value="<?php echo $row_hard_drive['storage'];?>" class="form-control" >
                            </td>
                            <td>
                                <input type="text" id="purpose[]" name="purpose[]" value="<?php echo $row_hard_drive['purpose'];?>" class="form-control" >
                            </td>
                            <td>
                                <input type="date" id="end_warranty_disk[]" name="end_warranty_disk[]" value="<?php echo $row_hard_drive['end_warranty_disk'];?>" class="form-control">
                            </td>
                                <td>
                                 <?php if($j++ == 0) {continue; } else { ?> <!--Skip first row so it don't have delete button -->
                                <button class="btn btn-danger btn-delete-file" type="button" onclick="
                                confirmDeleteExistingHardDrive(
                                    this,
                                    '<?php echo $row_hard_drive['id'];?>',
                                    '<?php echo $row_hard_drive['hard_drive'];?>',
                                    '<?php echo $row['id'];?>'
                                    )">Delete</button></td>
                                <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="hard_drive-table">
                        
                    </tbody>
                </table>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Software Specification</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button class="btn btn-info" type="button" onclick="createSoftware()">Add More Software</button>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Software Name</th>
                            <th>License Key</th>
                            <th>Expiry Date</th>
                            <!-- <th>Invoice</th> -->
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="existing-software-table">
                        <?php 
                        $sql_software_categories = "SELECT * FROM aims_software_category";
                        $result_software_categories = mysqli_query($con, $sql_software_categories);
                        $software_categories=[];
                        while ($row_software = mysqli_fetch_assoc($result_software_categories)) {
                            $software_categories[] = $row_software;
                        }

                        $sql_software = "SELECT * FROM aims_software where asset_tag ='".$row['asset_tag']."'";
                        $result_software = mysqli_query($con, $sql_software);
                        $i = 0;
                        while ($row_software = mysqli_fetch_assoc($result_software)) {
                        ?>
                        <tr>
                            <input type="text" id="software_id[]" name="software_id[]" value="<?php echo $row_software['id'];?>" hidden>
                            <td>
                                <input list="softwareList" name="software_category[]"  value="<?php echo $row_software['software_category'];?>" id="software_category[]" class="form-control">
                                    <datalist id="softwareList">    
                                        <option value="">Select Category</option>
                                        <?php 
                                        if ($software_categories == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php } else
                                        foreach ($software_categories as $software_category): ?>
                                            <option value="<?php echo $software_category['display_name']; ?>" <?php if($row_software['software_category'] == $software_category['display_name']){ echo 'selected';}?>><?php echo $software_category['display_name']; ?></option>
                                        <?php endforeach; ?>
                                    <datalist id="softwareList">
                                </select>
                            </td>
                            <td><input type="text" name="software_brand[]" value="<?php echo $row_software['brand'];?>" class="form-control"></td>
                            <td><input type="text" name="software_name[]" value="<?php echo $row_software['software_name'];?>" class="form-control"></td>
                            <td><input type="text" name="license_key[]" value="<?php echo $row_software['license_key'];?>" class="form-control"></td>
                            <td><input type="date" name="expiry_date[]" value="<?php echo $row_software['expiry_date'];?>" class="form-control"></td>
                            <!-- <td>
                                <?php
                                $billFile = $row['bill']; // Assign $row['bill'] to a new variable

                                // Check if $billFile is a valid string
                                if (is_string($billFile) && !empty($billFile)) {
                                    $fileName = basename($billFile); // Use basename on $billFile
                                    echo '<div class="md-3 form-control"><a href="' . $billFile . '" target="_blank">' . $fileName . '</a></div>';
                                    echo '<br>';
                                    echo '<form id="delete-bill-form" action="./module/computer/deletefile_action.php" method="POST">
                                            <input type="hidden" name="fileType" value="bill">
                                            <input type="hidden" name="software_id" value="'.$row['id'].'">
                                            <button class="btn btn-danger btn-delete-file" type="button" form="delete-bill-form" onclick="confirmDeleteFile('.$row['id'].',\'bill\')">Delete</button>
                                        </form>';
                                } else {
                                    echo '<input type="file" id="bill" name="bill[]" accept="" class="form-control" multiple />';
                                }
                                ?>
                            </td> -->
                            <td>
                                <?php if($i++ == 0) {continue; } else { ?> <!-- Skip first row so it don't have delete button -->
                                <button class="btn btn-danger btn-delete-file" type="button" onclick="
                                confirmDeleteExistingSoftware(
                                    this,
                                    '<?php echo $row_software['id'];?>',
                                    '<?php echo $row_software['software_name'];?>',
                                    '<?php echo $row['id'];?>'
                                    )">Delete</button>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="software-table">
                        
                    </tbody>
                </table>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>User Account</h4>
                        </div>
                        <div class="col-6">
                        <div class="float-right">
                            <button class="btn btn-info" type="button" onclick="createUser()">Add User</button>
                        </div>
                        </div>
                    </div>
                </div>
                
                <table id="user-table" class="table">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Password</th>
                            <th>User</th>
                            <th>Role</th>
                            <th style="width: 120px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="existing-user-table">
                    <?php 
                        $sql_users = "SELECT * FROM aims_people_staff";
                        $result_users = mysqli_query($con, $sql_users);
                        $users=[];
                        while ($row_users = mysqli_fetch_assoc($result_users)) {
                            $users[] = $row_users;
                        }

                        $sql_computer_user = "SELECT * FROM aims_computer_user where asset_tag ='".$row['asset_tag']."'";
                        $result_computer_user = mysqli_query($con, $sql_computer_user);
                        $j = 0;
                        while ($row_computer_user = mysqli_fetch_assoc($result_computer_user)) {
                        ?>
                        <tr>
                            <input type="text" id="user_id[]" name="user_id[]" value="<?php echo $row_computer_user['id'];?>" hidden>
                            <td><input type="text" name="username[]" value="<?php echo $row_computer_user['username'];?>" class="form-control"></td>
                            <td><input type="text" name="password[]" value="<?php echo $row_computer_user['password'];?>" class="form-control"></td>
                            <td>
                                <input list="userList" name="user[]" value="<?php echo $row_computer_user['user'];?>" id="user[]" class="form-control">
                                <datalist id="userList">
                                    <option value="NO USER" selected disabled>Select User</option>
                                    <?php 
                                    $sql_users = "SELECT * FROM aims_people_staff";
                                    $result_users = mysqli_query($con, $sql_users);
                                    $users=[];
                                    while ($row_users = mysqli_fetch_assoc($result_users)) {
                                        $users[] = $row_users;
                                    }
                                    if ($users != []) {
                                        foreach ($users as $user): ?>
                                            <option value="<?php echo $user['display_name']; ?>" <?php if($row_computer_user['user'] == $user['display_name']){ echo 'selected';}?>><?php echo $user['display_name']; ?></option>
                                        <?php endforeach;
                                    } ?>
                                </datalist>
                            </td>
                            <td>
                            <select name="role[]" id="role[]" class="form-control">
                                <option value="NO USER"<?php if($row_computer_user['role'] == 'NO USER') {echo 'selected';}?>>No User</option>
                                <option value="ADMINISTRATOR"<?php if($row_computer_user['role'] == 'ADMINISTRATOR') {echo 'selected';}?>>Administrator</option>
                                <option value="USER"<?php if($row_computer_user['role'] == 'USER') {echo 'selected';}?>>Standard User</option>
                                <option value="GUEST"<?php if($row_computer_user['role'] == 'GUEST') {echo 'selected';}?>>Guest</option>
                            </select>
                            </td>                            <td>
                                <?php if($j++ == 0) {continue; } else { ?> <!-- Skip first row so it don't have delete button -->
                                <button class="btn btn-danger btn-delete-file" type="button" onclick="
                                confirmDeleteExistingUser(
                                    this,
                                    '<?php echo $row_computer_user['id'];?>',
                                    '<?php echo $row_computer_user['username'];?>',
                                    '<?php echo $row['id'];?>'
                                    )">Delete</button></td>
                                <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="user-table">
                    </tbody>
                </table>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Files</h4>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <!-- invoice -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="invoice">Invoice</label></br>
                            <?php
                            if (!empty($row['invoice'])) {
                                $fileName = basename($row['invoice']);
                                echo '<div class="md-3 form-control"><a href="' . $row['invoice'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-invoice-form" action="./module/computer/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="invoice">
                                    <input type="hidden" name="invoice_id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-invoice-form" onclick="confirmDeleteFile('.$row['id'].',\'invoice\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="invoice" name="invoice" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>
                    
                    <!-- document -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="document">Document</label></br>
                            <?php
                            if (!empty($row['document'])) {
                                $fileName = basename($row['document']);
                                echo '<div class="md-3 form-control"><a href="' . $row['document'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-document-form" action="./module/computer/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="document">
                                    <input type="hidden" name="document_id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-document-form" onclick="confirmDeleteFile('.$row['id'].',\'document\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="document" name="document" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>

                    <!-- warranty card -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="warranty">Warranty</label></br>
                            <?php
                            if (!empty($row['warranty'])) {
                                $fileName = basename($row['warranty']);
                                echo '<div class="md-3 form-control"><a href="' . $row['warranty'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-warranty-form" action="./module/computer/deletefile_action.php" method="POST">
                                    <input type="hidden" name="fileType" value="warranty">
                                    <input type="hidden" name="warrenty_id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-warranty-form" onclick="confirmDeleteFile('.$row['id'].',\'warranty\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="warranty" name="warranty" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Picture</h4>
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                <button class="btn btn-info" type="button" onclick="createPicture()">Add More Picture</button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>View</th>
                            <th>Picture</th>
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="existing-picture-table">
                    <?php 
                        $sql_picture = "SELECT * FROM aims_all_asset_picture";
                        $result_picture = mysqli_query($con, $sql_picture);
                        while ($row_picture = mysqli_fetch_assoc($result_picture)) {
                            $pictures[] = $row_picture;
                        }

                        $sql_picture = "SELECT * FROM aims_all_asset_picture where asset_tag ='".$row['asset_tag']."'";
                        $result_picture = mysqli_query($con, $sql_picture);
                        $j = 0;
                        while ($row_picture = mysqli_fetch_assoc($result_picture)) {
                        ?>
                        <tr>
                            <input type="text" id="picture_id[]" name="picture_id[]" value="<?php echo $row_picture['id'];?>" hidden>
                            <td>
                                <input type="text" id="view[]" name="view[]" value="<?php echo $row_picture['view'];?>" class="form-control" >
                            </td>
                            <td>
                                <?php
                                if (!empty($row_picture['picture'])) {
                                    $fileName = basename($row_picture['picture']);
                                    echo '<div class="md-3 form-control"><a href="' . $row_picture['picture'] . '" target="_blank">' . $fileName . '</a></div>';
                                    echo '<br>';
                                    echo 
                                    '<form id="delete-picture-form" action="./module/computer/deletefile_action.php" method="POST">
                                        <input type="hidden" name="fileType" value="picture">
                                        <input type="hidden" name="picture_id" value="'.$row_picture['id'].'">
                                    </form>';
                                } else {
                                    echo '<input type="file" id="picture" name="picture" accept="" value="" class="form-control" />';
                                }
                                ?>
                            </td>                       
                            <td>
                                <button class="btn btn-danger btn-delete-file" type="button" onclick="
                                confirmDeleteExistingPicture(
                                    this,
                                    '<?php echo $row_picture['id'];?>',
                                    '<?php echo $row_picture['view'];?>',
                                    '<?php echo $row['id'];?>',
                                    )">Delete</button></td>
                                <?php  ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tbody id="picture-table">
                    </tbody>
                </table>
            </div>
        </div>
    </form>
</div>

<!-- COMPUTER MODAL -->
<?php include 'computer_modal.php' ?>

<script>
// Call toggleBrands on page load to set the initial display
document.addEventListener("DOMContentLoaded", function () {
    toggleBrands();
});

function toggleBrands() {
    var categoryInput = document.getElementById("category");
    var category = categoryInput.value.toLowerCase().trim(); // Clean the input

    var computerBrandDiv = document.getElementById("computer_brand_div");
    var phoneBrandDiv = document.getElementById("phone_brand_div");
    var virtualMachineDiv = document.getElementById("virtual_machine_div");

    // Handle "Add New Category" option
    if (category === "add new category") {
        computerBrandDiv.style.display = "none";
        phoneBrandDiv.style.display = "none";
        virtualMachineDiv.style.display = "none";
        return;
    }

    // Reset the displays before checking the selected category
    computerBrandDiv.style.display = "none";
    phoneBrandDiv.style.display = "none";
    virtualMachineDiv.style.display = "none";

    // Check the selected category and toggle visibility
    if (category === "smartphone" || category === "tablet") {
        phoneBrandDiv.style.display = "block";
    } else if (category === "desktop" || category === "laptop" || category === "server") {
        computerBrandDiv.style.display = "block";
    } else if (category === "virtual machine") {
        virtualMachineDiv.style.display = "block";
    } else {
        // Show all for other categories
        computerBrandDiv.style.display = "block";
        phoneBrandDiv.style.display = "block";
        virtualMachineDiv.style.display = "block";
    }
}

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
                    text: 'Computer edited successfully!',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function() {
                    window.location.href = './asset';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 20000
                }).then(function() {
                    window.location.href = './editcomputer?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Category" is selected
    $('#category').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Category') {
            $('#addAssetCategoryModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Category" option
    $('#categoryList option[data-action="addNewCategory"]').click(function () {
        $('#addAssetCategoryModal').modal('show');
        $('#category').val(''); // Clear the input field after opening the modal
    });


    $('#addAssetCategoryButton').click(function() {
        var prefixValue = $('#prefix').val();
        if (!/^C/.test(prefixValue)) {
            // Show an error message for the prefix
            $('#prefixError').text("The prefix must start with the letter 'C'");
        } else {
            // Prefix is valid, proceed with form submission
            // Clear any previous error message
            $('#prefixError').text("");
            $('#successMessage').text("");

            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            var formData = new FormData($('#addAssetCategoryForm')[0]);

            $.ajax({
                url: './module/computer/addcomputer_category_run_no.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.trim() === "true") {
                        // Success message
                        $('#successMessage').text('Computer Category added successfully!');
                        // Optionally, you can clear the prefix input or reset the form
                        $('#prefix').val('');
                        
                        // Add the new AssetCategory to the dropdown list
                        var newAssetCategoryName = $('#display_name_asset_category').val();
                        $('#assetCategoryList').append('<option value="' + newAssetCategoryName + '">' + newAssetCategoryName + '</option>');

                        // Optionally, you can select the newly added AssetCategory
                        $('#category').val(newAssetCategoryName);
                    } else {
                        // Error message
                        $('#prefixError').text('Something went wrong. Please try again.');
                    }

                    // Enable the button after processing
                    $('#addAssetCategoryButton').prop('disabled', false);
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Software Category" is selected
    $('#software_category').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Software Category') {
            $('#addCategoryModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Software Category" option
    $('#softwareList option[data-action="addNewSoftwareCategory"]').click(function () {
        $('#addCategoryModal').modal('show');
        $('#software_category').val(''); // Clear the input field after opening the modal
    });

    // Handling the "Add New Software Category" option
    $('#addSoftwareButton').click(function () {
        var formData = new FormData($('#addCategoryForm')[0]);

        $.ajax({
            url: './module/setting/preset/software_category/add_software_category_action.php',
            type: 'POST',
            data: formData,
            success: function (response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Category added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function () {
                        // Add the new Category to the dropdown list
                        var newSoftwareName = $('#display_name_software').val();
                        $('#softwareList').append('<option value="' + newSoftwareName + '">' + newSoftwareName + '</option>');

                        // Optionally, you can select the newly added Category
                        $('#software_category').val(newSoftwareName);

                        // Close the modal
                        $('#addCategoryModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

function openAddCategoryModal(rowIndex) {
    // You can use this function to open the modal
    $('#addCategoryModal').modal('show');
    // Optionally, you can set a data attribute to identify the current row index
    $('#addCategoryModal').data('currentRowIndex', rowIndex);
}

$(document).ready(function () {
    // Show the modal when "Add New Brand" is selected
    $('#computer_brand').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Brand') {
            $('#addComputerBrandModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Brand" option
    $('#computerBrandList option[data-action="addNewBrand"]').click(function () {
        $('#addComputerBrandModal').modal('show');
        $('#computer_brand').val(''); // Clear the input field after opening the modal
    });
    
    $('#addComputerBrandButton').click(function() {

        var formData = new FormData($('#addComputerBrandForm')[0]);

        $.ajax({
            url: './module/setting/preset/computer_brand/add_computer_brand_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Brand added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new ComputerBrand to the dropdown list
                        var newComputerBrandName = $('#display_name_computer').val();
                        $('#computerBrandList').append('<option value="' + newComputerBrandName + '">' + newComputerBrandName + '</option>');

                        // Optionally, you can select the newly added ComputerBrand
                        $('#computer_brand').val(newComputerBrandName);

                        // Close the modal
                        $('#addComputerBrandModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Brand" is selected
    $('#phone_brand').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Brand') {
            $('#addPhoneBrandModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Brand" option
    $('#phoneBrandList option[data-action="addNewBrand"]').click(function () {
        $('#addPhoneBrandModal').modal('show');
        $('#phone_brand').val(''); // Clear the input field after opening the modal
    });
    
    $('#addPhoneBrandButton').click(function() {

        var formData = new FormData($('#addPhoneBrandForm')[0]);

        $.ajax({
            url: './module/setting/preset/phone_brand/add_phone_brand_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Brand added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new PhoneBrand to the dropdown list
                        var newPhoneBrandName = $('#display_name_phone').val();
                        $('#phoneBrandList').append('<option value="' + newPhoneBrandName + '">' + newPhoneBrandName + '</option>');

                        // Optionally, you can select the newly added PhoneBrand
                        $('#phone_brand').val(newPhoneBrandName);

                        // Close the modal
                        $('#addPhoneBrandModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


$(document).ready(function () {
    // Show the modal when "Add New Brand" is selected
    $('#virtual_machine').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Brand') {
            $('#addVirtualMachineModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Brand" option
    $('#virtualMachineList option[data-action="addNewBrand"]').click(function () {
        $('#addVirtualMachineModal').modal('show');
        $('#virtual_machine').val(''); // Clear the input field after opening the modal
    });
        
    $('#addVirtualMachineButton').click(function() {

        var formData = new FormData($('#addVirtualMachineForm')[0]);

        $.ajax({
            url: './module/setting/preset/virtual_machine/add_virtual_machine_brand_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Brand added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new VirtualMachine to the dropdown list
                        var newVirtualMachineName = $('#display_name_virtual_machine').val();
                        $('#virtualMachineList').append('<option value="' + newVirtualMachineName + '">' + newVirtualMachineName + '</option>');

                        // Optionally, you can select the newly added VirtualMachine
                        $('#virtual_machine').val(newVirtualMachineName);

                        // Close the modal
                        $('#addVirtualMachineModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


$(document).ready(function () {
    // Show the modal when "Add New Location" is selected
    $('#location').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Location') {
            $('#addLocationModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Location" option
    $('#locationList option[data-action="addNewLocation"]').click(function () {
        $('#addLocationModal').modal('show');
        $('#location').val(''); // Clear the input field after opening the modal
    });

    $('#addLocationButton').click(function() {

        var formData = new FormData($('#addLocationForm')[0]);

        $.ajax({
            url: './module/setting/preset/location/addlocation_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Location added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Location to the dropdown list
                        var newLocationName = $('#display_name_location').val();
                        $('#locationList').append('<option value="' + newLocationName + '">' + newLocationName + '</option>');

                        // Optionally, you can select the newly added Location
                        $('#location').val(newLocationName);

                        // Close the modal
                        $('#addLocationModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Category" is selected
    $('#department').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Department') {
            $('#addDepartmentModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Department" option
    $('#departmentList option[data-action="addNewDepartment"]').click(function () {
        $('#addDepartmentModal').modal('show');
        $('#department').val(''); // Clear the input field after opening the modal
    });

    $('#addDepartmentButton').click(function() {

        var formData = new FormData($('#addDepartmentForm')[0]);

        $.ajax({
            url: './module/setting/preset/department/adddepartment_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Department added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new department to the dropdown list
                        var newDepartmentName = $('#display_name_department').val();
                        $('#departmentList').append('<option value="' + newDepartmentName + '">' + newDepartmentName + '</option>');

                        // Optionally, you can select the newly added department
                        $('#department').val(newDepartmentName);

                        // Close the modal
                        $('#addDepartmentModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});


$(document).ready(function () {
    // Show the modal when "Add New Building/Branch" is selected
    $('#branch').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Building/Branch') {
            $('#addBranchModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Building/Branch" option
    $('#branchList option[data-action="addNewBranch"]').click(function () {
        $('#addBranchModal').modal('show');
        $('#branch').val(''); // Clear the input field after opening the modal
    });
    $('#addBranchButton').click(function() {

        var formData = new FormData($('#addBranchForm')[0]);

        $.ajax({
            url: './module/setting/preset/branch/addbranch_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Branch added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new branch to the dropdown list
                        var newBranchName = $('#display_name_branch').val();
                        $('#branchList').append('<option value="' + newBranchName + '">' + newBranchName + '</option>');

                        // Optionally, you can select the newly added branch
                        $('#branch').val(newBranchName);

                        // Close the modal
                        $('#addBranchModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Supplier" is selected
    $('#supplier').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Supplier') {
            $('#addSupplierModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Supplier" option
    $('#supplierList option[data-action="addNewSupplier"]').click(function () {
        $('#addSupplierModal').modal('show');
        $('#supplier').val(''); // Clear the input field after opening the modal
    });

    $('#addSupplierButton').click(function() {

        var formData = new FormData($('#addSupplierForm')[0]);

        $.ajax({
            url: './module/people/supplier/addsupplier_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Supplier added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Supplier to the dropdown list
                        var newSupplierName = $('#display_name_supplier').val();
                        $('#supplierList').append('<option value="' + newSupplierName + '">' + newSupplierName + '</option>');

                        // Optionally, you can select the newly added Supplier
                        $('#supplier').val(newSupplierName);

                        // Close the modal
                        $('#addSupplierModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

$(document).ready(function () {
    // Show the modal when "Add New Preset" is selected
    $('#remote_name').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Preset') {
            $('#addRemoteAccessModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Preset" option
    $('#remoteAccessList option[data-action="addNewPreset"]').click(function () {
        $('#addRemoteAccessModal').modal('show');
        $('#remote_name').val(''); // Clear the input field after opening the modal
    });

    $('#addRemoteAccessButton').click(function() {

        var formData = new FormData($('#addRemoteAccessForm')[0]);

        $.ajax({
            url: './module/setting/preset/remote_access/add_remote_access_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.trim() === "true") {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Preset added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new Preset to the dropdown list
                        var newRemoteAccessName = $('#display_name_remote_access').val();
                        $('#remoteAccessList').append('<option value="' + newRemoteAccessName + '">' + newRemoteAccessName + '</option>');

                        // Optionally, you can select the newly added Remote
                        $('#remote_name').val(newRemoteAccessName);

                        // Close the modal
                        $('#addRemoteAccessModal').modal('hide');
                    });
                } else {
                    // Error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });
});

// Files
function confirmDeleteFile(id, fileType) {
Swal.fire({
    title: "Are you sure?",
    text: "You are about to delete the " + fileType + " file?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, delete it!",
    cancelButtonText: "Cancel"
}).then((result) => {
    if (result.isConfirmed) {
        deleteFile(id, fileType);
    }
});
}

function deleteFile(id, fileType) {
    $.ajax({
        url: "./module/computer/deletefile_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id, fileType: fileType}, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The file has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './editcomputer?id=' + id;
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the file.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './editcomputer?id=' + id;
            });
        }
    });
}

// Software
function createSoftware() {
    var table = document.getElementById("software-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <input type="text" id="software_id[]" name="software_id[]" value="" hidden>
            <td>
            <input list="softwareList" name="software_category[]" id="software_category" class="form-control" >
                <datalist id="softwareList">
                    <option value="">Select Category</option>
                    <?php
                    $sql_software_categories = "SELECT * FROM aims_software_category";
                    $result_software_categories = mysqli_query($con, $sql_software_categories);
                    $software_categories = [];
                    while ($row_software_categories = mysqli_fetch_assoc($result_software_categories)) {
                        $software_categories[] = $row_software_categories;
                    }
                    if ($software_categories == []) { ?>
                        <option value="">No Selection Found</option>
                    <?php } else {
                        foreach ($software_categories as $software_category) { ?>
                            <option value="<?php echo $software_category['display_name']; ?>"><?php echo $software_category['display_name']; ?></option>
                        <?php }
                    }
                    ?>
                    <option value="Add New Category"></option>
                <datalist id="softwareList">
            </select>
            </td>
            <td><input type="text" name="software_brand[]" class="form-control"></td>
            <td><input type="text" name="software_name[]" class="form-control"></td>
            <td><input type="text" name="license_key[]" class="form-control"></td>
            <td><input type="date" name="expiry_date[]" class="form-control"></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteSoftware(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deleteSoftware(input) {
    document.getElementById('software-table').removeChild(input.parentNode.parentNode);
}

function confirmDeleteExistingSoftware(input, id, software_name, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete software " + software_name + ". This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingSoftware(input, id, software_name, computer_id);
        }
    });
}

function deleteExistingSoftware(input, id, software_name, computer_id) {
    $.ajax({
        url: "./module/computer/deletesoftware_action.php",
        type: "POST",
        data: {id: id, software_name: software_name},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-software-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editcomputer?id=' + computer_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}


// User
function createUser() {
    var table = document.getElementById("user-table");
    var userCount = table.getElementsByTagName("tr").length;

    var row = document.createElement('tr');
    
    row.innerHTML = `
    <tr>
        <td><input type="text" name="username[]" class="form-control"></td>
        <td><input type="text" name="password[]" class="form-control"></td>
        <td>
            <input list="userList" name="user[]" id="user[]" class="form-control">
            <datalist id="userList">
                <option value="" selected disabled>Select User</option>
                <?php 
                $sql_users = "SELECT * FROM aims_people_staff";
                $result_users = mysqli_query($con, $sql_users);
                $users=[];
                while ($row_users = mysqli_fetch_assoc($result_users)) {
                    $users[] = $row_users;
                }
                if ($users != []) {
                    foreach ($users as $user): ?>
                        <option value="<?php echo $user['display_name']; ?>"><?php echo $user['display_name']; ?></option>
                    <?php endforeach;
                } ?>
            </datalist>
        </td>
        <td>
            <select name="role[]" id="role[]" class="form-control">
                <option value="NO USER">No User</option>
                <option value="ADMINISTRATOR">Administrator</option>
                <option value="USER">Standard User</option>
                <option value="GUEST">Guest</option>
            </select>
        </td>
        <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteUser(this)">Delete</button></td>
    </tr>
    `
    table.appendChild(row);
}


function deleteUser(input) {
    document.getElementById('user-table').removeChild(input.parentNode.parentNode);
}

function confirmDeleteExistingUser(input, id, username, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete username " + username + ". This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingUser(input, id, username, computer_id);
        }
    });
}

function deleteExistingUser(input, id, username, computer_id) {
    $.ajax({
        url: "./module/computer/deleteuser_action.php",
        type: "POST",
        data: {id:id, username: username},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-user-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editcomputer?id=' + computer_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}

function createIP() {
    var table = document.getElementById("ip-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <input type="text" id="network_id[]" name="network_id[]" value ="" hidden>
            <td><input type="text" name="ip_address[]" class="form-control" required></td>
            <td><input type="text" name="mac_address[]" class="form-control" required></td>
            <td><input type="text" name="port[]" class="form-control" required></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteIP(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deleteIP(input) {
    document.getElementById('ip-table').removeChild(input.parentNode.parentNode);
}

function confirmDeleteExistingNetwork(input, id, ip_address, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete network " + ip_address + ". This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingNetwork(input, id, ip_address, computer_id);
        }
    });
}

function deleteExistingNetwork(input, id, ip_address, computer_id) {
    $.ajax({
        url: "./module/computer/deletenetwork_action.php",
        type: "POST",
        data: {id:id, ip_address: ip_address},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-ip-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editcomputer?id=' + computer_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}

function createHardDrive() {
    var table = document.getElementById("hard_drive-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <input type="text" id="hard_drive_id[]" name="hard_drive_id[]" value="" hidden>
            <td>
                <input type="text" id="hard_disk_name[]" name="hard_disk_name[]" class="form-control" >
            </td>
            <td>
                <select name="hard_drive[]" id="hard_drive[]" class="form-control" required>
                    <option value="SSD">SSD</option>
                    <option value="HDD">HDD</option>
                    <option value="PCI">PCI</option>
                </select>
            </td>
            <td><input type="text" id="brand[]" name="brand[]" class="form-control"></td>
            <td><input type="text" id="storage[]" name="storage[]" class="form-control"></td>
            <td><input type="text" id="purpose[]" name="purpose[]" class="form-control"></td>
            <td><input type="date" id="end_warranty_disk[]" name="end_warranty_disk[]" class="form-control"></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteHardDrive(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deleteHardDrive(input) {
    document.getElementById('hard_drive-table').removeChild(input.parentNode.parentNode);
}

function confirmDeleteExistingHardDrive(input, id, hard_drive, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete hard drive " + hard_drive + ". This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingHardDrive(input, id, hard_drive, computer_id);
        }
    });
}

function deleteExistingHardDrive(input, id, hard_drive, computer_id) {
    $.ajax({
        url: "./module/computer/deleteharddrive_action.php",
        type: "POST",
        data: {id:id, hard_drive: hard_drive},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-hard_drive-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editcomputer?id=' + computer_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}

function createPicture() {
    var table = document.getElementById("picture-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <input type="text" id="picture_id[]" name="picture_id[]" value="" hidden>
            <td><input type="text" name="view[]" class="form-control"></td>
            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control"></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deletePicture(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deletePicture(input) {
    document.getElementById('picture-table').removeChild(input.parentNode.parentNode);
}

function confirmDeleteExistingPicture(input, id, view, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete picture with " + view + " view. This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingPicture(input, id, view, computer_id);
        }
    });
}

function deleteExistingPicture(input, id, view, computer_id) {
    $.ajax({
        url: "./module/computer/deletepicture_action.php",
        type: "POST",
        data: {id:id, view: view},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-picture-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editcomputer?id=' + computer_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}

//Remote Accesss
function createRemoteAccess() {
    var table = document.getElementById("remote_access-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <input type="text" id="remote_id[]" name="remote_id[]" value="" hidden>
            <td>
            <input list="remoteAccesslist" name="remote_name[]" id="remote_name" class="form-control" >
                <datalist id="remoteAccesslist">
                    <option value="">Select Category</option>
                    <?php
                    $sqlremote_access = "SELECT * FROM aims_preset_remote_access";
                    $resultremote_access = mysqli_query($con, $sqlremote_access);
                    $remote_access = [];
                    while ($rowremote_access = mysqli_fetch_assoc($resultremote_access)) {
                        $remote_access[] = $rowremote_access;
                    }
                    if ($remote_access == []) { ?>
                        <option value="">No Selection Found</option>
                    <?php } else {
                        foreach ($remote_access as $remote_access) { ?>
                            <option value="<?php echo $remote_access['display_name']; ?>"><?php echo $remote_access['display_name']; ?></option>
                        <?php }
                    }
                    ?>
                <datalist id="remoteAccesslist">
            </select>
            </td>
            <td><input type="text" name="remote_address[]" class="form-control" ></td>
            <td><input type="text" name="remote_password[]" class="form-control" ></td>
            <td><input type="text" name="remote_port[]" class="form-control" ></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteRemoteAccess(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deleteRemoteAccess(input) {
    document.getElementById('remote_access-table').removeChild(input.parentNode.parentNode);
}

function confirmDeleteExistingRemoteAccess(input, id, remote_name, computer_id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete " + remote_name + ". This procress is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
    }).then((result) => {
        if (result.isConfirmed) {
            deleteExistingRemoteAccess(input, id, remote_name, computer_id);
        }
    });
}

function deleteExistingRemoteAccess(input, id, remote_name, computer_id) {
    $.ajax({
        url: "./module/computer/delete_remote_access_action.php",
        type: "POST",
        data: {id: id, remote_name: remote_name},
        success: function(response) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: response,
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                document.getElementById('existing-remote_access-table').removeChild(input.parentNode.parentNode);
                window.location.href = './editcomputer?id=' + computer_id;
            });
        },
        error: function(xhr, status, error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                return false;
            });
        }
    });
}


// JavaScript to show/hide the server_name field based on the selected Category
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const serverNameField = document.getElementById('serverNameField');

    // Check the initial value
    if (categorySelect.value === 'Virtual Machine') {
        serverNameField.style.display = 'block';
    } else {
        serverNameField.style.display = 'none';
    }

    // Add an event listener for changes in the Category select
    categorySelect.addEventListener('change', function() {
        if (this.value === 'Virtual Machine') {
            serverNameField.style.display = 'block';
        } else {
            serverNameField.style.display = 'none';
        }
    });
});

// supplier details through ajax
function getSupplierDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/supplier/get_supplier_details_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#supplier_pic").text(data["pic"]);
                $("#supplier_contact_no").text(data["contact_no"]);
                $("#supplier_email").text(data["email"]);
                $("#supplier_fax").text(data["fax"]);
                $("#supplier_address").text(data["address"]);
            } catch (e) {
                $("#supplier_pic").text("");
                $("#supplier_contact_no").text("");
                $("#supplier_email").text("");
                $("#supplier_fax").text("");
                $("#supplier_address").text("");
            }
        }
    });
}

$(document).ready(function() {
    // Event handler for branch selection
    $('#branch').change(function() {
        var selectedBranch = $(this).val();

        // AJAX request to fetch departments based on the selected branch
        $.ajax({
            type: 'POST',
            url: './module/setting/preset_location/location/get_departments_by_branch.php',
            data: { branch: selectedBranch },
            success: function(response) {
                // Update the department dropdown with the new options
                $('#departmentList').html(response);
            },
            error: function(error) {
                console.log('Error fetching departments: ' + error);
            }
        });
    });

    // Event handler for clearing branch value
    $('#branch').on('input', function() {
        // If the branch value is empty, clear the department options
        if ($(this).val() === '') {
            $('#departmentList').empty();
        }
    });
});

$(document).ready(function() {
    // Event handler for department selection
    $('#department').change(function() {
        var selectedDepartment = $(this).val();

        // AJAX request to fetch locations based on the selected department
        $.ajax({
            type: 'POST',
            url: './module/setting/preset_location/location/get_location_by_department.php',
            data: { department: selectedDepartment },
            success: function(response) {
                // Update the location dropdown with the new options
                $('#locationList').html(response);
            },
            error: function(error) {
                console.log('Error fetching locations: ' + error);
            }
        });
    });

    // Event handler for clearing department value
    $('#department').on('input', function() {
        // If the department value is empty, clear the location options
        if ($(this).val() === '') {
            $('#locationList').empty();
        }
    });
});

</script>