<?php
if($submodule_access['asset']['view']!=1){
    header('location: logout.php');
}

$sqlServer = "SELECT aims_computer.asset_tag, 
                    aims_computer.name, 
                    aims_computer.processor, 
                    aims_computer_network.ip_address,
                    aims_computer_network.mac_address
                FROM aims_computer
                LEFT JOIN aims_computer_network ON aims_computer.asset_tag = aims_computer_network.asset_tag
                WHERE aims_computer.category ='Server'";

$resultServer = mysqli_query($con, $sqlServer);

// SQL query to retrieve data for virtual machines
$sqlVirtual = "SELECT aims_computer.asset_tag, 
                        aims_computer.name, 
                        aims_computer.processor, 
                        aims_computer_network.ip_address,
                        aims_computer_network.mac_address,
                        aims_computer.server_name
                    FROM aims_computer
                    LEFT JOIN aims_computer_network ON aims_computer.asset_tag = aims_computer_network.asset_tag
                    WHERE aims_computer.category = 'Virtual Machine' 
                        AND aims_computer.server_name IS NOT NULL";

$resultVirtual = mysqli_query($con, $sqlVirtual);
?>

<style>
    .action-button {
        cursor: pointer;
    }
    
    .hidden-number {
        visibility: hidden;
    }

    .branch-link:hover {
        color: #ff6600;
        text-decoration: underline;
        cursor: pointer;
    }

    #table_details {
        width: 100%;
        border-collapse: collapse;
        transition: width 0.3s ease;
    }

    #table_details th,
    #table_details td {
        text-align: left;
        padding: 12px;
        border: 1px solid #ddd;
    }

    #table_details td {
        width: auto; /* Set auto width for td */
    }

    #table_details th {
        background-color: #f2f2f2;
    }

    #table_details td {
        border-bottom: 1px solid #ddd;
        background-color: transparent;
    }

    /* -----------------------------
    CARD DISPLAY
    ----------------------------- */

    /* Header Box 1 */
    .card.header-box1 {
        width: calc(33.33% - 10px);
        height: 10vh;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    /* New Header Box  */
    .card.header-box3 {
        width: calc(21.88% - 10px);
        height: 10vh;
        box-sizing: border-box;
        margin-bottom: 10px;
    }

    .container {
        width: 100%;
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
        margin-right: 0px;
        margin-left: 0px;
        float: left;
        height: 100vh;
        max-width: 100vw;
    }

    .card {
        width: calc(66.66% - 10px); /* Adjust the width as needed for two cards in a row */
        max-height: 42vh;
        overflow-y: auto;
        box-sizing: border-box;
    }

    /* card 2 */
    .card.box2 {
        width: calc(33.33% - 10px); /* Adjust the width as needed for two cards in a row */
        max-height: 74vh; /* Adjust the height as needed for Box 2 */
        margin-bottom: 10px;
    }

    /* Box 3 */
    .card.box3 {
        width: calc(66.66% - 10px); /* Adjust the width as needed for two cards in a row */
        max-height: 30vh; /* Adjust the height as needed for Box 3 */
        margin-top: -32vh; /* Add a negative margin at the top to move Box 3 up */
    }

</style>


<!-- Content -->
<div class="main">
    <div class="container">
        <!-- New Header Box 3 - Part 1 -->
        <div class="card shadow rounded header-box3">
            <div class="card-body">
                <!-- Content for Header Box 3 - Part 1 goes here -->
            </div>
        </div>

        <!-- New Header Box 3 - Part 2 -->
        <div class="card shadow rounded header-box3">
            <div class="card-body">
                <!-- Content for Header Box 3 - Part 2 goes here -->
            </div>
        </div>

        <!-- New Header Box 3 - Part 3 -->
        <div class="card shadow rounded header-box3">
            <div class="card-body">
                <!-- Content for Header Box 3 - Part 3 goes here -->
            </div>
        </div>

        <!-- Header Box 1 -->
        <div class="card shadow rounded header-box1">
            <div class="card-body">
                <!-- Content for Header Box 1 goes here -->
            </div>
        </div>

        <!-- Box 1 -->
        <div class="card shadow rounded">
            <div class="card-body">
                <!-- Content for Box 1 goes here -->
            </div>
        </div>
        
        <!-- Box 2: Add more boxes as needed -->
        <div class="card shadow rounded box2">
            <div class="card-body">
                <!-- Content for Box 2 goes here -->
            </div>
        </div>

        <!-- Box 3: Add more boxes as needed -->
        <div class="card shadow rounded box3">
            <div class="card-body">
                <!-- Content for Box 3 goes here -->
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    
</script>