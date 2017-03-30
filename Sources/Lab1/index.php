<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="style.css">
    <script type="text/javascript" src="javascript.js"></script>
    <script
            src="https://code.jquery.com/jquery-1.11.3.min.js"
            integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g="
            crossorigin="anonymous"></script>
    <script type="text/javascript">
        window.onload = WindowOnLoad;
    </script>
    <title>Labwork 2 - Web programming</title>
</head>
<body>
<div id="advanced-div" class="advanced-div" style="display: none;">
    <div class="cloud-div">
        <input class="cloud-close-button" type="image" src="./img/close.png" alt="_" onclick="InfoHide()"/>
        <div class="cloud-div-content" id="cloud-div-content">
            <div id="cloud-div-content-text">
            </div>
        </div>
    </div>
</div>
<?php
    // Show items.
    ShowItems();
?>
</body>
</html>
<?php

function ShowItems() {
    // Reading filenames.
    $dirScan = scandir("./img/items");
    // making list of items
    $items = array();
    foreach ($dirScan as $fileName) {
        if ($fileName == '..' or $fileName == '.') continue;
        array_push($items, $fileName);
    }
    // Showing.
    foreach ($items as $image) {
        // Echo main data.
        echo "<a href=\"#\">
<img class=\"image-item\" src=\"./img/items/".trim($image)."\" alt=\"".trim($image)."\"/>
</a>";
    };
}

?>