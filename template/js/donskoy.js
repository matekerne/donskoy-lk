// Замена img на SVG
  function svgImage() {
    jQuery('img.svg').each(function() {
      var $img = jQuery(this);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');

      jQuery.get(imgURL, function(data) {
        // Get the SVG tag, ignore the rest
        var $svg = jQuery(data).find('svg');

        // Add replaced image's ID to the new SVG
        if (typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
        }
        // Add replaced image's classes to the new SVG
        if (typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', imgClass + ' replaced-svg');
        }

        // Remove any invalid XML tags as per http://validator.w3.org
        $svg = $svg.removeAttr('xmlns:a');

        // Check if the viewport is set, else we gonna set it if we can.
        if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
          $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
        }

        // Replace image with new SVG
        $img.replaceWith($svg);

      }, 'xml');

    });
  };

// Overlay
function showOverlay() {
    $(".body-overlay").addClass("load");
    setTimeout(function() {
        $(".body-overlay").addClass("active-overlay");
    }, 100);
}

function hideOverlay() {
    $(".body-overlay").removeClass("active-overlay");
    setTimeout(function() {
        $(".body-overlay").removeClass("load");
    }, 200);
}
// Overlay

// Overlay user form
function formDark() {
    $(".user_list").addClass("backdown");
}
function formLight() {
    $(".user_list").removeClass("backdown");
}
// Overlay user form

function showLines(option) {

    /**Установить поля реокмендуемые к заполнению в зависимости от выбраного типа*/
    $("input, select").attr("required",false);
    $("input." + option + ", select." + option).attr("required",true);
    /**/

    if (option == 'roof' || option == 'townhouse') {
        $(".roof").show();
        $(".town").hide();
        $("select.town,input.town").val('');
    } else if (option == 'town') {
        $(".town").show();
        $(".roof").hide();
        $("select.roof,input.roof").val('');
    } else if (option == 3) {
        //$("select.person,input.person").val('');
        $(".person").show();
    } else {
        $(".person").hide();
        $("select.person,input.person").val('');

    }
}

/*function makeActive(selector){
    $(selector).removeClass("active");
    $(this).addClass("active");
}*/
function deleteItem(table,selector,form){
    var id = $(selector + ".active").attr("id");
    console.info(id);
    if (id) {

            /**Установить режим работы формы*/
            $(form).attr("mode", "delete");
            /***/

            $.ajax({//Получает информацию о доме по id активного дома
                url: "lib.php",
                data: {
                    mode: 'delete',
                    table: table,
                    id: id
                },
                type: "post",
                success: function (res) {
                    if (res != 0){
                        alert('Запись удалена');
                    }
                    else {
                        alert('Произошла ошибка!');
                    }

                }
            });
        } else
            alert("Выберите объект!");
}

function deleteItemId(table,id){
    console.info(id);
    if (id) {

        $.ajax({//Получает информацию о доме по id активного дома
            url: "lib.php",
            data: {
                mode: 'delete',
                table: table,
                id: id
            },
            type: "post",
            success: function (res) {
                if (res != 0){
                    alert('Запись удалена');
                }
                else {
                    alert('Произошла ошибка!');
                }

            }
        });
    } else
        alert("Выберите объект!");
}



function loadHome() {
    // Получение списка домов по id активной улицы
    var street_id = $(".street.active").attr("id");
    var street_label = $(".street.active").text();

    //Добавление в форму редактирования дома информации об улице
    $(".edit_form .street_label").attr("id", street_id).text(street_label);

    $.ajax({
        url: "lib.php",
        data: {
            ediction_id: street_id,
            table: 'building',
            mode: 'select'
        },
        type: "post",
        success: function (res) {
            result = JSON.parse(res);
            str = '<table class="table table-border-left">'+
                        '<thead class="table-header">'+
                        '<th>Дом</th>'+
                        '<th>Характеристики</th>'+
                        '<th>Владелец</th>'+
                        '<th class="table-fix-width"></th>'+
                        '</thead><tbody>';
            for (i in result) {
                var build = result[i];
                    if (build[3] == 'roof') {
                        build[3] = "Многоэтажный дом";
                    }
                    else if (build[3] == 'town') {
                        build[3] = "Коттедж";
                    }
                    else if (build[3] == 'townhouse') {
                        build[3] = "Таунхаус";
                    }

                
                
                str += "<tr class='table-item' id=" + build[0] + ">";
                    str += "<td>"; //Дом
                    
                        str += "<div>"+ build[3];
                            if (build[4]){
                                str += " ( " + build[4] + " ) ";
                            }
                        str += "</div>";
                        
                        str += "<div>ул." + build[11] + ", " + build[1];
                            if (build[2]) {
                                str += " кв." + build[2];
                            }
                        str += "</div>";
                    str += "</td>"; //
                        
                    str += "<td>"; //Характеристики
                        str += "<div> Площадь: " + build[6];
                            if (build[7]) {
                                str += "Этажей: " + build[5];
                                str += "<div> Участок: " + build[7] + "</div>";
                            }
                        str += "</div>";
                    str += "</td>";//
                    
                    str += "<td>"; //Владелец
                        if (build[8]){
                            str += "<span> " + build[8] + " " + build[9] + " " + build[10] + " </span>";
                        }
                        else {
                            str += "<span></span>";
                        }
                    str += "</td>";
                    
                    str += "<td>"; //Кнопки
                        str += "<div>"+
                                    "<button class='button button-icon-small edit_home'><img src='template/img/icon/admin/street/edit.svg'></button>" +
                                    "<button class='button button-icon-small delete_home'><img src='template/img/icon/admin/street/delete.svg'></button>"+
                               "</div>";
                    str += "</td>";
                    
                      
                    
                str += "</tr>";
            }
            str += "</tbody></table>"
            $(".home_cont").html(str);
        }
    });
}


function loadUser(street_id) {
    //console.info(street_id);
    $.ajax({
        url: 'login.php',
        data: {
            mode: 'select',
            ediction_id: street_id
        },
        type: 'post',
        success: function (res) {
            $(".list_cont").html(res);
        }
    });
}

function cloneForm(selector) {
    var selector_tmp = selector + "_tmp";
    $("." + selector_tmp).remove();
    $("." + selector).clone().addClass(selector_tmp).appendTo("body");


    $(".close_date").pickadate({
        min: true,
        max: 15,
        format: 'd-mm-yyyy'
     });
    /**Маски полей*/
    $("input[name=phone]").inputmask("+7(999)999-99-99");
    //$("input[name=bank_book]").inputmask("999999999");
    /***/
}


function closeForm(selector) {
    var selector_tmp = selector + "_tmp";
    $("." + selector_tmp).fadeOut(200);
    $("." + selector_tmp).remove();
}

$(document).ready(function () {

    svgImage();

    var containerId = $(".container-body").attr("id");
    var firstStreet = $(".street:first");

    if (containerId == 'boxStreet') {
      $(".street:first").addClass("active");
      loadHome();
    } else if (containerId == 'boxIndication') {
      firstStreet.addClass("active");
      loadMonth();
      loadIndication();
    }


    $("body").on("change","#street_id",function(){
       var street_id = $(this).val();
        $.ajax({
            url: "lib.php",
            data: {
                ediction_id: street_id,
                table: 'building',
                mode: 'select'
            },
            type: "post",
            success:function(res){
                result = JSON.parse(res);
                console.info(result);
                var str = '';
                for (item in result){
                    str += "<option value=" + result[item][0] + ">"+ result[item][1] +"</option>";

                    }
            }
        });
    });

    $("body").on("click",".news_panel_btn",function(){
        $(".news_panel").toggle();

    });

    //Пометка изменённых полей
    $("body").on("change", "input, select", function () {
        $(this).attr("changed", "1");
    });

    /**Форма изменения информации о доме*/
    $("body").on("click",".edit_home",function () {
        var id = $(this).parent().parent().parent().attr("id")
        if (id) {

            /**Установить режим работы формы*/
            cloneForm('edit_form');

            $(".edit_form_tmp .edit_list").attr("id", $(".home-item.active").attr("id"));
            $('input[name=phone]').inputmask("+7(999)999-99-99");
            $(".edit_form_tmp").attr("mode", "update");
            $(".edit_form_tmp").attr("home_id", id);
            /***/
            var names = [];
            ;
            $(".edit_form_tmp .edit_list").find("input[changed^=1], select[changed^=1]").each(function () {
                names.push($(this).attr("id"));
            });
            $.ajax({//Получает информацию о доме по id активного дома
                url: "lib.php",
                data: {
                    mode: 'select',
                    table: 'building',
                    names: names,
                    id: id
                },
                type: "post",
                success: function (res) {
                    result = JSON.parse(res);
                    console.info(result);
                    showLines(result['type']);
                    for (var key in result) {
                        $(".edit_form_tmp .edit_list #" + key).val(result[key]);
                    }
                    $(".edit_form_tmp").show();
                    $(".body-overlay").addClass("load");

                    setTimeout(function() {
                        $(".body-overlay").addClass("active-overlay");
                    }, 100);
                }
            });
        } else
            alert("Выберите дом!");
    });

    /**Форма добавления дома*/
    $(".add").click(function () {
        if ($(".street.active").attr("id")) {
            /**Установить режим работы формы*/
            cloneForm('edit_form');
            $(".edit_form_tmp").attr("mode", "add").show();
            $(".body-overlay").addClass("load");

            setTimeout(function() {
                $(".body-overlay").addClass("active-overlay");
            }, 100);
            /***/
        } else {
            alert("Выберите улицу");
        }
    });


    /**Форма удаления дома*/
    $("body").on("click",".delete_home",function () {
        cls = $(this).parent().parent().attr('id');
        deleteItemId('building',cls);
        closeForm("edit_form");
        loadHome();

    });

    /**Добавление улицы*/
    $(".write_street").click(function () {
        $.ajax({
            url: "building.php",
            data: {
                mode: 'add-street',
                street: $(".val_street").val()
            },
            type: "post",
            success: function (res) {
                if (res) {
                    alert("Запись успешно добавлена!");
                    $(".form_street").hide();
                    $(".body-overlay").removeClass("active-overlay");
                    setTimeout(function() {
                      $(".body-overlay").removeClass("load");
                    }, 200);
                    location.reload();

                } else if (!res) {
                    alert("При попытке записать данные, произошла ошибка!");
                }
            }
        });
    });
    /***/

    /* Отправка данных в базу*/
    $("body").on("click", ".edit_form_tmp .write", function () {
        var mode = $(".edit_form_tmp").attr("mode");
        var select = ".edit_form_tmp .edit_list";


        //$(select).find("input[required='required'], select[required='required']")
        /*if ($(select + " *").is("input[required='required'], select[required='required']")){
            console.info($(this).val());
        }*/

        if (mode === 'update') {  //Изменение данных о доме

            var home_arr = {};
            var home_id = $(".edit_form_tmp").attr("home_id");
            home_arr['id'] = home_id;  //первым указывается id дома

            $(select).find("input[changed^=1], select[changed^=1]").each(function () {
                if ($(this).attr("required") && $(this).val() === ''){

                    throw alert("Пожалуйста, заполните все необходимые поля!");

                }
                else {
                    home_arr[$(this).attr("id")] = $(this).val();  //затем добавляются все остальные данные
                }
            });
            $.ajax({
                url: "lib.php",
                data: {
                    mode: 'update',
                    arr: home_arr,
                    id: home_id,
                    table: 'building'
                },
                type: "post",
                success: function (res) {
                    if (res) {
                        alert("Запись успешно добавлена!");
                        loadHome();
                        closeForm('edit_form');
                        $(".body-overlay").removeClass("active-overlay");

                        setTimeout(function() {
                          $(".body-overlay").removeClass("load");
                        }, 200);
                    } else if (!res) {
                        alert("При попытке записать данные, произошла ошибка!");
                    }
                }
            });
        } else if (mode === 'add') {

            var home_arr = {};

            $(select).find("input, select").each(function () {
                if ($(this).attr("required") && $(this).val() === ''){
                    throw alert("Пожалуйста, заполните все необходимые поля!");
                }
                else {
                    home_arr[$(this).attr("id")] = $(this).val();  //затем добавляются все остальные данные
                }
            });
            home_arr['street_id'] = $(".street.active").attr("id");

            $.ajax({
                url: "lib.php",
                data: {
                    mode: mode,
                    arr: home_arr,
                    table: 'building'
                },
                type: "post",
                success: function (res) {
                    if (res) {
                        alert("Запись успешно добавлена!");
                        loadHome();
                        closeForm('edit_form');
                        $(".body-overlay").removeClass("active-overlay");

                        setTimeout(function() {
                          $(".body-overlay").removeClass("load");
                        }, 200);
                    } else if (!res) {
                        alert("При попытке записать данные, произошла ошибка!");
                    }
                }
            });
        }
    });

    /**Открыть/закрыть форму добавления улицы*/
    $(".add_street").click(function () {
        $(".form_street").show();
        $(".body-overlay").addClass("load");

        setTimeout(function() {
            $(".body-overlay").addClass("active-overlay");
        }, 100);
    });

    $(".close_street").click(function() {
      $(".form_street").hide();
      $(".body-overlay").removeClass("active-overlay");

      setTimeout(function() {
        $(".body-overlay").removeClass("load");
      }, 200);
    });

    /**Открыть/закрыть форму изменения дома*/

    $("body").on("click", ".edit_form_tmp .close", function () {
        cloneForm('edit_form');
        $(".body-overlay").removeClass("active-overlay");

        setTimeout(function() {
          $(".body-overlay").removeClass("load");
        }, 200);
    });

    /**Выделение дома*/
    $("body").on("click", ".home-item", function () {
        $(".home-item").removeClass("active");
        $(this).addClass("active");
    });

    /**Дублирование поля ввода*/
    $("body").on("click", ".add_input", function () {
        $(this).parent().clone("").appendTo(".form_street");
    });

    $("body").on("click", ".remove_input", function () {
        $(this).parent().remove();
    });

    /**Загрузка домов нажатой улицы*/
    $(".street").on("click", function () {
        $(".street").removeClass("active");
        $(this).addClass("active");
        loadHome();
    });





    /**Действия с пользователями*/
    $("body").on("click",".create_user",function () {
        cloneForm('user_form');
        $(".user_form_tmp").attr("mode", "add");
        $(".user_form_tmp").show();
        showOverlay();
    });

    $("body").on("click", ".edit_user", function () {
        //var user_id = $(".user_item.active").attr("id");
        user_id = $(this).parent().parent().attr("id");
        console.info(user_id);
        if (user_id) {
            $.ajax({
                url: 'login.php',
                data: {
                    mode: 'select',
                    user_id: user_id
                },
                type: 'post',
                success: function (res) {
                    result = JSON.parse(res);
                    //console.info(result);
                    cloneForm('user_form');
                    $(".user_form_tmp").attr({mode: 'update', user_id: result['id']});
                    $(".user_form_tmp #home_id").remove();
                    showLines(result['role']);

                    for (var key in result) {
                        //console.info(key, '', result[key]);

                        $(".user_lines #" + key).val(result[key]);
                    }

                    $(".user_form_tmp").show();
                    showOverlay();
                }
            });
        } else {
            alert("Выберите пользователя");
        }
        //alert(123);

    });



    $("body").on("click", ".delete_user", function () {

        //var id = $(".user_item.active").attr("id");

        var id = $(this).parent().parent().attr("id");

        if (id) {

            $.ajax({
                url: "lib.php",
                data: {
                    mode: 'delete',
                    table: 'user',
                    id: id
                },
                type: "post",
                success: function (res) {
                    if (res === 0) {
                        alert("Произошла ошибка!");
                    } else {
                        alert("Запись удалена!");
                        closeForm('user_form');
                        loadUser($(".sys_contact_street.active").attr('id'));
                    }

                }
            });
        } else {
            alert("Выберите пользователя");
        }
    });

    $(".show_user").click(function () {
        loadUser();
    });


    $("body").on("click", ".user_item", function () {
        $(".user_item").removeClass("active");
        $(this).addClass("active");
    });


    $("body").on("click", ".close_list", function () {
        closeForm('user_list');
        hideOverlay();
    });

    //Отправить данные регистрации
    $("body").on("click", ".user_reg", function () {
        var user_arr = {};
        var mode = $(".user_form_tmp").attr("mode");
        var user_id = $(".user_form_tmp").attr("user_id");

        if (mode == 'update') {
            var findstr = "input[changed^=1], select[changed^=1]";
        } else if (mode == 'add') {
            var findstr = "input, select";
        }

        $(".user_lines").find(findstr).each(function () {
            user_arr[$(this).attr("id")] = $(this).val();  //затем добавляются все остальные данные
        });

        $.ajax({
            url: "lib.php",
            data: {
                mode: mode,
                id: user_id,
                arr: user_arr,
                table: 'user'
            },
            type: "post",
            success: function (res) {
                if (res != '') {
                    alert("Запись успешно обновлена!");
                    closeForm('user_form');
                    formLight();
                    loadUser($(".sys_contact_street.active").attr('id'));
                } else {
                    alert("Ошибка при попытке записать данные!");
                }
            }
        });
    });

    //Закрыть форму
    $("body").on("click", ".user_close", function () {
        closeForm('user_form');
        hideOverlay();
    });

    /***/


});
