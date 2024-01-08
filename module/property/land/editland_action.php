<?php
    include_once '../../../include/db_connection.php';
    session_start();

    // Function to escape user input
    function escapeInput($con, $input) {
        if (is_array($input)) {
            $escapedInput = [];
            foreach ($input as $value) {
                $escapedInput[] = mysqli_real_escape_string($con, $value);
            }
            return $escapedInput;
        } else {
            return mysqli_real_escape_string($con, $input);
        }
    }

    $id = isset($_POST['id']) ? escapeInput($con, $_POST['id']) : null;
    $asset_tag = isset($_POST['asset_tag']) ? escapeInput($con, $_POST['asset_tag']) : null;
    $name = isset($_POST['name']) ?  escapeInput($con, $_POST['name']): null;
    $category = isset($_POST['category']) ?  escapeInput($con, $_POST['category']): null;
    $status = 'ACTIVE';
    $price = isset($_POST['price']) ?  escapeInput($con, $_POST['price']): null;
    $land_area_size = isset($_POST['land_area_size']) ?  escapeInput($con, $_POST['land_area_size']): null;
    $land_area_price = isset($_POST['land_area_price']) ?  escapeInput($con, $_POST['land_area_price']): null;
    $remarks = isset($_POST['remarks']) ?  escapeInput($con, $_POST['remarks']): null;
    $address = isset($_POST['address']) ?  escapeInput($con, $_POST['address']): null;
    $view = isset($_POST['view']) ?  escapeInput($con, $_POST['view']): null;

    // Creating File Upload Directory
    $target_directory_document = "../../../include/upload/document/property/land/" . $asset_tag . "/";

    if (!is_dir($target_directory_document)) {
        mkdir($target_directory_document, 0755, true);
    }

    // Get existing link
    $sqlLink = mysqli_query($con, "SELECT * FROM aims_property_land WHERE id = '$id'");
    $resultLink = mysqli_fetch_assoc($sqlLink);

    // Delete existing document file if it exists
    if (!empty($resultLink["document"]) && file_exists($resultLink["document"])) {
        unlink($resultLink["document"]);
    }

    // document
    if ($resultLink["document"]) {
        $document = $resultLink["document"];
    } else if ($_FILES["document"]["name"] == "") {
        $document = "";
    } else {
        $document_name = basename($_FILES["document"]["name"]);
        $document_destination = $target_directory_document . $document_name;
        $document_tmp = $_FILES['document']['tmp_name'];

        if (move_uploaded_file($document_tmp, $document_destination)) {
            $document = "include/upload/document/property/land/" . $asset_tag . "/" . $document_name;
        } else {
            echo "Failed to move the document file.";
            // Handle the error accordingly, you might want to exit or return an error response
        }
    }

    // Update attributes other than pictures
    $sql_asset = "UPDATE aims_property_land SET
        name = '$name',
        category = '$category',
        price = '$price',
        land_area_size = '$land_area_size',
        land_area_price = '$land_area_price',
        remarks = '$remarks',
        address = '$address',
        document = '$document'
    WHERE id = '$id'
    ";

    // Now, handle picture uploads and updates
    $target_directory_picture = "../../../include/upload/picture/property/land/" . $asset_tag . "/";
    if (!is_dir($target_directory_picture)) {
        mkdir($target_directory_picture, 0755, true);
    }

    // Initialize $picture
    $picture = [];

    // Check if picture files were uploaded
    if (isset($_FILES['picture']) && $_FILES['picture']['name'][0] != "") {
        $pictureCount = count($_FILES['picture']['tmp_name']);
        for ($i = 0; $i < $pictureCount; $i++) {
            $picture_tmp = $_FILES['picture']['tmp_name'][$i];
            $picture_name = basename($_FILES['picture']['name'][$i]);
            $picture_destination = $target_directory_picture . $picture_name;

            if (move_uploaded_file($picture_tmp, $picture_destination)) {
                // Add the relative path of the uploaded picture to the $picture array
                $picture[] = "include/upload/picture/property/land/" . $asset_tag . "/" . $picture_name;
            }
        }
    }

    $queryPicture = null;

    $mi = new MultipleIterator();

    if (!empty($view) && !empty($picture)) {
        $mi->attachIterator(new ArrayIterator($view));
        $mi->attachIterator(new ArrayIterator($picture));
    }

    foreach ($mi as $value) {
        list($a, $b) = $value;
        $sqlPicture = "INSERT INTO aims_all_property_picture 
            (asset_tag, view, picture) 
            VALUES 
            ('$asset_tag','$a', '$b')";
        $queryPicture = mysqli_query($con, $sqlPicture);
    }

    $queryAsset = mysqli_query($con, $sql_asset);

    if ($queryAsset) {
        echo "true";
    } else {
        echo "false: " . mysqli_error($con);
    }
?>
