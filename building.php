<?php

$mode = isset($_POST['mode']) ? $_POST['mode'] : NULL;

function translit($str) {
    $converter = array(
        'а' => 'a', 'б' => 'b', 'в' => 'v',
        'г' => 'g', 'д' => 'd', 'е' => 'e',
        'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
        'и' => 'i', 'й' => 'y', 'к' => 'k',
        'л' => 'l', 'м' => 'm', 'н' => 'n',
        'о' => 'o', 'п' => 'p', 'р' => 'r',
        'с' => 's', 'т' => 't', 'у' => 'u',
        'ф' => 'f', 'х' => 'h', 'ц' => 'c',
        'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
        'ь' => '\'', 'ы' => 'y', 'ъ' => '\'',
        'э' => 'e', 'ю' => 'yu', 'я' => 'ya',
        'А' => 'A', 'Б' => 'B', 'В' => 'V',
        'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
        'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
        'И' => 'I', 'Й' => 'Y', 'К' => 'K',
        'Л' => 'L', 'М' => 'M', 'Н' => 'N',
        'О' => 'O', 'П' => 'P', 'Р' => 'R',
        'С' => 'S', 'Т' => 'T', 'У' => 'U',
        'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
        'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
        'Ь' => '\'', 'Ы' => 'Y', 'Ъ' => '\'',
        'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
    );

    return strtr($str, $converter);
}

function getConnect() {
    $connect = mysqli_connect('localhost', 'root', 'root');
    mysqli_select_db($connect, 'donskoy_bd');
    mysqli_set_charset($connect, utf8);
    return $connect;
}

function insertStreet() {
    $street = $_POST['street'] != '' ? $_POST['street'] : NULL;
    $res = 0;  //res останется нулевым, если данные введены не корректно

    /*     * Преобразование улицы в ID */
    $map_id = translit($street);
    $map_id = strtoupper($map_id);
    /*     * */

    if ($street && $map_id) { //Если получена улица и сформирован map_id
        $query = "INSERT INTO street(name,map_id) VALUES ('$street','$map_id');";
        $res = mysqli_query(getConnect(), $query);
    }

    return ($res);
}

if ($mode == 'add-street') {
    echo insertStreet();
} elseif ($mode == 'update') {
    echo updateBuilding();
}
?>