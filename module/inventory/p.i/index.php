<?php 
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}

?>

<style>
    .action-button {
        cursor: pointer;
    }

    /* Define styles for odd rows in striped-tables */
    table.striped-table tr:nth-child(odd) {
        background-color: #f2f2f2; /* Set the background color for odd data rows */
    }

    /* Define styles for even rows in striped-tables */
    table.striped-table tr:nth-child(even) {
        background-color: #ffffff; /* Set the background color for even data rows */
    }

    .sorting_asc, .sorting_desc, .sorting {
        background-image: none !important;  
    }
    
    .green-button {
        background-color: green;
    }

</style>

<!-- Content -->
<div class="main">
    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="false">
                All (<?php
                        $sqlTotalInvoice = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'APPROVE'";
                        $queryTotalInvoice = mysqli_query($con, $sqlTotalInvoice);
                        $totalInvoice = mysqli_num_rows($queryTotalInvoice);
                    echo $totalInvoice;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-outstanding" data-toggle="tab" href="#outstanding" role="tab" aria-controls="outstanding" aria-selected="false">
                Outstanding (<?php
                        $sqlTotalOutstanding = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'OUTSTANDING' AND approval = 'APPROVE'";
                        $queryTotalOutstanding = mysqli_query($con, $sqlTotalOutstanding);
                        $totalOutstanding = mysqli_num_rows($queryTotalOutstanding);
                    echo $totalOutstanding;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-unpaid" data-toggle="tab" href="#unpaid" role="tab" aria-controls="unpaid" aria-selected="false">
                Unpaid (<?php
                        $sqlTotaUnpaid = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'UNPAID' AND approval = 'APPROVE'";
                        $queryTotaUnpaid = mysqli_query($con, $sqlTotaUnpaid);
                        $totaUnpaid = mysqli_num_rows($queryTotaUnpaid);
                    echo $totaUnpaid;
                ?>)
            </a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-paid" data-toggle="tab" href="#paid" role="tab" aria-controls="paid" aria-selected="false">
                Paid (<?php
                        $sqlTotalPaid = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'PAID' AND approval = 'APPROVE'";
                        $queryTotalPaid = mysqli_query($con, $sqlTotalPaid);
                        $totalPaid = mysqli_num_rows($queryTotalPaid);
                    echo $totalPaid;
                ?>)
            </a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: All -->
        <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="tab-all">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>All Purchased Invoice</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right"> 
                                <a href="./addInvoice" class="btn btn-info">Add Purchase Invoice</a>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_all" class="striped-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Invoice No.</th>
                                <th style="text-align:center;">Date</th>
                                <th style="text-align:center;">Paid To</th>
                                <th style="text-align:center;">IA (Excl. Tax)</th>
                                <th style="text-align:center;">IA (Incl. Tax)</th>
                                <th style="text-align:center;">Adj. Amt.</th>
                                <th style="text-align:center;">Unpd Amt.</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $invoices = array();

                        // Query invoices from aims_all_asset_Invoice table with pictures from aims_all_asset_picture table
                        $sqlTotalInvoice = "SELECT id FROM `aims_inventory_p.i` WHERE approval = 'APPROVE'";
                        $queryInvoice = mysqli_query($con, $sqlTotalInvoice);
                        
                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($queryInvoice)) {
                            if (!isset($invoices[$row['invoice_no']])) {
                                $invoices[$row['invoice_no']] = array(
                                    'id' => $row['id'],
                                    'invoice_no' => $row['invoice_no'],
                                    'date' => $row['date'],
                                    'recipient' => $row['recipient'],
                                    'exclude' => $row['exclude'],
                                    'include' => $row['include'],
                                    'adjustment' => $row['adjustment'],
                                    'unpaid' => $row['unpaid'],
                                    'status' => $row['status']
                                );
                            }
                        }
                        
                        foreach ($invoices as $invoice) {
                            echo "<tr data-invoice-no='" . $invoice['invoice_no'] . "'>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['invoice_no'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['date'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['recipient'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['exclude'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['include'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['adjustment'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['unpaid'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['status'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='InvoiceEditBtn' href='./viewInvoice?id=".$invoice['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='InvoiceEditBtn' href='./editInvoice?id=".$invoice['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='InvoiceDeleteBtn' class='action-button mx-1' onclick='confirmDeleteInvoice(".$invoice['id']. ",\"".$invoice['invoice_no']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 2: Outstanding -->
        <div class="tab-pane fade show" id="outstanding" role="tabpanel" aria-labelledby="tab-outstanding">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Outstanding Purchased Invoice</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right"> 
                                <a href="./addInvoice" class="btn btn-info">Add Purchase Invoice</a>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_outstanding" class="striped-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Invoice No.</th>
                                <th style="text-align:center;">Date</th>
                                <th style="text-align:center;">Paid To</th>
                                <th style="text-align:center;">IA (Excl. Tax)</th>
                                <th style="text-align:center;">IA (Incl. Tax)</th>
                                <th style="text-align:center;">Adj. Amt.</th>
                                <th style="text-align:center;">Unpd Amt.</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $invoices = array();

                        // Query invoices from aims_all_asset_Invoice table with pictures from aims_all_asset_picture table
                        $sqlTotalInvoice = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'OUTSTANDING' AND approval = 'APPROVE'";
                        $queryInvoice = mysqli_query($con, $sqlTotalInvoice);
                        
                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($queryInvoice)) {
                            if (!isset($invoices[$row['invoice_no']])) {
                                $invoices[$row['invoice_no']] = array(
                                    'id' => $row['id'],
                                    'invoice_no' => $row['invoice_no'],
                                    'date' => $row['date'],
                                    'recipient' => $row['recipient'],
                                    'exclude' => $row['exclude'],
                                    'include' => $row['include'],
                                    'adjustment' => $row['adjustment'],
                                    'unpaid' => $row['unpaid'],
                                    'status' => $row['status']
                                );
                            }
                        }
                        
                        foreach ($invoices as $invoice) {
                            echo "<tr data-invoice-no='" . $invoice['invoice_no'] . "'>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['invoice_no'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['date'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['recipient'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['exclude'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['include'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['adjustment'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['unpaid'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['status'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='InvoiceEditBtn' href='./viewInvoice?id=".$invoice['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='InvoiceEditBtn' href='./editInvoice?id=".$invoice['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='InvoiceDeleteBtn' class='action-button mx-1' onclick='confirmDeleteInvoice(".$invoice['id']. ",\"".$invoice['invoice_no']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 3: Unpaid -->
        <div class="tab-pane fade show" id="unpaid" role="tabpanel" aria-labelledby="tab-unpaid">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Unpaid Purchased Invoice</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right"> 
                                <a href="./addInvoice" class="btn btn-info">Add Purchase Invoice</a>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_unpaid" class="striped-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Invoice No.</th>
                                <th style="text-align:center;">Date</th>
                                <th style="text-align:center;">Paid To</th>
                                <th style="text-align:center;">IA (Excl. Tax)</th>
                                <th style="text-align:center;">IA (Incl. Tax)</th>
                                <th style="text-align:center;">Adj. Amt.</th>
                                <th style="text-align:center;">Unpd Amt.</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $invoices = array();

                        // Query invoices from aims_all_asset_Invoice table with pictures from aims_all_asset_picture table
                        $sqlTotalInvoice = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'UNPAID' AND approval = 'APPROVE'";
                        $queryInvoice = mysqli_query($con, $sqlTotalInvoice);
                        
                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($queryInvoice)) {
                            if (!isset($invoices[$row['invoice_no']])) {
                                $invoices[$row['invoice_no']] = array(
                                    'id' => $row['id'],
                                    'invoice_no' => $row['invoice_no'],
                                    'date' => $row['date'],
                                    'recipient' => $row['recipient'],
                                    'exclude' => $row['exclude'],
                                    'include' => $row['include'],
                                    'adjustment' => $row['adjustment'],
                                    'unpaid' => $row['unpaid'],
                                    'status' => $row['status']
                                );
                            }
                        }
                        
                        foreach ($invoices as $invoice) {
                            echo "<tr data-invoice-no='" . $invoice['invoice_no'] . "'>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['invoice_no'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['date'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['recipient'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['exclude'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['include'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['adjustment'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['unpaid'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['status'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='InvoiceEditBtn' href='./viewInvoice?id=".$invoice['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='InvoiceEditBtn' href='./editInvoice?id=".$invoice['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='InvoiceDeleteBtn' class='action-button mx-1' onclick='confirmDeleteInvoice(".$invoice['id']. ",\"".$invoice['invoice_no']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 4: Paid -->
        <div class="tab-pane fade show" id="paid" role="tabpanel" aria-labelledby="tab-paid">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Paid Purchased Invoice</h2>
                        </div>
                        <div class="col-6">
                            <div class="float-right"> 
                                <a href="./addInvoice" class="btn btn-info">Add Purchase Invoice</a>  
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="max-height: 76vh; overflow-y: scroll;">
                    <table id="table_paid" class="striped-table">
                        <thead>
                            <tr>
                                <th style="text-align:center;">No.</th>
                                <th style="text-align:center;">Invoice No.</th>
                                <th style="text-align:center;">Date</th>
                                <th style="text-align:center;">Paid To</th>
                                <th style="text-align:center;">IA (Excl. Tax)</th>
                                <th style="text-align:center;">IA (Incl. Tax)</th>
                                <th style="text-align:center;">Adj. Amt.</th>
                                <th style="text-align:center;">Unpd Amt.</th>
                                <th style="text-align:center;">Status</th>
                                <th style="text-align:center;">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $invoices = array();

                        // Query invoices from aims_all_asset_Invoice table with pictures from aims_all_asset_picture table
                        $sqlTotalInvoice = "SELECT id FROM `aims_inventory_p.i` WHERE status = 'PAID' AND approval = 'APPROVE'";
                        $queryInvoice = mysqli_query($con, $sqlTotalInvoice);
                        
                        $rowNumber = 1; // Initialize a row counter
                        
                        while ($row = mysqli_fetch_assoc($queryInvoice)) {
                            if (!isset($invoices[$row['invoice_no']])) {
                                $invoices[$row['invoice_no']] = array(
                                    'id' => $row['id'],
                                    'invoice_no' => $row['invoice_no'],
                                    'date' => $row['date'],
                                    'recipient' => $row['recipient'],
                                    'exclude' => $row['exclude'],
                                    'include' => $row['include'],
                                    'adjustment' => $row['adjustment'],
                                    'unpaid' => $row['unpaid'],
                                    'status' => $row['status']
                                );
                            }
                        }
                        
                        foreach ($invoices as $invoice) {
                            echo "<tr data-invoice-no='" . $invoice['invoice_no'] . "'>";
                            echo "<td style='text-align:center;'>" . $rowNumber . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['invoice_no'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['date'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['recipient'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['exclude'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['include'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['adjustment'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['unpaid'] . "</td>";
                            echo "<td style='text-align:center;'>" . $invoice['status'] . "</td>";
                            echo "<td style='text-align:center;'>";
                            echo "
                                <a id='InvoiceEditBtn' href='./viewInvoice?id=".$invoice['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='InvoiceEditBtn' href='./editInvoice?id=".$invoice['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='InvoiceDeleteBtn' class='action-button mx-1' onclick='confirmDeleteInvoice(".$invoice['id']. ",\"".$invoice['invoice_no']."\")' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";
                            echo "</tr>";

                            $rowNumber++;
                        }
                        ?>
                    </table>
                </div>            
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
    //datatable
    $(document).ready(function() {
        $('#table_all').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_outstanding').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_unpaid').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );
    });

    $(document).ready(function() {
        $('#table_paid').DataTable(
            {
                "paging":   true,
                "ordering": true,
                "info":     true,
                "searching": true,
                "columnDefs": [
                    { "orderable": false, "targets": 4 }
                ]
            }
        );
    });

    function confirmDeleteInvoice(id, invoice_no) {
        Swal.fire({
        title: "Are you sure?",
        text: "You are about to delete invoice with Tag: " + invoice_no + ". This process is irreversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "Cancel"
        }).then((result) => {
        if (result.isConfirmed) {
            deleteInvoice(id);
        }
        });
        }

    function deleteInvoice(id) {
        $.ajax({
        url: "./module/inventory/p.i/deleteInvoice_action.php", // Update the URL to your PHP script
        type: "POST", // Use POST method
        data: { id: id }, // Send the ID as data
        success: function(response) {
            // Handle the server response here if needed
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'The asset has been deleted.',
                showConfirmButton: false,
                timer: 2000
            }).then(function() {
                window.location.href = './p.i';
            });
            // You can also update the UI or perform any other action
        },
        error: function(xhr, status, error) {
            // Handle errors here if needed
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the asset.' + error,
                showConfirmButton: true,
                timer: 2000
            }).then(function() {
                window.location.href = './p.i';
            });
        }
        });
    }
</script>