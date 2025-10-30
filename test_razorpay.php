<?php
// test_razorpay.php
$key_id = "rzp_test_RYtAON28p8h21c";
$key_secret = "5pWoIGnLLlHQEsUcwsbQwt4O";

// Test API call
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.razorpay.com/v1/orders');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'amount' => 10000, // 100 INR in paise
    'currency' => 'INR',
    'payment_capture' => 1,
    'receipt' => 'test_123'
]));
curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<h2>Razorpay API Test</h2>";
echo "<p>Key ID: " . $key_id . "</p>";
echo "<p>HTTP Status Code: " . $http_code . "</p>";
echo "<p>Response: " . $result . "</p>";

$response = json_decode($result, true);
if (isset($response['error'])) {
    echo "<p style='color: red;'>Error: " . $response['error']['description'] . "</p>";
} else {
    echo "<p style='color: green;'>Success! API credentials are working.</p>";
}
?>
<<<<<<< HEAD

=======
>>>>>>> d1d47e158548194637363a7839398ddbca506736
