<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
?>

<style>
    textarea {
        resize: none;
    }

    .card-body {
        max-height: 750px; /* Adjust the height as needed */
        overflow-y: scroll;
    }

    .main span {
        height: 2.3rem;
    }

    .modal-backdrop {
        display: none;
    }

    .bold-option {
        font-weight: bold;
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
        width: 300%;
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

    .table thead th {
        border-bottom: none;
    }

    .table td, .table th, tbody td, #picture-table {
        border-top: none;
    }

    .clear-button {
        left: 390%;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 400%;
    }
</style>

<div class="main">
    <form action=".\module\computer\addcomputer_action.php"  method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Computer Information</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./add" class="btn btn-danger">Discard</a>
                            <button type="button" id="importButton" class="btn btn-primary" style="background-color: green;">Import</button>
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
            <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="assetType">Asset Type</label>
                            <div class="radio-buttons">
                                <div class="radio-option">
                                    <input type="radio" id="single" name="assetType" value="single" checked>
                                    <label for="single">Single</label>
                                </div>
                                <div class="radio-option">
                                    <input type="radio" id="multiple" name="assetType" value="multiple">
                                    <label for="multiple">Multiple</label>
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- Select dropdown for quantity -->
                   <div id="quantityInput" class="col-2" style="display: none;">
                        <div class="form-group">
                            <label for="quantity"><b>Quantity</b></label>
                            <select id="quantity" name="quantity" class="form-control" onchange="limitInputToRange(this)">
                                <?php
                                    // Populate options from 1 to 50
                                    for ($i = 1; $i <= 50; $i++) {
                                        echo "<option value=\"$i\">$i</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="dropdown">
                            <label for="smartSearch"><b>Smart Search</b></label>
                            <div class="input-container">
                                <input type="text" placeholder="Search.." id="myInput" oninput="filterFunction()">
                                <span class="clear-button" onclick="clearSearch()">x</span>
                            </div>
                            <div id="myDropdown" class="dropdown-content" style="display: none;">
                                <?php 
                                $sql_smartSearchs = "SELECT c.*, s.* FROM aims_computer c 
                                                    LEFT JOIN aims_software s ON c.asset_tag = s.asset_tag";
                                $result_smartSearchs = mysqli_query($con, $sql_smartSearchs);
                                $smartSearchs = [];

                                while ($row_smartSearchs = mysqli_fetch_assoc($result_smartSearchs)) {
                                    $assetTag = $row_smartSearchs['asset_tag'];
                                    // Check if this asset tag is already added
                                    if (!isset($smartSearchs[$assetTag])) {
                                        $smartSearchs[$assetTag] = [
                                            'name' => $row_smartSearchs['name'],
                                            'category' => $row_smartSearchs['category'],
                                            'price' => $row_smartSearchs['price'],
                                            'processor' => $row_smartSearchs['processor'],
                                            'software_names' => [],
                                        ];
                                    }
                                    // Add software name to the array
                                    $smartSearchs[$assetTag]['software_names'][] = $row_smartSearchs['software_name'];
                                }

                                foreach ($smartSearchs as $index => $smartSearch) {
                                    // Combine software names into a single string
                                    $softwareNameString = implode(' - ', $smartSearch['software_names']);
                                    ?>
                                    <p id="smartSearchItem_<?php echo $index; ?>" onclick="populateFormFields('<?php echo $smartSearch['name']; ?>', '<?php echo $smartSearch['category']; ?>', '<?php echo $smartSearch['price']; ?>', '<?php echo $smartSearch['processor']; ?>', '<?php echo $softwareNameString; ?>')">
                                        <?php echo $smartSearch['name'] . ' - ' . $smartSearch['category'] . ' - ' . $smartSearch['price'] . ' - ' . $smartSearch['processor'] . ' - ' . $softwareNameString; ?>
                                    </p>
                                    <?php
                                }

                                if (empty($smartSearchs)) { ?>
                                    <p>No Selection Found</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                     <!-- name -->
                     <div class="col-2">
                        <div class="form-group" style="display: flex; align-items: center;">
                            <label for="name" style="margin-right: 10px; margin-top: 0px; margin-bottom: 0;">Name</label>
                            <img id="infoImage" src='./include/action/info.png' alt='Info' title='Additional Information: This is the name field where you enter the name of the asset.' width='16' height='16' style="display: none;">
                        </div>
                        <div style="margin-top: -7px;">
                            <input type="text" id="name" name="name" placeholder="Name" class="form-control" required>
                        </div>
                    </div>
                    
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input list="assetCategoryList" name="category" id="category" class="form-control" required onchange="toggleBrands()">
                            <datalist id="assetCategoryList">
                                <option value="">Select Category</option>
                                <?php
                                $sql_categories = "SELECT category, display_name FROM aims_computer_category_run_no";
                                $result_categories = mysqli_query($con, $sql_categories);
                                while ($row_categories = mysqli_fetch_assoc($result_categories)) {
                                    $categories[] = $row_categories;
                                }
                                if ($categories == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else
                                    foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category['display_name']; ?>"><?php echo $category['display_name']; ?></option>
                                <?php endforeach; ?>
                                <option value="Add New Category" data-action="addNewCategory">Add New Category</option>
                            </datalist>
                        </div>
                    </div>
                    <!-- server if virtual machine is choosen as category  -->
                    <div class="col-2" id="server_nameContainer" style="display: none;">
                        <div class ="form-group">
                            <label for="server_name">Server</label>
                            <input list ="serverNameList" id="server_name" name="server_name" class="form-control">
                                <datalist id="serverNameList">
                                    <?php 
                                        $sql_categories = "SELECT name FROM aims_computer WHERE category = 'Server'";
                                        $result_categories = mysqli_query($con, $sql_categories);
                                        
                                        if (!$result_categories) {
                                            echo "Error: " . mysqli_error($con); // Add error handling as needed
                                        } else {
                                            if (mysqli_num_rows($result_categories) > 0) {
                                                while ($row_category = mysqli_fetch_assoc($result_categories)) {
                                                    echo '<option value="' . $row_category['name'] . '">' . $row_category['name'] . '</option>';
                                                }
                                            } else {
                                                echo '<option value="">No Selection Found</option>';
                                            }
                                        }
                                    ?>
                                <datalist id="serverNameList">
                            </select>
                        </div>
                    </div>
                    <!-- branch  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch">Building/Branch</label>
                            <input list ="branchList" name="branch" id="branch" class="form-control">
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
                                    <?php } else
                                    foreach ($branchs as $branch): ?>
                                        <option value="<?php echo $branch['display_name']; ?>"><?php echo $branch['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Building/Branch" data-action="addNewBranch">Add New Building/Branch</option>
                                <datalist id="branchList">
                            </select>
                        </div>
                    </div>
                    <!-- department  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="department">Department</label>
                            <input list ="departmentList" name="department" id="department" class="form-control">
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
                                    <?php } else
                                    foreach ($departments as $department): ?>
                                        <option value="<?php echo $department['display_name']; ?>"><?php echo $department['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Department" data-action="addNewDepartment">Add New Department</option>
                                <datalist id="departmentList">
                            </select>
                        </div>
                    </div>
                    <!-- location  -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input list ="locationList" name="location" id="location" class="form-control">
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
                                    <?php } else
                                    foreach ($locations as $location): ?>
                                        <option value="<?php echo $location['display_name']; ?>"><?php echo $location['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Location" data-action="addNewLocation">Add New Location</option>
                                <datalist id="locationList">
                            </select>
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="price">Price (RM)</label>
                            <input type="number" id="price" name="price" placeholder="Price in Ringgit"  class="form-control" step="any">
                        </div>
                    </div>

                    <div class="col-2">
                        <div class="form-group">
                            <label for="date_purchase">Date of Purchase</label>
                            <input type="date" id="date_purchase" name="date_purchase" class="form-control">
                        </div>
                    </div>

                    <div class="col-5">
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <input type="text" id="remark" name="remark" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group form-check form-check-inline">
                            <label class="form-check-label" for="warranty_checkbox"><b>Set Warranty</b></label>
                            <input type="checkbox" id="warranty_checkbox" name="warranty_checkbox" class="form-check-input" style="margin-left: 10px;">
                        </div>
                    </div>
                    <!-- start_warranty -->
                    <div class="col-2 warranty-fields" style="display: none;">
                        <div class="form-group">
                            <label for="start_warranty">Start Warranty</label>
                            <input type="date" id="start_warranty" name="start_warranty" placeholder="Start Date of Warranty" class="form-control">
                        </div>
                    </div>
                    <!-- end_warranty -->
                    <div class="col-2 warranty-fields" style="display: none;">
                        <div class="form-group">
                            <label for="end_warranty">End Warranty</label>
                            <input type="date" id="end_warranty" name="end_warranty" placeholder="End Date of Warranty" class="form-control">
                        </div>
                    </div>
                    <!-- Upload warranty card -->
                    <div class="col-4 warranty-fields" style="display: none;">
                        <div class="form-group">
                            <label for="warranty"><b>Warranty Card</b></label>
                            <input type="file" id="warranty" name="warranty" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                </div>

                <br><hr>

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Supplier Details</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- supplier -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="supplier">Name</label>
                            <input list="supplierList" name="supplier" id="supplier" class="form-control" autofocus oninput = "getSupplierDetails(this.value)">
                                <datalist id="supplierList">    
                                    <option value="">Select Supplier</option>
                                    <?php 
                                    $sql_suppliers = "SELECT * FROM aims_people_supplier";
                                    $result_suppliers = mysqli_query($con, $sql_suppliers);
                                    while ($row_suppliers = mysqli_fetch_assoc($result_suppliers)) {
                                        $suppliers[] = $row_suppliers;
                                    } if ($suppliers == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier['display_name']; ?>"><?php echo $supplier['display_name']; ?></option>
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
                    <div class="col-2" id="computer_brand_div">
                        <div class="form-group">
                            <label for="computer_brand">Computer Brand</label>
                            <input list="computerBrandList" name="computer_brand" id="computer_brand" class="form-control">
                                <datalist id="computerBrandList">
                                    <option value="">Select Brand</option>
                                    <?php 
                                    $sqlcomputer_brands = "SELECT * FROM aims_preset_devices_computer_brand";
                                    $resultcomputer_brands = mysqli_query($con, $sqlcomputer_brands);
                                    while ($rowcomputer_brands = mysqli_fetch_assoc($resultcomputer_brands)) {
                                        $computer_brands[] = $rowcomputer_brands;
                                    } if ($computer_brands == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($computer_brands as $computer_brand): ?>
                                        <option value="<?php echo $computer_brand['display_name']; ?>"><?php echo $computer_brand['display_name']; ?></option>
                                    <?php endforeach; 
                                    ?>
                                    <option value="Add New Brand" data-action="addNewBrand">Add New Brand</option>
                                <datalist id="computerBrandList">
                            </select>
                        </div>
                    </div>
                    <div class="col-2" id="phone_brand_div" style="display: none;">
                        <div class="form-group">
                            <label for="phone_brand">Phone Brand</label>
                            <input list="phoneBrandList" name="phone_brand" id="phone_brand" class="form-control">
                                <datalist id="phoneBrandList">
                                    <option value="">Select Brand</option>
                                    <?php 
                                    $sqlphone_brands = "SELECT * FROM aims_preset_devices_phone_brand";
                                    $resultphone_brands = mysqli_query($con, $sqlphone_brands);
                                    $phone_brands = [];
                                    while ($rowphone_brands = mysqli_fetch_assoc($resultphone_brands)) {
                                        $phone_brands[] = $rowphone_brands;
                                    } if ($phone_brands == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($phone_brands as $phone_brand): ?>
                                        <option value="<?php echo $phone_brand['display_name']; ?>"><?php echo $phone_brand['display_name']; ?></option>
                                    <?php endforeach; 
                                    ?>
                                    <option value="Add New Brand" data-action="addNewBrand">Add New Brand</option>
                                <datalist id="phoneBrandList">
                            </select>
                        </div>
                    </div>
                    <div class="col-2" id="virtual_machine_div" style="display: none;">
                        <div class="form-group">
                            <label for="virtual_machine">Virtual Machine Brand</label>
                            <input list="virtualMachineList" name="virtual_machine" id="virtual_machine" class="form-control">
                                <datalist id="virtualMachineList">
                                    <option value="">Select Brand</option>
                                    <?php 
                                    $sqlvirtual_machines = "SELECT * FROM aims_preset_virtual_machine";
                                    $resultvirtual_machines = mysqli_query($con, $sqlvirtual_machines);
                                    $virtual_machines = [];
                                    while ($rowvirtual_machines = mysqli_fetch_assoc($resultvirtual_machines)) {
                                        $virtual_machines[] = $rowvirtual_machines;
                                    } if ($virtual_machines == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($virtual_machines as $virtual_machine): ?>
                                        <option value="<?php echo $virtual_machine['display_name']; ?>"><?php echo $virtual_machine['display_name']; ?></option>
                                    <?php endforeach; 
                                    ?>
                                    <option value="Add New Brand" data-action="addNewBrand">Add New Brand</option>
                                <datalist id="virtualMachineList">
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="ram">Installed RAM</label>
                            <input type="text" id="ram" name="ram"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="processor">Processor (CPU)</label>
                            <input type="text" id="processor" name="processor"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="graphic_card">Graphic Card</label>
                            <input type="text" id="graphic_card" name="graphic_card"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="casing">Casing</label>
                            <input type="text" id="casing" name="casing"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="psu">Power Supply Unit</label>
                            <input type="text" id="psu" name="psu"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="motherboard">Motherboard</label>
                            <input type="text" id="motherboard" name="motherboard"  class="form-control">
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
                    <div class="col-2">
                        <div class="form-group">
                            <label for="ip_type[]">IP Type</label>
                                <select name="ip_type[]" id="ip_type[]" class="form-control">
                                    <option value="" selected>Choose IP Type</option>
                                    <option value="Dynamic" >Dynamic</option>
                                    <option value="Static">Static</option>
                                </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="ip_address[]">IP Address</label>
                            <input type="text" id="ip_address[]" name="ip_address[]"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="mac_address[]">MAC Address</label>
                            <input type="text" id="mac_address[]" name="mac_address[]"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="port[]">Active Port</label>
                            <input type="text" id="port[]" name="port[]"  class="form-control">
                        </div>
                    </div>
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
                    <tbody>
                        <tr>
                            <td>
                                <input list="remoteAccesslist" name="remote_name[]" id="remote_name" class="form-control">
                                    <datalist id="remoteAccesslist">
                                        <option value="">Select Type</option>
                                        <?php 
                                        $sqlremote_access = "SELECT * FROM aims_preset_remote_access";
                                        $resultremote_access = mysqli_query($con, $sqlremote_access);
                                        $remote_access = [];
                                        while ($rowremote_access = mysqli_fetch_assoc($resultremote_access)) {
                                            $remote_access[] = $rowremote_access;
                                        } if ($remote_access == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php  } else
                                        foreach ($remote_access as $remote_access): ?>
                                            <option value="<?php echo $remote_access['display_name']; ?>"><?php echo $remote_access['display_name']; ?></option>
                                        <?php endforeach; 
                                        ?>
                                        <option value="Add New Preset" data-action="addNewPreset">Add New Preset</option>
                                    <datalist id="remoteAccesslist">
                                </select>
                            </td>
                            <td><input type="text" name="remote_address[]" class="form-control" ></td>
                            <td><input type="text" name="remote_password[]" class="form-control" ></td>
                            <td><input type="text" name="remote_port[]" class="form-control" ></td>
                            <td></td>
                        </tr>
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

                <table class="table">
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
                    <tbody>
                        <tr>
                            <td><input type="text" name="hard_disk_name[]" class="form-control" ></td>
                            <td>
                                <select name="hard_drive[]" id="hard_drive[]" class="form-control" >
                                    <option value="SSD">SSD</option>
                                    <option value="HDD">HDD</option>
                                    <option value="PCI">PCI</option>
                                </select>
                            </td>
                            <td><input type="text" name="brand[]" class="form-control" ></td>
                            <td><input type="text" name="storage[]" class="form-control" ></td>
                            <td><input type="text" name="purpose[]" class="form-control" ></td>
                            <td><input type="date" name="end_warranty_disk[]" class="form-control" ></td>
                            <td></td>
                        </tr>
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
                            <th style="width: 100px;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="software-table" data-asset-tag="">
                        <tr>
                            <td>
                                <div class="input-group">
                                    <input list="softwareList" name="software_category[]" id="software_category" class="form-control">
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
                                        <option value="Add New Software Category" data-action="addNewSoftwareCategory">Add New Software Category</option>
                                    </datalist>
                                </div>
                            </td>
                            <td><input type="text" name="software_brand[]" class="form-control"></td>
                            <td><input type="text" name="software_name[]" class="form-control"></td>
                            <td><input type="text" name="license_key[]" class="form-control"></td>
                            <td><input type="date" name="expiry_date[]" class="form-control"></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-2">
                            <h4>User Account</h4>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" id="user_checkbox" name="user_checkbox" class="form-check-input">
                                    <label class="form-check-label" for="user_checkbox"><b>Display User</b></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-8 user-fields" style="display: none;">
                            <div class="float-right">
                                <button class="btn btn-info" type="button" onclick="createUser()">Add User</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class=" user-fields" style="display: none;">
                    <table id="user-table" class="table" >
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Password</th>
                                <th>User</th>
                                <th>Role</th>
                                <th style="width: 120px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="username[]" value = "NO USER" class="form-control"></td>
                                <td><input type="text" name="password[]" value = "NO USER" class="form-control"></td>
                                <td>
                                    <input list="userList" name="user[]" value = "NO USER" id="user[]" class="form-control">
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
                                                <option value="<?php echo $user['display_name']; ?>"><?php echo $user['display_name']; ?></option>
                                            <?php endforeach;
                                        } ?>
                                    <datalist id="userList">
                                </td>
                                <td>
                                    <select name="role[]" id="role[]" class="form-control">
                                        <option value="NO USER">No User</option>
                                        <option value="ADMINISTRATOR">Administrator</option>
                                        <option value="USER">Standard User</option>
                                        <option value="GUEST">Guest</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
                    <tbody>
                        <tr>
                            <td><input type="text" name="view[]" class="form-control" ></td>
                            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control" ></td>                                    
                        </tr>
                    </tbody>
                    <tbody id="picture-table">
                    </tbody>
                </table>
                
                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <!-- invoices -->
                        <div class="col-3">
                            <div class="form-group">
                                <label for="invoice">Invoice</label>
                                <input type="file" id="invoice" name="invoice" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                            </div>
                        </div>
                        <!-- documents -->
                        <div class="col-3">
                            <div class="form-group">
                                <label for="document">Document</label>
                                <input type="file" id="document" name="document" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- COMPUTER MODAL -->
<?php include 'computer_modal.php' ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function downloadTemplate() {
    var link = document.createElement('a');
    link.href = './include/upload/templates/computer/template_computer.xlsx';
    link.download = 'template_computer.xlsx';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Ensure the iframe src is empty initially
$('#importModal').on('show.bs.modal', function () {
    document.getElementById('downloadFrame').src = '';
});

// Trigger the modal when the import button is clicked
document.getElementById('importButton').addEventListener('click', function () {
    document.getElementById('openModalBtn').click();
});

$(document).ready(function () {
    // Function to handle the click event of the "Add" button
    $("#importModalAddBtn").click(function () {
        // Get the selected file
        var fileInput = document.getElementById('import');
        var file = fileInput.files[0];

        // Create a FormData object and append the file to it
        var formData = new FormData();
        formData.append('import', file);

        // Send an AJAX request to the server to handle the file upload
        $.ajax({
            type: 'POST',
            url: './module/computer/upload.php', // Replace with the actual server-side script handling the file upload
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function (response) {
                // Handle the server response here (if needed)
                console.log(response);

                // Handle the response based on success or error
                if (response.status === 'success') {
                    // Success
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Computer added successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        // Optionally, redirect or perform additional actions after success
                        // For example, reload the page
                        window.location.reload();
                    });
                } else {
                    // Error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error adding data: ' + response.message,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function () {
                        // Handle error as needed
                    });
                }
            },
            error: function (error) {
                // Handle errors (if any)
                console.log(error);
            }
        });
    });
});

// JavaScript to show/hide the quantity input and info image based on the radio button selection
document.addEventListener('DOMContentLoaded', function () {
    var singleRadio = document.getElementById('single');
    var multipleRadio = document.getElementById('multiple');
    var quantityInput = document.getElementById('quantityInput');
    var infoImage = document.getElementById('infoImage');

    function updateVisibility() {
        quantityInput.style.display = multipleRadio.checked ? 'block' : 'none';
        infoImage.style.display = multipleRadio.checked ? 'inline' : 'none';
    }

    singleRadio.addEventListener('change', updateVisibility);
    multipleRadio.addEventListener('change', updateVisibility);

    // Initialize visibility based on the default state
    updateVisibility();
});

// Tooltip for info image
$(document).ready(function() {
    $('#infoImage').attr('title', 'When selecting multiple, system will add number according to the quantity to the back of the name.');
});

$(document).ready(function() {
    $('#prefix').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
});

function capitalizeAndLimitTo3() {
    var input = document.getElementById('prefix');
    var value = input.value.toUpperCase(); // Convert to uppercase
    value = value.slice(0, 3); // Limit to 3 characters
    input.value = value;
}

function convertToLowerCase(inputElement) {
    inputElement.value = inputElement.value.toLowerCase();
}

function autoFillPrefix() {
    var categoryInput = document.getElementById('display_name_asset_category');
    var prefixInput = document.getElementById('prefix');

    if (categoryInput.value.length >= 2) {
        prefixInput.value = 'C' + categoryInput.value.substring(0, 2).toUpperCase();
    } else if (categoryInput.value.length === 1) {
        prefixInput.value = 'C' + categoryInput.value.toUpperCase() + 'X';
        // The 'X' or any other letter is added to ensure a minimum length of 3 characters.
    } else {
        prefixInput.value = 'C';
    }
}

function limitInputToRange(inputElement) {
  // Get the min and max values from the input attributes
  const min = parseFloat(inputElement.getAttribute('min'));
  const max = parseFloat(inputElement.getAttribute('max'));

  // Add an event listener to the input element
  inputElement.addEventListener('input', function() {
    // Get the current value of the input
    let inputValue = parseFloat(inputElement.value);

    // Check if the input is a valid number
    if (isNaN(inputValue)) {
      // If not a valid number, set the value to the minimum
      inputElement.value = min;
    } else {
      // If the input is less than the minimum, set it to the minimum
      if (inputValue < min) {
        inputElement.value = min;
      }
      // If the input is greater than the maximum, set it to the maximum
      else if (inputValue > max) {
        inputElement.value = max;
      }
    }
  });
}

function clearSearch() {
    var input = document.getElementById('myInput');
    input.value = '';
    filterFunction(); // Call your filter function after clearing the input

    // Clear related fields and hide the dropdown
    resetRelatedFields();
}

function resetRelatedFields() {
    // Clear the fields you want to reset
    document.getElementById("name").value = "";
    document.getElementById("category").value = "";
    document.getElementById("date_purchase").value = "";
    document.getElementById("price").value = "";
    document.getElementById("branch").value = "";
    document.getElementById("department").value = "";
    document.getElementById("location").value = "";
    document.getElementById("supplier").value = "";
    document.getElementById("computer_brand").value = "";
    document.getElementById("phone_brand").value = "";
    document.getElementById("virtual_machine").value = "";
    document.getElementById("ram").value = "";
    document.getElementById("processor").value = "";
    document.getElementById("graphic_card").value = "";
    document.getElementById("casing").value = "";
    document.getElementById("psu").value = "";
    document.getElementById("motherboard").value = "";

    // Clear the smart search input
    document.getElementById("myInput").value = "";

    // Hide the software specification table
    document.getElementById("software-table").style.display = "none";
}

function filterFunction() {
    var input, filter, div, p, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    p = div.getElementsByTagName("p");

    // Show or hide the dropdown based on the filter
    if (filter === "") {
        div.style.display = "none";
    } else {
        div.style.display = "block";
    }

    for (i = 0; i < p.length; i++) {
        txtValue = p[i].textContent || p[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            p[i].style.display = "";
        } else {
            p[i].style.display = "none";
        }
    }
}

document.getElementById("myInput").addEventListener("input", function(event) {
    var selectedText = event.target.value;
    var selectedItem = findSmartSearchItem(selectedText);

    if (selectedItem) {
        // Call populateFormFields with the selected name
        populateFormFields(selectedItem.item.name, selectedItem.item.category, selectedItem.item.price,  selectedItem.item.processor);
        // Hide the dropdown after selection
        document.getElementById("myDropdown").style.display = "none";
        // Display selected data in the input field
        document.getElementById("myInput").value = selectedText;
    }
});

function populateFormFields(name, category, price, processor, softwareName) {
    $.ajax({
        type: "POST",
        url: "module/computer/get_computer_ajax.php",
        data: { name: name, category: category, price: price, processor: processor, software_name: softwareName },
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#name").val(data["name"]);
                $("#category").val(data["category"]);
                $("#date_purchase").val(data["date_purchase"]);
                $("#price").val(data["price"]);
                $("#branch").val(data["branch"]);
                $("#department").val(data["department"]);
                $("#location").val(data["location"]);
                $("#supplier").val(data["supplier"]);
                $("#computer_brand").val(data["computer_brand"]);
                $("#phone_brand").val(data["phone_brand"]);
                $("#virtual_machine").val(data["virtual_machine"]);
                $("#ram").val(data["ram"]);
                $("#processor").val(data["processor"]);
                $("#graphic_card").val(data["graphic_card"]);
                $("#casing").val(data["casing"]);
                $("#psu").val(data["psu"]);
                $("#motherboard").val(data["motherboard"]);

                var categoryInput = document.getElementById("category");
                var category = categoryInput.value.toLowerCase().trim(); // Clean the input

                var computerBrandDiv = document.getElementById("computer_brand_div");
                var phoneBrandDiv = document.getElementById("phone_brand_div");
                var virtualMachineDiv = document.getElementById("virtual_machine_div");

                // Check the selected category and toggle visibility
                if (category === "smartphone" || category === "tablet") {
                    computerBrandDiv.style.display = "none";
                    phoneBrandDiv.style.display = "block";
                    virtualMachineDiv.style.display = "none";
                } else if (category === "desktop" || category === "laptop" || category === "server") {
                    computerBrandDiv.style.display = "block";
                    phoneBrandDiv.style.display = "none";
                    virtualMachineDiv.style.display = "none";
                } else if (category === "virtual machine") {
                    computerBrandDiv.style.display = "none";
                    phoneBrandDiv.style.display = "none";
                    virtualMachineDiv.style.display = "block";
                } else {
                    computerBrandDiv.style.display = "block";
                    phoneBrandDiv.style.display = "block";
                    virtualMachineDiv.style.display = "block";
                }

                // Set the selected data in the smart search input
                document.getElementById("myInput").value = name + ' - ' + category + ' - ' + price + ' - ' + processor + ' - ' + softwareName;
                // Hide the dropdown after selection
                document.getElementById("myDropdown").style.display = "none";

            } catch (e) {
                // Handle any errors or clear the fields as needed
                $("#name").val("");
                $("#category").val("");
                $("#date_purchase").val("");
                $("#price").val("");
                $("#branch").val("");
                $("#department").val("");
                $("#location").val("");
                $("#supplier").val("");
                $("#computer_brand").val("");
                $("#phone_brand").val("");
                $("#virtual_machine").val("");
                $("#ram").val("");
                $("#processor").val("");
                $("#graphic_card").val("");
                $("#casing").val("");
                $("#psu").val("");
                $("#motherboard").val("");
                // Clear other form fields here

                // Set the selected data in the smart search input
                document.getElementById("myInput").value = name + ' - ' + category + ' - ' + price + ' - ' + processor + ' - ' + softwareName;
                // Hide the dropdown after selection
                document.getElementById("myDropdown").style.display = "none";
            }
        }
    });
}

function getAssetTagFromSmartSearch(name) {
   var smartSearchs = <?php echo json_encode($smartSearchs); ?>;
   for (var i = 0; i < smartSearchs.length; i++) {
      var item = smartSearchs[i];
      if (item.name === name) {
         return item.assetTag;
      }
   }
   return null;
}

function findSmartSearchItem(selectedText) {
    var smartSearchs = <?php echo json_encode($smartSearchs); ?>;
    for (var i = 0; i < smartSearchs.length; i++) {
        var item = smartSearchs[i];
        var itemText = item.name + ' - ' + item.category + ' - ' + item.price + ' - ' + item.processor;
        if (itemText === selectedText) {
            return { index: i, item: item };
        }
    }
    return null;
}


 function toggleBrands() {
    var categoryInput = document.getElementById("category");
    var category = categoryInput.value.toLowerCase().trim(); // Clean the input

    var computerBrandDiv = document.getElementById("computer_brand_div");
    var phoneBrandDiv = document.getElementById("phone_brand_div");
    var virtualMachineDiv = document.getElementById("virtual_machine_div");

    // Check the selected category and toggle visibility
    if (category === "smartphone" || category === "tablet") {
        computerBrandDiv.style.display = "none";
        phoneBrandDiv.style.display = "block";
        virtualMachineDiv.style.display = "none";
    } else if (category === "desktop" || category === "laptop" || category === "server") {
        computerBrandDiv.style.display = "block";
        phoneBrandDiv.style.display = "none";
        virtualMachineDiv.style.display = "none";
    } else if (category === "virtual machine") {
        computerBrandDiv.style.display = "none";
        phoneBrandDiv.style.display = "none";
        virtualMachineDiv.style.display = "block";
    } else {
        computerBrandDiv.style.display = "block";
        phoneBrandDiv.style.display = "block";
        virtualMachineDiv.style.display = "block";
    }
}


// Add an event listener to the checkbox to toggle the display of warranty fields
document.getElementById('warranty_checkbox').addEventListener('change', function() {
    var warrantyFields = document.querySelectorAll('.warranty-fields');
    warrantyFields.forEach(function(field) {
        field.style.display = this.checked ? 'block' : 'none';
    }, this);
});

document.getElementById('user_checkbox').addEventListener('change', function() {
    var userFields = document.querySelectorAll('.user-fields');
    userFields.forEach(function(field) {
        // Set the display style based on the checkbox state
        field.style.display = this.checked ? 'block' : 'none';

        // Update values when checkbox is checked
        if (this.checked) {
            // Update input values
            var inputs = field.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.value = ''; // Clear the input value
            });
        } else {
            // Update input values to 'no_user' when checkbox is unchecked
            var inputs = field.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.value = 'NO USER'; // Set input value to 'no_user'
            });
        }
    }, this);
});

// submit using ajax
$('form').submit(function(e){
        e.preventDefault();

        // Disable the submit button to prevent multiple submissions
        $('button[type="submit"]').prop('disabled', true);
        
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
                        text: 'Computer added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = './addcomputer';
                    });
                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 15000
                    }).then(function() {
                        window.location.href = './addcomputer';
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
    // Show the modal when "Add New Brand" is selected
    $('#software_category').change(function () {
        var selectedValue = $(this).val();
        if (selectedValue === 'Add New Software Category') {
            $('#addCategoryModal').modal('show');
            $(this).val(''); // Clear the input field after opening the modal
        }
    });

    // Handling the "Add New Brand" option
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
            url: './module/setting/preset_location/location/addlocation_action.php',
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
            url: './module/setting/preset_location/department/adddepartment_action.php',
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

                        // Update the nameList in addLocationModal
                        updateNameList();

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

    // Function to update sectionList in addDepartmentModal
    function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/asset/get_department_names.php',
            success: function(response) {
                // Update the sectionList with the new categories
                $('#sectionList').html(response);
            },
            error: function(error) {
                console.log('Error fetching department names: ' + error);
            }
        });
    }
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
            url: './module/setting/preset_location/branch/addbranch_action.php',
            type: 'POST',
            data: formData,
            success: function(response) {
                console.log(response);
                if (response.includes("Branch added successfully")) {
                    // Success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Branch added successfully!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        // Add the new branch to the dropdown list
                        var newBranchName = $('#display_name').val();
                        $('#branchList').append('<option value="' + newBranchName + '">' + newBranchName + '</option>');

                        // Optionally, you can select the newly added branch
                        $('#branch').val(newBranchName);

                        // Close the modal
                        $('#addBranchModal').modal('hide');

                        // Update the nameList in addDepartmentModal
                        updateNameList();
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

    // Function to update buildingList in addDepartmentModal
    function updateNameList() {
        $.ajax({
            type: 'POST',
            url: './module/asset/get_branch_names.php',
            success: function(response) {
                // Update the buildingList with the new categories
                $('#buildingList').html(response);
            },
            error: function(error) {
                console.log('Error fetching branch names: ' + error);
            }
        });
    }
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

function createSoftware() {
    var table = document.getElementById("software-table");
    var row = document.createElement('tr');
    var rowIndex = table.rows.length; // Get the current row index

    // Clone the original datalist and set a new ID for the cloned datalist
    var originalDatalist = document.getElementById('softwareList');
    var clonedDatalist = originalDatalist.cloneNode(true);
    clonedDatalist.id = 'softwareList' + rowIndex;

    row.innerHTML = `
        <td>
            <input list="softwareList${rowIndex}" name="software_category[]" class="form-control software-category software-modal-trigger">
        </td>
        <td><input type="text" name="software_brand[]" class="form-control"></td>
        <td><input type="text" name="software_name[]" class="form-control"></td>
        <td><input type="text" name="license_key[]" class="form-control"></td>
        <td><input type="date" name="expiry_date[]" class="form-control"></td>
        <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteSoftware(this)">Delete</button></td>
    `;

    // Append the cloned datalist to the new row
    row.querySelector('.software-category').appendChild(clonedDatalist);

    // Attach event listener to the new row's category input
    var categoryInput = row.querySelector('.software-category');
    categoryInput.addEventListener('change', function () {
        var selectedValue = this.value;
        if (selectedValue === 'Add New Software Category') {
            openAddCategoryModal(rowIndex);
            // Clear the input field after opening the modal
            this.value = '';
        } else {
            // If a category is selected, fetch and update the options of the datalist
            fetchAndUpdateDatalistOptions(rowIndex, selectedValue);
        }
    });

    table.appendChild(row);
}

// Function to fetch and update options of the datalist dynamically
function fetchAndUpdateDatalistOptions(rowIndex, selectedCategory) {
    // Assuming you have a PHP script to fetch software categories based on the selectedCategory
    // Adjust the URL and data according to your backend implementation
    $.ajax({
        url: "module/computer/fetch_categories.php",
        type: 'POST',
        data: { selectedCategory: selectedCategory },
        success: function(response) {
            try {
                var softwareCategories = JSON.parse(response);

                // Update the datalist options in the corresponding row
                var datalist = document.getElementById('softwareList' + rowIndex);
                datalist.innerHTML = ''; // Clear existing options

                // Add the default "Select Category" option
                var defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = 'Select Category';
                datalist.appendChild(defaultOption);

                // Add options based on the fetched categories
                softwareCategories.forEach(function(category) {
                    var option = document.createElement('option');
                    option.value = category.display_name;
                    option.textContent = category.display_name;
                    datalist.appendChild(option);
                });

                // Add the "Add New Software Category" option if the selected category is "Add New Software Category"
                if (selectedCategory === 'Add New Software Category') {
                    var addNewOption = document.createElement('option');
                    addNewOption.value = 'Add New Software Category';
                    addNewOption.setAttribute('data-action', 'addNewSoftwareCategory');
                    addNewOption.textContent = 'Add New Software Category';
                    datalist.appendChild(addNewOption);
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', status, error);
        }
    });
}

function openAddCategoryModal(rowIndex) {
    // You can use this function to open the modal
    $('#addCategoryModal').modal('show');
    // Optionally, you can set a data attribute to identify the current row index
    $('#addCategoryModal').data('currentRowIndex', rowIndex);
}

// Function to delete a row from the table
function deleteSoftware(input) {
    document.getElementById('software-table').removeChild(input.parentNode.parentNode);
}

// Event listener for the default row's category input
$('#software_category').change(function() {
    var selectedValue = $(this).val();
    if (selectedValue === 'Add New Software Category') {
        $('#addCategoryModal').modal('show');
    }
});

function createUser() {
    var table = document.getElementById("user-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <td><input type="text" name="username[]" value = "NO USER" class="form-control"></td>
            <td><input type="text" name="password[]" value = "NO USER" class="form-control"></td>
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


function createRemoteAccess() {
    var table = document.getElementById("remote_access-table");
    var row = document.createElement('tr');
    var rowIndex = table.rows.length; // Get the current row index

    row.innerHTML = `
        <tr>
            <td>
            <input list="remoteAccesslist${rowIndex}" name="remote_name[]" class="form-control remote_name remote_access-modal-trigger">
                <datalist id="remoteAccesslist${rowIndex}" data-category>
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
                     <option value="Add New Preset" data-action="addNewPreset">Add New Preset</option>
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

    // Attach event listener to the new row's category input
    var categoryInput = row.querySelector('.remote_name');
    categoryInput.addEventListener('change', function() {
        var selectedValue = this.value;
        if (selectedValue === 'Add New Preset') {
            openAddRemoteAccessModal(rowIndex);
            // Clear the input field after opening the modal
            this.value = '';
        }
    });
}

    function openAddRemoteAccessModal(rowIndex) {
        // You can use this function to open the modal
        $('#addRemoteAccessModal').modal('show');
        // Optionally, you can set a data attribute to identify the current row index
        $('#addRemoteAccessModal').data('currentRowIndex', rowIndex);
}

function deleteRemoteAccess(input) {
    document.getElementById('remote_access-table').removeChild(input.parentNode.parentNode);
}

// Event listener for the default row's category input
$('#remote_name').change(function() {
    var selectedValue = $(this).val();
    if (selectedValue === 'Add New Preset') {
        $('#addRemoteAccessModal').modal('show');
    }
});

function createHardDrive() {
    var table = document.getElementById("hard_drive-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <td><input type="text" name="hard_disk_name[]" class="form-control" ></td>
            <td>
                <select name="hard_drive[]" id="hard_drive[]" class="form-control" >
                    <option value="SSD">SSD</option>
                    <option value="HDD">HDD</option>
                    <option value="PCI">PCI</option>
                </select>
            </td>
            <td><input type="text" name="brand[]" class="form-control" ></td>
            <td><input type="text" name="storage[]" class="form-control" ></td>
            <td><input type="text" name="purpose[]" class="form-control" ></td>
            <td><input type="date" name="end_warranty_disk[]" class="form-control" ></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deleteHardDrive(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deleteHardDrive(input) {
    document.getElementById('hard_drive-table').removeChild(input.parentNode.parentNode);
}

function createPicture() {
    var table = document.getElementById("picture-table");
    var row = document.createElement('tr');

    row.innerHTML = `
        <tr>
            <td><input type="text" name="view[]" class="form-control" required></td>
            <td><input type="file" id="picture" name="picture[]" accept="image/png, image/jpg, image/webp" class="form-control" required></td>
            <td><button class="btn btn-danger btn-delete-file" type="button" onclick="deletePicture(this)">Delete</button></td>
        </tr>
    `
    table.appendChild(row);
}

function deletePicture(input) {
    document.getElementById('picture-table').removeChild(input.parentNode.parentNode);
}

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

document.getElementById('category').addEventListener('change', function() {
        const selectedCategory = this.value;
        const server_nameContainer = document.getElementById('server_nameContainer');
        const nameList = document.getElementById('server_name');

        if (selectedCategory === 'Virtual Machine') {
            server_nameContainer.style.display = 'block';
            // You can fetch and populate the 'nameList' here if needed.
        } else {
            server_nameContainer.style.display = 'none';
        }
    });

function getStaffDetails(name, contactNoId) {
    $.ajax({
        type: "POST",
        url: "module/people/staff/get_staff_detail_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#" + contactNoId).text(data["contact_no"]);
            } catch (e) {
                $("#" + contactNoId).text("");
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

                // Add "Add New Department" option if it doesn't exist
                if (!$('#departmentList option[value="Add New Department"]').length) {
                    $('#departmentList').append('<option value="Add New Department" data-action="addNewDepartment">Add New Department</option>');
                }
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

                // Add ""Add New Location" option if it doesn't exist
                if (!$('#locationList option[value="Add New Location"]').length) {
                    $('#locationList').append('<option value="Add New Location" data-action="addNewLocation">Add New Location</option>');
                }
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