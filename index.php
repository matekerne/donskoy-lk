<?php

$cookie = isset($_COOKIE['donskoy_cookie']) ? $_COOKIE['donskoy_cookie'] : null;

require_once './header.php';
if ($cookie) {


    //Админские кнопки
    if ($result['role'] == '1' || $result['role'] == '2') {
        require_once './admin.php';
    }
    //Для пользователя
    else {
        require_once './user.php';
    }
}

/* * Форма регистрации для гостя */ else {
    echo '

        <div class="home-login">
            <form class="login-form">
              <label for="login">Логин</label>
              <input name="login" id="login" type="text" placeholder="Введите логин" />
              <label for="login">Пароль</label>
              <input name="password" id="password" type="password" placeholder="Введите пароль" />
              <button type="button" class="button button-color button-round-small" id="send_login">Войти</button>
            </form>
        </div>

        </body>
        </html>';
}

/* * */
?>
