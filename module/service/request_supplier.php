<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';
?>

<style>
    .main span {
        height: 2.3rem;
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

    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
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
    <form action="./module/service/request_supplier_action.php" method="POST" id="maintenanceForm">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-3">
                        <h4>Request Service</h4>
                    </div>
                    <div class="col-9">
                        <div class="float-right">
                            <a href="./service_request" class="btn btn-danger">Back</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 80vh; overflow-y: scroll;">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- Search Asset -->
                    <div class="col-2">
                    <div class="form-group">
                        <label for="name">Search Asset</label>
                        <input type="text" id="name" name="name" class="form-control" oninput="searchAsset()" required>
                        <div id="searchResults"></div>
                    </div>

                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <span id="category" name="category" placeholder="" class="form-control" onchange="lol(this.value)"></span>
                            <!-- Hidden input for category -->
                            <input type="hidden" id="hidden_category" name="category">
                        </div>
                    </div>
                    <!-- asset_tag -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="asset_tag">Asset Tag</label>
                            <span id="asset_tag" name="asset_tag" placeholder="" class="form-control"></span>
                        </div>
                    </div>
                    <!-- Type of Maintenance -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control" onchange="lolAndDumpValue(this.value)" required>
                                <option value="">Select Type</option>
                                <?php 
                                $sql_types = "SELECT type, display_name FROM aims_maintenance_type_run_no";
                                $result_types = mysqli_query($con, $sql_types);
                                while ($row_types = mysqli_fetch_assoc($result_types)) {
                                    $types[] = $row_types;
                                }
                                if ($types == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php } else
                                foreach ($types as $type): ?>
                                    <option value="<?php echo $type['type']; ?>"><?php echo $type['display_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <!-- maintenance date -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="maintenance_date">Maintenance Date</label>
                            <input type="date" id="maintenance_date" name="maintenance_date" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- expenses -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="expenses">Expenses</label>
                            <input type="number" id="expenses" name="expenses" placeholder="Price in Ringgit"  class="form-control">
                        </div>
                    </div>
                    <!-- title -->
                    <div class="col-6">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <textarea id="title" name="title" rows="2" placeholder="Who, What & Where?" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="remark">Remark</label>
                            <textarea id="remark" name="remark" rows="2" placeholder="Reason?" class="form-control"></textarea>
                        </div>
                    </div>
                </div>

                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Vendor</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class="col-2">
                        <div class="form-group">
                            <label for="vendors">Vendor</label>
                            <select name="vendors" id="vendors" class="form-control" autofocus oninput = "getVendorsDetails(this.value)">
                                <option value="">Select Supplier</option>
                                <?php 
                                $sql_vendor = "SELECT * FROM aims_people_supplier";
                                $result_vendor = mysqli_query($con, $sql_vendor);
                                while ($row_vendor = mysqli_fetch_assoc($result_vendor)) {
                                    $vendor[] = $row_vendor;
                                } if ($vendor == []) { ?>
                                    <option value="">No Selection Found</option>
                                <?php  } else
                                foreach ($vendor as $vendors): ?>
                                    <option value="<?php echo $vendors['display_name']; ?>"><?php echo $vendors['display_name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label for="pic">Person in Charge</label>
                            <span type="text" id="pic" name="pic" class="form-control" ></span>
                        </div>
                    </div>
                    <!-- phone number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="contact_no">Company Contact No.</label>
                            <span type="number" id="contact_no" name="contact_no" class="form-control" ></span>
                        </div>
                    </div>
                    <!-- company email -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="email">Company Email</label>
                            <span type="email" id="email" name="email" class="form-control" ></span>
                        </div>
                    </div>
                    <!-- company fax number -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="fax">Fax Number</label>
                            <span type="number" id="fax" name="fax" class="form-control" ></span>
                        </div>
                    </div>
                </div>
                
                <br><hr>

                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Upload</h4>
                        </div>
                    </div>
                </div>
                <div class="row mb-5">
                    <!-- maintenance -->
                    <div class="col-3">
                        <div class="form-group">
                            <label for="maintenance">Invoice</label>
                            <input type="file" id="maintenance" name="maintenance" accept="application/pdf, application/msword, application/vnd.ms-excel, image/png, image/jpg, image/webp" class="form-control" />
                        </div>
                    </div>
                    <div class="col-4">
                        <label for="picture">Picture</label><br>
                        <?php
                        if (!empty($row['picture'])) {
                            $fileName = basename($row['picture']);
                            echo '<img id="picture" src="' . $row['picture'] . '" alt="Asset Picture" style="max-width: 100%; max-height: 300px;">';
                        } else {
                            // Add a placeholder image or message when there is no picture
                            echo '<img id="picture" src="path/to/placeholder-image.jpg" alt="No Picture Available" style="max-width: 100%; max-height: 300px;">';
                            // or echo 'No picture available.';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function lolAndDumpValue(type) {
    var expensesInput = $('#expenses');
    if (type === 'without') {
        expensesInput.val('0');
        expensesInput.prop('disabled', true);
    } else {
        expensesInput.val('');
        expensesInput.prop('disabled', false);
    }
}


function searchAsset() {
    var input = document.getElementById('name').value;
    var searchResultsDiv = document.getElementById('searchResults');
    var categorySpan = document.getElementById('category');
    var assetTagSpan = document.getElementById('asset_tag');
    var pictureTagSpan = document.getElementById('picture'); // Add this line

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
                                        categorySpan.textContent = data.category;
                                        assetTagSpan.textContent = data.asset_tag;

                                        // Set the src attribute of the image element
                                        document.getElementById('picture').src = data.picture;

                                       // Also, update the hidden input fields so that they are sent with the form
                                        document.getElementById('hidden_category').value = data.category;
                                        document.getElementById('hidden_asset_tag').value = data.asset_tag;
                                        document.getElementById('hidden_branch').value = data.branch;
                                        document.getElementById('hidden_department').value = data.department;
                                        document.getElementById('hidden_location').value = data.location;
                                        document.getElementById('hidden_picture').value = data.picture;
                                    } else {
                                        // Handle the error
                                        console.error('Error fetching details:', xhrDetails.status, xhrDetails.statusText);
                                    }
                                }
                            };

                            // Assuming the server-side script is named getAssetDetails.php
                            xhrDetails.open('GET', 'module/maintenance/getAssetDetails.php?name=' + selectedAssetName, true);
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
        xhr.open('GET', 'module/service/smart_search.php?name=' + input, true);
        xhr.send();
    } else {
        // Clear the searchResults if the input is empty
        searchResultsDiv.innerHTML = '';
        searchResultsDiv.style.display = 'none'; // Hide the suggestions box

        // Clear the category and asset tag boxes
        categorySpan.textContent = '';
        assetTagSpan.textContent = '';
    }
}

function lol(category) {
    if (category == "computer") {
        var actionUrl = './module/maintenance/' + category + '/add' + category + '_maintenance_action.php';
        $('#maintenanceForm').attr('action', actionUrl);
    }
}

function selectAsset(assetName) {
    $('#name').val(assetName);
    $('#suggestedAssets').html(''); // Clear suggested assets
}

function getVendorsDetails(name){
    $.ajax({
        type: "POST",
        url: "module/people/supplier/get_supplier_details_ajax.php",
        data: "name=" + name,
        cache: true,
        success: function (result) {
            // console.log(result);
            try {
                var data = JSON.parse(result);
                $("#pic").text(data["pic"]);
                $("#contact_no").text(data["contact_no"]);
                $("#email").text(data["email"]);
                $("#fax").text(data["fax"]);
            } catch (e) {
                $("#pic").text("");
                $("#contact_no").text("");
                $("#email").text("");
                $("#fax").text("");
            }
        }
    });
}

// submit using ajax
$('form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this);
    formData.append('asset_tag', $('#asset_tag').text());

    // Manually append expenses value based on the selected type
    var type = $('#type').val();
    if (type === 'without') {
        formData.append('expenses', '0');
    }

    $.ajax({
        url: $(this).attr('action'),
        type: $(this).attr('method'),
        data: formData,
        success: function(response) {
            // console.log(response);
            if (response.trim() == "true") {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Record added successfully!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    window.location.href = './request_supplier';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!' + response,
                    showConfirmButton: false,
                    timer: 200000
                }).then(function() {
                    window.location.href = './request_supplier';
                });
            }
        },
        cache: false,
        contentType: false,
        processData: false
    });
});
</script>