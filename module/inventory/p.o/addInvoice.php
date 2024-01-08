<?php 
$user_group_id = $_SESSION['aims_user_group_id'];
if ($submodule_access['asset']['add']!=1) {
    header('location: logout.php');
}
?>

<style>
    .row .float-right {
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .main span {
        height: 2.3rem;
    }

    .modal-backdrop {
        display: none;
    }

    /* Style the modal background */
    .modal {
        background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black background */
        margin-top: 50px;
    }

    /* Style the modal content */
    .modal-content {
        background-color: #fff; /* White background */
        border-radius: 5px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2); /* Box shadow for a slight elevation effect */
        max-height: 80vh; /* Adjust the maximum height as needed (e.g., 80% of the viewport height) */
        overflow-y: auto; /* Enable vertical scrolling if the content exceeds the modal height */
    }

    /* Style the modal header */
    .modal-header {
        background-color: #007bff; /* Blue header background */
        color: #fff; /* White text color */
        border-bottom: none; /* Remove the default border */
    }

    /* Style the close button in the header */
    .modal-header .close {
        color: #fff;
    }

    /* Style the modal title */
    .modal-title {
        font-weight: bold;
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

    #myInput {
        padding-right: 20px; /* Space for the 'x' button */
    }

    .clear-button {
        position: absolute;
        top: 50%;
        left: 290%;
        right: 8px; /* Adjust the distance from the right edge */
        transform: translateY(-50%);
        cursor: pointer;
        color: #888; /* Color of the 'x' button */
        font-weight: bold;
        font-size: 20px;
    }

    .input-container {
        position: relative;
        width: 100%;
        }

    /* Responsive design for smaller screens */
    @media (max-width: 768px) {
        .modal-dialog {
            max-width: 90%; /* Adjust the modal width for smaller screens */
        }
    }

    /* Sticky Header */
	.sticky-header {
		position: sticky;
		top: 0;
		background-color: #f5f5f5;
	}

     /* Table Styles */
	#tbl-invoice-item {
		border-collapse: separate;
		border-spacing: 0;
		width: 100%;
		margin-bottom: 20px;
		border-top: 1px solid #ccc;
		border-right: 1px solid #ccc;
		/* font-family: Arial, sans-serif; */
	}

	#tbl-invoice-item th, #tbl-invoice-item td {
		border-bottom: 1px solid #ccc;
		border-left: 1px solid #ccc;
		padding: 5px;
		text-align: center;
	}

    /* CSS for Autocomplete Dropdown */
    .ui-autocomplete {
        list-style-type: none; /* Remove list-style (bullets/numbers) */
        background-color: white; /* Set the background color to white */
        border: 1px solid #ccc; /* Add a border (optional) */
        padding: 0; /* Remove padding (optional) */
        max-height: 200px; /* Set a maximum height to limit the dropdown size (optional) */
        overflow-y: auto; /* Enable vertical scrolling if the dropdown exceeds max-height (optional) */
        width: fit-content;
    }

    /* CSS for Autocomplete List Items */
    .ui-autocomplete li {
        padding: 5px; /* Add padding to each list item (optional) */
        border-bottom: 1px solid #ccc; /* Add a bottom border to separate items (optional) */
    }

    /* CSS for Autocomplete Selected Item (optional) */
    .ui-autocomplete .ui-state-focus {
        background-color: #f0f0f0; /* Customize the background color of the selected item (optional) */
    }

    .btn.delete {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .btn.delete img {
        max-width: 100%;
        max-height: 100%;
    }

    .btn.add {
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
    }

    .btn.add img {
        max-width: 100%;
        max-height: 100%;
    }
</style>

<div class="main">
    <form action=".\module\inventory\p.o\addInvoice_action.php" method="POST">
        <div class="card shadow rounded">
            <div class="card-header" style="background:white;">
                <div class="row">
                    <div class="col-6">
                        <h4>Enter Purchase Invoice Information</h4>
                    </div>
                    <div class="col-6">
                        <div class="float-right">
                            <a href="./p.o" class="btn btn-danger">Discard</a>
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

                <div class="row">
                    <!-- stock -->
                    <div class="col-3">
                        <div class="form-group">
                        <label for="supplier">Supplier</label>
                            <input list="supplierList" name="supplier" id="supplier" class="form-control" autofocus oninput = "getSupplierDetails(this.value)">
                                <datalist id="supplierList">    
                                    <option value="">Select Supplier</option>
                                    <?php 
                                    $sql_suppliers = "SELECT * FROM aims_people_supplier";
                                    $result_suppliers = mysqli_query($con, $sql_suppliers);
                                    $suppliers=[];
                                    while ($row_suppliers = mysqli_fetch_assoc($result_suppliers)) {
                                        $suppliers[] = $row_suppliers;
                                    } if ($suppliers == []) { ?>
                                        <option value="">No Selection Found</option>
                                    <?php  } else
                                    foreach ($suppliers as $supplier): ?>
                                        <option value="<?php echo $supplier['display_name']; ?>"><?php echo $supplier['display_name']; ?></option>
                                    <?php endforeach; ?>
                                    <option value="Add New Supplier" data-action="addNewSupplier">Add New Supplier</option>
                                <datalist id="supplierList">
                            </select>
                        </div>
                    </div>
                </div>    

                <div class="row">
                    <div class="col-3">
                        <div class="form-group">
                            <label for="invoice_date">Invoice Date</label>
                            <input type="date" id="invoice_date" name="invoice_date" class="form-control">
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-3">
                        <label for="invoice_amount">Invoice Amount Exc. Tax</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">RM</span>
                            </div>
                            <input type="number" class="form-control" id="invoice_amount" name="invoice_amount" min="0.00" value="0.00" required readonly>
                        </div>
                    </div>

                    <div class="col-3">
                        <label for="invoice_amount_with_tax">Invoice Amount Inc. Tax</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">RM</span>
                            </div>
                            <input type="number" class="form-control" id="invoice_amount_with_tax" name="invoice_amount_with_tax" min="0.00" value="0.00" required readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" style="display: flex; justify-content: flex-end; align-items: center;">
                        <button type="button" id="btnAddItem" class="btn btn-primary" onclick="addItem();">Add item</button>
                    </div>
                </div>

                <div class="table-container">
                    <table id="tbl-invoice-item" style="width:100%; overflow-y:auto;">
                        <thead class="sticky-header">
                            <tr>
                                <th width="5%">No.</th>
                                <th width="10%">Stock Code</th>
                                <th width="10%">Item Code</th>
                                <th width="20%">Description</th>
                                <th width="5%">Qty</th>
                                <th width="10%">Unit Price (RM)</th>
                                <th width="5%">Tax</th>
                                <th width="10%">Subtotal</th>
                                <th width="6%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var count=0;
    function addItem() {
        count = count+1;
        let tbody = $('#tbl-invoice-item tbody');
        let rowCount = tbody.children().length;

        let html = `<tr>
                        <td>${rowCount + 1}</td>
                        <td><input type="text" class="form-control" name="stock_code[]" id='stock_code_${count}'></td>
                        <td><input type="text" class="form-control" name="item_code[]" id='item_code_${count}'></td>
                        <td><input type="text" class="form-control" name="description[]" id='description_${count}'></td>
                        <td><input type="number" class="form-control" name="qty[]" min="1" value="1" id='qty_${count}' onchange = "cal_item_subtotal(${count})"></td>
                        <td><input type="number" class="form-control" name="unit_price[]" step="0.01" id='unit_price_${count}' onchange = "cal_item_subtotal(${count})"></td>
                        <td style="display: none"><input type="number" class="form-control" name="item_tax_percentage[]" step="0.01" id='item_tax_percentage_${count}'</td>
                        <td><input type="number" class="form-control" name="item_tax[]" step="0.01" id='item_tax_${count}' readonly></td>
                        <td><input type="number" class="form-control" name="item_subtotal[]" step="0.01" id='item_subtotal_${count}'></td>
                        <td>
                            <a class="btn add" title="Add On"><img src="include/action/add.png" alt="Add"></a>
                            <a class="btn delete" title="Delete item"><img src="include/action/delete.png" alt="Delete"></a>
                        </td>
                    </tr>`;
        
        tbody.append(html);

        // Delegate autocomplete to tbody for inputs with specific IDs
        tbody.on('focus', `input[id^='stock_code_${count}']`, function() {
            let input = $(this).attr('id');   
            let inputId = input.replace('stock_code_', '');


            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "./module/",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term,
                            request:1
                        },
                        success: function( data ) {
                            response(data);
                            console.log(data);
                        }
                    });
                },
                select: function (event, ui) {
                    $(this).val(ui.item.label); // display the selected text
                    var item_id = ui.item.value; // selected value

                    // AJAX
                    $.ajax({
                        url: 'module/',
                        type: 'post',
                        data: {
                            item_id: item_id,
                            request: 2
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            var len = response.length;

                            if (len > 0) {
                                var item_code = response[0]['item_code'];
                                var item_description = response[0]['item_description'];
                                var item_price = parseFloat(response[0]['item_price']);
                                var item_tax_percentage = parseFloat(response[0]['item_tax_percentage']);
                                var item_tax = item_price*item_tax_percentage/100;
                                var item_subtotal = item_price+item_tax;

                                $(`#stock_code_${inputId}`).val(item_code);
                                $(`#item_code_${inputId}`).val(item_code);
                                $(`#description_${inputId}`).val(item_description);
                                $(`#unit_price_${inputId}`).val(item_price.toFixed(2));
                                $(`#item_tax_percentage_${inputId}`).val(item_tax_percentage.toFixed(2));
                                $(`#item_tax_${inputId}`).val(item_tax.toFixed(2));
                                $(`#item_subtotal_${inputId}`).val(item_subtotal.toFixed(2));
                                updateTotal();
                            }
                        }
                    })
                }
            });
        });

        tbody.on('focus', `input[id^='item_code_${count}']`, function() {
            let input = $(this).attr('id');   
            let inputId = input.replace('item_code_', '');

            $(this).autocomplete({
                source: function( request, response ) {
                    $.ajax({
                        url: "./module/",
                        type: 'post',
                        dataType: "json",
                        data: {
                            search: request.term,
                            request:1
                        },
                        success: function( data ) {
                            response(data);
                            console.log(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $(this).val(ui.item.label); // display the selected text
                    var item_id = ui.item.value; // selected value

                    // AJAX
                    $.ajax({
                        url: 'module/',
                        type: 'post',
                        data: {
                            item_id: item_id,
                            request: 2
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            var len = response.length;

                            if (len > 0) {
                                var item_code = response[0]['item_code'];
                                var item_description = response[0]['item_description'];
                                var item_price = parseFloat(response[0]['item_price']);
                                var item_tax_percentage = parseFloat(response[0]['item_tax_percentage']);
                                var item_tax = item_price*item_tax_percentage/100;
                                var item_subtotal = item_price+item_tax;

                                $(`#item_code_${inputId}`).val(item_code);
                                $(`#description_${inputId}`).val(item_description);
                                $(`#unit_price_${inputId}`).val(item_price.toFixed(2));
                                $(`#item_tax_percentage_${inputId}`).val(item_tax_percentage.toFixed(2));
                                $(`#item_tax_${inputId}`).val(item_tax.toFixed(2));
                                $(`#item_subtotal_${inputId}`).val(item_subtotal.toFixed(2));
                                updateTotal();
                            }
                        }
                    })
                    
                }
            });
        });

        // Delegate click event to tbody for the "Delete item" button
        tbody.on('click', '.btn.delete', function() {
            let tr = $(this).closest('tr');
            // Check if the previous row has the first td cell hidden
            if(tr.find('td:nth-child(2)').is(':hidden')){
                let prevRow = tr.prev('tr');
                while (prevRow.find('td:nth-child(2)').is(':hidden')) {
                    prevRow = prevRow.prev('tr');
                }

                let rowspanFirst = parseInt(prevRow.find('td:first-child').attr('rowspan')) || 1;
                let rowspanSecond = parseInt(prevRow.find('td:nth-child(2)').attr('rowspan')) || 1;

                if (rowspanFirst > 1) {
                    prevRow.find('td:first-child').attr('rowspan', rowspanFirst - 1);
                }
                if (rowspanSecond > 1) {
                    prevRow.find('td:nth-child(2)').attr('rowspan', rowspanSecond - 1);
                }

                // Find and destroy autocomplete for inputs within the deleted row
                tr.find('input[id^="stock_code_"]').each(function() {
                    if ($(this).data('ui-autocomplete')) {
                        $(this).autocomplete('destroy');
                    }
                });
                tr.find('input[id^="item_code_"]').each(function() {
                    if ($(this).data('ui-autocomplete')) {
                        $(this).autocomplete('destroy');
                    }
                });

                tr.remove();
            }else{
                let nextRow = tr.next('tr');
                while (nextRow.length && nextRow.find('td:nth-child(2)').is(':hidden')) {
                    nextRow.find('input[id^="stock_code_"]').each(function() {
                        if ($(this).data('ui-autocomplete')) {
                            $(this).autocomplete('destroy');
                        }
                    });
                    nextRow.find('input[id^="item_code_"]').each(function() {
                        if ($(this).data('ui-autocomplete')) {
                            $(this).autocomplete('destroy');
                        }
                    });
                    nextNextRow = nextRow.next('tr');
                    nextRow.remove();
                    nextRow = nextNextRow;
                }

                tr.find('input[id^="stock_code_"]').each(function() {
                    if ($(this).data('ui-autocomplete')) {
                        $(this).autocomplete('destroy');
                    }
                });
                tr.find('input[id^="item_code_"]').each(function() {
                    if ($(this).data('ui-autocomplete')) {
                        $(this).autocomplete('destroy');
                    }
                });

                tr.remove();

            }
            
            updateRowNumbers();
            updateTotal();
        });

        // Delegate click event to tbody for the buttons within rows
        tbody.off('click', '.btn.add').on('click', '.btn.add', function() {
            count = count+1
            let tr = $(this).closest('tr');
            let clone = tr.clone(); // Clone the specific row
            // Increment the rowspan attribute of the corresponding cells in the previous row
            let rowspanFirst = parseInt(tr.find('td:first-child').attr('rowspan')) || 1;
            let rowspanSecond = parseInt(tr.find('td:nth-child(2)').attr('rowspan')) || 1;

            tr.find('td:first-child').attr('rowspan', rowspanFirst + 1);
            tr.find('td:nth-child(2)').attr('rowspan', rowspanSecond + 1);

            // Change the ID of the cloned row and its elements
            clone.find('[id]').each(function() {
                let newId = $(this).attr('id') + "_"+count;
                $(this).attr('id', newId);
            });

            clone.find('input[name="item_code[]"]').val('');
            clone.find('input[name="description[]"]').val('');
            clone.find('input[name="qty[]"]').val('1');
            clone.find('input[name="unit_price[]"]').val('');
            clone.find('input[name="item_tax_percentage[]"]').val('');
            clone.find('input[name="item_tax[]"]').val('');
            clone.find('input[name="item_subtotal[]"]').val('');
            clone.find('td:nth-child(-n+2)').hide();
            clone.find('a.btn.add').hide();

            // Reattach the onchange event to the 'qty[]' input field in the cloned row
            clone.find('input[name="qty[]"]').on('change', function() {
                var inputId = $(this).attr('id');
                var numericPart = inputId.substring(4); // Remove the "qty_" prefix
                cal_item_subtotal(numericPart);
            });

            // Reattach the onchange event to the 'qty[]' input field in the cloned row
            clone.find('input[name="unit_price[]"]').on('change', function() {
                var inputId = $(this).attr('id');
                var numericPart = inputId.substring(11); // Remove the "unit_price_" prefix
                cal_item_subtotal(numericPart);
            });


            tr.after(clone); // Append the cloned row below the current row
            updateRowNumbers(); // Update row numbers or any other necessary updates
        });


    }

    function updateRowNumbers() {
        let tbody = $('#tbl-invoice-item tbody');
        let rows = tbody.children();

        rows.each(function(index) {
            let firstCell = $(this).children().first();
            firstCell.html(index + 1);
        });
    }

    function cal_item_subtotal(rowId) {
        // Extract the row index from the rowId
        var rowIndex = rowId;

        // Get the quantity and unit price values
        var qty = parseFloat($('#qty_' + rowIndex).val()) || 0;
        var unitPrice = parseFloat($('#unit_price_' + rowIndex).val()) || 0;
        var taxPercentage = parseFloat($('#item_tax_percentage_' + rowIndex).val()) || 0;

        // Calculate the subtotal
        var tax = unitPrice * taxPercentage / 100 * qty;
        var subtotal = qty * unitPrice + tax;

        // Update the item_subtotal input field
        $('#item_tax_' + rowIndex).val(tax.toFixed(2));
        $('#item_subtotal_' + rowIndex).val(subtotal.toFixed(2)); // Adjust decimal places as needed

        // Optionally, update the total of all subtotals
        updateTotal();
    }

    function updateTotal(){
        var total = 0;
        var total_with_tax = 0;
        console.log("calculate Total");

        // Iterate over all rows and sum up the item subtotals
        $('#tbl-invoice-item tbody tr').each(function() {
            // var rowIndex = parseInt($(this).find('td:first').text()) - 1;
            let tr = $(this).closest('tr');
            var secondTdId = tr.find('td:eq(1) input').attr('id');
            var rowIndex = secondTdId.replace('stock_code_', '');
            var tax = parseFloat($('#item_tax_' + rowIndex).val()) || 0;
            var subtotal_with_tax = parseFloat($('#item_subtotal_' + rowIndex).val()) || 0;
            var subtotal = subtotal_with_tax - tax;
            total +=subtotal;
            total_with_tax += subtotal_with_tax;
        });

        $('#invoice_amount').val(total.toFixed(2));
        $('#invoice_amount_with_tax').val(total_with_tax.toFixed(2));
    }

    $("#add_invoice_form").submit(function (e) {
        e.preventDefault();

        progressBar.width('0%');
        progressText.text('0%');
        overlay.show();

        var formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            data: formData,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
                        progressBar.width(percentComplete + '%');
                        progressText.text(percentComplete.toFixed(0) + '%');
                    }
                }, false);
                return xhr;
            },
            success: function(response){
                overlay.hide();
                if((response.trim()=="true")){
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Supplier Invoice Added!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = './p.o';
                    });
                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                    showConfirmButton: false,
                    timer: 1500
                });
                }
            },
            error: function(xhr, status, error) {
                overlay.hide();
                Swal.fire("Error", "An error occurred while adding the supplier invoice.", "error");
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });

    //enter no submit 
    document.onkeydown = function(e) {
		// alert();
		e = e || window.event; 
		k = e.which || e.charCode || e.keyCode; 
		if (k == 13 || k==9 && !e.altKey && !e.ctrlKey && !e.shiftKey) {
			var inputs = $('input:not(:hidden, :disabled)');
			var currentIndex = inputs.index($(document.activeElement));
			var nextIndex = currentIndex + 1;

			while (nextIndex < inputs.length && !inputs.eq(nextIndex).is(':visible, :enabled')) {
			nextIndex++;
			}

			if (nextIndex < inputs.length) {
			inputs.eq(nextIndex).focus();
			} else {
			// Handle the case when there is no next input element
			}

			event.preventDefault();
			
		} else if(k >= 37 && k <= 40) { // Arrow keys (left: 37, up: 38, right: 39, down: 40)
            var inputs = $('input:not(:hidden, :disabled)');
            var currentIndex = inputs.index($(document.activeElement));
            var nextIndex;

            if (k === 37) { // Left arrow
                nextIndex = currentIndex - 1;
            } else if (k === 39) { // Right arrow
                nextIndex = currentIndex + 1;
            } else if (k === 38 || k === 40) { // Up and down arrows
                return; // Allow default behavior for up and down arrows
            }

            // Loop to find the next visible and enabled input element
            while (nextIndex >= 0 && nextIndex < inputs.length && !inputs.eq(nextIndex).is(':visible, :enabled')) {
                if (k === 37) {
                    nextIndex--;
                } else if (k === 39) {
                    nextIndex++;
                }
            }

            if (nextIndex >= 0 && nextIndex < inputs.length) {
                inputs.eq(nextIndex).focus();
            }
        }else{
			return true;
		}

		return false;

	}
</script>