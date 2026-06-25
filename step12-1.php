<?php
$plaintext = json_encode(array("showpassword"=>"no", "bgcolor"=>"#ffffff"));
$cookie = "EGAgHwQ1IxYYMSQYGSZxTUksPFVHYDEQCC0/GBlgaVVIJDURDSQ1VRY=";
$ciphertext = base64_decode($cookie);
echo $ciphertext;

$key = ""; // using double quotes here to be safe
for($i=0; $i < strlen($plaintext); $i++) {
    $key .= $plaintext[$i] ^ $ciphertext[$i];
}

echo "The repeating key is: " . $key . "\n";
?>
