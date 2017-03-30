<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style-filemanager.css" type="text/css">
    <title>Labwork 5</title>
</head>
<body class="fm-body">
<?php
class Item {
    public $name;
    public $path;
    public $type;
    public $size;
    public $ctime;

    function __construct($name, $path, $type, $size, $ctime) {
        $this->name = $name;
        $this->path = $path;
        $this->type = $type;
        $this->size = $size;
        $this->ctime = $ctime;
    }
}

$MainRoot = dirname(__FILE__);
$CurrentDir = GetParam("CurrentDir", $MainRoot);

$SortDirection = GetParam("SortDirection", "Ascending");
$SortValue = GetParam("SortValue", "Filename");

$clickedItem = GetParam("ClickedItem");
if ($clickedItem !== NULL and $clickedItem !== 'NULL' and is_dir(realpath($CurrentDir.'\\'.$clickedItem))) {
    $CurrentDir = realpath($CurrentDir.'\\'.$clickedItem);
}

if (strlen($CurrentDir) < strlen(   $MainRoot)) {
    $CurrentDir = $MainRoot;
}
?>
<header>
    <div class="fm-div header-menu item">
        <div class="fm-div field-name field">
            <p class='fm-p'> Filename</p>
        </div>
        <div class="fm-div field-type field">
            <p class='fm-p'> Extension</p>
        </div>
        <div class="fm-div field-size field">
            <p class='fm-p'> Size</p>
        </div>
        <div class="fm-div field-ctime field" >
            <p>
                Creation time
            </p>
        </div>
    </div>
</header>
<footer>
    <div class="fm-div footer-menu item">
        <div class="fm-div field" >
            <a class="fm-a" href="javascript: jsChangeSortDirection()">
                <?php
                if ($SortDirection == "Ascending")
                    echo "<img class=\"fm-img\" src=\"./img/icon-ascending.png\" alt=\"Icon\">";
                else
                    echo "<img class=\"fm-img\" src=\"./img/icon-descending.png\" alt=\"Icon\">";
                ?>
            </a>
        </div>
        <div class="fm-div field-name field">
            <a class="fm-a"  href="javascript: jsSort('Filename')">
                <p class='fm-p'>Sort by filename</p>
            </a>
        </div>
        <div class="fm-div field-type field">
            <a class="fm-a"  href="javascript: jsSort('Extension')">
                <p class='fm-p'>Ext</p>
            </a>
        </div>
        <div class="fm-div field-size field">
            <a class="fm-a"  href="javascript: jsSort('Size')">
                <p class='fm-p'>Size</p>
            </a>
        </div>
        <div class="fm-div field-ctime field" >
            <a class="fm-a"  href="javascript: jsSort('CTime')">
                <p class="fm-p">
                    CTime
                </p>
            </a>
        </div>
    </div>
</footer>
<main>
    <form name="menuForm" action="filemanager.php" method="post">
        <?php
        echo "<input type=\"hidden\" name=\"CurrentDir\" value=\"$CurrentDir\">
                <input type=\"hidden\" name=\"ClickedItem\" value=\"NULL\">
                <input type=\"hidden\" name=\"SortDirection\" value=\"$SortDirection\">
                <input type=\"hidden\" name=\"SortValue\" value=\"$SortValue\">";
        ?>
        <div class="fm-div menu">
            <?php
            $dirScan = scandir($CurrentDir);
            // making list of items
            $menuItems = array();
            foreach ($dirScan as $fileName) {
                if ($fileName == '..' or $fileName == '.') continue;
                $path = realpath($CurrentDir.'\\'.$fileName);
                $type = GetFileType($path);
                $size = GetFileSize($path, false);
                $ctime = GetFileCTime($path, false);

                array_push($menuItems, new Item($fileName, $path, $type, $size, $ctime));
            }
            // sorting dirs before files
            $isDirsBeforeFiles = true;
            do {
                $isDirsBeforeFiles = true;
                $fileHappened = false;
                // checking order
                foreach ($menuItems as $item) {
                    if ($item->type !== "Directory") $fileHappened = true;
                    elseif ($fileHappened and $item->type == "Directory") {
                        $isDirsBeforeFiles = false;
                        break;
                    }
                }
                // bubble sort
                if ($isDirsBeforeFiles == false) {
                    for ($itemIndex = 0; $itemIndex <= sizeof($menuItems) - 2; ++$itemIndex) {
                        if ($menuItems[$itemIndex]->type !== "Directory" and
                            $menuItems[$itemIndex+1]->type == "Directory") {
                            // swap if needed
                            $temp = $menuItems[$itemIndex];
                            $menuItems[$itemIndex] = $menuItems[$itemIndex+1];
                            $menuItems[$itemIndex+1] = $temp;
                        }
                    }
                }
            } while ($isDirsBeforeFiles == false);
            // sorting by asked value and in asked direction
            $lastDirIndex = -1; // looking for las dir in list
            for ($itemIndex = 0; $itemIndex < sizeof($menuItems); ++$itemIndex) {
                if ($menuItems[$itemIndex]->type == "Directory") {
                    $lastDirIndex++;
                }
                else if ($menuItems[$itemIndex]->type !== "Directory") {
                    break;
                }
            }
            // sort firs first
            if ($lastDirIndex !== -1) {
                // sort dirs separately
                $isDirsSorted = true;
                do {
                    $isDirsSorted = true;
                    for ($itemIndex = 0; $itemIndex <= $lastDirIndex-1; ++$itemIndex) {
                        $needBubble = false;
                        switch ($SortValue) {
                            case "Extension":
                            case "Filename": {
                                $tempArray = array($menuItems[$itemIndex]->name, $menuItems[$itemIndex+1]->name);
                                if ($SortDirection == "Ascending") {
                                    sort($tempArray, SORT_STRING | SORT_FLAG_CASE);
                                }
                                else {
                                    rsort($tempArray, SORT_STRING | SORT_FLAG_CASE);
                                }

                                if ($tempArray[0] !== $menuItems[$itemIndex]->name) {
                                    $needBubble = true;
                                }
                                break;
                            }
                            case "Size": {
                                $tempArray = array($menuItems[$itemIndex]->size, $menuItems[$itemIndex+1]->size);
                                if ($SortDirection == "Ascending") {
                                    sort($tempArray, SORT_NUMERIC);
                                }
                                else {
                                    rsort($tempArray, SORT_NUMERIC);
                                }
                                if ($tempArray[0] !== $menuItems[$itemIndex]->size) {
                                    $needBubble = true;
                                }
                                break;
                            }
                            case "CTime": {
                                $tempArray = array($menuItems[$itemIndex]->ctime, $menuItems[$itemIndex+1]->ctime);
                                if ($SortDirection == "Ascending") {
                                    sort($tempArray, SORT_NUMERIC);
                                }
                                else {
                                    rsort($tempArray, SORT_NUMERIC);
                                }
                                if ($tempArray[0] !== $menuItems[$itemIndex]->ctime) {
                                    $needBubble = true;
                                }
                                break;
                            }
                            default: {
                                break;
                            }
                        }

                        if ($needBubble == true) {
                            // swap if needed
                            $temp = $menuItems[$itemIndex];
                            $menuItems[$itemIndex] = $menuItems[$itemIndex+1];
                            $menuItems[$itemIndex+1] = $temp;
                            $isDirsSorted = false;
                        }
                    }
                } while ($isDirsSorted == false);
            }
            // sorting files
            if (sizeof($menuItems) - $lastDirIndex - 1 > 1) {
                $isFilesSorted = true;
                do {
                    $isFilesSorted = true;
                    for ($itemIndex = $lastDirIndex+1; $itemIndex <= sizeof($menuItems)-2; ++$itemIndex) {
                        $needBubble = false;
                        switch ($SortValue) {
                            case "Extension":
                            case "Filename": {
                                $tempArray = array($menuItems[$itemIndex]->name, $menuItems[$itemIndex+1]->name);
                                if ($SortDirection == "Ascending") {
                                    sort($tempArray, SORT_STRING | SORT_FLAG_CASE);
                                }
                                else {
                                    rsort($tempArray, SORT_STRING | SORT_FLAG_CASE);
                                }

                                if ($tempArray[0] !== $menuItems[$itemIndex]->name) {
                                    $needBubble = true;
                                }
                                break;
                            }
                            case "Size": {
                                $tempArray = array($menuItems[$itemIndex]->size, $menuItems[$itemIndex+1]->size);
                                if ($SortDirection == "Ascending") {
                                    sort($tempArray, SORT_NUMERIC);
                                }
                                else {
                                    rsort($tempArray, SORT_NUMERIC);
                                }
                                if ($tempArray[0] !== $menuItems[$itemIndex]->size) {
                                    $needBubble = true;
                                }
                                break;
                            }
                            case "CTime": {
                                $tempArray = array($menuItems[$itemIndex]->ctime, $menuItems[$itemIndex+1]->ctime);
                                if ($SortDirection == "Ascending") {
                                    sort($tempArray, SORT_NUMERIC);
                                }
                                else {
                                    rsort($tempArray, SORT_NUMERIC);
                                }
                                if ($tempArray[0] !== $menuItems[$itemIndex]->ctime) {
                                    $needBubble = true;
                                }
                                break;
                            }
                            default: {
                                break;
                            }
                        }

                        if ($needBubble == true) {
                            // swap if needed
                            $temp = $menuItems[$itemIndex];
                            $menuItems[$itemIndex] = $menuItems[$itemIndex+1];
                            $menuItems[$itemIndex+1] = $temp;
                            $isFilesSorted = false;
                        }
                    }
                } while ($isFilesSorted == false);
            }
            // displaying
            if ($CurrentDir !== $MainRoot and strlen($CurrentDir) > strlen($MainRoot)) {
                AddItem("..", "Directory", GetFileSize($CurrentDir.'\\..'), GetFileCTime($CurrentDir.'\\..'));
            }
            foreach ($menuItems as $menuItem) {
                AddItem($menuItem->name, GetFileType($menuItem->path), GetFileSize($menuItem->path), GetFileCTime($menuItem->path));
            }
            ?>
        </div>
    </form>
    <script type="text/javascript">
        function jsSubmitForm(clickedItem)
        {
            document.forms.namedItem("menuForm").elements["ClickedItem"].value = clickedItem;
            document.menuForm.submit();
        }
        function jsSort(sortValue)
        {
            document.forms.namedItem("menuForm").elements["SortValue"].value = sortValue;
            document.menuForm.submit();
        }
        function jsChangeSortDirection()
        {
            if (document.forms.namedItem("menuForm").elements["SortDirection"].value == "Ascending") {
                document.forms.namedItem("menuForm").elements["SortDirection"].value = "Descending";
            }
            else {
                document.forms.namedItem("menuForm").elements["SortDirection"].value ="Ascending";
            }
            document.menuForm.submit();
        }
    </script>
</main>
</body>
</html>
<?php
    function AddItem($fileName = "Test file name", $extension = "txt", $size = "1 Gb", $ctime = "2016.10.22<br>10:23") {
        echo "
        <a class=\"fm-a\"  href=\"javascript: jsSubmitForm('$fileName')\">
        <div class=\"item hover\">
            <div class=\"field-name field\">
                <p class='fm-p'> $fileName</p>
            </div>
            <div class=\"field-type field\">
                <p class='fm-p'> $extension</p>
            </div>
            <div class=\"field-size field\">
                <p class='fm-p'> $size</p>
            </div>
            <div class=\"field-ctime field\">
                <p class='fm-p'> $ctime</p>
            </div>
        </div>
        </a>";
    }

    function GetFileSize($fileName, $addValue = true, $size = 0) {
        $result = $size;
        if ($result == 0) {
            if (is_dir($fileName)) {
                $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($fileName));
                foreach ($iterator as $i)
                {
                    $result += $i->getSize();
                }
            }
            else {
                $result = filesize($fileName);
            }
        }


        if ($addValue) {
            $divisionsMade = 0;
            while ($result >= 1024) {
                $result /= 1024;
                $divisionsMade++;
            }
            $result = round($result, 2);
            switch ($divisionsMade) {
                case 0: {
                    $result = $result.' B';
                    break;
                }
                case 1: {
                    $result = $result.' KB';
                    break;
                }
                case 2: {
                    $result = $result.' MB';
                    break;
                }
                case 3: {
                    $result = $result.' GB';
                    break;
                }
                case 4: {
                    $result = $result.' TB';
                    break;
                }
                case 5: {
                    $result = $result.' PB';
                    break;
                }
                default: {
                    break;
                }
            }
        }

        return $result;
    }

    function GetFileCTime($fileName, $parse = true) {
        $result = filectime($fileName);
        if ($parse) {
            $result = str_replace(".", "<br>", date("H:i:s.d F Y", $result));
        }
        return $result;
    }

    function GetFileType($fileName) {
        if (is_dir($fileName)) {
            return "Directory";
        }
        $type = pathinfo($fileName);

        if (isset($type['extension'])) {
            $type = $type['extension'];
//            $type[0] = strtoupper(substr($type, 0, 1));
//            if ($type == "Txt") {
//                $type = "Text file";
//            }
//            elseif ($type == "Txt") {
//                $type = "Text file";
//            }
//            elseif ($type == "Php") {
//                $type = "PHP file";
//            }
//            elseif ($type == "Html" or $type == "Htm") {
//                $type = "HTML file";
//            }
//            elseif ($type == "Css") {
//                $type = "Stylesheet file";
//            }
        }
        else {
            $type = "Unknown<br>extension";
        }
        return $type;
    }

    function GetParam($paramName, $default = NULL) {
        $result = $default;

        if (isset($_POST[$paramName])) {
            $result = $_POST[$paramName];
        }
        elseif (isset($_GET[$paramName])) {
            $result = $_GET[$paramName];
        }

        return $result;
    }
?>