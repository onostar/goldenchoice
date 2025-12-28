<?php
include "../classes/dbh.php";
include "../classes/update.php";
$customer = $_POST['patient'];
$folderPath = '../photos/';
$image_parts = explode(";base64,", $_POST['image']);
$image_type_aux = explode("image/", $image_parts[0]);
$image_type = $image_type_aux[1];
$image_base64 = base64_decode($image_parts[1]);
$file_name = uniqid() . '.png';
$file = $folderPath . $file_name;
file_put_contents($file, $image_base64);
$update = new Update_table();
$update->update('customers', 'photo', 'customer_id', $file_name, $customer);
echo json_encode(["Image uploaded successfully."]);
?>
