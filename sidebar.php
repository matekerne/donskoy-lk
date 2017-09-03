<?php

require_once './lib.php';

$street = json_decode(getAllItem('street'));



echo "
    <div class='wrapper-admin'>
        <nav class='tool_panel'>";

        $menu = array (
            "Главная"=>"./", 
            "Новости"=>"news.php", 
            "Обслуживание"=>"indication.php", 
            "Допольнительные услуги"=>"addit.php",
            "Контакты"=>"contact.php",
            "Автомобили"=>"auto.php",
            "Все пользователи"=>"users.php"
        );
        
        foreach ($menu as $title=>$url) {
           $class = strpos($_SERVER["REQUEST_URI"], $url) !== false ? " active" : "";
           //echo "<li$class><a href='$url'>$title</a><li>";
           echo "<span class='nav_item$class'><a href='$url'>$title</a></span>";
        }
        

        //     <span class='nav_item'><a href='./'>Главная</a></span>
        //     <span class='nav_item'><a href='news.php'>Новости</a></span>
        //     <span class='nav_item'><a href='indication.php'>Обслуживание</a></span>
        //     <span class='nav_item additional'><a href='addit.php'>Дополнительные услуги</a></span>
        //     <span class='nav_item'><a href='contact.php'>Контакты</a></span>
        //     <span class='nav_item'><a href='auto.php'>Автомобили</a></span>
        //     <span class='nav_item'><a href='users.php'>Все пользователи</a></span>
        echo "</nav>";
echo "
        <!-- Просмотр полного текста новости -->

        <div class='news_popup'>
          <div class='button_close news_popup_close'><span></span></div>
          <article class='article'>

          </article>
        </div>

        <!-- Просмотр полного текста новости -->

        <div class='view-panel'>
              <div class='view-panel__button'>
                <input class='tabs btn btn-label-radio' type='radio' checked name='view_group' id='addit_view' onchange='changePanel()'>
                <label for='addit_view'>Доп.услуги</label>
                <input class='tabs btn btn-label-radio' type='radio' name='view_group' id='auto_view' onchange='changePanel()'>
                <label for='auto_view'>Автомобили</label>
              </div>
                <div class='addit_view_cont'>";
                    $journal = json_decode(getAddit());
                    if ($journal){
                        foreach ($journal as $item) {
                            echo "<div class='view_item addit_item' id=".$item[0]." addit_id=".$item[1].">"
                            ."<div class='grid-group-item'><div class=grid-1-2'><div id='name' class='imp'>".$item[2]."</div><div id='user'>".$item[8]."</div><div id='addit_comment'>".$item[6]."</div></div>";

                            if ($item[4] == '0') {
                              $item[4] = 'Не оплачено';
                            } elseif ($item[4] == 1) {
                              $item[4] = 'Оплачено';
                            } elseif ($item[4] == 2) {
                              $item[4] = 'В работе';
                            } elseif ($item[4] == 3) {
                              $item[4] = 'Выполнено';
                            }
                            echo "<div class='grid-1-2 grid-align-right'><div id='addit_date'>".$item[7]."</div><span class='timestamp'>".$item[3]."</span><div id='status'>".$item[4]."</div></div>"



                            . "</div></div>";
                        }
                    }
                echo "</div>

                <div class='auto_view_cont'>";
                    $auto = json_decode(getAllItem("auto"));
                    if ($auto){
                        foreach ($auto as $item) {
                            echo "<div class='view_item auto_item' id=".$item[0].">"
                            ."<div class='grid-group-item'>"
                            . "<div class='grid-1-2'><div id='number' class='imp'>".$item[1]."</div><div><span id='mark'>".$item[2]."</span><span id='model'>".$item[3]."</span></div></div>"
                            . "<div class='grid-1-2 grid-align-right'><div id='close_date'>".$item[4]."</div><div id='timestamp'>".$item[5]."</div></div>"

                            . "</div></div>";
                        }
                    }
                echo "</div>
            </div>";

                echo ''
                    ;
