<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
?>

<div class="main">
    <!-- <h2>Add News</h2> -->
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Choose Category</h4>
                </div>
                <div class="col-6">
                    <div class="float-right">
                        <a href="./news" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height: 75vh; overflow-y: scroll;">
            <div class="col-2">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="" selected>Choose News</option>
                        <option value="news">News</option>
                        <option value="updates">Updates</option>
                        <option value="advertisement">Advertisement</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$('#category').on('change', function() {
        var value = $(this).val();
        if (value == 'news') {
            setTimeout(window.location = '/aims/addnews', 1000);
        } else
        if (value == 'updates') {
            setTimeout(window.location = '/aims/addupdates', 1000);
        } else
        if (value == 'advertisement') {
            setTimeout(window.location = '/aims/addadvertisement', 1000);
        } else
        if (value == 'other') {
            setTimeout(window.location = '/aims/addother', 1000);
        } else {
            
        }
    }
);
</script>