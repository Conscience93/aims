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
        <form action=".\module\setting\preset\phone_brand\add_phone_brand_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add New Brand</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./preset" class="btn btn-danger">Discard</a>
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>New Brand</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="display_name">Smartphone/Tablet Brand</label>
                            <input type="text" id="display_name" name="display_name"  class="form-control">
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
                    text: 'Brand added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './preset';
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
                    window.location.href = './add_phone_brand';
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


</script>