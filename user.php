<?php

echo "
            <section id='boxCommunal' class='section'>
              <div class='main-content'>
                <div class='communal-header'>
                    <div class='box-title'>Коммунальные платежи</div>
                    <div class='month-block'>
                        <!--<a href='#' class='prev-month'><img src='template/img/icon/slider/prev.svg'></a>-->
                        <span>Май 2017</span>
                        <!--<a href='#' class='next-month'><img src='template/img/icon/slider/next.svg'></a>-->
                    </div>
                    <a href='#'>История платежей</a>
                </div>

                <div class='part main_part'>

                    <div class='pay_part'>

                        <table>
                            <tr>

                                <td>
                                    <img src='template/img/icon/admin/table/service.svg'>
                                </td>
                                <td>
                                    Обслуживание
                                </td>
                                <td>
                                    <a href='#'>Подробности</a>
                                </td>
                                <td>
                                    <span>2132 руб.</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src='template/img/icon/admin/table/avans.svg'>
                                </td>
                                <td>
                                    Аванс
                                </td>
                                <td>
                                    <a href='#'>Подробности</a>
                                </td>
                                <td>
                                    <span>- 1375 руб.</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src='template/img/icon/admin/table/more-service.svg'>
                                </td>
                                <td>
                                    <pre>Регулярные
дополнительные
услуги</pre>
                                </td>
                                <td>
                                    <a href='#'>Подробности</a>
                                </td>
                                <td>
                                    <span>789 руб.</span>
                                </td>
                            </tr>
                        </table>

                        <div class='pay-block'>
                            <div class='total-price'>
                              К оплате: <span id='totalSum'>10 000 руб.</span>
                            </div>

                            <div class='pay-online'>
                              <button class='button button-color button-round-small lets_pay'> Оплатить онлайн </button><br>
                              <a href='#'>Скачать квитанцию</a>
                            </div>
                        </div>

                    </div>

                    <div class='payment'>
                        <div class='tile water count-card'>
                            <div class='tile-caption water-info'>
                                <img src='template/img/icon/admin/tile/water-icon.svg'>
                                Водоснабжение
                            </div>
                        </div>
                        <div class='tile energy count-card'>
                            <div class='tile-caption energy-info'>
                                <img src='template/img/icon/admin/tile/energy-icon.svg'>
                                Электроэнергия
                            </div>
                        </div>
                    </div>

                </div>
              </div>
            </section>

            <section id='boxServices' class='section section--gray'>
                <div class='main-content'>
                    <div class='part addit_part'>
                        <div class='service-button-group'>
                            <span class='box-title'>Дополнительные услуги</span>
                            <button class='button button-border-color button-round button-icon button-padding-small take_service'><img src='template/img/icon/admin/plus.svg' /> Заказать услугу</button>
                            <a href='#'>Архив услуг</a>
                        </div>

                        <table class='addit_services'>
                            <thead>
                                <th>Наименование услуг</th>
                                <th>Дата заказа</th>
                                <th>Статус</th>
                                <th>Цена руб.</th>
                                <th>Комментарий</th>
                                <th>Дата выполнения</th>
                                <th>Заказчик</th>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                        <div class='form addit_form'>
                          <div class='addit_form-title'>
                            Дополнительные услуги
                          </div>
                          <div class='addit_close'></div>
                          <div class='grid-group-item'>
                            <div class='grid-expand-1'>
                              <select id='addit_id'>
                                 <option disabled selected>Что сделать?</option>
                              </select>
                              <div class='grid-1-3'>
                                <input class='close_date' id='addit_date' placeholder='Когда?'/>
                              </div>


                              <input id='addit_comment' placeholder='Комментарий к заказу'/>
                            </div>

                              <button class='button button-padding-small button-border-color button-round button-icon addit_add'><img src='template/img/icon/admin/plus.svg' /> Добавить</button>
                          </div>

                          <div class='addit_selected'>
                          </div>

                          <div class='addit_footer'>
                              <div class='total_sum'>К оплате:  <span price='0' class='global_price'> 0 </span><span> руб.</span></div>
                              <button class='button button-color button-round-small addit_pay'>Оплатить онлайн</button>
                          </div>
                        </div>

                    </div>
                </div>
            </section>

            <!-- Просмотр полного текста новости -->

            <div class='news_popup'>
              <div class='button_close news_popup_close'><span></span></div>
              <article class='article'>

              </article>
            </div>

            <!-- Просмотр полного текста новости -->

            <!-- Новости -->
            <section id='boxNews' class='section news_panel'>
                <div class='news-panel-slider'>
                    <div class='news_panel-header'>
                      <span class='box-title'>
                          Новости
                      </span>
                    </div>

                    <div class='news-slider'>

                    </div>
                </div>
            </section>

            <section id='boxContacts' class='section section-overlay'>

                  <div class='grid-content'>
                    <div class='grid-1-4'>
                        <div class='box-title'>Контактные телефоны</div>
                        <div class='box-title-text'>для урегулирования аварийных ситуаций</div>
                    </div>

                    <div class='grid-1-2'>
                        <div class='phone-number-group frame'>
                            <div class='service-number'>112</div>
                            <div>
                                <div class='imp'>Вызов экстренных служб</div>
                                <div>(пожарная охрана и спасатели, полиция, скорая помощь, аварийная служба газовой сети)</div>
                            </div>
                        </div>
                    </div>

                    ";

               $res_small = mysqli_query(getConnect(), "SELECT * FROM contact LIMIT 1");
               $result_small = mysqli_fetch_all($res_small);

               foreach ($result_small as $item) {
                   echo "<div class='grid-1-4'>
                           <div id='serv_name' class='imp'>".$item[1]."</div>
                           <div id='serv_man'>".$item[2]."</div>
                           <div id='serv_number'>".$item[3]."</div>
                        </div>";
               };

               echo "</div>";
               echo "<div class='grid-content more-phones'>";$res_full = mysqli_query(getConnect(), "SELECT * FROM contact LIMIT 2, 20");
               $result_full = mysqli_fetch_all($res_full);

               foreach ($result_full as $item) {
                   echo "<div class='grid-1-4'>
                           <div id='serv_name' class='imp'>".$item[1]."</div>
                           <div id='serv_man'>".$item[2]."</div>
                           <div id='serv_number'>".$item[3]."</div>
                        </div>";
               }echo "</div>



                <button class='button button-border-white button-round button-center show-contact'>Показать все службы</button>

            </section>


            <footer class='footer'>

                    <div class='footer-group'>
                        <img class='footer-icon' src='template/img/icon/admin/spravka.svg'>
                        <div class='footer-icon-text'>
                            Справочная информация<br>
                            для жителя КП Донской
                        </div>
                    </div>
                    <div class='footer-group'>
                        <img class='footer-icon' src='template/img/icon/admin/pamytka.svg'>
                        <div class='footer-icon-text'>
                            Памятка
                        </div>
                    </div>
                    <div class='footer-logo'>
                        <img src='template/img/logo/logo_footer.svg'>
                    </div>
                
            </footer>

        </body>
    </html>";
