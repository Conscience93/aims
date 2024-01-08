<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}

include_once 'include/db_connection.php';

// Function to fetch categories from a specified table
function getCategories($con, $tableName) {
    $categories = [];

    $sql = "SELECT category FROM $tableName";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row['category'];
    }

    return $categories;
}
?>

<style>
    .main span {
        height: 2.3rem;
    }

    .modal-backdrop {
        display: none;
    }

    /* Style the "Add Category" button */
    .btn-primary {
        background-color: #007bff; /* Blue background for the button */
        color: #fff; /* White text color */
    }

    /* Style the "Close" button */
    .btn-secondary {
        background-color: #ccc; /* Gray background for the button */
        color: #333; /* Dark text color */
    }

    .dropdown {
        display: inline-block;
        position: relative;
    }

    #myInput {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        width: 300%;
        padding-right: 20px; /* Space for the 'x' button */
    }

    #myDropdown {
        display: none;
        position: absolute;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        max-height: 200px;
        width: 300%;
        overflow-y: auto;
        z-index: 1;
    }

    #myDropdown p {
        padding: 8px;
        margin: 0;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    #myDropdown p:hover {
        background-color: #f1f1f1;
    }

    .input-container {
        position: relative;
        width: 100%;
    }

    .clear-button {
        margin-left:50%;
    }
</style>

<div class="main">
    <form action=".\module\disposal\adddisposal_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Enter Disposed Asset Information</h4>
                    </div>
                    <div class="col-6">
                        <div class="row float-right">
                            <a href="./disposal" class="btn btn-danger">Discard</a>
                            <button type="submit" class="btn btn-primary">Submit</button> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 75vh; overflow-y: scroll;">
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <h4>Data</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="dropdown">
                            <label for="smartSearch"><b>Smart Search</b></label>
                            <div class="input-container">
                                <input type="text" placeholder="Search.." id="myInput" oninput="filterFunction()">
                                <span class="clear-button" onclick="clearSearch()">x</span>
                            </div>
                            <div id="myDropdown" class="dropdown-content" style="display: none;">
                                <?php 
                                $sql_smartSearchs = "SELECT category, asset_tag, name  FROM aims_asset WHERE status = 'ACTIVE'
                                                     UNION
                                                     SELECT category, asset_tag, name  FROM aims_computer WHERE status = 'ACTIVE'
                                                     UNION
                                                     SELECT category, asset_tag, name  FROM aims_electronics WHERE status = 'ACTIVE'";
                                $result_smartSearchs = mysqli_query($con, $sql_smartSearchs);
                                $smartSearchs = [];

                                while ($row_smartSearchs = mysqli_fetch_assoc($result_smartSearchs)) {
                                    $assetTag = $row_smartSearchs['asset_tag'];
                                    // Check if this asset tag is already added
                                    if (!isset($smartSearchs[$assetTag])) {
                                        $smartSearchs[$assetTag] = [
                                            'asset_tag' => $row_smartSearchs['asset_tag'],
                                            'name' => $row_smartSearchs['name'],
                                            'category' => $row_smartSearchs['category'],  
                                        ];
                                    }
                                }

                                foreach ($smartSearchs as $index => $smartSearch) {
                                    ?>
                                    <p id="smartSearchItem_<?php echo $index; ?>" onclick="populateFormFields('<?php echo $smartSearch['asset_tag']; ?>', '<?php echo $smartSearch['name']; ?>', '<?php echo $smartSearch['category']; ?>')">
                                        <?php echo $smartSearch['asset_tag'] . ' - ' . $smartSearch['name'] . ' - ' . $smartSearch['category']; ?>
                                    </p>
                                    <?php
                                }

                                if (empty($smartSearchs)) { ?>
                                    <p>No Selection Found</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <!-- asset_tag -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="asset_tag">Asset Tag</label>
                            <input type="text" id="asset_tag" name="asset_tag" class="form-control" >
                        </div>
                    </div>
                    <!-- name -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" >
                        </div>
                    </div>
                    <!-- category -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="category">Category</label>
                            <input type="text" id="category" name="category" class="form-control" >
                        </div>
                    </div>
                    <!-- expected_date -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="expected_date">Expected Disposal Date</label>
                            <input type="date" id="expected_date" name="expected_date" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- value -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="value">Value (RM)</label>
                            <input type="number" id="value" name="value" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- reason -->
                    <div class="col-4">
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <input type="text" id="reason" name="reason" placeholder="" class="form-control">
                        </div>
                    </div>
                </div>

                <hr>

                <div class ="mb-3">
                    <div class = "row">
                        <div class="col-6">
                            <h4>Disposed To</h4>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <!-- company -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="company">Company/Organization</label>
                            <input type="text" id="company" name="company" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- phone_no -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="phone_no">Company Phone No.</label>
                            <input type="number" id="phone_no" name="phone_no" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- email -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="email">Company Email</label>
                            <input type="text" id="email" name="email" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- pic -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="pic">Person In Charge</label>
                            <input type="text" id="pic" name="pic" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- pic_phone_no -->
                    <div class="col-2">
                        <div class="form-group">
                            <label for="pic_phone_no">Phone No.</label>
                            <input type="text" id="pic_phone_no" name="pic_phone_no" placeholder="" class="form-control">
                        </div>
                    </div>
                    <!-- address -->
                    <div class="col-4">
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" id="address" name="address" placeholder="" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- DISPOSAL MODAL -->
<?php include 'disposal_modal.php' ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

// submit using ajax
$('form').submit(function(e){
        e.preventDefault();

        // Disable the submit button to prevent multiple submissions
        $('button[type="submit"]').prop('disabled', true);
        
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
                        text: 'Asset Disposed successfully!',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        window.location.href = './adddisposal';
                    });
                }else if(response.trim()=="duplicate"){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There is duplicate name! Please try again or use another name.',
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        return false;
                    });
                }else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!' + response,
                        showConfirmButton: false,
                        timer: 20000
                    }).then(function() {
                        window.location.href = './adddisposal';
                    });
                }
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

function clearSearch() {
    var input = document.getElementById('myInput');
    input.value = '';
    filterFunction(); // Call your filter function after clearing the input

    // Clear related fields and hide the dropdown
    resetRelatedFields();
}

function resetRelatedFields() {
    // Clear the fields you want to reset
    document.getElementById("asset_tag").value = "";
    document.getElementById("name").value = "";
    document.getElementById("category").value = "";

    // Clear the smart search input
    document.getElementById("myInput").value = "";
}

function filterFunction() {
    var input, filter, div, p, i;
    input = document.getElementById("myInput");
    filter = input.value.toUpperCase();
    div = document.getElementById("myDropdown");
    p = div.getElementsByTagName("p");

    // Show or hide the dropdown based on the filter
    if (filter === "") {
        div.style.display = "none";
    } else {
        div.style.display = "block";
    }

    for (i = 0; i < p.length; i++) {
        txtValue = p[i].textContent || p[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            p[i].style.display = "";
        } else {
            p[i].style.display = "none";
        }
    }
}

document.getElementById("myInput").addEventListener("input", function (event) {
    var selectedText = event.target.value;
    var selectedItem = findSmartSearchItem(selectedText);

    if (selectedItem) {
        populateFormFields(selectedItem.item.asset_tag, selectedItem.item.name, selectedItem.item.category);
        document.getElementById("myDropdown").style.display = "none";
        document.getElementById("myInput").value = selectedText;
    }
});

function populateFormFields(asset_tag, name, category) {
    $.ajax({
        type: "POST",
        url: "module/disposal/get_all_asset_ajax.php",
        data: { asset_tag: asset_tag, name: name, category: category },
        cache: true,
        success: function (result) {
            try {
                var data = JSON.parse(result);
                $("#asset_tag").val(data["asset_tag"]);
                $("#name").val(data["name"]);
                $("#category").val(data["category"]);
                
                var categoryInput = document.getElementById("category");
                var category = categoryInput.value.toLowerCase().trim(); // Clean the input

                // Set the selected data in the smart search input
                document.getElementById("myInput").value = asset_tag + ' - ' + name + ' - ' + category;
                // Hide the dropdown after selection
                document.getElementById("myDropdown").style.display = "none";

            } catch (e) {
                console.error(e);
                // Handle any errors or clear the fields as needed
                $("#asset_tag").val("");
                $("#name").val("");
                $("#category").val("");
                
                // Set the selected data in the smart search input
                document.getElementById("myInput").value = asset_tag + ' - ' + name + ' - ' + category;
                // Hide the dropdown after selection
                document.getElementById("myDropdown").style.display = "none";
            }
        }
    });
}

function getAssetTagFromSmartSearch(name) {
   var smartSearchs = <?php echo json_encode($smartSearchs); ?>;
   for (var i = 0; i < smartSearchs.length; i++) {
      var item = smartSearchs[i];
      if (item.name === name) {
        return item.asset_tag;
      }
   }
   return null;
}

function findSmartSearchItem(selectedText) {
    var smartSearchs = <?php echo json_encode($smartSearchs); ?>;
    for (var i = 0; i < smartSearchs.length; i++) {
        var item = smartSearchs[i];
        var itemText = item.asset_tag + ' - ' + item.name + ' - ' + item.category;
        if (itemText === selectedText) {
            return { index: i, item: item };
        }
    }
    return null;
}
</script>