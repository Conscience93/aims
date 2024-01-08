<?php 
// $id = $_SESSION['aims_user_group_id'];
if($submodule_access['asset']['edit']!=1){
    header('location: logout.php');
}
include_once 'include/db_connection.php';

$sql = "SELECT * FROM aims_izzat where id ='".$_GET['id']."'";
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    textarea {
    resize: none;
    }

    span {
        height: 2.3rem;
    }

    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    /* Add this style to your CSS file or within a <style> tag in your HTML */
    .suggested-names {
        list-style-type: none;
        padding: 0;
        margin: 0;
        max-height: 150px; /* Set a fixed height for the suggestion box */
        overflow-y: auto; /* Enable vertical scrolling if there are too many suggestions */
        background-color: #fff; /* Set a background color for the suggestion box */
        border: 1px solid #ccc; /* Add a border for a similar look to a select dropdown */
        border-radius: 4px; /* Optional: Add border-radius for rounded corners */
        position: absolute; /* Set the position to absolute */
        z-index: 1; /* Ensure the suggestion box appears above other elements */
        width: 90%; /* Make the suggestion box full width */
    }

    .suggested-names li {
        padding: 8px;
    }

    .suggested-names a {
        text-decoration: none;
        color: #333;
    }

    .suggested-names a:hover {
        background-color: #f0f0f0; /* Optional: Add a background color on hover */
    }

    /* Add this style to the parent container of the suggestion box */
    .parent-container {
        position: relative;
    }
</style>

<div class="main">
    <form action=".\module\nfc\editnfc_action.php" method="POST">
    <div class="card shadow rounded">
        <div class="card-header" style="background:white;">
        <div class="row">
                    <div class="col-6">
                        <h4>Edit nfc Details</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./nfc" class="btn btn-danger">Cancel</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <input id="id" name="id" value="<?php echo $row['id'];?>" hidden>
                    <div class ="mb-3">
                        <div class = "row">
                            <div class="col-6">
                                <h4>NFC & QR Details</h4>
                            </div>
                        </div>
                    </div>
                    <div class = "row">
                        <!-- nfc -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="nfc_code">NFC Tag</label>
                                <input type="text" id="nfc_code" name="nfc_code" value="<?php echo $row['nfc_code'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- qr -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="qr_code">QR Tag</label>
                                <input type="email" id="qr_code" name="qr_code" value="<?php echo $row['qr_code'];?>" class="form-control" readonly>
                            </div>
                        </div>
                        <!-- name -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input id="name" name="name" value="<?php echo $row['name'];?>" oninput="searchAsset()" class="form-control" >
                                <div id="searchResults"></div>
                            </div>
                        </div>
                        <!-- asset tag -->
                        <div class="col-2">
                            <div class="form-group">
                                <label for="asset_tag">Asset Tag</label>
                                <span id="asset_tag" name="asset_tag" class="form-control"><?php echo $row['asset_tag'];?></span>
                                <!-- Hidden input for category -->
                                <input type="hidden" id="hidden_asset_tag" name="asset_tag">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

function searchAsset() {
    var input = document.getElementById('name').value;
    var searchResultsDiv = document.getElementById('searchResults');
    var assetTagSpan = document.getElementById('asset_tag');

    // Check if the input is not empty
    if (input.trim() !== '') {
        // Make an AJAX request to the server to fetch asset names
        var xhr = new XMLHttpRequest();

        // Handle the state change
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Update the searchResults div with the fetched data
                    searchResultsDiv.innerHTML = xhr.responseText;
                    searchResultsDiv.style.display = 'block'; // Show the suggestions box

                    // Add click event listener to each suggestion
                    var suggestions = searchResultsDiv.getElementsByTagName('li');
                    for (var i = 0; i < suggestions.length; i++) {
                        suggestions[i].addEventListener('click', function() {
                            // Fill in the textbox with the clicked suggestion
                            document.getElementById('name').value = this.textContent;
                            // Hide the suggestions box
                            searchResultsDiv.style.display = 'none';

                            // Make another AJAX request to fetch category and asset tag
                            var selectedAssetName = this.textContent;
                            var xhrDetails = new XMLHttpRequest();
                            xhrDetails.onreadystatechange = function() {
                                if (xhrDetails.readyState === 4) {
                                    if (xhrDetails.status === 200) {
                                        // Update the category and asset tag spans with the fetched data
                                        var data = JSON.parse(xhrDetails.responseText);
                                        console.log(xhrDetails.responseText); // Add this line to check the response
                                        assetTagSpan.textContent = data.asset_tag;
                                        // Also, update the hidden input fields so that they are sent with the form
                                        document.getElementById('hidden_asset_tag').value = data.asset_tag;
                                    } else {
                                        // Handle the error
                                        console.error('Error fetching details:', xhrDetails.status, xhrDetails.statusText);
                                    }
                                }
                            };

                            // Assuming the server-side script is named getAssetDetails.php
                            xhrDetails.open('GET', 'module/nfc/getAssetDetails.php?name=' + selectedAssetName, true);
                            xhrDetails.send();
                        });
                    }
                } else {
                    // Handle the error (e.g., display an error message)
                    console.error('Error fetching data:', xhr.status, xhr.statusText);
                }
            }
        };

        // Assuming the server-side script is named searchAsset.php
        xhr.open('GET', 'module/nfc/smart_search.php?name=' + input, true);
        xhr.send();
    } else {
        // Clear the searchResults if the input is empty
        searchResultsDiv.innerHTML = '';
        searchResultsDiv.style.display = 'none'; // Hide the suggestions box
        assetTagSpan.textContent = '';
    }
}

// submit using ajax
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
                    text: 'Tag edited successfully!',
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = './nfc?id=<?php echo $row["id"];?>';
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 1500000
                }).then(function() {
                    window.location.href = './nfc?id=<?php echo $row["id"];?>';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>