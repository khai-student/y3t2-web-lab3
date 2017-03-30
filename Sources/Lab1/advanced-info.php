<?php
/**
 * Created by PhpStorm.
 * User: Yuriy Vlasov
 * Date: 08.02.2017
 * Time: 8:24
 */

$items = ReadDomXml();
if (GetParam("image-name") != NULL) {
    $asked_image = GetParam("image-name");
    $is_item_found = false;
    foreach ($items as $item) {
        if ($item->image == trim($asked_image)) {
            echo json_encode($item);
            $is_item_found = true;
            break;
        }
    }
    if ($is_item_found == false) {
        echo 'Item not found: '.trim($asked_image);
    }
}
else {
    echo 'Bad advanced-info request.';
}

function GetParam($param_name, $default = NULL) {
    $result = $default;

    if (isset($_POST[$param_name])) {
        $result = $_POST[$param_name];
    }
    elseif (isset($_GET[$param_name])) {
        $result = $_GET[$param_name];
    }

    return $result;
}

class Item {
    public $title;
    public $price;
    public $quantity;
    public $id;
    public $about;
    public $other_info;
    public $image;

    function __construct($id)
    {
        $this->id = $id;
    }
}

function ReadDomXml() {
    //TODO Implement AddItemToDb.
    // Making new DOM document to load xml.
    $xml_db = new DOMDocument("1.0");
    $xml_db->preserveWhiteSpace = false;
    $xml_db->formatOutput = true;
    $xml_db->load("db.xml", LIBXML_DTDVALID);
    $root = $xml_db->documentElement;
    // Loading.
    $items = array();
    $new_item = NULL;
    foreach ($root->childNodes as $item) {
        // Creation of the object for each <item>.
        if ($item->nodeName == "item") {
            // Adding new element to array if it is not null.
            if ($new_item != NULL) {
                array_push($items, $new_item);
            }
            $new_item = new Item(trim($item->getAttribute("id")));

            foreach ($item->childNodes AS $property) {
                // Parsing fields.
                switch ($property->nodeName) {
                    case "title": {
                        $new_item->title = trim($property->nodeValue);
                        break;
                    }
                    case "price": {
                        $new_item->price = trim($property->nodeValue);
                        break;
                    }
                    case "quantity": {
                        $new_item->quantity = trim($property->nodeValue);
                        break;
                    }
                    case "about": {
                        $new_item->about = trim($property->nodeValue);
                        break;
                    }
                    case "image": {
                        $new_item->image = trim($property->nodeValue);
                        break;
                    }
                    case "advanced-info": {
                        foreach ($property->childNodes as $adv_info) {
                            $new_item->other_info[trim($adv_info->getAttribute("text"))] = trim($adv_info->nodeValue);
                        }
                        break;
                    }
                }
            }
        }
    }

    return $items;
}

?>