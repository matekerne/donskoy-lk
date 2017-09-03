
function chooseAddit(user_id, view) {
    var role = $(".status").attr("role")
    $.ajax({
        url: "lib.php",
        data: {
            mode: 'select',
            table: 'addit_journal',
            view: view,
            role: role,
            id: user_id

        },
        type: "post",
        success: function (res) {
            var result = JSON.parse(res);
            if (view == 'single') {
                str = '<div class="addit_item" id=' + result['id'] + ' addit_id = ' + result['addit_id'] + '>';
                str += "<span>" + result['name'] + "</span>";
                str += "<span>" + result['addit_date'] + "</span>";
                //str += "<span>" + result['status'] + "</span>";
                str += "<span>" + result['timestamp'] + "</span>";
                str += "<span>" + result['addit_comment'] + "</span>";
                str += "<span>" + result['price'] + "</span>";
                str += "</div>"
                $(".addit_form_tmp .addit_selected").append(str);


                var global_price = parseInt($(".addit_form_tmp .global_price").attr('price')) + parseInt(result['price']);
                $(".addit_form_tmp .global_price").text(global_price);
                $(".addit_form_tmp .global_price").attr('price',global_price);
                $(".addit_form_tmp .global_price").attr('price',global_price);
                //$(".addit_form select, input").val();
            }
            else {
                var list = '';
                for (item in result ){
                    str = '<tr class="table-item addit_item" id=' + result[item][0] + '>';
                    str += '<td class="table-align-left">' + result[item][2] + '</td>';
                    str += '<td>' + result[item][7] + '</td>';
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
                        str += '<td><select class="change_status" name="status"><option selected disabled>' + additStatus + '</option><option value="2">В работе</option><option value="3">Выполнено</option></select></td>';
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
                    //str += '<td>' + result[item][4] + '</td>';

                    str += '<td>' + result[item][5] + '</td>';
                    str += '<td>' + result[item][6] + '</td>';
                    str += '<td>' + result[item][3] + '</td>';
                    str += '<td>' + result[item][8] + ' ' + result[item][9] + ' ' + result[item][10] + '</td>';
                    str += '</tr>';
                    list += str;
                }
                $(".addit_services tbody").html(list);
            }
        }
    });
}

function getIndication(user_id){
    $.ajax({
        url: "lib.php",
        data: {
            mode: 'select',
            table: 'indication',
            education_id: user_id

        },
        type: "post",
        success: function (res) {
            result = JSON.parse(res);
            console.info(result);
            $(".energy-info").append('<div class="tile-date">показания счетчика на<br> <span>' + result['timestamp'] + '</span></div><div class="tile-count">'+result['energy']+' <span>кВт/ч</span></div>');
            $(".water-info").append('<div class="tile-date">показания счетчика на<br> <span>' + result['timestamp'] + '</span></div><div class="tile-count">'+result['water']+' <span>м<sup>3</sup></span></div>');
        },
        error: {

        }
    });
}


function payAddit(res){
    if (res) {
        return res;
    }
    else {
        return false;
    }
}

$(document).ready(function(){

var user_id = $(".status").attr('user_id');
var role = $(".status").attr('role');

loadNews(".news-slider");
if (role >= 3) {
    getIndication(user_id);
}
chooseAddit(user_id, 'global');

$("body").on("click",".addit_date",function(){
    $(".date_panel").toggle();
});

$("body").on("click",".addit_add",function(){
    var arr= {};
    $(".addit_form_tmp").find("input[changed^=1], select[changed^=1]").each(function () {
        if ($(this).attr("required") && $(this).val() === ''){

            throw alert("Пожалуйста, заполните все необходимые поля!");

        }
        else {
            arr[$(this).attr("id")] = $(this).val();  //затем добавляются все остальные данные
        }
    });
    arr['user_id'] = user_id;

    date = arr['addit_date'];
    date_arr = date.split('-');

    arr['addit_date'] = date_arr[2] + '-' + date_arr[1] + '-' + date_arr[0];

    $.ajax({
        url: "lib.php",
        data: {
            mode: 'add',
            table: 'addit_journal',
            arr: arr
        },
        type: "post",
        success: function (res) {
            if (res != '' ) {
                chooseAddit(user_id,'single');
                $(".addit_form input, .addit_form select").val('');
            } else {
                alert("Ошибка при попытке записать данные!");
            }
        }
    });
});

$(".show-menu").on("click", function() {

  if ($(this).hasClass("active-menu")) {
    $(this).removeClass("active-menu");
    $(".dropdown-list").removeClass("show");
    setTimeout(function() {
      $(".dropdown-list").addClass("open-menu");
    }, 200);
  } else {
    $(this).addClass("active-menu");
    $(".dropdown-list").addClass("open-menu");
    setTimeout(function() {
      $(".dropdown-list").addClass("show");
    }, 200);
  }

});

// Показать телефоны
$("body").on("click",".show-contact",function(){
    if ($(this).hasClass("active")) {
        $(this).removeClass("active");
        $(".more-phones").removeClass("show");
        setTimeout(function() {
        $(".more-phones").removeClass("open");
        }, 50);
        $(".show-contact").text("Показать все службы");
    } else {
        $(this).addClass("active");
        $(".more-phones").addClass("open");
        setTimeout(function() {
        $(".more-phones").addClass("show");
        }, 200);
        $(".show-contact").text("Свернуть службы");
    }
});
// Показать телефоны

// Слайдер новостей

// Слайдер новостей

$("body").on("click",".addit_close",function(){
    //$('.addit_form').hide();
    //$('.addit_form input,.addit_form select').val('');
    closeForm('addit_form');
    $("body").removeClass("body-fix");
    $(".body-overlay").removeClass("active-overlay");

    setTimeout(function() {
      $(".body-overlay").removeClass("load");
    }, 200);
})

$("body").on("click",".addit_pay",function(){
        var arr = [];
        var addit_arr = [];
        $(".addit_selected").find(".addit_item").each(function(){
            arr.push($(this).attr("id"));
            addit_arr.push($(this).attr("addit_id"));
        });

        $.ajax({
            url: "lib.php",
            data: {
                mode: 'get_sum',
                table: 'addit_journal',
                arr: addit_arr
            },
            type: "post",
            success: function (res) {

                //Имитация оплаты
                if (payAddit(res)){
                    $.ajax({
                        url: "lib.php",
                        data: {
                            mode: 'update',
                            table: 'addit_journal',
                            arr: arr,
                            count: 'global'
                        },
                        type: "post",
                        success: function (res) {
                            if (res != '' ) {
                                alert("Оплачено!");
                                //$(".addit_form").fadeOut(200);
                                //$(".addit_form input, .addit_form select").val('');
                                closeForm('addit_form');
                                $("body").removeClass("body-fix");
                                $(".body-overlay").removeClass("active-overlay");

                                setTimeout(function() {
                                  $(".body-overlay").removeClass("load");
                                }, 200);
                                chooseAddit(user_id,'global');
                            } else {
                                alert("Ошибка при попытке записать данные!");
                            }
                        }
                    });
                }
                else if (payAddit()) {
                    alert("Оплата не удалась!");
                }
                //
            }
        });
});

$(".take_service").click(function(){

    $.ajax({
        url: "lib.php",
        data: {
            mode: 'select',
            table: 'addit_service'
        },
        type: "post",
        success: function(res) {
            if (res != '') {
                var items = JSON.parse(res);
                var str = '<select class="addit_list">';
                    str += '<option disabled selected>Что сделать?</option>';
                for (i in items) {
                    str += "<option price=" + items[i][2] +" value=" + items[i][0] + ">";
                    str +="<span class='imp'>" + items[i][1] + " </span>";
                    str += "<span>" + items[i][2] + " руб</span>";
                    str += "</option>";
                }
                str += '</select>';
                $("#addit_id").html(str);
                cloneForm('addit_form');
                $(".addit_form_tmp").show();
                $("body").addClass("body-fix");
                $(".body-overlay").addClass("load");

                setTimeout(function() {
                  $(".body-overlay").addClass("active-overlay");
                }, 100);
            } else {
                alert("Ошибка при попытке записать данные!");
            }
        }
    });
});

// Просмотр полной новости
$("body").on("click","#text_news",function() {

  cloneForm("news_popup");
  $(".news_popup_tmp").show();
  showOverlay();

  var role = $('.status').attr("role");

  if (role >= 3) {
    var news_id = $(this).parent().parent().attr("id");
  } else if (role < 3) {
    var news_id = $(this).parent().attr("id");
  }

  //var news_id = $(this).attr('id');
  $.ajax({
        url: "lib.php",
        data: {
            mode: 'select',
            table: 'news',
            id: news_id
        },
        type: "post",
        success: function(res) {

            result = JSON.parse(res);
            console.log(result);
            str = '<div class="article-header">' + result['header_news'] + '</div>';
            str += '<div class="article-date">' + result['date'] + '</div>';
            str += '<div class="article-text">' + result['text_news'] + '</div>';
            $(".news_popup article").html(str);
        }
    });

});

$("body").on("click",".news_popup_close",function() {
  closeForm('news_popup');

  hideOverlay();
});
// Просмотр полной новости

});/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
