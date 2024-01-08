<?php 
// $id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['edit'] != 1) {
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = mysqli_query($con, "SELECT * FROM aims_company");
$row = mysqli_fetch_assoc($sql);

// Check if $row is not null before accessing its elements
if ($row) {
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $fax = $row['fax'];
    $address = $row['address'];
} else {
    // Handle the case where $row is null or empty
    $name = $email = $phone = $fax = $address = '';
}
?>

<style>
    textarea {
        resize: none;
    }
</style>

<div class="main">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Company Profile</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./editcompany" class="btn btn-primary float-right">Edit Company Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
            <input id="id" name="id" value="<?php echo $row['id'] ?? ''; ?>" hidden>
            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <h4>Company Details</h4>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <?php
                    if (!empty($row['logo'])) {
                        echo '<img src="' . $row['logo'] . '" alt="Company logo" style="max-width: 100%; max-height: 300px;">';
                    } else {
                        echo 'No logo available.';
                    }
                    ?>
                </div>
            </div>
            </br><div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Company Name</label>
                        <input type="text" id="name" name="name" value="<?php echo $row['name'] ?? ''; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="<?php echo $row['email'] ?? ''; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label for="phone">Contact Number</label>
                        <input type="text" id="phone" name="phone" value="<?php echo $row['phone'] ?? ''; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group">
                        <label for="fax">Fax Number</label>
                        <input type="text" id="fax" name="fax" value="<?php echo $row['fax'] ?? ''; ?>" class="form-control" readonly>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" placeholder="Company's Address" class="form-control" readonly><?php echo $row['address'] ?? ''; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>