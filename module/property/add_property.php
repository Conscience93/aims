<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
?>

<div class="main">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
            <div class="row">
                <div class="col-6">
                    <h4>Choose Category</h4>
                </div>
                <div class="col-6">
                    <div class="row float-right">
                        <a href="./property" class="btn btn-danger">Back</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
            <div class="col-2">
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control">
                        <option value="" selected>Choose Category</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                        <option value="specialized">Specialized</option>
                        <option value="land">Land</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#category').on('change', function () {
            var value = $(this).val();
            if (value == 'residential') {
                window.location.href = '/aims/addresidential';
            } else if (value == 'commercial') {
                window.location.href = '/aims/addcommercial';
            } else if (value == 'specialized') {
                window.location.href = '/aims/addspecialized';
            } else if (value == 'land') {
                window.location.href = '/aims/addland';
            }
        });
    });
</script>