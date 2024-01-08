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

    // Array data received from the form
    $name = escapeInput($con, $_POST['name']);
    $category = escapeInput($con, $_POST['category']);
    $status = 'ACTIVE';
    $price = escapeInput($con, $_POST['price']);
    $built_up_price = escapeInput($con, $_POST['built_up_price']);
    $built_up_size = escapeInput($con, $_POST['built_up_size']);
    $land_area_size = escapeInput($con, $_POST['land_area_size']);
    $land_area_price = escapeInput($con, $_POST['land_area_price']);
    $floor = escapeInput($con, $_POST['floor']);
    $remarks = escapeInput($con, $_POST['remarks']);
    $address = escapeInput($con, $_POST['address']);
    $view = escapeInput($con, $_POST['view']);

    // picture
    $view = escapeInput($con, $_POST['view']);

    // Get asset category running number
    $sql = mysqli_query($con, "SELECT * FROM aims_specialized_category_run_no WHERE category = '$category'");
    $result = mysqli_fetch_assoc($sql);
    $asset_running_no = $result['next_no'];

    // Complete asset tag wording, adding zero to the left
    $asset_tag = $result['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);
    $base_asset_running_no = $result['next_no'];
    $base_name = $name;

    // Initialize the MultipleIterator
    $m5 = new MultipleIterator();

    // Array data received from the form
    if (isset($_POST['assetType']) && $_POST['assetType'] == 'multiple') {
        $quantity = escapeInput($con, $_POST['quantity']);
    } else {
        $quantity = 1;
    }

    for ($i = 0; $i < $quantity; $i++) {
        $picture = [];
        // Increment the asset running number
        $asset_running_no = $base_asset_running_no + $i;

        // Complete asset tag wording, adding zero to the left
        $asset_tag = $result['prefix'] . str_pad($asset_running_no, 5, "0", STR_PAD_LEFT);

        // Modify the name based on the asset type
        if ($_POST['assetType'] == 'single') {
            $name = $base_name;
        } else {
            $name = $base_name . ($i + 1);
        }

        // Check for duplicate name
        $sqlDuplicateCheck = "SELECT COUNT(*) as count FROM aims_property_specialized WHERE name = '$name'";
        $resultDuplicateCheck = mysqli_query($con, $sqlDuplicateCheck);
        $count = mysqli_fetch_assoc($resultDuplicateCheck)['count'];

        if ($count > 0) {
            // Duplicate name found, handle accordingly
            echo "duplicate";
            exit; // Stop further execution
        }

        // Creating File Upload Directory
        $target_directory_document = "../../../include/upload/document/property/specialized/" . $asset_tag . "/";

        if (!is_dir($target_directory_document)) {
            mkdir($target_directory_document, 0755, true);
        }

        // Initialize $document
        $document = "";

        // Check if an document file was uploaded
        if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
            $document_tmp = $_FILES['document']['tmp_name'];
            $document_name = basename($_FILES["document"]["name"]);
            $document_destination = $target_directory_document . $document_name;

            if (copy($document_tmp, $document_destination)) {
                // Set $document to the relative path of the uploaded file
                $document = "include/upload/document/property/specialized/" . $asset_tag . "/" . $document_name;
            }
        }

        // Insert data into the aims_property_specialized table
        $sqlAsset = "INSERT INTO aims_property_specialized 
        (name, asset_tag, category, status, price, floor, built_up_price, built_up_size, land_area_size, land_area_price, remarks, address, document) 
        VALUES 
        ('$name', '$asset_tag', '$category', '$status', '$price', '$floor', '$built_up_price', '$built_up_size', '$land_area_size', '$land_area_price','$remarks', '$address', '$document')";

        $queryAsset = mysqli_query($con, $sqlAsset);

        // Creating picture directory
        $target_directory_picture = "../../../include/upload/picture/property/specialized/" . $asset_tag . "/";

        if (!is_dir($target_directory_picture)) {
            mkdir($target_directory_picture, 0755, true);
        }

        // Initialize $picture
        $picturesForCurrentAsset = [];

        // Handle picture files
        // Check if there are picture files
        if (isset($_FILES['picture']) && is_array($_FILES['picture']['tmp_name'])) {
            $pictureCount = count($_FILES['picture']['tmp_name']);

            for ($j = 0; $j < $pictureCount; $j++) {
                // Check if the current picture file exists and is not empty
                if (isset($_FILES['picture']['name'][$j]) && $_FILES['picture']['size'][$j] > 0) {
                    $picture_tmp = $_FILES['picture']['tmp_name'][$j];
                    $picture_name = basename($_FILES['picture']['name'][$j]);
                    $picture_destination = $target_directory_picture . $picture_name;

                    // Check if the destination directory exists, and if not, create it
                    if (!is_dir($target_directory_picture)) {
                        mkdir($target_directory_picture, 0755, true);
                    }

                    // Check if the file is successfully copied
                    if (copy($picture_tmp, $picture_destination)) {
                        // Add the relative path of the copied picture to the array
                        $picturesForCurrentAsset[] = "include/upload/picture/property/specialized/" . $asset_tag . "/" . $picture_name;
                    }
                }
            }
        }

        // Insert picture data into aims_all_property_picture
        foreach ($picturesForCurrentAsset as $picturePath) {
            $viewValue = isset($view[$i]) ? $view[$i] : ''; // Ensure view value exists
            $sqlPicture = "INSERT INTO aims_all_property_picture (asset_tag, view, picture) VALUES ('$asset_tag', '$viewValue', '$picturePath')";
            $queryPicture = mysqli_query($con, $sqlPicture);

            if (!$queryPicture) {
                echo "Error inserting into aims_all_property_picture: " . mysqli_error($con);
                exit;
            }
        }
    }

    if ($queryAsset) {
        $next_no = $asset_running_no + 1;
        $update_running_no = mysqli_query($con, "UPDATE aims_specialized_category_run_no SET next_no = '$next_no' WHERE category = '$category'");
        echo "true";
    } else {
        echo "false";
    }
?>
