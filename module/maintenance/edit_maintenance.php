<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_maintenance where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);

// Query for the picture based on asset tag from another table (assuming the table is aims_asset)
$assetTag = mysqli_real_escape_string($con, $row['asset_tag']);
$sql2 = "SELECT picture FROM aims_all_asset_picture WHERE asset_tag ='$assetTag'";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_assoc($result2);
?>

<style>
.main span {
    height: 2.3rem;
}

form .btn-delete-file {
    width: 75px !important;
}

.row .float-right {
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
</style>

<div class="main">
    <form action=".\module\maintenance\edit_maintenance_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Edit Data: <?php echo $row['asset_tag']?></h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./maintenance" class="btn btn-danger">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save</button> 
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
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" placeholder="Name" value="<?php echo $row['name'];?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input id="category" name="category" value="<?php echo $row['category'];?>" class="form-control" readonly>
                        </div>
                    </div>
                    <!-- asset_tag -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="asset_tag">Asset Tag</label>
                            <input id="asset_tag" name="asset_tag" value="<?php echo $row['asset_tag'];?>"  class="form-control" readonly>
                        </div>
                    </div>
                    <!-- Type of Maintenance -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" onchange="lolAndDumpValue(this.value)">
                                <option value="">Select Type</option>
                                <?php 
                                $sql_types = "SELECT type, display_name FROM aims_maintenance_type_run_no";
                                $result_types = mysqli_query($con, $sql_types);
                                while ($row_types = mysqli_fetch_assoc($result_types)) {
                                    $selected = ($row['type'] == $row_types['type']) ? 'selected' : '';
                                    echo "<option value='{$row_types['type']}' $selected>{$row_types['display_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <!-- maintenance date -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="maintenance_date">Maintenance Date</label>
                            <input type="date" id="maintenance_date" name="maintenance_date"value="<?php echo $row['maintenance_date'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- expenses -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="expenses">Expenses</label>
                            <input type="number" id="expenses" name="expenses" placeholder="Price in Ringgit" value="<?php echo $row['expenses'];?>" class="form-control">
                        </div>
                    </div>
                    <!-- title -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <textarea id="title" name="title" rows="2" placeholder="Who, What & Where?" class="form-control"><?php echo $row['title'];?></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea id="remark" name="remark" rows="2" placeholder="Reason?" class="form-control"><?php echo $row['remark'];?></textarea>
                        </div>
                    </div>
                </div>   

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Vendor</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="vendors">Vendor</label>
                            <select name="vendors" id="vendors" class="form-control" autofocus oninput = "getVendorsDetails(this.value)" >
                                <option value="">Select Supplier</option>
                                <?php 
                                $sql_vendor = "SELECT * FROM aims_people_supplier";
                                $result_vendor = mysqli_query($con, $sql_vendor);
                                while ($row_vendor = mysqli_fetch_assoc($result_vendor)) {
                                    $vendor[] = $row_vendor;
                                } if ($vendor == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php  } else
                                foreach ($vendor as $vendors): ?>
                                    <option value="<?php echo $vendors['display_name']; ?>" <?php if($row['vendors'] == $vendors['display_name']) {echo 'selected';} ?>><?php echo $vendors['display_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="pic">Person in Charge</label>
                            <span type="text" id="pic" name="pic" class="form-control" ></span>
                        </div>
                    </div>
                    <!-- phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="contact_no">Company Contact No.</label>
                            <span type="number" id="contact_no" name="contact_no" class="form-control" ></span>
                        </div>
                    </div>
                    <!-- company email -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="email">Company Email</label>
                            <span type="email" id="email" name="email" class="form-control" ></span>
                        </div>
                    </div>
                    <!-- company fax number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="fax">Fax Number</label>
                            <span type="number" id="fax" name="fax" class="form-control" ></span>
                        </div>
                    </div>
                </div>
                    
                <br><hr>

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Files</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <!-- maintenance -->    
                    <div class="col-3">
                        <div class="form-group">
                            <label for="maintenance">Invoice</label></br>
                            <?php
                            if (!empty($row['maintenance'])) {
                                $fileName = basename($row['maintenance']);
                                echo '<div class="md-3 form-control"><a href="' . $row['maintenance'] . '" target="_blank">' . $fileName . '</a></div>';
                                echo '<br>';
                                echo 
                                '<form id="delete-maintenance-form" action="./module/maintenance/deletefile_maintenance_action method="POST">
                                    <input type="hidden" name="fileType" value="maintenance">
                                    <input type="hidden" name="id" value="'.$row['id'].'">
                                    <button class="btn btn-danger btn-delete-file" type="button" form="delete-maintenance-form" onclick="confirmDeleteFile('.$row['id'].',\'maintenance\')">Delete</button>
                                </form>';
                            } else {
                                echo '<input type="file" id="maintenance" name="maintenance" accept="" value="" class="form-control" />';
                            }
                            ?>
                        </div>
                    </div>
                    <!-- picture -->
                    <div class="col-4">
                        <label for="picture">Picture</label><br>
                        <?php
                            if (!empty($row2['picture'])) {
                                $fileName = basename($row2['picture']);
                                echo '<img src="' . $row2['picture'] . '" alt="Picture" style="max-width: 100%; max-height: 300px;">'; // Display the picture from another table
                            } else {
                                echo 'No picture available.';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function getVendorsDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/supplier/get_supplier_details_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#pic").text(data["pic"]);
                $("#contact_no").text(data["contact_no"]);
                $("#email").text(data["email"]);
                $("#fax").text(data["fax"]);
            } catch (e) {
                $("#pic").text("");
                $("#contact_no").text("");
                $("#email").text("");
                $("#fax").text("");
            }
        }
    });
}

$(document).ready(function() {
    // Trigger the change event on 'type' select element to initialize 'expenses' field
    $('#type').trigger('change');
});

// Add an event listener to the 'type' select element
$('#type').change(function() {
    var selectedType = $(this).val();
    var expensesInput = $('#expenses');

    // Check if the selected type is 'without'
    if (selectedType === 'without') {
        // Set expenses to 0 and make it readonly
        expensesInput.val('0').attr('readonly', true);
    } else {
        // Clear expenses and allow editing
        expensesInput.val('0').removeAttr('readonly');
    }
});



// submit using ajax
$('form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response) {
            // console.log(response);
            if (response.trim() == "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Record edited successfully!' + response,
                    showConfirmButton: false,
                    timer: 1500000
                }).then(function() {
                    window.location.href = './maintenance';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './edit_maintenance?asset=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
            
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
    console.log('Delete button clicked. ID:', id, 'File Type:', fileType);
    $.ajax({
        url: "./module/maintenance/deletefile_maintenance_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id, fileType: fileType}, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The file has been deleted.',
                showConfirmButton: false,
                timer: 2000000
            }).then(function() {
                window.location.href = './edit_maintenance?id=' + id;
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the file.' + response,
                showConfirmButton: true,
                timer: 2000000
            }).then(function() {
                window.location.href = './edit_maintenance?id=' + id;
            });
        }
    });
}
</script>