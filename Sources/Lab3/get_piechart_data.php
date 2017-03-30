<?php
/**
 * Created by PhpStorm.
 * User: SIE
 * Date: 3/16/2017
 * Time: 16:58
 */
$data = [];
$data_length = random_int(3, 7);
for ($i = 0; $i < $data_length; ++$i) {
    array_push($data, random_int(20, 1024));
}
echo json_encode($data);

?>