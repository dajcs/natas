### natas8 pswd: xcoXLmzMkoIP9D7hlgPlh9XD7OgLAe5Q

```bash
curl -v -s -c cookie.txt -X POST http://natas8:xcoXLmzMkoIP9D7hlgPlh9XD7OgLAe5Q@natas8.natas.labs.overthewire.org

```
firefox, [view-source](http://natas8:xcoXLmzMkoIP9D7hlgPlh9XD7OgLAe5Q@natas8.natas.labs.overthewire.org/index-source.html)


php source code

```php
<body>
<h1>natas8</h1>
<div id="content">

<?

$encodedSecret = "3d3d516343746d4d6d6c315669563362";

function encodeSecret($secret) {
    return bin2hex(strrev(base64_encode($secret)));
}

if(array_key_exists("submit", $_POST)) {
    if(encodeSecret($_POST['secret']) == $encodedSecret) {
    print "Access granted. The password for natas9 is <censored>";
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