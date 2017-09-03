<?php

require_once './lib.php';
require_once './header.php';


    echo '<body>

              <div class="container-body">
                <div class="container-content">

                    <div class="contact" mode="add">
                        <div class="grid-group-item">
                            <div class="box-title">Контакты</div>
                            <button class="button button-border-color button-round button-icon add_new_contact"><img src="template/img/icon/admin/plus.svg">Добавить</button>
                        </div>

                        <div class="fl container_box">
                            <div class="fl_item contact_show">
                                <table class="table phone_number_table">
                                    <thead class="table-header number_table-header">
                                        <th class="table-align-left">Имя контакта</th>
                                        <th>Контактное лицо</th>
                                        <th>Номер</th>
                                        <td></td>
                                    </thead>
                                        <tbody>';

                        foreach (json_decode(getAllItem('contact')) as $item) {
                            echo "
                                <tr class='table-item contact_item' id=".$item[0].">
                                    <td id='serv_name' class='table-align-left imp'>".$item[1]."</td>
                                    <td id='serv_man'>".$item[2]."</td>
                                    <td id='serv_number'>".$item[3]."</td>
                                    <td class='table-item-group'>
                                        <button class='button button-icon-small edit_contact'><img src='template/img/icon/admin/street/edit.svg'></button>
                                        <button class='button button-icon-small delete_contact'><img src='template/img/icon/admin/street/delete.svg'></button>
                                    </td>
                                </tr>";
                        };

                        echo '</tbody></table></div>
                        <div class=" fl_item contact_lines" mode="add">
                            <div class="form">
                                <div class="form-input-group">

                                    <div class="grid-1-3">
                                        <input id="serv_name" name="serv_name" type="text" placeholder="Имя контакта"/>
                                    </div>
                                    <div class="grid-1-3">
                                        <input id="serv_man" name="serv_man" type="text" placeholder="Контактное лицо"/>
                                    </div>
                                    <div class="grid-1-3">
                                        <input id="serv_number" name="serv_number" type="text" placeholder="Номер контакта"/>
                                    </div>

                                </div>
                            </div>
                            <div class="contact-button-group">
                                <button class="button button-border-color button-round write_contact"> Записать </button>
                                <button class="button button-border-grey button-round clear_input"> Очистить </button>
                            </div>
                            <div class="button_close close_contact_form"><span></span></div>
                        </div>
                    </div>

                </div>

          </div>
        </div>';


    /*echo "<div class='part foot_info'>
                <div class='footer'>
                    <span>Контактная информация</span>

                    <div class='save_service'>
                        <h3>112</h3>
                        <div class='imp'>Вызов экстренных служб</div>
                        <div>(пожарная, охрана и спасптели, полиция, скорая помощь)</div>
                    </div>";

                    $res = mysqli_query(getConnect(), "SELECT * FROM contact;");
                    $result = mysqli_fetch_all($res);

                    foreach ($result as $item) {
                        echo "<div>
                                <div id='serv_name' class='imp'>".$item[1]."</div>
                                <div id='serv_man'>".$item[2]."</div>
                                <div id='serv_number'>".$item[3]."</div>
                             </div>";
                    }

            echo "</div>
            </div>*/
    echo "
        </body>
    </html>";

?>
