<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link type="text/css" rel="stylesheet" href="style.css">
    <script type="text/javascript" src="lab3-js.js"></script>
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
<div>
    <canvas id="piechart" width="400" height="400"></canvas>
    <img src="get_image.php?" width="300" height="240">
    <form action="upload.php" method="post" enctype="multipart/form-data">
        Select image to upload:
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload Image" name="submit">
    </form>
</div>
</body>
</html>

