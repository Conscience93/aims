<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
?>

<div class="main">
    <!-- <h2>Add Asset</h2> -->
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Choose Category Transfer</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./transfer" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
            <div class="col-2">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="" selected>Choose Category</option>
                        <option value="asset">Physical Asset</option>
                        <option value="electronics">Electronics</option>
                        <option value="computer">Computer</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#category').on('change', function() {
        var value = $(this).val();
        if (value == 'asset') {
            setTimeout(window.location = '/aims/addtransferasset', 1000);
        } else
        if (value == 'electronics') {
            setTimeout(window.location = '/aims/addtransferelectronics', 1000);
        } else
        if (value == 'computer') {
            setTimeout(window.location = '/aims/addtransfercomputer', 1000);
        } else {
            
        }
    }
);
</script>