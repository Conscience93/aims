<style>
/* Style the modal background */
.modal {
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    margin-top: 50px;
}

/* Style the modal content */
.modal-content {
    background-color: #fff; /* White background */
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Box shadow for a slight elevation effect */
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

<!-- Modal for adding a new PropertyCategory -->
<form action=".\module\property\addproperty_category_run_no.php" method="POST" id="addPropertyCategoryForm">
    <div class="modal fade" id="addPropertyCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addPropertyCategoryForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPropertyCategoryLabel">Add New Property Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name_property_category">Property Category Name</label>
                            <input type="text" id="display_name_property_category" name="display_name" placeholder="" class="form-control" oninput="autoFillPrefix()"> 
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" placeholder="same as property category name"  class="form-control" oninput="convertToLowerCase(this)">
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
                        <button type="button" id="addPropertyCategoryButton" class="btn btn-primary">Add Property Category</button>
                        <div id="successMessage" class="text-success"></div>
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