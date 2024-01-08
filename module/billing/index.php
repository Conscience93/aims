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
</style>

<!-- Content -->
<div class="main">

    <!-- Tab navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="tab-invoice" data-toggle="tab" href="#invoice" role="tab" aria-controls="invoice" aria-selected="true">Invoice</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-adjustment" data-toggle="tab" href="#adjustment" role="tab" aria-controls="adjustment" aria-selected="false">Adjustment</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-payment" data-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="false">Payment</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="tab-reminder" data-toggle="tab" href="#reminder" role="tab" aria-controls="reminder" aria-selected="false">Reminder</a>
        </li>
    </ul>

    <!-- Tab content -->
    <div class="tab-content" id="myTabContent">
        <!-- Tab 1: Invoice -->
        <div class="tab-pane fade show active" id="invoice" role="tabpanel" aria-labelledby="tab-invoice">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Invoice</h2>
                        </div>
                        <div class="col-6">
                            <a href="./addinvoice" class="btn btn-primary float-right">Add Invoice</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_invoice" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>User</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Overdue (Days)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                        //query vehicle from aim_invoice table using pagination
                        $sql = "SELECT * FROM aims_billing_invoice GROUP BY id";
                        $query = mysqli_query($con, $sql);
                        
                        while ($row = mysqli_fetch_assoc($query)) {
                            echo "<tr>";
                            echo "<td>".$row['id']."</td>";
                            echo "<td>".$row['invoice_id']."</td>";
                            echo "<td>".$row['invoice_date']."</td>";
                            echo "<td>".$row['user']."</td>";
                            echo "<td>".$row['invoice_date_due']."</td>";
                            echo "<td>".$row['invoice_amount']."</td>";
                            echo "<td>".$row['overdue']."</td>";
                            echo "<td>
                                    <a id='invoiceViewBtn' href='./viewinvoice?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                    <a id='invoiceEditBtn' href='./editinvoice?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                    <a id='invoicePrintBtn' class='action-button mx-1' onclick='printInvoice()' title='Print'><img class='actionbtn' src='./include/action/print.png'></a>&nbsp;
                                </td>";    
                            echo "</tr>";
                        }
                    ?>
                    </table>
                </div>            
            </div>
        </div>         

        <!-- Tab 2: Adjustment -->
        <div class="tab-pane fade" id="adjustment" role="tabpanel" aria-labelledby="tab-adjustment">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Adjustment</h2>
                        </div>
                        <div class="col-6">
                            <a href="./addadjustment" class="btn btn-primary float-right">Add Adjustment</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="table_adjustment" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Adjustment No.</th>
                                <th>Adjustment Date</th>
                                <th>Adjustment Type</th>
                                <th>Adjustment Reason</th>
                                <th>Invoice No.</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    //query vehicle from aim_adjustment table using pagination
                    $sql = "SELECT * FROM aims_billing_adjustment GROUP BY id";
                    $query = mysqli_query($con, $sql);
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['adjustment_id']."</td>";
                        echo "<td>".$row['adjustment_date']."</td>";
                        echo "<td>".$row['adjustment_type']."</td>";
                        echo "<td>".$row['adjustment_reason']."</td>";
                        echo "<td>".$row['invoice_id']."</td>";
                        echo "<td>".$row['user']."</td>";
                        echo "<td>".$row['total_amount']."</td>";
                        echo "<td>
                                <a id='adjustmentViewBtn' href='./viewadjustment?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='adjustmentEditBtn' href='./editadjustment?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='adjustmentDeleteBtn' class='action-button mx-1' onclick='confirmDeleteAdjustment()' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";    
                        echo "</tr>";
                    }
                    ?>
                    </table>
                </div>            
            </div>
        </div>
        
        <!-- Tab 3: Payment -->
        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="tab-payment">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Payment</h2>
                        </div>
                        <div class="col-6">
                            <a href="./addpayment" class="btn btn-primary float-right">Add Payment</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_payment" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Receipt No.</th>
                                <th>Payment Date</th>
                                <th>User</th>
                                <th>Invoice No.</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    $sql = "SELECT * FROM aims_billing_payment GROUP BY id";
                    $query = mysqli_query($con, $sql);
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['receipt_id']."</td>";
                        echo "<td>".$row['payment_date']."</td>";
                        echo "<td>".$row['user']."</td>";
                        echo "<td>".$row['invoice_id']."</td>";
                        echo "<td>".$row['total_amount']."</td>";
                        echo "<td>".$row['payment_method_id']."</td>";
                        echo "<td>".$row['remark']."</td>";
                        echo "<td>
                                <a id='paymentViewBtn' href='./viewpayment?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='paymentEditBtn' href='./editpayment?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='paymentDeleteBtn' class='action-button mx-1' onclick='confirmDeletePayment()' title='Delete'><img class='actionbtn' src='./include/action/delete.png'></a>&nbsp;
                            </td>";    
                        echo "</tr>";
                    }
                ?>
                    </table>
                </div>            
            </div>
        </div>

        <!-- Tab 4: Reminder -->
        <div class="tab-pane fade" id="reminder" role="tabpanel" aria-labelledby="tab-reminder">
            <div class="card shadow rounded">
                <div class="card-header" style="background:white;">
                    <div class="row">
                        <div class="col-6">
                            <h2>Reminder</h2>
                        </div>
                        <div class="col-6">
                            <a href="./addreminder" class="btn btn-primary float-right">Add Reminder</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- generate table from query with pagination -->
                    <table id="table_reminder" class="striped-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>User</th>
                                <th>Due Date</th>
                                <th>Payment Status</th>
                                <th>Amount</th>
                                <th>Overdue</th>
                                <th>Remark</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    <?php
                    $sql = "SELECT * FROM aims_billing_invoice GROUP BY id";
                    $query = mysqli_query($con, $sql);
                    
                    while ($row = mysqli_fetch_assoc($query)) {
                        echo "<tr>";
                        echo "<td>".$row['id']."</td>";
                        echo "<td>".$row['invoice_id']."</td>";
                        echo "<td>".$row['invoice_date']."</td>";
                        echo "<td>".$row['user']."</td>";
                        echo "<td>".$row['invoice_date_due']."</td>";
                        echo "<td>".$row['payment_status']."</td>";
                        echo "<td>".$row['invoice_amount']."</td>";
                        echo "<td>".$row['overdue']."</td>";
                        echo "<td>".$row['remark']."</td>";
                        echo "<td>
                                <a id='reminderViewBtn' href='./viewreminder?id=".$row['id']."' title='More Info'><img class='actionbtn' src='./include/action/review.png'></a>&nbsp;
                                <a id='reminderEditBtn' href='./editreminder?id=".$row['id']."' title='Edit'><img class='actionbtn' src='./include/action/edit.png'></a>&nbsp;
                                <a id='reminderSendBtn' class='action-button mx-1' onclick='' title='Send Reminder'><img class='actionbtn' src='./include/action/reminder.png'></a>&nbsp;
                            </td>";    
                        echo "</tr>";
                    }
                ?>
                    </table>
                </div>            
            </div>
        </div>

    </div>
</div>

<script>
    //datatable
    $(document).ready(function() {
        $('#table_invoice').DataTable(
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
        $('#table_adjustment').DataTable(
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
        $('#table_payment').DataTable(
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
        $('#table_reminder').DataTable(
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
</script>