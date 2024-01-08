<style>
    .modal {
    background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
    margin-top:50px;
    }

    /* Style the modal content */
    .modal-content {
        background-color: #fff; /* White background */
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Box shadow for a slight elevation effect */
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
<!-- <button type="button" id="openModalBtn" data-toggle="modal" data-target="#importModal" style="display: none;">Open Modal</button> -->

<!-- Modal for Import -->
<!-- <div class="modal" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"> -->
                <!-- Download Template Button -->
                <!-- <iframe style="display:none;" id="downloadFrame"></iframe>
                <a href="javascript:void(0);" onclick="downloadTemplate()" class="btn btn-info mt-2">Download Template</a> -->
                <!-- Import Template Button -->
                <!-- <input type="file" id="import" name="import" accept=".xlsx" class="form-control" />
            </div>
            <div class="modal-footer">
                <button type="submit" id="importModalAddBtn" class="btn btn-primary green-button">Add</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->

<!-- Modal for adding a new WebpageCategory -->
<form action="./module/intangible/webpage/addwebpage_category_run_no.php" method="POST" enctype="multipart/form-data" id="addWebpageCategoryForm">
    <div class="modal fade" id="addWebpageCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addWebpageCategoryLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addWebpageCategoryForm" >
                    <div class="modal-header">
                        <h5 class="modal-title" id="addWebpageCategoryLabel">Add New Webpage Category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="display_name_asset_category">Webpage Category Name</label>
                            <input type="text" id="display_name_asset_category" name="display_name" placeholder="" class="form-control" oninput="autoFillPrefix()">
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" placeholder="same as asset category name" class="form-control" oninput="convertToLowerCase(this)">
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
                        <button type="button" id="addWebpageCategoryButton" class="btn btn-primary">Add Webpage Category</button>
                        <div id="successMessage" class="text-success"></div>
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
                <form action="javascript:void(0)" method="POST" enctype="multipart/form-data" id="addSupplierForm" >
                    <div class="modal-header">
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
                                    <label for="pic">Person In Charge</label>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    
</script>