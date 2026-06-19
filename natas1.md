```bash
#┌──(kali㉿kali)-[~/Projects/natas]
#└─$ 
curl -s -X POST  http://natas0:natas0@natas0.natas.labs.overthewire.org  
# <html>
# <head>
# <!-- This stuff in the header has nothing to do with the level -->
# <link rel="stylesheet" type="text/css" href="http://natas.labs.overthewire.org/css/level.# css">
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/jquery-ui.css" />
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/wechall.css" />
# <script src="http://natas.labs.overthewire.org/js/jquery-1.9.1.js"></script>
# <script src="http://natas.labs.overthewire.org/js/jquery-ui.js"></script>
# <script src=http://natas.labs.overthewire.org/js/wechall-data.js></script><script src="http://natas.labs.overthewire.org/js/wechall.js"></script>
 <script>var wechallinfo = { "level": "natas0", "pass": "natas0" };</script></head>
# <body>
# <h1>natas0</h1>
# <div id="content">
# You can find the password for the next level on this page.
# 
<!--The password for natas1 is 0nzCigAq7t2iALyvU9xcHlYN4MlkIwlq -->
# </div>
# </body>
# </html>

#┌──(kali㉿kali)-[~/Projects/natas]
#└─$ 
curl -s -X POST  http://natas0:natas0@natas0.natas.labs.overthewire.org -v 
# * Host natas0.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas0.natas.labs.overthewire.org (13.53.215.123 port 80) # from 10.0.2.15 port 58198 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas0'
# > POST / HTTP/1.1
# > Host: natas0.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXMwOm5hdGFzMA==
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 12:23:44 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Last-Modified: Sun, 14 Jun 2026 17:38:50 GMT
# < ETag: "396-6543a2ed21ec7"
# < Accept-Ranges: bytes
# < Content-Length: 918
# < Vary: Accept-Encoding
# < Content-Type: text/html
# < 
# <html>
# <head>
# <!-- This stuff in the header has nothing to do with the level -->
# <link rel="stylesheet" type="text/css" href="http://natas.labs.overthewire.org/css/level.# css">
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/jquery-ui.css" />
# <link rel="stylesheet" href="http://natas.labs.overthewire.org/css/wechall.css" />
# <script src="http://natas.labs.overthewire.org/js/jquery-1.9.1.js"></script>
# <script src="http://natas.labs.overthewire.org/js/jquery-ui.js"></script>
# <script src=http://natas.labs.overthewire.org/js/wechall-data.js></script><script # src="http://natas.labs.overthewire.org/js/wechall.js"></script>
# <script>var wechallinfo = { "level": "natas0", "pass": "natas0" };</script></head>
# <body>
# <h1>natas0</h1>
# <div id="content">
# You can find the password for the next level on this page.
# 
# <!--The password for natas1 is 0nzCigAq7t2iALyvU9xcHlYN4MlkIwlq -->
# </div>
# </body>
# </html>
# 
# * Connection #0 to host natas0.natas.labs.overthewire.org:80 left intact
# 