<?php

require_once './lib.php';

require_once './header.php';




        echo "
        <div id='boxStreet' class='container-body fl'>
            <div class='container-content'>
                <div class='grid-content grid-width-100 grid-nowrap grid-nopadding'>
            <div class='container_left'>
                <button class='button button-border-color button-round button-padding-small button-icon add_street'><img src='template/img/icon/admin/plus.svg' />Новая улица</button>
                <ul class='street_list'>";
        $street = json_decode(getAllItem('street'));
        foreach ($street as $item) {
            echo '<li class="street" id=' . $item[0] . ' map_id=' . $item[2] . '>' . $item[1] . '</li>';
        }

        echo "</ul>
            </div>
            <div class='container_right fl_item'>
                <button class='button button-border-color button-round button-padding-small button-icon add'><img src='template/img/icon/admin/plus.svg' />Добавить дом</button>
                <div class='home_cont'>
                    <div class='first-street-content'>
                        <div class='first-street-img'><img src='template/img/icon/admin/street/street.svg'></div>
                        <div class='first-street-text'>Выберите улицу!</div>
                    </div>
                </div>
            </div>
                </div>
            </div>
        </div>


        <div class='form_street' mode='add-street'>

          <div class='form edit_lines'>
              <div class='form-title'>Добавить улицу</div>
              <div class='form-input-group'>

                <div class='grid-1-1'>
                    <input class='val_street' type='text' name='text' pattern='^[А-Я][а-я]+$' placeholder='Например: Донская'/>
                </div>

              </div>
          </div>
          <button class='button button-border-color button-round button-padding-small button-icon write_street'><img src='template/img/icon/admin/plus.svg' />Добавить</button>

          <div class='button_close close_street'></div>
        </div>
        <div class='permit'>

            <div class='guest' mode='add'>
                <button class='btn edit_guest'>Изменить автомобиль</button>
                <button class='btn delete_guest'>удалить автомобиль</button>
                <div class='guest_cont'>
                    <div class='guest_lines'>
                        <label for='#guest_name'>Ф.И.О. гостя</label>
                        <input name='guest_name' id='guest_number' type='text' placeholder='Иванов Иван Иванович'/><br>
                        <label for='#note'>Примечание</label>
                        <input name='note' id='mark' type='text' placeholder='Например: Приёдт сантехник'/><br>
                        <label for='#close_date'>Время прибывания (дней)</label>
                        <input name='close_date' id='close_date' type='number' min='1' max='31' step='1'/><br>
                    </div>
                    <ul class='guest_list'>
                    </ul>
                </div>
                <button class='btn write_guest'>Записать</button>
                <button class='btn close_guest'>Закрыть</button>
            </div>

            <div class='auto' mode='add'>
                <button class='btn edit_auto'>Изменить автомобиль</button>
                <button class='btn delete_auto'>удалить автомобиль</button>
                <div class='auto_cont'>
                    <div class='auto_lines'>
                        <label for='#auto_number'>Номер автомобиля</label>
                        <input name='auto_number' id='auto_number' type='text' placeholder='A111AA'/><br>
                        <label for='#mark'>Марка автомобиля</label>
                        <input name='mark' id='mark' type='text' placeholder='TOYOTA'/><br>
                        <label for='#model'>Модель автомобиля</label>
                        <input name='model' id='model' type='text' placeholder='CAMRY'/><br>
                        <label for='#close_date'>Время прибывания (дней)</label>
                        <input name='close_date' id='close_date' type='number' min='1' max='31' step='1'/><br>
                    </div>
                    <ul class='auto_list'>
                    </ul>
                </div>
                <button class='btn write_auto'>Записать</button>
                <button class='btn close_auto'>Закрыть</button>
            </div>
        </div>

        <!--<div class='view-panel'>
          <div class='view-panel__button'>
            <input class='tabs btn btn-label-radio' type='radio' checked name='view_group' id='addit_view' onchange='changePanel()'>
            <label for='addit_view'>Доп.услуги</label>
            <input class='tabs btn btn-label-radio' type='radio' name='view_group' id='auto_view' onchange='changePanel()'>
            <label for='auto_view'>Автомобили</label>
          </div>
            <div class='addit_view_cont'>-->";

            echo "<!--</div>
        </div>-->

        <div class='edit_form' mode='add'>

            <div class='edit_form-content'>
              <div class='edit_lines'>
                  <div class='form edit_list'>
                      <div class='form-title street_label'>Улица</div>

                      <div class='grid-expand-1'>

                          <select id='type' class='both' name='type' onchange='showLines(this.value)'>
                              <option selected disabled>Выберите тип строения</option>
                              <option value='roof'>Многоэтажный дом</option>
                              <option value='townhouse'>Таунхаус</option>
                              <option value='town'>Котедж</option>
                          </select>


                          <select id='type_apart' class='roof' name='type_apart'>
                              <option disabled selected>Выберите тип квартиры</selected>
                              <option value='studio'>Студия</option>
                              <option value='1th'>1-комнатная</option>
                              <option value='2th'>2x-комнатная</option>
                              <option value='3th'>3x-комнатная</option>
                              <option value='4th'>4x-комнатная</option>
                          </select>

                            <select id='user_id' class='user_id' name='type_apart'>
                              <option disabled selected>Выберите пользователя</selected>";
                              foreach (json_decode(getUserByStreet()) as $item){
                                echo '<option value="'.$item[0].'">'.$item[1].' '.$item[2].' '.$item[3].'</option>';
                              }
                            echo "</select>

                      </div>




                      <div class='grid-expand-1'>

                        <label for='home_number'>Номер дома
                          <input class='both' id='home_number' />
                        </label>

                        <label for='floor'>Этаж
                          <input type='number' class='both' id='floor' />
                        </label>

                        <label for='area'>Площадь
                          <input type='number' class='both' id='area' pattern='\d+(,\d{2})?' />
                        </label>

                        <label for='apart_number' class='roof'>Номер квартиры
                          <input type='number'  class='roof' min='1' max='150' step='1' id='apart_number' />
                        </label>
                        <label for='space_area' class='town'>Площадь участка
                          <input type='number' class='town' id='space_area' pattern='\d+(,\d{2})?' />
                        </label>

                        

                      </div>
                  </div>
                  <button class='button button-border-color button-round write'><span></span>Записать</button>
              </div>
            </div>
            <div class='button_close close'><span></span></div>
        </div>";
