<?php

require_once './connect.php';

$mode = isset($_POST['mode']) ? $_POST['mode'] : null;

function deleteItem() {
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $table = isset($_POST['table']) ? $_POST['table'] : NULL;
    $query = "DELETE FROM ". $table ." WHERE id=" . $id . ";";
    $res = mysqli_query(getConnect(), $query);

    return $res;
}

function getAllItem($tab) {
    $table = isset($_POST['table'])?$_POST['table'] : $tab;

    $query = "SELECT * FROM ". $table;
    //var_dump($query);
    return tempAll($query);
}

function getItemById($where,$id) {
    $query = "SELECT * FROM ".$_POST['table']." WHERE ".$where."=".$id;
    //var_dump($query);
    if ($_POST['id']) {
        return tempAssoc($query);
    }
    else {
    //var_dump($query);
        return tempAll($query);
    }
}

function getBuilding (){
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $ediction_id = isset($_POST['ediction_id']) ? $_POST['ediction_id'] : null;
    $query = "SELECT b.id, b.home_number, b.apart_number, b.type, b.type_apart, b.floor, b.area, b.space_area, u.user_surname, u.user_name, u.user_lastname, s.name, u.id AS user_id FROM building b LEFT JOIN user u ON u.id = b.user_id LEFT JOIN street s ON s.id = b.street_id ";
    if ($ediction_id){
        $query .= "WHERE b.street_id = ".$ediction_id;
        }
    elseif ($id){
        $query .= "WHERE b.id = ".$id;
        return tempAssoc($query);
    }
    else {
        $query .= "WHERE b.user_id IS NULL;";
    }
    return tempAll($query);
}

function getContact() {
    $id = isset($_POST['id']) ? $_POST['id'] : $_POST['ediction_id'];
    $where = 'id';
    if ($id) {
        if ($_POST['table'] == 'auto' && $_POST['ediction_id']){
            $where = 'user_id';
        }
        elseif ($_POST['table'] == 'building' && $_POST['ediction_id']){
            $where = 'street_id';
        }
        elseif ($_POST['table'] == 'addit_journal'){
            $where = 'paid is NULL AND user_id';
        }
        return getItemById($where,$id);
    }
    else  {
        return getAllItem ($tab);
    }
}

function getUserByStreet(){
    $ediction_id = isset($_POST['ediction_id']) ? $_POST['ediction_id'] : null;
    $query = "SELECT id, user_surname, user_name, user_lastname FROM user";
        if ($ediction_id){
            $query = "SELECT u.id, u.user_surname, u.user_name, u.user_lastname FROM user u LEFT JOIN building b ON u.home_id = b.id ";
            $query .= "WHERE b.street_id=". $ediction_id;
        }
        //var_dump($query);
    return tempAll($query);
}

function getAuto($user_id, $role) {

    $query = "SELECT id, auto_number, mark, model, DATEDIFF(close_date, NOW()) AS close_count, DATE_FORMAT(close_date, '%d-%m-%Y') AS close_date FROM auto WHERE DATEDIFF(close_date, NOW()) > -14 ";
    if (isset($_POST['id'])){
        $query .= "AND id=".$_POST['id'];
        return tempAssoc($query);
    }
    elseif ($role >= 3 && !(isset($_POST['id']))) {
        $query .= "AND user_id=".$user_id;
    }

    $res = mysqli_query(getConnect(), $query);
    $result = mysqli_fetch_all($res);
    //var_dump($result);
    for ($j = 0; $j <= count($result)-1; $j++){
        for ($i = 1; $i<= count($result[$j])-1; $i++){
           if ($result[$j][$i] < 0){
               $result[$j][$i] = '-';
           }
        }
    }
    return json_encode($result);
    //return tempAll($query);
}

function getGuest($user_id, $role) {

    $query = "SELECT id, guest_surname, guest_name, guest_patronymic, note, DATEDIFF(close_date, NOW()) AS close_count, DATE_FORMAT(close_date, '%d-%m-%Y') AS close_date FROM guest WHERE DATEDIFF(close_date, NOW()) > -14 ";
    if (isset($_POST['id'])){
        $query .= "AND id=".$_POST['id'];
        return tempAssoc($query);
    }
    elseif ($role >= 3 && !(isset($_POST['id']))) {
        $query .= "AND user_id=".$user_id;
    }

    $res = mysqli_query(getConnect(), $query);
    $result = mysqli_fetch_all($res);
    for ($j = 0; $j <= count($result)-1; $j++){
        for ($i = 1; $i<= count($result[$j])-1; $i++){
        //var_dump($result[$j][$i]);
           if ($result[$j][$i] < 0){
               $result[$j][$i] = '-';
           }
        }
    }
    return json_encode($result);
}

function getNews(){
    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;
    $role = isset($_POST['role']) ? $_POST['role'] : NULL;
    if (!$user_id || $role < 3) {
        $query = "SELECT n.id, n.header_news, n.text_news, u.user_surname, u.user_name, u.user_lastname, DATE_FORMAT(n.date, '%d-%m-%Y') AS date FROM news AS n LEFT JOIN user AS u ON u.id = n.user_id;";
        //var_dump($query);
    }
    elseif ($user_id && $role >= 3) {
        $query = "SELECT id, header_news, text_news, user_id, DATE_FORMAT(date, '%d-%m-%Y') AS date FROM news WHERE user_id = ''  OR user_id=".$user_id." LIMIT 8;";

        //var_dump(tempAll($query));
    }
    else {

    }
    return tempAll($query);
}

function getAddit(){
    $query = "SELECT j.id, j.addit_id, s.name, DATE_FORMAT(j.addit_date, '%d-%m-%Y') AS addit_date, j.status, s.price, j.addit_comment, DATE_FORMAT(j.timestamp, '%d-%m-%Y') AS timestamp, u.user_surname, u.user_name, u.user_lastname "
            . " FROM addit_journal AS j "
            . "LEFT JOIN addit_service AS s "
            . "ON s.id = j.addit_id "
            . " LEFT JOIN user AS u "
            . "ON u.id = j.user_id "
            . "WHERE ";
           if (isset($_POST['role']) && $_POST['role'] >= 3){
               if ($_POST['view'] == 'single') {
                   $query .= "j.user_id=". $_POST['id'] ." AND j.id=(SELECT MAX(id) FROM addit_journal)";
                   //var_dump($query);
                   return tempAssoc($query);
               }
               elseif ($_POST['view'] == 'global') {
                   $query .= "j.status IS NOT NULL AND j.user_id=". $_POST['id'];
                   //var_dump($query);
                   return tempAll($query);

               }
           }
           else {
                   $query .= "j.status IS NOT NULL";
                   //var_dump($query);
                   return tempAll($query);

           }
}

function getSum(){
    $arr = isset($_POST['arr']) ? $_POST['arr'] : null;
    $query = "SELECT SUM(price) FROM addit_service WHERE id IN (". implode(',', $arr).")";
    $res = mysqli_query(getConnect(), $query);
    $result = mysqli_fetch_array($res);
    return $result[0];
}


function addItem() {
    $arr = isset($_POST['arr']) ? $_POST['arr'] : null;
    foreach ($arr as $key => $value) {
        $keys .= $key.",";
        //$values .= "'".$value."',";
        /*if ($value == '') {
            $values .= "NULL,";
        }
        else {*/
            //if ($key == 'close_date') {
                /*В ячейке close_date лежит количество дней на пропуск.
                * Вместо числа подставляется SQL конструкция, которая
                * прибавляет это число дней к текущей дате*/
                //$values .= "ADDDATE(NOW()," . $arr['close_date'] . "),";
                /***/
            /*}
            else {
                $values .= "'" . $value . "',";
            }*/
        //}
        $values .= "'" . $value . "',";

    }

    $keys = substr($keys, 0, -1);
    $values = substr($values, 0, -1);
    $request = "INSERT INTO ".$_POST['table']."(".$keys.") VALUES (".$values.");";
    //var_dump($request);
    $res = mysqli_query(getConnect(), $request);
    return $res;
}

function updateItem() {
    $arr = isset($_POST['arr']) ? $_POST['arr'] : NULL;
    $table = isset($_POST['table']) ? $_POST['table'] : NULL;
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $str = 'UPDATE '. $table .' SET ';
    foreach ($arr as $key => $value) {
        $str .= $key . " = ";
        if ($value == '') {
            $str .= 'NULL,';
        } else {
            /*Для таблицы auto*/
            //if ($key == 'close_date') {
                /*В ячейке close_date лежит количество дней на пропуск.
                * Вместо числа подставляется SQL конструкция, которая
                * прибавляет это число дней к текущей дате*/
                //$str .= "ADDDATE(NOW()," . $arr['close_date'] . "),";
                /***/
            /*}
            else {
                $str .= "'" . $value . "',";
            }*/
                $str .= "'" . $value . "',";
        }
    }
    $query = substr($str, 0, -1);
    $query .= " WHERE id=" . $id . ";";
    //var_dump($query);
    $res = mysqli_query(getConnect(), $query);

    return $res;
}

function getMonth (){
    $street_id = isset($_POST['street_id']) ? $_POST['street_id'] : NULL;
    $query = "SELECT DISTINCT DATE_FORMAT(i.timestamp, '%m-%Y') AS view_date "
            . "FROM indication i "
            . "LEFT JOIN user AS u "
            . "ON u.id = i.user_id "
            . "LEFT JOIN building b "
            . "ON b.id = u.home_id ";
            $query .= "WHERE b.street_id = ". $street_id .";";
            //var_dump($query);
            return tempAll($query);
}

function getIndication(){
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $education_id = isset($_POST['education_id']) ? $_POST['education_id'] : NULL;
    $street_id = isset($_POST['street_id']) ? $_POST['street_id'] : NULL;
    $month = isset($_POST['month']) ? $_POST['month'] : NULL;
    //var_dump($_POST);
    $query = "SELECT i.id, i.user_id, i.energy, i.water, u.user_surname, u.user_name, u.user_lastname "
            . "FROM indication AS i "
            . "LEFT JOIN user u "
            . "ON u.id = i.user_id "
            . "LEFT JOIN building b "
            . "ON b.id = u.home_id ";
        if ($id){
            $query .= "WHERE i.id = ". $id;
            //var_dump($query);

        }
        elseif ($education_id){
            $query .= "WHERE i.user_id = ". $education_id ." ORDER BY i.timestamp DESC LIMIT 1;";
            //var_dump($query);
        }
        elseif ($street_id){
            $query .= "WHERE b.street_id = ". $street_id ." AND DATE_FORMAT(i.timestamp, '%m')= ".$month;
            //var_dump($query);
            return tempAll($query);
        }
        else {
            //var_dump($query);
            return tempAll($query);

        }
            //var_dump($query);
    return tempAssoc($query);
}

function updateAddit() {
    $arr = isset($_POST['arr']) ? $_POST['arr'] : NULL;
    $table = isset($_POST['table']) ? $_POST['table'] : NULL;
    $query = 'UPDATE addit_journal SET status="1" WHERE id IN ('. implode(',', $arr).')';
    //var_dump($query);
    $res = mysqli_query(getConnect(), $query);
    return $res;
}

function updatePermit(){
    $arr = isset($_POST['arr']) ? $_POST['arr'] : NULL;
    $table = isset($_POST['table']) ? $_POST['table'] : NULL;
    $id = isset($_POST['id']) ? $_POST['id'] : NULL;
    $query = 'UPDATE '.$table.' SET close_date="'.$arr['close_date'].'" WHERE id='.$id;

    $res = mysqli_query(getConnect(), $query);
    return $res;
}

if ($mode == 'add') {
    echo addItem();
}
elseif ($mode == 'get_sum') {
    echo getSum();
}
elseif ($mode == 'getMonth') {
    echo getMonth();
}
elseif ($mode == 'select') {
    if ($_POST['table'] == 'news'){
        if (!empty($_POST['id'])){
            echo getContact();
        }
        else {
            echo getNews();
        }
    }
    elseif ($_POST['table'] == 'auto'){
        echo getAuto($_POST['ediction_id'], $_POST['role']);
    }
    elseif ($_POST['table'] == 'guest'){
        echo getGuest($_POST['ediction_id'], $_POST['role']);
    }
    elseif ($_POST['table'] == 'addit_journal'/* && isset($_POST['id'])*/){
        echo getAddit();
    }
    elseif ($_POST['table'] == 'indication'){
        echo getIndication();
    }
    elseif ($_POST['table'] == 'building'){
        echo getBuilding();
    }
    elseif ($_POST['table'] == 'user'){
        echo getUserByStreet();
    }
    else {
        echo getContact();
    }
}
elseif ($mode === 'update') {
    if ($_POST['table'] == 'addit_journal' && !$_POST['id']){
        echo updateAddit();
    }
    elseif ($_POST['table'] == 'auto' || $_POST['table'] == 'guest') {
        echo updatePermit();
}
    else {
        echo updateItem();
    }
}
elseif ($mode == 'delete') {
    echo deleteItem();
}
