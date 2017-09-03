<?php

require_once './lib.php';
require_once './header.php';

    echo
    "<div class='guest' mode='add'>
        <div class='form guest_cont'>
            <div class='form-title'>Оформить пропуск</div>
            <div class='form-input-group guest_lines'>

                <div class='grid-1-3'>
                    <input name='guest_surname' id='guest_surname' type='text' placeholder='Фамилия'/>
                    <input name='note' id='note' type='text' placeholder='Примечание'/>
                </div>
                <div class='grid-1-3'>
                    <input name='guest_name' id='guest_name' type='text' placeholder='Имя'/>
                    <input name='close_date' class='close_date' id='close_date'/>
                </div>
                <div class='grid-1-3'>
                    <input name='guest_patronymic' id='guest_patronymic' type='text' placeholder='Отчество'/>
                </div>

            </div>
            <ul class='guest_list'>
            </ul>
        </div>
        <button class='button button-border-color button-round write_guest'>Оформить пропуск</button>
        <div class='button_close close_guest'></div>
    </div>

    <div class='auto' mode='add'>
        <div class='form auto_cont'>
            <div class='form-title'>Оформить пропуск</div>
            <div class='form-input-group auto_lines'>

                <div class='grid-1-3'>
                    <input name='auto_number' id='auto_number' type='text' placeholder='Номер машины'/>
                    <input name='close_date' class='close_date' id='close_date'/>
                </div>
                <div class='grid-1-3'>
                    <input name='mark' id='mark' type='text' placeholder='Марка'/>
                </div>
                <div class='grid-1-3'>
                    <input name='model' id='model' type='text' placeholder='Модель'/>
                </div>

                <!--<div class='grid-1-3'>
                    <input name='who_are' id='who_are' type='text' placeholder='Кто это' />
                </div>-->
            </div>
            <ul class='auto_list'>
            </ul>
        </div>
        <button class='button button-border-color button-round write_auto'>Оформить пропуск</button>
        <div class='button_close close_auto'></div>
    </div>


    <div class='container-body'>
      <div class='container-content'>
          <div class='grid-1-1'>


                <div class='box-title center-title'>Оформленные пропуска</div>


                <div class='grid-group-item'>
                    <span class='box-title'>Люди</span>
                    <button class='button button-padding-small button-border-color button-round button-icon add_guest'><img src='template/img/icon/admin/plus.svg' />Добавить</button>
                </div>
                <table class='table permit_guest'>
                    <thead class='table-header'>
                        <th class='table-align-left'>ФИО</th>
                        <th></th>
                        <th>Осталось дней</th>
                        <th>Дата окончания</th>
                        <th></th>
                    </thead>
                    <tbody>";
                //var_dump(json_decode(getGuest($user_id, $role)));
                foreach (json_decode(getGuest($user_id, $role)) as $item){
                    echo "<tr class='table-item guest_item' id='".$item[0]."'>";
                        echo "<td class='table-align-left'><div>".$item[1]."</div><div>".$item[2]." ".$item[3]."</td>";
                        echo "<td>".$item[4]."</td>";
                        echo "<td>".$item[5]."</td>";
                        echo "<td><input class='close_date' value='".$item[6]."'></td>";
                        echo "<td class='table-align-right'><button class='button button-text-green button-small button-round edit_guest'>Продлить</button></td>";
                    echo "</tr>";
                }

                    echo "</tbody>
                </table>


                <div class='grid-group-item'>
                    <div class='box-title'>Автомобили</div>
                    <button class='button button-padding-small button-border-color button-round button-icon add_auto'><img src='template/img/icon/admin/plus.svg' />Добавить</button>
                </div>

                <table class='table permit_auto'>
                    <thead class='table-header'>
                        <th class='table-align-left'>Номер</th>
                        <th>Марка и модель</th>
                        <th>Осталось дней</th>
                        <th>Дата окончания</th>
                        <th></th>
                    </thead>
                    <tbody>";

                foreach (json_decode(getAuto($user_id, $role)) as $item){
                    echo "<tr class='table-item auto_item' id='".$item[0]."'>";
                        echo "<td class='table-align-left'>".$item[1]."</td>";
                        echo "<td><div class='car_name'>".$item[3]."<br><span>".$item[2]."</span></div></td>";
                        echo "<td>".$item[4]."</td>";
                        echo "<td><input class='close_date' value='".$item[5]."'></td>";
                        echo "<td class='table-align-right'><button class='button button-text-green button-small button-round edit_auto'>Продлить</button></td>";
                    echo "</tr>";
                }

                    echo "</tbody>
                </table>
            </div>
      </div>
    </div>
    ";


/* * */
?>
