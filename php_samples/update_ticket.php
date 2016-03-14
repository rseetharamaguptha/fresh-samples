<?php 

$api_key = "API_KEY";
$password = "x";
$yourdomain = "YOUR_DOMAIN";

$custom_fields = array(
  "department" => "Production"
);

$ticket_data = json_encode(array(
  "priority" => 3,
  "status" => 4,
  "description" => "Need support for the issue",
  "custom_fields" => $custom_fields
));

// Id of the ticket to be updated
$ticket_id = 44;

$url = "https://$yourdomain.freshdesk.com/api/v2/tickets/$ticket_id";

$ch = curl_init($url);

$header[] = "Content-type: application/json";
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$password");
curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
$info = curl_getinfo($ch);
$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$headers = substr($server_output, 0, $header_size);
$response = substr($server_output, $header_size);


if($info['http_code'] == 200) {
  echo "Ticket updated successfully, the response is given below \n";
  echo "Response Headers are \n";
  echo $headers."\n";
  echo "Response Body \n";
  echo "$response \n";
} else {
  if($info['http_code'] == 404) {
    echo "Error, Please check the end point \n";
  } else {
    echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
    echo "Headers are ".$headers;
    echo "Response are ".$response;
  }
}

curl_close($ch);

?>