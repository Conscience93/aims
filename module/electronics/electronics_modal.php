<style>
/* Style the modal background */
.modal {
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    margin-top:50px;
}

/* Style the modal content */
.modal-content {
    background-color: #fff; /* White background */
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Box shadow for a slight elevation effect */
    width: 800px;
    max-height: 80vh; /* Adjust the maximum height as needed (e.g., 80% of the viewport height) */
    overflow-y: auto; /* Enable vertical scrolling if the content exceeds the modal height */
}

/* Style the modal header */
.modal-header {
    background-color: #007bff; /* Blue header background */
    color: #fff; /* White text color */
    border-bottom: none; /* Remove the default border */
}

/* Style the close button in the header */
.modal-header .close {
    color: #fff;
}

/* Style the modal title */
.modal-title {
    font-weight: bold;
}

/* Responsive design for smaller screens */
@media (max-width: 768px) {
    .modal-dialog {
        max-width: 90%; /* Adjust the modal width for smaller screens */
    }
}
</style>

<!-- Modal Trigger Button (Hidden) -->
<button type="button" id="openModalBtn" data-toggle="modal" data-target="#importModal" style="display: none;">Open Modal</button>

<!-- Modal -->
<div class="modal" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Download Template Button -->
                <iframe style="display:none;" id="downloadFrame"></iframe>
                <a href="javascript:void(0);" onclick="downloadTemplate()" class="btn btn-info mt-2">Download Template</a>
                <!-- Import Template Button -->
                <input type="file" id="import" name="import" accept=".xlsx" class="form-control" />
            </div>
            <div class="modal-footer">
                <button type="submit" id="importModalAddBtn" class="btn btn-primary green-button">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal for adding a new AssetCategory -->
<form action=".\module\electronics\addelectronics_category_run_no.php" method="POST" id="addAssetCategoryForm">
    <div class="modal fade" id="addAssetCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addAssetCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addAssetCategoryForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAssetCategoryLabel">Add New Electronics Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name_asset_category">Electronics Category Name</label>
                            <input type="text" id="display_name_asset_category" name="display_name" placeholder="" class="form-control" oninput="autoFillPrefix()">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" placeholder="same as electronics category name" class="form-control" oninput="convertToLowerCase(this)">
                        </div>
                        <div class="form-group">
                            <label for="prefix" style="display: flex; align-items: center;">
                                Prefix
                                <img id="prefixInfo" src='./include/action/info.png' alt='Info' title='Will be the Running Number.' width='16' height='16' style="margin-left: 5px;">
                            </label>
                            <div style="display: flex; align-items: center;">
                                <input type="text" id="prefix" name="prefix" placeholder="3 letters" class="form-control" oninput="capitalizeAndLimitTo3()">
                            </div>
                            <div id="prefixError" class="text-danger"></div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addAssetCategoryButton" class="btn btn-primary">Add Electronics Category</button>
                        <div id="successMessage" class="text-success"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new brand -->
<form action=".\module\setting\preset\electronics_brand\add_electronics_brand_action.php" method="POST"  id="addElectronicsBrandForm">
    <div class="modal fade" id="addElectronicsBrandModal" tabindex="-1" role="dialog" aria-labelledby="addElectronicsBrandLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addElectronicsBrandForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addElectronicsBrandLabel">Add New Electronics Brand</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name">Electronics Brand</label>
                            <input type="text" id="display_name_electronics" name="display_name" placeholder="Electronics Brand" class="form-control" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"  id="addElectronicsBrandButton" class="btn btn-primary">Add Electronics Brand</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new department -->
<form action=".\module\setting\preset_location\department\adddepartment_action.php" method="POST" id="addDepartmentForm">
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="addDepartmentLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addDepartmentForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepartmentLabel">Add New Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class ="row">
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="display_name_department">Department Name</label>
                                    <input type="text" id="display_name_department" name="display_name" placeholder="Make sure to add Department at the end" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="noe">No. of employees</label>
                                    <input type="text" id="noe" name="noe" placeholder="Etc 12"  class="form-control">
                                </div>
                            </div>
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="staff_department">Person In Charge</label>
                                    <select name="staff" id="staff_department" class="form-control" autofocus onchange="getStaffDetails(this.value, 'staff_contact_no_department')">
                                        <option value="">Select Staff</option>
                                        <?php 
                                        $sql_staffs = "SELECT * FROM aims_people_staff";
                                        $result_staffs = mysqli_query($con, $sql_staffs);
                                        while ($row_staffs = mysqli_fetch_assoc($result_staffs)) {
                                            $staffs[] = $row_staffs;
                                        }
                                        if ($staffs == []) { ?>
                                            <option value="">No Selection Found</option>
                                        <?php } else
                                        foreach ($staffs as $staff): ?>
                                            <option value="<?php echo $staff['display_name']; ?>"><?php echo $staff['display_name']; ?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                </div>                   
                                <div class="form-group">
                                    <label for="staff_contact_no_department">Contact Number</label>
                                    <span id="staff_contact_no_department" name="staff_contact_no" placeholder="" class="form-control"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addDepartmentButton" class="btn btn-primary">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new location -->
<form action=".\module\setting\preset_location\location\addlocation_action.php" method="POST"  id="addLocationForm">
    <div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog" aria-labelledby="addLocationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addLocationForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addLocationLabel">Add New Location</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name">Location</label>
                            <input type="text" id="display_name_location" name="display_name" placeholder="Location" class="form-control" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"  id="addLocationButton" class="btn btn-primary">Add Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new branch -->
<form action=".\module\setting\preset_location\branch\addbranch_action.php" method="POST" id="addBranchForm">
    <div class="modal fade" id="addBranchModal" tabindex="-1" role="dialog" aria-labelledby="addBranchLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addBranchForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBranchModalLabel">Add New Branch</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class ="row">
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="display_name">Building/Branch</label>
                                    <input type="text" class="form-control" id="display_name" name="display_name" required>
                                </div>
                                <div class="form-group">
                                    <label for="branch_contact_no">Office No.</label>
                                    <input type="number" id="branch_contact_no" name="branch_contact_no"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="branch_email">Office Email</label>
                                    <input type="email" id="branch_email" name="branch_email"  class="form-control">
                                </div>
                            </div>
                            <div class ="col md-6">
                                <div class="form-group">
                                    <label for="pic">Person In Charge</label>
                                    <input type="text" id="pic" name="pic"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="contact_no">Contact No.</label>
                                    <input type="number" id="contact_no" name="contact_no"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea cols="65" rows="4" type="text" id="address" name="address" placeholder="Full Address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addBranchButton" class="btn btn-primary">Add Building/Branch</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>

<!-- Modal for adding a new supplier -->
<form action=".\module\people\supplier\addsupplier_action.php" method="POST" id="addSupplierForm">
    <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addSupplierLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addSupplierForm" >                    <div class="modal-header">
                        <h5 class="modal-title" id="addSupplierLabel">Add New Supplier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class = "row">
                            <div class = "col md-6">
                                <div class="form-group">
                                    <label for="display_name">Supplier</label>
                                    <input type="text" id="display_name_supplier" name="display_name" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="pic">Person in Charge</label>
                                    <input type="text" id="pic" name="pic" class="form-control" >
                                </div>             
                                <div class="form-group">
                                    <label for="contact_no">Company Contact No.</label>
                                    <input type="number" id="contact_no" name="contact_no" class="form-control" >
                                </div>
                            </div>
                            <div class = "col md-6">
                                <div class="form-group">
                                    <label for="email">Company Email</label>
                                    <input type="email" id="email" name="email" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="fax">Fax Number</label>
                                    <input type="number" id="fax" name="fax" class="form-control" >
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <textarea cols="65" rows="4" type="text" id="address" name="address" placeholder="Full Address" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="addSupplierButton" class="btn btn-primary">Add Supplier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</form>
