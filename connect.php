<?php

function getConnect() {
    $connect = mysqli_connect('localhost', 'root', 'root');
    mysqli_select_db($connect, 'donskoy_bd');
    mysqli_set_charset($connect, 'utf8');

    return $connect;
}

function tempAssoc ($query){
    $res = mysqli_query(getConnect(), $query);
    $result = mysqli_fetch_assoc($res);

    return json_encode($result);
}

function tempAll ($query){
    $res = mysqli_query(getConnect(), $query);
    $result = mysqli_fetch_all($res);

    return json_encode($result);
}

?>