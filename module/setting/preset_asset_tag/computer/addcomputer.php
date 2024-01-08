<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

?>

<style>
textarea {
  resize: none;
}

.card-body {
  max-height: 650px; /* Adjust the height as needed */
  overflow-y: scroll;
}

</style>

<div class="main">
        <form action=".\module\computer\addcomputer_category_run_no.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add New Computer Category</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./preset_asset_tag" class="btn btn-danger">Discard</a>                            
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>New Computer Category</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="display_name_asset_category">Asset Category Name</label>
                            <input type="text" id="display_name_asset_category" name="display_name" placeholder="" class="form-control" oninput="autoFillPrefix()">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" placeholder="same as asset category name" class="form-control" oninput="convertToLowerCase(this)">
                        </div>
                    </div>
                    <div class="col-4">
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
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

// submit using ajax
$('form').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response){
            // Log the response for debugging
            console.log(response);

            if(response.trim() === "true"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Computer added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './preset_asset_tag';
                });
            } else {
                // Display an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! ' + response, // Display the response from the server for debugging
                    showConfirmButton: false,
                    timer: 150000
                }).then(function() {
                    window.location.href = './addcomputerassettag';
                });
            }
        },
        error: function(xhr, status, error) {
            // Handle AJAX errors here
            console.error(xhr.responseText);
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

$(document).ready(function() {
    $('#prefix').on('input', function() {
        $(this).val($(this).val().toUpperCase());
    });
});

function capitalizeAndLimitTo3() {
    var input = document.getElementById('prefix');
    var value = input.value.toUpperCase(); // Convert to uppercase
    value = value.slice(0, 3); // Limit to 3 characters
    input.value = value;
}

function convertToLowerCase(inputElement) {
    inputElement.value = inputElement.value.toLowerCase();
}

function autoFillPrefix() {
    var categoryInput = document.getElementById('display_name_asset_category');
    var prefixInput = document.getElementById('prefix');

    if (categoryInput.value.length >= 2) {
        prefixInput.value = 'C' + categoryInput.value.substring(0, 2).toUpperCase();
    } else if (categoryInput.value.length === 1) {
        prefixInput.value = 'C' + categoryInput.value.toUpperCase() + 'X';
        // The 'X' or any other letter is added to ensure a minimum length of 3 characters.
    } else {
        prefixInput.value = 'C';
    }
}
</script>