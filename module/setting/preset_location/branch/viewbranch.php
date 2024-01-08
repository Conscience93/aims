<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_preset_computer_branch where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    .modal {
       margin: auto;
    }

	.modal-backdrop {
		display: none;
	}

	.action-button {
		cursor: pointer;
	}

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
    <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Building/Branch Information</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./preset_location" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                    <!-- SMART SEARCH 
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="smart">Smart Search</label>
                                <input type="text" id="" name="" placeholder="" class="form-control">
                            </div>
                        </div>
                    </div> -->

                    <div class ="mb-3">
                        <div class = "row">
                            <div class="col-6">
                                <h4>Data</h4>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-2">
                            <div class="form-group">
                                <label for="display_name">Building/Branch</label>
                                <input type="text" id="display_name" name="display_name"  value="<?php echo $row['display_name'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="branch_contact_no">Office Contact No.</label>
                                <input type="text" id="branch_contact_no" name="branch_contact_no"  value="<?php echo $row['branch_contact_no'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="branch_email">Office Email</label>
                                <input type="email" id="branch_email" name="branch_email"  value="<?php echo $row['branch_email'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="pic">Person In Charge</label>
                                <input type="text" id="pic" name="pic"  value="<?php echo $row['pic'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="contact_no">Contact No.</label>
                                <input type="text" id="contact_no" name="contact_no"  value="<?php echo $row['contact_no'];?>" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address</label></br>
                                <input type="text" id="address" name="address"  value="<?php echo $row['address'];?>" class="form-control" readonly>
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