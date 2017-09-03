<?php

require_once './lib.php';
require_once './header.php';


echo'
    <body>


          <div class="container-body">
            <div class="container-content">

                    <div class="addit" mode="add">

                        <div class="addit_show">
                            <table class="table addit_services">
                                <thead class="table-header">
                                    <th class="table-width-30 table-align-left">Наименование услуг</th>
                                    <th>Дата заказа</th>
                                    <th class="table-fix-width">Статус</th>
                                    <th>Цена (руб.)</th>
                                    <th>Комментарий</th>
                                    <th>Дата выполнения</th>
                                    <th>Заказчик</th>
                                </thead>
                                <tbody>';

                            /*$journal = json_decode(getAddit());
                            if ($journal){
                                foreach ($journal as $item) {
                                    echo "<tr class='table-item addit_item' id=".$item[0]." addit_id=".$item[1].">"
                                    . "<td class='table-align-left'>".$item[2]."</td>"
                                    . "<td>".$item[7]."</td>"
                                    . "<td>".$item[4]."</td>"
                                    . "<td>".$item[5]."</td>"
                                    . "<td>".$item[6]."</td>"
                                    . "<td>".$item[3]."</td>"
                                    . "<td>".$item[8]." ".$item[9]." ".$item[9]."</td>"
                                    . "</tr>";
                                }
                            }*/



                            echo '</tbody>
                            </table>
                        </div>

                    </div>

            </div>
          </div>

    </body>
</html>';
