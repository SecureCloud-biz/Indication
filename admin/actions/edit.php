<!-- SHTracker, Copyright Josh Fradley (http://sidhosting.co.uk/projects/shtracker) -->
<html> 
<head>
<title>SHTracker: Download Edited</title>
<link rel="stylesheet" type="text/css" href="../../style.css" />
</head>
<body>
<?php

//Connect to database
require_once("../../config.php");

$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
if (!$con) {
    die("Could not connect: " . mysql_error());
}

mysql_select_db(DB_NAME, $con);

$idtoedit = mysql_real_escape_string($_POST["idtoedit"]);

//Set variables
$newname = mysql_real_escape_string($_POST["name"]);
$newid = mysql_real_escape_string($_POST["id"]);
$newurl = mysql_real_escape_string($_POST["url"]);
$newcount = mysql_real_escape_string($_POST["count"]);

//Convert to lowercase
$newid = strtolower($newid);
$newurl = strtolower($newurl);

if (isset($_POST["passwordprotectstate"])) {
    $getprotectinfo = mysql_query("SELECT password FROM Data WHERE id = \"$idtoedit\"");
    $getprotectinforesult = mysql_fetch_assoc($getprotectinfo); 
    if (!isset($_POST["password"])) {
        die("<h1>SHTracker: Error</h1><p>Password is missing...</p><hr /><p><a href=\"javascript:history.go(-1)\">&larr; Go Back</a></p></body></html>");
    } 
    $inputtedpassword = mysql_real_escape_string($_POST["password"]);
    if (empty($inputtedpassword)) {
        $password = $getprotectinforesult["password"];
    } else {
        $password = sha1($inputtedpassword);
    }
    $protect = "true";
} else {
    $protect = "false";
    $password = "";
}

mysql_query("UPDATE Data SET name = \"$newname\", id = \"$newid\", url = \"$newurl\", count = \"$newcount\", protect = \"$protect\", password = \"$password\" WHERE id = \"$idtoedit\"");

mysql_close($con);

?> 
<h1>SHTracker: Download Edited</h1>
<p>The download <b><? echo $newname; ?></b> has been edited successfully.</p>
<p><b>Updated Details:</b></p>
<ul>
<li>Name : <? echo $newname; ?></li>
<li>ID : <? echo $newid; ?></li>
<li>URL : <? echo $newurl; ?></li>
</ul>
<p><b>Download link:</b></p>
<p><? echo PATH_TO_SCRIPT; ?>/get.php?id=<? echo $newid; ?></p>
<hr />
<p><a href="../../admin">Back To Home</a></p>
</body>
</html>