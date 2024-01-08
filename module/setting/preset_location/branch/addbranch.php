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
        <form action=".\module\setting\preset_location\branch\addbranch_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add New Building/Branch</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./preset_location" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>New Building/Branch</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="display_name">Building/Branch</label>
                            <input type="text" id="display_name" name="display_name"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch_contact_no">Office No.</label>
                            <input type="number" id="branch_contact_no" name="branch_contact_no"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="branch_email">Office Email</label>
                            <input type="email" id="branch_email" name="branch_email"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="pic">Person In Charge</label>
                            <input type="text" id="pic" name="pic"  class="form-control">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="contact_no">Contact No.</label>
                            <input type="number" id="contact_no" name="contact_no"  class="form-control">
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea cols="65" rows="4" type="text" id="address" name="address" placeholder="Full Address" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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

            if (response.includes("Branch added successfully")) { // Check for success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response, // Display the success message
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './addbranch';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong! ' + response,
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './addbranch';
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