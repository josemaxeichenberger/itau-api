<?php
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://sts.itau.com.br/seguranca/v1/certificado/solicitacao");
curl_setopt($ch, CURLOPT_PORT, 443);
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_HEADER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1); // Enable SSL verification
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$requestBody = file_get_contents("ARQUIVO_REQUEST_CERTIFICADO.csr");
curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

$authToken = 'eyJraWQiOiIxNDZlNTY1Yy02ZjQ4LTRhN2EtOTU3NS1kYjg2MjE5YTc5N2MucHJkLmdlbi4xNTk3NjAwMTI1ODQ4Lmp3dCIsImFsZyI6IlJTMjU2In0.eyJzdWIiOiIxYTU3OTZlZi1lYzFlLTQ1NGEtYTQ0Mi04YmY0NjQ2ZTIwM2YiLCJpc3MiOiJodHRwczovL29wZW5pZC5pdGF1LmNvbS5ici9hcGkvb2F1dGgvdG9rZW4iLCJpYXQiOjE3MjQ4NjI5NzUsImV4cCI6MTcyNTQ2Nzc3NSwiQWNjZXNzX1Rva2VuIjoiWmZIUDJMeEMzUzZ6ZVc3TVB6S290M0pydFN0ZlZidEgzdjVYNzVhMXQyMmdPN3A1YlBRZHpCIiwianRpIjoiWmZIUDJMeEMzUzZ6ZVc3TVB6S290M0pydFN0ZlZidEgzdjVYNzVhMXQyMmdPN3A1YlBRZHpCIiwidXNyIjoibnVsbCIsImZsb3ciOiJUT0tFTlRFTVAiLCJzb3VyY2UiOiJFWFQiLCJzaXRlIjoiY3RtbTIiLCJlbnYiOiJQIiwibWJpIjoidHJ1ZSIsImF1dCI6Ik1BUiIsInZlciI6InYxLjAiLCJzY29wZSI6ImNlcnRpZmljYXRlLndyaXRlIn0.Fi2GEz3E58LHo6FHtNimjG_QGbWlxmdt3WOuhFDWuhL6IXJCBSVUxtsCvYNsmEsksTOxvMtro1gCyFhwpMaQzB8noiAp5zf1-pJPenLpEt6jkcerDM7FN3WPBIoGsh0V_uV4Y64cvzd9bqX9IGie8HdaAon9UkU2GsMTHchOM97qhMiGh0K7nTR_SmLF9z9AWevjjeQvISg7HjrW0oEkYrMKUtwTYmJvuRQ-CnqpA8t_-G_sPSZHXpK3PQNJDkZPksZBeRjfvGJlg5FIcj8scd4NnIsObolXhrAYdsGnmbZ75e8B9mCVc9dZmgMLzh8aTEPYDb43zSxA4HixX9kI7g'; // Generate or retrieve the JWT token securely
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Content-Type: text/plain",
    "Authorization: Bearer $authToken"
));

$response = curl_exec($ch);
$info = curl_getinfo($ch);

if (curl_errno($ch) > 0) {
    echo "cURL error: " . curl_error($ch);
} else {
    $httpCode = $info['http_code'];
    if ($httpCode >= 200 && $httpCode < 300) {
        // Handle successful response
        echo "Response: $response";
    } else {
        echo "HTTP error: $httpCode";
    }
}

curl_close($ch);