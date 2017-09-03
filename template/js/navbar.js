function loadContact(){
    $.ajax({
        url: 'lib.php',
        data: {
            mode: 'select',
            table: 'contact'
        },
        type: 'post',
        success: function (res) {
            var items = JSON.parse(res);
            var str = '<table class="table phone_number_table">'+
                        '<thead class="table-header number_table-header">'+
                        '<th class="table-align-left">Имя контакта</th>'+
                        '<th>Контактное лицо</th>'+
                        '<th>Номер</th>'+
                        '<th></th></thead><tbody>';
            for (i in items) {
                str += "<tr class='table-item contact_item' id=" + items[i][0] + ">";
                str +="<td id='serv_name' class='table-align-left imp'>" + items[i][1] + "</td>";
                //str += "<div id='serv_man'>" + items[i][2] + "</div>";
                if (items[i][3] == null) {
                    str += "<td id='serv_man'></td>";
                }
                else {
                    str += "<td id='serv_man'>" + items[i][2] + "</td>";
                    //str += "<div id='destination'>" + items[i][3] + "</div>";
                }
                str += "<td id='serv_number'>" + items[i][3] + "</td>";
                str += "<td class='table-item-group'><button class='button button-icon-small edit_contact'><img src='template/img/icon/admin/street/edit.svg'></button><button class='button button-icon-small delete_icon delete_contact'><img src='template/img/icon/admin/street/delete.svg'></button></td>";
                str += "</tr>";
            }
            str += "</tbody></table>";
            // $(".footer").html(str);
            $(".contact_show").html(str);
        }
    });
}

function changePanel() {
    $(".addit_view_cont").toggle();
    $(".auto_view_cont").toggle();
}

function loadMonth (){
    var street_id = $(".street_item.active").attr('id');
    var date = new Date();
    $(".sys_month").attr("street_id",street_id);
    $.ajax({
        url: "lib.php",
        data: {
            mode: 'getMonth',
            table: 'indication',
            street_id: street_id
        },
        type: "post",
        success: function(res) {
            var result = JSON.parse(res);

            month = '';
            getmonth = '0' + date.getMonth()+1;
            flag_month = true;
            for (val in result){

               period = result[val][0].split('-');
               if (period[0] == getmonth){
                   flag_month = false;
               }
               str = "<div class='month-item sys_month' month=" + period[0]+ " street_id="+street_id+">";
               str += "<div >"+ period[0] + "</div>";
               // str += "<div >----------------</div>";
               str += "<div >"+ period[1] + "</div>";
               str += "</div>";
               month += str;
            }
            if (!flag_month) {
                month += "<div class='month-item sys_month' month=" + date.getMonth() + " street_id="+street_id+">";
                month += "<div >"+ getmonth + "</div>";
                //month += "<div >----------------</div>";
                month += "<div >"+ date.getFullYear() + "</div>";
                month += "</div>";

            }
            $(".indication_period").html(month);
            $(".month-item:last").addClass("active");
            loadIndication();
        }
        });
}

function loadIndication(){
        var street_id = $(".sys_month.active").attr('street_id');
        var month = $(".sys_month.active").attr('month');
            $.ajax({
            url: 'lib.php',
            data: {
                mode: 'select',
                table: 'user',
                ediction_id: street_id || $(".street_item.active").attr('id')
            },
            type: 'post',
            success: function (list) {
                user_list = JSON.parse(list);
                $.ajax({
                    url: "lib.php",
                    data: {
                        mode: 'select',
                        table: 'indication',
                        month: month,
                        street_id: street_id
                    },
                    type: "post",
                    success: function(res) {
                        var result = JSON.parse(res);
                        for (i in user_list){
                            user = user_list[i];
                            for (cur in result){
                                indication = result[cur];
                                if (indication[1] == user[0]){
                                    user.push(indication[2],indication[3],indication[0]);
                                }
                            }
                        }
                        str = '';
                        for (item in user_list){
                            var cur = user_list[item];
                            str += "<tr class='table-item indication_item' id="  + cur[6] +" user_id="+ cur[0] +">";
                            str += "<td id='user_name' class='imp'>" + cur[1] + " " + cur[2] + " " + cur[3] +  "</td>"
                            if (cur[4] && cur[5]){
                                str += "<td><input id='energy' type='text' value='" + cur[4] + "' disabled></td>"
                                str += "<td><input id='water' type='text' value='" + cur[5] + "' disabled></td>"
                                str += "<td class='table-item-group'>";
                                str += "<button class='button button-small button-icon-small edit_indication'><img src='template/img/icon/admin/street/edit.svg'></button>";
                                str += "</td></tr>";
                            }
                            else {
                                str += "<td><input id='energy' type='text' placeholder='Показания электроенергии'/></td>";
                                str += "<td><input id='water' type='text' placeholder='Показания водоснабжения'/></td>";
                                str += "<td class='table-item-group'>";
                                str += "<button class='button button-small button-icon-small write_indication'><img src='template/img/icon/admin/table/done.svg'></button>";
                                str += "</td></tr>";
                            }
                        }
                        $(".indication_table tbody").html(str);
                    }
                });
            }
        });
}

function loadNews(place){
    role = $(".status").attr("role");
    user_id = $(".status").attr("user_id");
    $.ajax({
        url: 'lib.php',
        data: {
            mode: 'select',
            table: 'news',
            user_id: user_id,
            role: role
        },
        type: 'post',
        success: function(res) {
            if (res != '') {
                var items = JSON.parse(res);
                var str = '';
                if (role >= 3){
                    for (i in items) {

                        var newsText = items[i][2]/*.substr(0, 59) + '...'*/;

                        str += "<div class='news_item new-item' id=" + items[i][0] + "><div user_id='" + items[i][3] + "' class='news_item_user' >";
                        str += "<div id='header_news'>" + items[i][1] + "</div>";
                        str += "<span class='time'>" + items[i][4] + "</span>";
                        str +="<div id='text_news' class='imp'>" + items[i][2] + "</div>";
                        str += "</div></div>";
                    }
                }
                else if (role < 3){
                  str += "<table class='table'>"+
                            "<thead class='table-header'>"+
                                  "<th class='table-align-left table-width-35'>Заголовок</th>"+
                                  "<th>Новость</th>"+
                                  "<th>Кому</th>"+
                                  "<th>Дата</th>"+
                                  "<th></th>"+
                              "</thead><tbody>";
                    for (i in items) {
                        /*var newsText = items[i][2].substr(0, 59) + '...'*/;
                        console.info(items);
                        str += "<tr class='table-item news_item new-item' id=" + items[i][0] + ">";
                        str += "<td id='text_news' class='table-align-left imp'>" + items[i][2] + "</td>";
                        str += "<td id='header_news'>" + items[i][1] + "</td>";
                        if (items[i][3]){
                           str += "<td id='user_id'>" + items[i][3] + ' ' + items[i][4] + ' ' + items[i][5] + "</td>";
                        }
                        else {
                            str += "<td id='user_id'></td>";
                        }
                        str += "<td class='time'>" + items[i][6] + "</td>";
                        str += "<td>"+
                                  "<button class='button button-small button-icon-small edit_news'><img src='template/img/icon/admin/street/edit.svg' /></button>"+
                                  "<button class='button button-small button-icon-small delete_news'><img src='template/img/icon/admin/street/delete.svg' /></button>"+
                                "</td>";
                        str += "</tr>";
                    }
                    str += "</tbody></table>"
                }
                /*$(".news-slider").append(str);
                $(".news-slider").slick({*/
                $(place).html(str);
                $(".news-slider").slick({
                  dots: true,
                  infinite: false,
                  speed: 300,
                  slidesToShow: 4,
                  slidesToScroll: 1,
                  centerMode: false,
                  variableWidth: true
                });
            } else {
                alert("Ошибка при попытке записать данные!");
            }
        },
        error: function(){
            alert("Не удалось обратиться к серверу!");
        }
    });
}


$(document).ready(function(){

    //Получение новостей
    /*$.ajax({
        url: "lib.php",
        data: {
            mode: 'select',
            table: 'news',
            user_id: $(".status").attr("user_id"),
            role: $(".status").attr("role")

        },
        type: "post",
        success: function (res) {
            if (res != '') {
                var items = JSON.parse(res);
                var str = '';
                for (i in items) {
                    str += "<div class='news_item' id=" + items[i][0] + ">";
                    str +="<div id='text_news' class='imp'>" + items[i][1] + "</div>";
                    str += "<div id='destination'>" + items[i][2] + "</div>";
                    str += "<span class='time'>" + items[i][3] + "</div>";
                    str += "</div>";
                }
                $(".news_panel").html(str);
            } else {
                alert("Ошибка при попытке записать данные!");
            }
        },
        error: function(){
            alert("Не удалось обратиться к серверу!");
        }
    });*/
    //
    //loadNews(".news_panel");


    function makeActive(selector, item){
        $(selector).removeClass("active");
        item.addClass("active");
    }

    // $("body").on("click", ".contact_item", function () {
    //     makeActive(".contact_item", $(this));
    // });

    $("body").on("click", ".add_new_contact", function() {
        $(".contact").attr("mode","add");
        $(".contact_lines").show();
        showOverlay();
    });

    $("body").on("click",".write_contact",function(){
        var arr = {};
        var mode = $(".contact").attr("mode");
        var contact_id = $(".contact").attr("id");
        //alert(123);
        $(".contact_lines").find("input, select").each(function () {
            console.info($(this).val());
            arr[$(this).attr("id")] = $(this).val();  //затем добавляются все остальные данные
        });


        $.ajax({
            url: "lib.php",
            data: {
                mode: mode,
                arr: arr,
                id: contact_id,
                table: 'contact'
            },
            type: "post",
            success: function (res) {
                if (res == 1) {

                    $(".contact_lines").hide();
                    hideOverlay();
                    loadContact();
                    alert("Запись успешно обновлена!");
                    $(".contact_lines input").val("");
                } else {
                    alert("Ошибка при попытке записать данные!");
                }
            },
            error: function(){
                alert("Не удалось обратиться к серверу!");
            }
        });
    });

    $("body").on("click", ".edit_contact", function () {
        contact_id = $(this).parent().parent().attr("id");
        if (contact_id) {
            $(".contact").attr("id",contact_id);
            $(".contact").attr("mode","update");
            $.ajax({
                url: 'lib.php',
                data: {
                    mode: 'select',
                    table: 'contact',
                    id: contact_id
                },
                type: 'post',
                success: function (res) {
                    result = JSON.parse(res);
                    $(".contact").attr({mode: 'update', user_id: result['id']});
                    $(".contact_lines").show();
                    $(".body-overlay").addClass("load");
                    setTimeout(function() {
                        $(".body-overlay").addClass("active-overlay");
                    }, 100);
                    for (var key in result) {

                        $(".contact_lines #" + key).val(result[key]);
                    }
                },
                error: function(){
                alert("Не удалось обратиться к серверу!");
            }
            });
        } else {
            alert("Выберите контакт");
        }

    });


    $("body").on("click",".delete_contact",function(){
        contact_id = $(this).parent().parent().attr("id");
        // var contact_id = $(".contact_item.active").attr("id");

        if (contact_id) {
            $.ajax({
                url: 'lib.php',
                data: {
                    mode: 'delete',
                    id: contact_id,
                    table: 'contact'
                },
                type: 'post',
                success: function (res) {
                    if (res === 0) {
                        alert("Произошла ошибка!");
                    } else {
                        alert("Запись удалена!");
                        loadContact();
                    }
                }
            });
        } else {
            alert("Выберите контакт");
        }
    });

    $("body").on("click",".clear_input",function(){

        $(".contact_lines input").val("");
    });

    $("body").on("click", ".close_contact_form", function() {
        $(".contact_lines input").val("");
        $(".contact_lines").hide();
        $(".body-overlay").removeClass("active-overlay");
        setTimeout(function() {
            $(".body-overlay").removeClass("load");
        }, 200);
    });






    //НОВОСТИ

    $("body").on("click", ".news_item", function () {
        makeActive(".news_item", $(this));
    });


    $("body").on("click",".write_news",function(){
        
        console.info(CKEDITOR.instances.sys_text_news.getData());
        var arr = {};
        var mode = $(".news").attr("mode");

        /*$(".news_lines").find("input, select").each(function () {
            arr[$(this).attr("name")] = $(this).val();  //затем добавляются все остальные данные
        });*/
        //console.info(arr);
        arr['user_id'] = $(".news_lines #user_id").val();
        arr['header_news'] = $(".news_lines #sys_header_news").val();
        arr['text_news'] = CKEDITOR.instances.sys_text_news.getData();
        $.ajax({
            url: "lib.php",
            data: {
                mode: mode,
                arr: arr,
                table: 'news',
                id: $(".news_item.active").attr("id")
            },
            type: "post",
            success: function (res) {
                if (res != '') {
                    loadNews(".news_show");
                    alert("Запись успешно обновлена!");
                    $(".news_lines input, .news_lines select").val("");
                    CKEDITOR.instances.sys_text_news.setData('');
                } else {
                    alert("Ошибка при попытке записать данные!");
                }
            }
        });
    });

    $("body").on("click",".delete_news",function(){
        var id = $(this).parent().parent().attr('id');
        deleteItemId('news', id);
        loadNews(".news_show");
        $(".news").attr("mode","add");
    });


    $("body").on("click",".edit_news",function(){
        var id = $(this).parent().parent().attr("id");
        //var id = $(".news_item.active").attr("id");
        if (id) {
            $.ajax({
                url: 'lib.php',
                data: {
                    mode: 'select',
                    table: 'news',
                    id: id
                },
                type: 'post',
                success: function (res) {
                    result = JSON.parse(res);
                    $(".news").attr("mode","update");
                    //console.info(result['header_news']);
                    //console.info(result['text_news']);
                    $(".news_lines #user_id").val(result['user_id']);
                    $(".news_lines #sys_header_news").val(result['header_news']);
                    CKEDITOR.instances.sys_text_news.setData(result['text_news']);
                    
                    /*
                     * 

                    for (var key in result) {

                        $(".news_lines [name=" + key + "]").val(result[key]);
                    }*/
                    //console.info(result);
                }
            });
        } else {
            alert("Выберите пользователя");
        }
    });
    //



    //ДОПУСЛУГИ
    $("body").on("click",".addit_item",function(){
        makeActive(".addit_item",$(this));
    });

    $("body").on("change",".change_status",function(){
        var arr = {};
        arr['status'] = $(this).val();
        console.info($(this).val());
        $.ajax({
            url: "lib.php",
            data: {
                mode: 'update',
                table: 'addit_journal',
                arr: arr,
                role: $(".status").attr("role"),
                id: $(this).parent().parent().attr("id")
            },
            type: "post",
            success: function (res) {
                if (res != '' ) {
                        $.ajax({
                            url: "lib.php",
                            data: {
                                mode: 'select',
                                table: 'addit_journal',
                                view: 'global',
                            },
                            type: "post",
                            success: function (res) {
                                var result = JSON.parse(res);
                                var list = '';
                                for (item in result ){
                                    str = '<tr class="table-item addit_item" id=' + result[item][0] + '>';
                                    str += '<td class="table-align-left">' + result[item][2] + '</td>';
                                    str += '<td>' + result[item][7] + '</td>';
                                    // if (result[item][4] == 0) {
                                    //   str += '<td>Не оплачено</td>';
                                    // } else if (result[item][4] == 1) {
                                    //   str += '<td>Оплачено</td>';
                                    // } else if (result[item][4] == 2) {
                                    //   str += '<td>В работе</td>';
                                    // } else if (result[item][4] == 3) {
                                    //   str += '<td>Выполнено</td>';
                                    // }

                                    if (role < 3){
                                        if (result[item][4] == 0) {
                                        var additStatus = 'Не оплачено';
                                        } else if (result[item][4] == 1) {
                                        var additStatus = 'Оплачено';
                                        } else if (result[item][4] == 2) {
                                        var additStatus = 'В работе';
                                        } else if (result[item][4] == 3) {
                                        var additStatus = 'Выполнено';
                                        }
                                        str += '<td><select class="change_status" name="status"><option selected disabled>' + additStatus + '<option value="2">В работе</option><option value="3">Выполнено</option></select></td>';
                                    }
                                    else if (role >=3) {
                                        if (result[item][4] == 0) {
                                        str += '<td>Не оплачено</td>';
                                        } else if (result[item][4] == 1) {
                                        str += '<td>Оплачено</td>';
                                        } else if (result[item][4] == 2) {
                                        str += '<td>В работе</td>';
                                        } else if (result[item][4] == 3) {
                                        str += '<td>Выполнено</td>';
                                        }

                                    }

                                    str += '<td>' + result[item][5] + '</td>';
                                    str += '<td>' + result[item][6] + '</td>';
                                    str += '<td>' + result[item][3] + '</td>';
                                    str += '<td>' + result[item][8] + ' ' + result[item][9] + ' ' + result[item][10] + '</td>';
                                    str += '</tr>';
                                    list += str;
                                }
                                $(".addit_services tbody").html(list);
                            }
                        });
                } else {
                    alert("Ошибка при попытке записать данные!");
                }
            },
            error: function(){
                alert("Ошибка доступа к базе!");
            }
        });
    });

    //



    //ПОКАЗАНИЯ
    $("body").on("click",".indication_item",function(){
        makeActive(".indication_item",$(this));
    });

    $("body").on("click",".sys_month",function(){
        makeActive(".sys_month",$(this));
    });

    $("body").on("click",".write_indication",function(){
        var parent = $(this).parent().parent();
        var user_id = $(this).parent().parent().attr('user_id');
        var indication_id = $(this).parent().parent().attr('id');
        var arr = {};
        if (indication_id == 'undefined') {
            var mode = 'add';
            indication_id = '';
        }
        else {
            var mode = 'update';
        }
        parent.find("#energy, #water").each(function(){
            
            arr[$(this).attr("id")] = $(this).val();
        });
        arr['user_id'] = user_id;
        $.ajax({
            url: "lib.php",
            data: {
                mode: mode,
                table: 'indication',
                arr: arr,
                id: indication_id
            },
            type: "post",
            success: function (res) {
                if (res != '' ) {
                    loadIndication();
                } else {
                    alert("Ошибка при попытке записать данные!");
                }
            },
            error: function(){
                alert("Ошибка доступа к базе!");
            }
        });
    });

    $("body").on("click",".edit_indication",function(){
        var parent = $(this).parent().parent();
        $(this).removeClass("edit_indication").addClass("write_indication").children("img").attr("src","template/img/icon/admin/table/done.svg");
        parent.find("input").each(function(){
            $(this).removeAttr("disabled");
        });
    });

    function activeFirstMonth() {
        //$(".street_item:first").addClass("active");
        var street_id = $(".street_item.active").attr("id");
        $.ajax({
            url: 'lib.php',
            data: {
                mode: 'select',
                table: 'user',
                ediction_id: street_id
            },
            type: 'post',
            success: function (res) {
                result = JSON.parse(res);
                list = '';
                for (item in result) {
                    value = result[item];
                    str = '';
                    str += "<tr class='table-item indication_item' id="+value[0]+">";
                    str += "<td id='user_name'>"+value[1]+" "+value[2]+" "+value[3]+"</td>";
                    str += "<td><input id='energy' type='text' placeholder='Показания электроенергии'/></td>";
                    str += "<td><input id='water' type='text' placeholder='Показания водоснабжения'/></td>";
                    str += "<td class='table-item-group'>" +
                        "<button class='button button-small button-icon-small write_indication'><img src='template/img/icon/admin/street/edit.svg'></button>";
                    str += "</td></tr>";
                    list += str;
                }
                $(".indication_table tbody").html(list);
            }
        });
        loadMonth();

    }

    activeFirstMonth();

    $(".street_item:first").addClass("active");

    $("body").on("click",".street_item",function(){
        $(".indication_table tbody").html('');
        $(".street_item").removeClass("active");
        $(this).addClass("active");
        loadMonth();
    });

    $("body").on("click",".sys_month",function(){
        loadIndication();
    });
    
    
    
    $("body").on("click",".sys_contact_street",function(){
        $(".sys_contact_street").removeClass("active");
        $(this).addClass("active");
        loadUser($(this).attr('id'));
    });

});/*

 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
