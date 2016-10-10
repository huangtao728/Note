<?php

// Root URL of the website.
$URL = "http://note.jht.io";

// Subfolder to output user content.
$FOLDER = "_tmp";


function sanitize_file_name($filename) {
    // Original function borrowed from Wordpress.
    $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", ".");
    $filename = str_replace($special_chars, '', $filename);
    $filename = preg_replace('/[\s-]+/', '-', $filename);
    $filename = trim($filename, '.-_');
    return $filename;
}


if (!isset($_GET["f"])) {
    // User has not specified a name, get one and refresh.
    $lines = file("words.txt");
    $name = trim($lines[array_rand($lines)], "\n");
    while (file_exists($FOLDER."/".$name) && strlen($name) < 10) {
        $name .= rand(0,9);
    }
    if (strlen($name) < 10) {
        header("Location: ".$URL."/".$name);
    }
    die();
}

$name = sanitize_file_name($_GET["f"]);
$path = $FOLDER."/".$name;

if (isset($_POST["t"])) {
    // Update content of file
    file_put_contents($path, $_POST["t"]);
    die();
}
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#ebeef2" />
    <title>Note</title>
    <link href="lib/normalize.css" rel="stylesheet" />
    <link href="styles.css" rel="stylesheet" />
    
    <link rel="shortcut icon" href="meta/favicon.png" type="image/png" />
    <link rel="icon" href="meta/favicon.png" type="image/png" />
    <link rel="apple-touch-icon" href="meta/app.png" />
    <link rel="apple-touch-icon-precomposed" href="meta/app.png"/>
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="msapplication-TileColor" content="ebeef2" />
    <meta name="msapplication-TileImage" content="meta/app.png"/>
    <meta name="theme-color" content="#ebeef2">

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, target-densitydpi=160dpi, initial-scale=1.0, maximum-scale=1, user-scalable=no, minimal-ui">
    <meta name="format-detection" content="telephone=no" />
    
    <meta property="og:title" content="Note"/>
    <meta property="og:site_name" content="Note"/>
    <meta property="og:description" content="note.jht.io"/>
    <meta property="og:image" content="http://note.jht.io/meta/app.png"/>
</head>
<body>

    <div class="stack">
        <div class="layer">
            <div class="layer">
                <div class="layer">
                <textarea class="content"><?php if (file_exists($path)) { print htmlspecialchars(file_get_contents($path)); } ?></textarea>
                </div>
            </div>
        </div>
    </div>
    <div class="flag">
        <a href="http://note.jht.io/">Note</a> /<?php print $name; ?>
    </div>
    <pre class="print"></pre>
    <script src="lib/jquery.min.js"></script>
    <script src="lib/jquery.textarea.js"></script>
    <script src="script.js"></script>
</body>
</html>
