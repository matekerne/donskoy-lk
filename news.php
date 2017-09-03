<?php

require_once './lib.php';
require_once './header.php';


echo'
    <body>
        <span class="status" user_id="'.$user_id.'" role="'.$role.'"></span>


          <div class="container-body">
            <div class="container-content">

                <div class="grid-1-1 news" mode="add">

                    <div class="fl_item news_show">
                                            <table class="table">
                                                <thead class="table-header">
                                                    <th class="table-align-left table-width-30">Заголовок</th>
                                                    <th>Тема</th>
                                                    <th>Кому</th>
                                                    <th>Дата</th>
                                                    <th></th>
                                                </thead><tbody>';

                        foreach (json_decode(getNews()) as $item) {
                            //echo "<div class='news_item' id=".$item[0].">
                            //$newsText = substr($item[2],0, 60).' ...';
                            echo "<tr class='table-item news_item new-item' id=".$item[0]." user_id='".$item[3]."'>
                                <td id='text_news' class='table-align-left imp'>".$item[2]."</td>
                                <td id='header_news' class='imp'>".$item[1]."</td>
                                <td id='user_id'>".$item[3]." ".$item[4]." ".$item[5]."</td>
                                <td class='date'>".$item[6]."</td>
                                <td>
                                  <button class='button button-small button-icon-small edit_news'><img src='template/img/icon/admin/street/edit.svg' /></button>
                                  <button class='button button-small button-icon-small delete_news'><img src='template/img/icon/admin/street/delete.svg' /></button>
                                </td>
                            </tr>";
                        };
                        echo '</tbody></table></div>';
                            $query = "SELECT id,login,user_surname, user_name, user_lastname FROM user;";
                            $res = mysqli_query(getConnect(), $query);
                            $result = mysqli_fetch_all($res);
                echo '<div class="fl_item news_lines">


                        <select name="user_id" id="user_id">
                            <option value="0" selected disabled>Выберите адресата</option>';
                            foreach ($result as $item){
                                echo '<option value="'.$item[0].'">'.$item[2].'</option>';
                            }
                        echo '</select>
                        <!--<label for="header_news">Заголовок</label>-->
                        <input id="sys_header_news" name="header_news" type="texarea" placeholder="Заголовок"/>
                        <!--<label for="text_news">Новость</label>-->
                        <textarea id="sys_text_news" name="text_news" type="texarea" placeholder="Новость"/></textarea>
                        <script type="text/javascript">
                            CKEDITOR.replace( "sys_text_news" );
                        </script>
                    </div>
                    <button class="btn write_news">Записать</button>
                    <button class="btn clear_news">Очистить</button>
                </div>
            </div>
          </div>

    </body>
</html>
    ';
