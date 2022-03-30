<?php
require "connect_to_database.php";

$encodedImage = $_POST['EN_IMAGE'];
$imageTitle = $_POST['FILE_NAME'];

$imageLocation = "imageupload/$imageTitle";

$sqlQuery = "INSERT INTO `images_tbl` (`image_name`, `image_url`) VALUES ('$imageTitle', '$imageLocation')";

if (mysqli_query($conn, $sqlQuery)) {

    file_put_contents($imageLocation, base64_decode($encodedImage));

    $result["status"] = TRUE;
    $result["remarks"] = "Image Saved Successfully";
} else {
    $result["status"] = FALSE;
    $result["remarks"] = "Image Saving Failed";
}

mysqli_close($conn);

print(json_encode($result));
