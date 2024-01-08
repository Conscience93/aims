<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}

$sql = "SELECT * FROM aims_software_category where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
textarea {
  resize: none;
}
</style>

<div class="main">
    <h2>Edit Location</h2>
    <form action=".\module\setting\preset\software_category\edit_software_category_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Location ID: <?php echo $row['id']?></h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./preset" class="btn btn-danger">Discard</a>
                            <button type="submit" class="btn btn-primary" style="margin-right: 5px;">Save</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="overflow-y:scroll; overflow-x:hidden;">
                <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <h4>Data</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <!-- Software Category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="display_name">Software Category</label>
                            <input type="text" id="display_name" name="display_name" placeholder="Name" value="<?php echo $row['display_name'];?>" class="form-control">
                        </div>
                    </div>
                </div>
                <hr> 
            </div>
        </div>
    </form>
</div>

<script>
// Submit the form using AJAX
$('form').submit(function(e){
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response){
            // console.log(response);
            if(response.trim()=="true"){
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Category edited successfully!',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function() {
                    window.location.href = './preset?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 5000
                }).then(function() {
                    window.location.href = './edit_software_category?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});

</script>