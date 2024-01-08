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
</style>

<div class="main">
        <form action=".\module\people\customer\addcustomer_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Customer Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./customer" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
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
                                <h4>Customer Details</h4>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <!-- customer's name -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="display_name">Customer Name</label>
                                <input type="text" id="display_name" name="display_name"  class="form-control">
                            </div>
                        </div>
                        <!-- customer email -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control">
                            </div>
                        </div>
                        <!-- phone number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="contact_no">Contact Number</label>
                                <input type="number" id="contact_no" name="contact_no" class="form-control">
                            </div>
                        </div>
                        <!-- staff's nric -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="nric">NRIC</label>
                                <input type="number" id="nric" name="nric"  class="form-control">
                            </div>
                        </div>
                        <!-- staff's address -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea id="address" name="address" rows="3" placeholder="Customer's Address" class="form-control"></textarea>
                            </div>
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

            if (response.trim() === "Customer details added successfully!") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response, // Display the response from the server
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './customer';
                });
            } else {
                // Display an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response, // Display the response from the server for debugging
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './customer';
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