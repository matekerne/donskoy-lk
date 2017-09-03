<?php

require_once './connect.php';

$login = array_key_exists('login', $_POST) ? $_POST['login'] : null;
$pass = array_key_exists('pass', $_POST) ? $_POST['pass'] : null;
$out = isset($_POST['out']) ? $_POST['out'] : null;
$mode = isset($_POST['mode']) ? $_POST['mode'] : null;

function selectUser() {

    $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : null;
    $ediction_id = isset($_POST['ediction_id']) ? $_POST['ediction_id'] : null;
    if ($user_id) {
        $query = "SELECT u.id,u.login,u.pass,u.user_surname, u.user_name, u.user_lastname,u.bank_book,s.name,s.id AS street_id,u.role,u.home_id,u.phone,u.email FROM user u LEFT JOIN building b ON b.id = u.home_id LEFT JOIN street AS s ON s.id = b.street_id WHERE u.role>=3 AND u.id =" . $user_id . ";";
        return tempAssoc($query);
    } else {
        $request = "SELECT u.id,u.user_surname, u.user_name, u.user_lastname,u.bank_book,s.name,u.home_id,u.phone,u.email "
                . "FROM user AS u LEFT JOIN building b ON u.home_id = b.id LEFT JOIN street AS s ON s.id = b.street_id "
                . "WHERE u.role>=3";
        if($ediction_id){
            $request .= " AND s.id=". $ediction_id;
        }
        $res = mysqli_query(getConnect(), $request);
        $result = mysqli_fetch_all($res);
        $str = '<table class="table table-border-left"><thead class="table-header user_item-header">
                        <th>Фамилия</th>
                        <th>Имя</th>
                        <th>Отчество</th>
                        <th>Лиц.счёт</th>
                        <th>Улица</th>
                        <th>№ дома</th>
                        <th>Телефон</th>
                        <th>Почтовый ящик</th>
                        <th>Редактирование</th></thead><tbody>';

        foreach ($result as $arr) {
            $str .= '<tr class="table-item user_item" id=' . $arr[0] . '>';
            for ($i = 1; $i < count($arr); $i++) {
                $str .= '<td>' . $arr[$i] . '</td>';
            }
            $str .= '<td><button class="button button-small button-icon-small edit_user"><img src="template/img/icon/admin/street/edit.svg"></button><button class="button button-small button-icon-small delete_user"><img src="template/img/icon/admin/street/delete.svg"></button></td>';
            $str .= '</tr>';
        }

        $str .= '</tbody></table>';
        return $str;
    }
}

function getUser($login, $pass) {
    $request = "SELECT id,user_surname, user_name, user_lastname,login,role FROM user WHERE login='$login' AND pass='$pass';";
    $res = mysqli_query(getConnect(), $request);
    $result = mysqli_fetch_array($res);

    return $result;
}

function setLogin($user_id) {
    $hid = md5(rand() . time() . microtime());
    $request = "INSERT INTO sessions (user_id, hid) VALUES ('$user_id','$hid')";
    mysqli_query(getConnect(), $request);
    setcookie('donskoy_cookie', $hid, time() + 36000);
}


if ($out) {
    setcookie('donskoy_cookie', '', time() - 36000);
} elseif ($mode == 'select') {
    echo selectUser();
} elseif ($mode == 'update') {
    echo updateUser();
} else {
    $result = getUser($login, $pass);
    if ($result) {
        setLogin($result['id']);
        echo json_encode($result);
    } else {
        echo 0;
    }
}
?>
