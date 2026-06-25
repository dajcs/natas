### natas8 pswd: ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc

```bash
curl -v -s -c cookie.txt -X POST http://natas8:ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc@natas8.natas.labs.overthewire.org


# * Host natas8.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas8.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 36768 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas8'
# > POST / HTTP/1.1
# > Host: natas8.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM4Onhjb1hMbXpNa29JUDlEN2hsZ1BsaDlYRDdPZ0xBZTVR
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Sun, 21 Jun 2026 05:45:07 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 990
# < Content-Type: text/html; charset=UTF-8
# < 
# <html>
# <head>

# <body>
# <h1>natas8</h1>
# <div id="content">
# 
# 
# <form method=post>
# Input secret: <input name=secret><br>
# <input type=submit name=submit>
# </form>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
# * Connection #0 to host natas8.natas.labs.overthewire.org:80 left intact
# 

```

- checking the page `index-source.html`
- the response is garbled with php syntax highlights so we're going to unscrambe it with terminal-based web browser `w3m`
- similar result by visiting from firefox, [view-source](http://natas8:ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc@natas8.natas.labs.overthewire.org/index-source.html)

```bash
curl -v -s -c cookie.txt  http://natas8:ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc@natas8.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html
# * Host natas8.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas8.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 56532 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas8'
# > GET /index-source.html HTTP/1.1
# > Host: natas8.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM4Onhjb1hMbXpNa29JUDlEN2hsZ1BsaDlYRDdPZ0xBZTVR
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Sun, 21 Jun 2026 06:11:38 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Last-Modified: Sun, 14 Jun 2026 17:38:50 GMT
# < ETag: "db4-6543a2ed6c53c"
# < Accept-Ranges: bytes
# < Content-Length: 3508
# < Vary: Accept-Encoding
# < Content-Type: text/html
# < 
# { [2627 bytes data]
# * Connection #0 to host natas8.natas.labs.overthewire.org:80 left intact
# <html>
# <head>
# </head>
# <body>
# <h1>natas8</h1>
# <div id="content">
# 
# <?
# 
# $encodedSecret = "3d3d516343746d4d6d6c315669563362";
# 
# function encodeSecret($secret) {
#     return bin2hex(strrev(base64_encode($secret)));
# }
# 
# if(array_key_exists("submit", $_POST)) {
#     if(encodeSecret($_POST['secret']) == $encodedSecret) {
#     print "Access granted. The password for natas9 is <censored>";
#     } else {
#     print "Wrong secret";
#     }
# }
# ?>
# 
# <form method=post>
# Input secret: <input name=secret><br>
# <input type=submit name=submit>
# </form>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>

```

- php source code with comments:

```php
<body>
<h1>natas8</h1>
<div id="content">

<?php 
// -------------------------------------------------------------------------
// PHP START
// -------------------------------------------------------------------------

// This is the "target" secret. Instead of storing the secret in plain text 
// where anyone can read it, the developer stored an encoded version of it. 
// The user's input will be encoded and compared against this string.
$encodedSecret = "3d3d516343746d4d6d6c315669563362";

// A custom function that takes a plain text string ($secret) and applies 
// three layers of obfuscation/encoding to it. Returns the $encodedSecret.
function encodeSecret($secret) {
    // From the inside out:
    //
    // Step 1: base64_encode($secret)
    //         Converts the plain text string into Base64 format.
    //
    // Step 2: strrev(...)
    //         Takes that Base64 string and reverses it (e.g., "abc" becomes "cba").
    //
    // Step 3: bin2hex(...)
    //         Takes the reversed string and converts ASCII -> hexadecimal representation.
    return bin2hex(strrev(base64_encode($secret)));
}

// Checks if the 'submit' key exists in the $_POST superglobal array.
// This ensures the PHP validation logic only runs AFTER the user clicks 
// the "submit" button on the HTML form below. If the page is just loading 
// normally (a GET request), this block is skipped.
if(array_key_exists("submit", $_POST)) {
    
    // Takes the user's input ($_POST['secret']), passes it through the 
    // encodeSecret() function, and checks if the output matches $encodedSecret.
    // If the encoded user input matches the encoded target string, it means 
    // the user must have known the original, plain-text secret.
    if(encodeSecret($_POST['secret']) == $encodedSecret) {
        
        // The user successfully inputted the correct secret, so they are 
        // rewarded with the password for the next level.
        print "Access granted. The password for natas9 is <censored>";
    
    } else {
        
        // Wrong secrect enteed.
        print "Wrong secret";
    }
}
?>

<!-- ----------------------------------------------------------------------- -->
<!-- HTML FORM START                                                         -->
<!-- ----------------------------------------------------------------------- -->

<!-- 
An HTML form that sends data to the current page using the POST method.
This allows the user to type in a guess and send it to the PHP script 
above so it can populate the $_POST array. 
-->
<form method=post>
<!-- The text box where the user types their guess. It is named "secret" so PHP can access it as $_POST['secret'] -->
Input secret: <input name=secret><br>

<!-- The button the user clicks to submit the form. It is named "submit" so PHP can trigger the array_key_exists check -->
<input type=submit name=submit>
</form>

<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
</html>
```

the `encodeSecret` function:
1. encodes base64 the input `secret`
2. reverses the string
3. converts the ASCII chars to hexadecimal

and we're comparing the result to the `$encodedSecret = "3d3d516343746d4d6d6c315669563362";`

To find the secret we'll reverse the process.

bash method:
```bash
# reverse hex
echo 3d3d516343746d4d6d6c315669563362 | xxd -r                           
                                                                                                                                                                 
# reverse hex + print
echo 3d3d516343746d4d6d6c315669563362 | xxd -r -p                        
==QcCtmMml1ViV3b                                                                                                                                                                 

# reverse hex, print | reverse string
echo 3d3d516343746d4d6d6c315669563362 | xxd -r -p | rev                  
b3ViV1lmMmtCcQ==                                                                                                                                                                 
# reverse hex, print | reverse string | base64 decode
echo 3d3d516343746d4d6d6c315669563362 | xxd -r -p | rev | base64 -d; echo
oubWYf2kBq
```

- same result with php method:

```bash
php -r 'echo base64_decode(strrev(hex2bin("3d3d516343746d4d6d6c315669563362"))) . "\n";'
oubWYf2kBq
```

from firefox POST request \ copy value \ copy as cURL we're getting the `--data-raw 'secret=oubWYf2kBq&submit=Submit+Query'` parameters

```bash
curl 'http://natas8:ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc@natas8.natas.labs.overthewire.org/' \
  --compressed \
  -X POST \
  -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0' \
  -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' \
  -H 'Accept-Language: en-US,en;q=0.5' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Content-Type: application/x-www-form-urlencoded' \
  -H 'Origin: http://natas8.natas.labs.overthewire.org' \
  -H 'Authorization: Basic bmF0YXM4Onhjb1hMbXpNa29JUDlEN2hsZ1BsaDlYRDdPZ0xBZTVR' \
  -H 'Connection: keep-alive' \
  -H 'Referer: http://natas8.natas.labs.overthewire.org/' \
  -H 'Upgrade-Insecure-Requests: 1' \
  -H 'Priority: u=0, i' \
  --data-raw 'secret=oubWYf2kBq&submit=Submit+Query'

# Access granted. The password for natas9 is UdxmI27dTaXmnd1rxKQTfws6jihTdcQ9
```

same result with "simplified" curl

```bash
curl -s  -X POST -d "secret=oubWYf2kBq&submit=Submit+Query"  http://natas8:ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc@natas8.natas.labs.overthewire.org/ 

# Access granted. The password for natas9 is UdxmI27dTaXmnd1rxKQTfws6jihTdcQ9
```
