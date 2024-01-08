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
        <form action=".\module\people\dealership\adddealership_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Add Dealership Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./dealership" class="btn btn-danger">Cancel</a>
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
                                <h4>Dealership Details</h4>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <!-- location bought it from -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="display_name">Dealership</label>
                                <input type="text" id="display_name" name="display_name" class="form-control" >
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="form-group">
                                <label for="pic">Person in Charge</label>
                                <input type="text" id="pic" name="pic" class="form-control" >
                            </div>
                        </div>
                        <!-- phone number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="contact_no">Company Contact No.</label>
                                <input type="number" id="contact_no" name="contact_no" class="form-control" >
                            </div>
                        </div>
                        <!-- company email -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="email">Company Email</label>
                                <input type="email" id="email" name="email" class="form-control" >
                            </div>
                        </div>
                        <!-- company fax number -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="fax">Fax Number</label>
                                <input type="number" id="fax" name="fax" class="form-control" >
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
        </div>
    </form>
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
                    text:'Dealership added successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './dealership';
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
                    window.location.href = './dealership ';
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