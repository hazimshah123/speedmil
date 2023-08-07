<?php

// header('Content-Type: application/json');

// Validate the form submission
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('error' => 'Method not allowed.'));
    exit;
}

// Retrieve the form data
$originPincode = $_POST['originPincode'];
$destinationPincode = $_POST['destinationPincode'];
$deliverySpeed = $_POST['deliverySpeed'];
$packageWeight = floatval($_POST['packageWeight']);
$paymentMode = $_POST['paymentMode'];

// Validate the required fields
if (
    empty($originPincode) ||
    empty($destinationPincode) ||
    empty($deliverySpeed) ||
    !isset($packageWeight) ||
    empty($paymentMode)
) {
    http_response_code(400); // Bad Request
    echo json_encode(array('error' => 'Missing or invalid input data'));
    exit;
}

// Calculate the delivery charges based on the input data
$deliveryCharge = calculateDeliveryCharge($originPincode, $destinationPincode, $deliverySpeed, $packageWeight, $paymentMode);

// Prepare the response
$response = array(
    'deliveryCharge' => $deliveryCharge
);

// Convert the response data to JSON format and send the response
echo json_encode($response);

// Function to calculate the delivery charge based on input data
function calculateDeliveryCharge($originPincode, $destinationPincode, $deliverySpeed, $packageWeight, $paymentMode)
{
    // Load the data from the JSON file
    $data = json_decode(file_get_contents('data.json'), true);

    $response = array();

    $slowDeliveryRatePer1000g = 35;
    $slowDeliveryRatePer3000g = 85;
    $fastDeliveryRatePer1000g = 45;
    $fastDeliveryRatePer3000g = 95;
    $prepaidRatePer1000g = 30;
    $prepaidRatePer3000g = 70;

     $rate = 0;

  if ($deliverySpeed === 'slow') {
    if ($packageWeight <= 1000) {
      $rate = $slowDeliveryRatePer1000g;
    } else if ($packageWeight <= 3000) {
      $rate = $slowDeliveryRatePer3000g;
    } else {
        http_response_code(200); // Bad Request
        $response['deliveryCharge'] = 0;
        $response['error'] = 'packageWeight exceeds the limit for slow delivery.';
        return;
    }
  } else if ($deliverySpeed === 'fast') {
    if ($packageWeight <= 1000) {
      $rate = $fastDeliveryRatePer1000g;
    } else if ($packageWeight <= 3000) {
      $rate = $fastDeliveryRatePer3000g;
    } else {
        http_response_code(200); // Bad Request
        $response['deliveryCharge'] = 0;
        $response['error'] = 'packageWeight exceeds the limit for fast delivery.';
      return;
    }
  }

  if ($paymentMode === 'prepaid') {
    $rate = $rate * ($packageWeight / 1000) * $prepaidRatePer1000g;
  } else if ($paymentMode === 'cod') {
    $rate = $rate * ($packageWeight / 1000);
  }

   //Add the calculated delivery charge to the response
        $response['deliveryCharge'] = round($rate, 2);
    

    // Send the JSON response back to the client
    // header('Content-Type: application/json');
    //echo json_encode($response);

    return $response['deliveryCharge'];


    //old code starts here
    // // Find the selected delivery speed and payment mode in the data
    // $deliverySpeedData = null;
    // foreach ($data['deliveryOptions'] as $option) {
    //     if ($option['type'] === $deliverySpeed) {
    //         $deliverySpeedData = $option;
    //         break;
    //     }
    // }

    // $paymentModeData = null;
    // foreach ($data['paymentModes'] as $option) {
    //     if ($option['type'] === $paymentMode) {
    //         $paymentModeData = $option;
    //         break;
    //     }
    // }

    // // Prepare the response data
    // $response = array();

    // if (!$deliverySpeedData || !$paymentModeData) {
    //     // Return an error response if the delivery speed or payment mode is not found
    //     http_response_code(200); // Bad Request
    //     $response['deliveryCharge'] = 0;
    //     $response['error'] = 'Invalid delivery speed or payment mode.';
    // } else {
    //     // Calculate the delivery charge based on weight
    //     $deliveryCharge = 0;

    //     // Define the weight tiers and their respective charges
    //     $weightTiers = array(
    //         array('weight' => 1, 'charge' => 35),
    //         array('weight' => 3, 'charge' => 85),
    //         // Add more tiers as needed
    //     );

    //     foreach ($weightTiers as $tier) {
    //         if ($packageWeight <= $tier['weight']) {
    //             $deliveryCharge = $tier['charge'];
    //             break;
    //         }
    //     }

    //     // Apply additional charge based on delivery speed
    //     $deliveryCharge += $deliverySpeedData['additional_charge'];

    //     // Apply discount if the payment mode is "prepaid"
    //     if ($paymentMode === 'prepaid') {
    //         $discountPercentage = $paymentModeData['discount_percentage'];
    //         $deliveryCharge *= (1 - ($discountPercentage / 100));
    //     }

    //     // Add the calculated delivery charge to the response
    //     $response['deliveryCharge'] = round($deliveryCharge, 2);
    // }

    // // Send the JSON response back to the client
    // header('Content-Type: application/json');
    // echo json_encode($response);

    // return $deliveryCharge;
}

?>
