<?php
$origin_pincode = isset($_POST['origin_pincode']) ? $_POST['origin_pincode'] : '';
$delivery_pincode = isset($_POST['delivery_pincode']) ? $_POST['delivery_pincode'] : '';

$serviceable_pincodes = range(180001, 193333);
$is_origin_serviceable = in_array($origin_pincode, $serviceable_pincodes);
$is_delivery_serviceable = in_array($delivery_pincode, $serviceable_pincodes);

$result = "Origin Pincode is serviceable: " . ($is_origin_serviceable ? "Yes" : "No");
$result .= "<br>Delivery Pincode is serviceable: " . ($is_delivery_serviceable ? "Yes" : "No");

echo $result;
?>
