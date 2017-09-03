<?php

require_once './lib.php';
require_once './header.php';


echo '

          <div id="boxIndication" class="container-body">
            <div class="container-content">

              <div class="grid-1-1">
                <div class="grid-group-item month indication_period">
                </div>
              </div>

              <div class="grid-content grid-width-100 grid-nowrap grid-nopadding">

              <div class="container_left">
                <ul class="street_list">';
                    $street = json_decode(getAllItem('street'));
                    foreach ($street as $item) {
                        echo '<li class="street street_item" id=' . $item[0] . ' map_id=' . $item[2] . '>' . $item[1] . '</li>';
                    }

                    echo '</ul>
              </div>

              <div class="container_right indication" mode="add">

                  <div class="fl_item indication_show">
                        <table class="table table-border-left table-margin-top-20 indication_table">
                            <thead class="table-header indication_table-header">
                                <th>Пользователь</th>
                                <th>Электроэнергия</th>
                                <th>Водоснабжение</th>
                                <th>Редактирование</th>
                                </thead>
                                <tbody>
                                </tbody>
                        </table>';

                        /*foreach ($indications as $item) {
                            echo "
                                <tr class='table-item indication_item' id=".$item[0].">
                                    <td id='user_name' class='imp'>".$item[3]." ".$item[4]." ".$item[5]."</td>
                                    <td id='energy'>".$item[1]."</td>
                                    <td id='water'>".$item[2]."</td>
                                    <td id='indication_date'>".$item[6]."</td>
                                    <td class='table-item-group'>
                                        <button class='button edit_indication'><img src='template/img/icon/admin/street/edit.svg'></button>
                                        <button class='button delete_indication'><img src='template/img/icon/admin/street/delete.svg'></button>
                                    </td>
                                </tr>";
                        };*/

              /*echo '</div>';
                          $query = "SELECT id,login,user_surname, user_name, user_lastname FROM user;";
                          $res = mysqli_query(getConnect(), $query);
                          $users = mysqli_fetch_all($res);
              echo '<div class="fl_item indication_lines">
                      <select id="user_id">
                          <option selected disabled>Выберите пользователя</option>';
                          foreach ($users as $item){
                              echo '<option value="'.$item[0].'">'.$item[2].' '.$item[3].' '.$item[4].'</option>';
                          }
                      echo '</select>
                      <label for="energy">Электроэнергия</label>
                      <input id="energy" type="texarea"/>
                      <label for="water">Вода</label>
                      <input id="water" type="texarea"/>
                      <input id="indication_date" type="date"/>
                  </div>
                  <div>
                    <button class="button button-border-color button-round write_indication"><span></span>Записать</button>
                    <button class="button button-border-color button-round clear_indication">Очистить</button>
                  </div>';*/

              echo '</div>
                </div>
            </div>
          </div>

    </body>
</html>';
