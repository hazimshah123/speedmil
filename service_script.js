document.getElementById("serviceabilityForm").onsubmit = function (e) {
    e.preventDefault();

    const originPincode = document.getElementById("origin_pincode").value;
    const deliveryPincode = document.getElementById("delivery_pincode").value;

    // Simple validation to check if the input is numeric
    if (isNaN(originPincode) || isNaN(deliveryPincode)) {
        alert("Please enter valid numeric pincodes.");
        return;
    }

    // Make an AJAX request to the PHP script
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "check_serviceability.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("result").innerHTML = xhr.responseText;
        } else {
            alert("Error occurred. Please try again.");
        }
    };

    xhr.onerror = function () {
        alert("Error occurred. Please try again.");
    };

    xhr.send("origin_pincode=" + originPincode + "&delivery_pincode=" + deliveryPincode);
};
