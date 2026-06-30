### natas15 pswd: GB6USCJYJjwLyYhZUNkE1NwDueiTow6g

```bash
curl  -s  http://natas15:GB6USCJYJjwLyYhZUNkE1NwDueiTow6g@natas15.natas.labs.overthewire.org
# <html>
# <body>
# <h1>natas15</h1>
# <div id="content">
# 
# <form action="index.php" method="POST">
# Username: <input name="username"><br>
# <input type="submit" value="Check existence" />
# </form>
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
# 
```

getting the source code:

```bash
curl  -s  http://natas15:GB6USCJYJjwLyYhZUNkE1NwDueiTow6g@natas15.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html
# <html>
# <body>
# <h1>natas15</h1>
# <div id="content">
# <?php
# 
# /*
# CREATE TABLE `users` (
#   `username` varchar(64) DEFAULT NULL,
#   `password` varchar(64) DEFAULT NULL
# );
# */
# 
# if(array_key_exists("username", $_REQUEST)) {
#     $link = mysqli_connect('localhost', 'natas15', '<censored>');
#     mysqli_select_db($link, 'natas15');
# 
#     $query = "SELECT * from users where username=\"".$_REQUEST["username"]."\""
# ;
#     if(array_key_exists("debug", $_GET)) {
#         echo "Executing query: $query<br>";
#     }
# 
#     $res = mysqli_query($link, $query);
#     if($res) {
#     if(mysqli_num_rows($res) > 0) {
#         echo "This user exists.<br>";
#     } else {
#         echo "This user doesn't exist.<br>";
#     }
#     } else {
#         echo "Error in query.<br>";
#     }
# 
#     mysqli_close($link);
# } else {
# ?>
# 
# <form action="index.php" method="POST">
# Username: <input name="username"><br>
# <input type="submit" value="Check existence" />
# </form>
# <?php } ?>
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```

The php code with comments:

```php
<html>
<body>
<h1>natas15</h1>
<div id="content">
<?php

// 1. THE DATABASE SCHEMA (A huge hint!)
// The developer left a comment showing exactly how the database is structured.
// We now know for a fact there is a table named `users` with columns `username` and `password`.
/*
CREATE TABLE `users` (
  `username` varchar(64) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL
);
*/

// 2. CHECK FOR SUBMISSION
// Check if the user submitted a username via the form.
if(array_key_exists("username", $_REQUEST)) {
    
    // Connect to the database
    $link = mysqli_connect('localhost', 'natas15', '<censored>');
    mysqli_select_db($link, 'natas15');

    // ---------------------------------------------------------
    // 3. BUILD THE SQL QUERY (THE FATAL FLAW)
    // ---------------------------------------------------------
    // Just like Natas 14, they are taking the raw input and gluing it directly 
    // into the SQL string without any escaping or sanitization.
    // They are ONLY asking for the username this time, not the password.
    $query = "SELECT * from users where username=\"".$_REQUEST["username"]."\"";
    
    // We can still append ?debug to the URL to see our injected query.
    if(array_key_exists("debug", $_GET)) {
        echo "Executing query: $query<br>";
    }

    // 4. EXECUTE AND PARSE RESULTS (THE BLIND SQLi)
    $res = mysqli_query($link, $query);
    if($res) {
        
        // If the query returns 1 or more rows, it just prints "This user exists."
        if(mysqli_num_rows($res) > 0) {
            echo "This user exists.<br>";
            
        // If it returns 0 rows, it prints "This user doesn't exist."
        } else {
            echo "This user doesn't exist.<br>";
        }
    } else {
        // If the SQL injection has a syntax error (like a missing quote), it prints this.
        echo "Error in query.<br>";
    }

    mysqli_close($link);
} else {
?>

<!-- 5. THE HTML FORM -->
<form action="index.php" method="POST">
Username: <input name="username"><br>
<input type="submit" value="Check existence" />
</form>
<?php } ?>
<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
</html>
```





---

A generic Python script using the `requests` library. It demonstrates how to send parameterized requests for both **GET** (parameters in the URL) and **POST** (parameters in the body), handle Basic Authentication (needed for Natas), and search the response.

### The Python Script

```python
import requests

# ==========================================
# 1. SETUP & AUTHENTICATION
# ==========================================
# Target URLs (using httpbin.org which just echoes back what you send it)
url_get = "http://httpbin.org/get"
url_post = "http://httpbin.org/post"

# Basic Authentication tuple (perfect for Natas levels!)
my_auth = ('natas_username', 'natas_password')


# ==========================================
# 2. SENDING A GET REQUEST
# ==========================================
# For GET requests, parameters are appended to the URL (e.g., ?debug=1&search=apple)
get_params = {
    'debug': '1',
    'search': 'apple'
}

print("--- Sending GET Request ---")
# The 'params' argument automatically safely encodes the URL
response_get = requests.get(url_get, params=get_params, auth=my_auth)

print("Constructed URL:", response_get.url)
print("Status Code:", response_get.status_code)


# ==========================================
# 3. SENDING A POST REQUEST
# ==========================================
# For POST requests (like submitting an HTML form), parameters go in the body
post_data = {
    'username': 'admin',
    'password': 'mysecretpassword'
}

print("\n--- Sending POST Request ---")
# The 'data' argument sends it as standard form data (application/x-www-form-urlencoded)
response_post = requests.post(url_post, data=post_data, auth=my_auth)

print("Status Code:", response_post.status_code)


# ==========================================
# 4. READING THE RESPONSE
# ==========================================
print("\n--- Checking Response Content ---")

# response_post.text contains the raw HTML/text returned by the server
html_output = response_post.text

# This is how we play the "20 Questions" game for Blind SQLi!
if "This user exists" in html_output:
    print("[+] True! The database returned a match.")
elif "This user doesn't exist" in html_output:
    print("[-] False! No match found.")
else:
    print("[!] Something else happened (maybe an error or bad syntax).")
```

### Key Takeaways for Scripting the Exploit:

1. **URL Encoding is Automatic:** Notice how to pass a Python dictionary (`{ 'username': 'admin' }`) into the `data` or `params` arguments. The `requests` library automatically URL-encodes the payload (turning spaces into `%20`, `#` into `%23`, etc.). No need to manually encode the SQL injections!
2. **`response.text` is the answer:** This holds the entire HTML response. It can be used Python's `in` keyword (e.g., `if "keyword" in response.text:`) to instantly check if the SQL injection resulted in a True or False statement.
3. **Session Re-use (Advanced):** When running thousands of requests in a loop, doing `requests.post()` over and over, this opens a new TCP connection every time, which is slow. The `Session` object can be used to speed it up drastically:

```python
# Creates a persistent session that keeps the connection open
s = requests.Session()
s.auth = ('natas15', 'GB6USCJYJjwLyYhZUNkE1NwDueiTow6g')

# Now s.post() can be used inside the loop instead of requests.post()
response = s.post(url, data={'username': 'payload'})
```

