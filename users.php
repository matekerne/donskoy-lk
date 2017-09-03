<?php

require_once './lib.php';
require_once './header.php';
require_once './login.php';


echo'<div id="boxIndication" class="container-body">
            <div class="container-content">

              <div class="grid-1-1">
              <div class="grid-group-item">
                <div class="box-title">Пользователи</div>
                <button class="button button-border-color button-round button-padding-small button-icon create_user"><img src="template/img/icon/admin/plus.svg">Создать пользователя</button>
                </div>
              </div>

              

              <div class="grid-content grid-width-100 grid-nowrap grid-nopadding">
    

                <div class="container_left">
                    <ul class="street_list">';
                        $street = json_decode(getAllItem('street'));
                        foreach ($street as $item) {
                            echo '<li class="street sys_contact_street" id=' . $item[0] . ' map_id=' . $item[2] . '>' . $item[1] . '</li>';
                        }

                    echo '</ul>
                </div>
    


                <div class="user_form">
                    <div class="form user_lines">
                          <div class="form-title">Пользователь</div>

                          <select id="role" name="role" onchange="showLines(this.value)">
                              <option disabled selected>Выберите тип пользователя</option>
                              <option value="2">Руководитель</option>
                              <option value="3">Пользователь</option>
                              <option value="4">Работник</option>
                          </select>

                          <div class="form-input-group">

                              <div class="grid-1-3">
                                <input name="login" id="login" type="text" placeholder="Введите логин" pattern="^[a-z,\.?]+(\d?)+$"/>
                                <input name="user_name" id="user_name" type="text" placeholder="Введите имя"/>
                              </div>
                              <div class="grid-1-3">
                                <input name="pass" id="pass" type="password" placeholder="Введите пароль"  pattern="^(\w+){3,32}$"/>
                                <input name="user_lastname" id="user_lastname" type="text" placeholder="Введите отчество"/>
                              </div>
                              <div class="grid-1-3">
                                <input name="user_surname" id="user_surname" type="text" placeholder="Введите фамилию"/>
                                <input name="bank_book" class="person" id="bank_book" placeholder="Лицевой счет" />
                              </div>

                          </div>

                            <div class="grid-expand-1">
                              <select id="home_id" class="person" name="home_id"">
                                <option selected disabled>Выберите дом</option>';
                                $building = json_decode(getBuilding());
                                foreach ($building as $item) {
                                    echo '<option value=' . $item[0] . ' > ул.' . $item[11] .', '. $item[1];
                                            if ($item[2]) {
                                                echo ' кв.'. $item[2];
                                            }
                                    echo '</option>';
                                }
                                echo '
                              </select>
                            </div>





                          <div class="grid-expand-1">
                              
                            <input name="email" id="email" type="email" placeholder="example@mail.ru" placeholder="Email" />
                            
                            <input name="phone" class="person" id="phone" type="text" placeholder="Телефон" />

                          </div>
                    </div>
                    <button class="button button-border-color button-round user_reg">Записать</button>
                    <div class="button_close user_close"><span></span></div>
                </div>

                <div class="container_right user_list">

                    <div class="list_cont">';
                    echo selectUser();
                    echo '</div>
                </div>';

?>