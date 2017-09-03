<?php
Ini_set ('display_errors', 'On');
Error_reporting (E_ALL ^ E_DEPRECATED);
require_once './lib.php';

if(date("H") >= 04) {$hello = "Доброе утро";}
if(date("H") >= 10) {$hello = "Добрый день";}
if(date("H") >= 16) {$hello = "Добрый вечер";}
if(date("H") >= 22 or date("H") < 04) {$hello = "Доброй ночи";}



echo'
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600&amp;subset=cyrillic-ext" rel="stylesheet">
        <link rel="stylesheet" href="/template/css/template.css.php"/>
        <script src="/template/js/vendor/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
        <script src="/template/js/vendor/jquery.inputmask.bundle.js"></script>
        <script src="/template/js/vendor/picker.js"></script>
        <script src="/template/js/vendor/picker.date.js"></script>
        <script src="/template/js/plugins/slick.min.js"></script>
        <script src="/template/js/donskoy.js"></script>
        <script src="/template/js/login.js"></script>
        <script src="/template/js/auto.js"></script>
        <script src="/template/js/navbar.js"></script>
        <script src="/template/js/user.js"></script>
        <script src="/components/ckeditor/ckeditor.js"></script>
    </head>';




    $cookie = isset($_COOKIE['donskoy_cookie']) ? $_COOKIE['donskoy_cookie'] : null;
    $request = "SELECT u.login,u.user_surname, u.user_name, u.user_lastname,u.role,u.id FROM user AS u LEFT JOIN sessions AS s ON s.user_id=u.id WHERE s.hid='$cookie';";
    $res = mysqli_query(getConnect(), $request);
    $result = mysqli_fetch_array($res);
    $user_id = $result['id'];
    $role = $result['role'];

    if ($result['role'] == '1' || $result['role'] == '2') {
        echo '<body class="admin">';
    } else {
        echo '<body class="site">';
    }

    if ($cookie) {

    echo
    "<nav class='navbar-body'>
        <div class='navbar-logo'>
            <a href='#'>ДОНСКОЙ</a>
        </div>

        <a class='button button-border-white button-round button-text-color button-icon' href='auto.php'><img src='template/img/icon/admin/ticket.svg' />Выписать пропуск</a>

        <ul class='user-menu'>
            <li class='show-menu'>

              <div class='user-menu__name'>
                <div class='user-menu__name-hello'>".$hello.",</div>
                <div class='status' user_id=".$user_id." role=".$result['role'].">" . $result['user_surname'] ." ". $result['user_name'] ." ". $result['user_lastname'] ."</div>
              </div>

              <ul class='dropdown-list'>
                <li id='out'>Выход</li>
              </ul>
            </li>
        </ul>

        <!--<span class='status' user_id=".$user_id." role=".$result['role'].">" . $result['login'] . "</span><span> | </span>-->

        <!--<button class='btn permit_btn'><a href='auto.php'>Выписать пропуск</a></button>-->

    </nav>
    <div class='body-overlay'></div>";

    //Админская навигационная панель и сайдбар
    if ($result['role'] == '1' || $result['role'] == '2') {
        require_once './sidebar.php';
    }
  }
