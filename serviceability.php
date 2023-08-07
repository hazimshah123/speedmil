<!DOCTYPE html>
<html>
<head>
    <title>Pin-code Serviceability Form</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Pin-code Serviceability Form</h1>
        <form id="serviceabilityForm">
            <label for="origin_pincode">Enter Origin Pincode:</label>
            <input type="text" id="origin_pincode" name="origin_pincode" required><br><br>

            <label for="delivery_pincode">Enter Delivery Pincode:</label>
            <input type="text" id="delivery_pincode" name="delivery_pincode" required><br><br>

            <input type="submit" value="Check Serviceability">
        </form>
        <div id="result"></div>
    </div>

    <script src="script.js"></script>
</body>
</html>
