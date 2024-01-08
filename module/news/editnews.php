<?php
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

$sql = "SELECT * FROM aims_news where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
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
        <form action=".\module\news\editnews_action.php" method="POST">
        <input id="id" name="id" value="<?php echo $row['id']; ?>" hidden>
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Edit News</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <button type="submit" class="btn btn-primary">Submit</button> 
                            <a href="./news" class="btn btn-danger">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>News Details</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- News Title / Name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">News Title</label>
                            <input type="text" id="name" name="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                        </div>
                    </div>
                    <!-- Category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" class="form-control" value="<?php echo $row['category']; ?>" required>
                        </div>
                    </div>
                    <!-- Publisher -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="publisher">Publisher</label>
                            <input type="text" id="publisher" name="publisher" class="form-control" value="<?php echo $row['publisher']; ?>" required>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- Description -->
                    <div class="col-12">
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" rows="5" placeholder="News Description" class="form-control" required><?php echo $row['description']; ?></textarea>
                        </div>
                    </div>
                </div>

                <br>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="file"><b>File</b></label>
                            <input type="file" id="file" name="file" accept="" class="form-control" />
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

            if (response.trim() === "News added successfully!") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response, // Display the response from the server
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './news';
                });
            } else {
                // Display an error message
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response, // Display the response from the server for debugging
                    showConfirmButton: false,
                    timer: 15000
                }).then(function() {
                    window.location.href = './news';
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