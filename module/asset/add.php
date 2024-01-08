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
                        <a href="./asset" class="btn btn-danger">Back</a>
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
            if (value == 'fixed-asset') {
                window.location.href = '/aims/addasset';
            } else if (value == 'electronics') {
                window.location.href = '/aims/addelectronics';
            } else if (value == 'computer') {
                window.location.href = '/aims/addcomputer';
            }
        });

        // Load selected categories from localStorage and update options
        const selectedCategories = JSON.parse(localStorage.getItem('selectedCategories') || '[]');
        const selectElement = document.getElementById('category');
        selectedCategories.forEach(category => {
            // Check if the category is not 'reject' or 'disposal' before adding to options
            if (category !== 'reject' && category !== 'disposal' && category !=='property' && category !=='vehicle' && category !=='webpage' && category !=='proprietary' && category !=='licences') {
                const option = document.createElement('option');
                option.value = category;
                option.textContent = category;
                selectElement.appendChild(option);
            }
        });
    });
</script>