document.getElementById("deliveryForm").onsubmit = function (e) {
  e.preventDefault();

  const originPincode = document.getElementById('originPincode').value;
  const destinationPincode = document.getElementById('destinationPincode').value;
  const deliverySpeed = document.getElementById('deliverySpeed').value;
  const weight = parseInt(document.getElementById('packageWeight').value);
  const paymentMode = document.getElementById('paymentMode').value;

  if (!isValidPincode(originPincode) || !isValidPincode(destinationPincode)) {
    displayResult('Invalid pincode. Please enter a 6-digit pincode between 180001 and 193000.');
    return;
  }

  const formData = new FormData();
  formData.append('originPincode', originPincode);
  formData.append('destinationPincode', destinationPincode);
  formData.append('deliverySpeed', deliverySpeed);
  formData.append('packageWeight', weight);
  formData.append('paymentMode', paymentMode);

  // Send the form data to the PHP script using AJAX
  fetch('calculate_delivery_charges.php', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(result => displayResult(result))
  .catch(error => displayResult('An error occurred while processing the request.'));

  // const slowDeliveryRatePer1000g = 35;
  // const slowDeliveryRatePer3000g = 85;
  // const fastDeliveryRatePer1000g = 45;
  // const fastDeliveryRatePer3000g = 95;
  // const prepaidRatePer1000g = 30;
  // const prepaidRatePer3000g = 70;

  // let rate = 0;

  // if (deliverySpeed === 'slow') {
  //   if (weight <= 1000) {
  //     rate = slowDeliveryRatePer1000g;
  //   } else if (weight <= 3000) {
  //     rate = slowDeliveryRatePer3000g;
  //   } else {
  //     displayResult('Weight exceeds the limit for slow delivery.');
  //     return;
  //   }
  // } else if (deliverySpeed === 'fast') {
  //   if (weight <= 1000) {
  //     rate = fastDeliveryRatePer1000g;
  //   } else if (weight <= 3000) {
  //     rate = fastDeliveryRatePer3000g;
  //   } else {
  //     displayResult('Weight exceeds the limit for fast delivery.');
  //     return;
  //   }
  // }

  // if (paymentMode === 'prepaid') {
  //   rate = rate * (weight / 1000) * prepaidRatePer1000g;
  // } else if (paymentMode === 'cod') {
  //   rate = rate * (weight / 1000);
  // }

  // displayResult(`Delivery charge: &#8377;${rate.toFixed(2)}`);



}


function displayResult(message) {
  document.getElementById('rate_result').innerHTML = message;
}

function isValidPincode(pincode) {
  return /^\d{6}$/.test(pincode) && Number(pincode) >= 180001 && Number(pincode) <= 193000;
}
