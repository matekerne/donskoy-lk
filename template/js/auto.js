function writePermit(table){
     var arr = {};
     var mode = $("."+table+"_tmp").attr("mode");
        var id = $("."+table+"_item.active").attr("id");
            $("."+table+"_tmp ."+table+"_lines").find("input, select").each(function () {
                arr[$(this).attr("id")] = $(this).val();  //затем добавляются все остальные данные
            });
            arr['user_id'] = $(".status").attr("user_id");
            date = arr['close_date'];
            date_arr = date.split('-');

            arr['close_date'] = date_arr[2] + '-' + date_arr[1] + '-' + date_arr[0];
            //arr['timestamp'] = '';
            /*arr['close_date'] = "ADDDATE(NOW()," + arr['close_date'] +")";
            console.info(arr);*/

            $.ajax({
                url: "lib.php",
                data: {
                    mode: mode,
                    arr: arr,
                    table: table,
                    ediction_id: $(".status").attr("user_id"),
                    id: id
                },
                type: "post",
                success: function (res) {
                    if (res) {
                        alert("Запись успешно добавлена!");
                        //closeForm("auto");
                        loadPermit(table);
                    } else if (!res) {
                        alert("При попытке записать данные, произошла ошибка!");
                    }
                }
            });
}

function updateDate(table, id, arr){

    $.ajax({
        url: "lib.php",
        data: {
            mode: 'update',
            arr: arr,
            table: table,
            id: id
        },
        type: "post",
        success: function (res) {
            if (res) {
                loadPermit(table);
                alert("Запись успешно добавлена!");
                //closeForm("auto");
            } else if (!res) {
                alert("При попытке записать данные, произошла ошибка!");
            }
        }
    });
}

function editPermit (table) {
    var cur_id = $("."+table+"_item.active").attr("id");
    //console.info($("."+table+"_item.active").attr("id"));
        if (cur_id) {
            $.ajax({
                url: 'lib.php',
                data: {
                    mode: 'select',
                    table: table,
                    id: cur_id
                },
                type: 'post',
                success: function (res) {
                    $("."+table).attr('mode', 'update');
                    result = JSON.parse(res);
                    cloneForm(table);

                    for (var key in result) {

                        $("."+table+"_tmp ."+table+"_lines #" + key).val(result[key]).attr("disabled",true);
                    }
                    $("."+table+"_tmp ."+table+"_lines #close_date").attr("disabled",false);
                    $("."+table+"_tmp").show();
                }
            });
        } else {
            alert("Выберите автомобиль");
        }
}

function loadPermit(table){
    var ediction_id = $(".status").attr("user_id");

    if ($(".status").attr("role") < 3) {
        ediction_id = null;
    }// Если руководитель, то стереть id, чтобы получить всё.

    //cloneForm('permit');
    $.ajax({
        url: "lib.php",
        data: {
            table: table,
            mode: 'select',
            ediction_id: ediction_id,
            role: $(".status").attr("role")
        },
        type: "post",

        success: function (result) {
            res = JSON.parse(result);
            str = '';
            //$(".home_cont").html(res);
            for (item in res) {
                str = str + '<tr class="table-item '+ table +'_item" id='+ res[item][0] +'>';
                if (table == 'auto'){
                    str = str + "<td class='table-align-left'>"+res[item][1]+"</td>";
                    str = str + "<td><div class='car_name'>"+res[item][3]+"<br><span>"+res[item][2]+"</span></div></td>";
                    str = str + "<td>"+ res[item][4] +"</td>";
                    str = str + "<td><input class='close_date' value='"+ res[item][5] +"'></td>";
                    str = str + "<td class='table-align-right'><button class='button button-text-green button-small button-round edit_auto'>Продлить</button></td>"
                }
                else if (table == 'guest'){
                    str = str + "<td class='table-align-left'><div>"+res[item][1]+"</div><div>"+res[item][2]+" "+res[item][3]+"</td>";
                    str = str + "<td>"+res[item][4]+"</td>";
                    str = str + "<td>"+res[item][5]+"</td>";
                    str = str + "<td><input class='close_date' value='"+res[item][6]+"'></td>";
                    str = str + "<td class='table-align-right'><button class='button button-text-green button-small button-round edit_guest'>Продлить</button></td>"
                }
                str = str + '</tr>';
                //$(str).appendTo(".permit_tmp ." + $table + "_list");
            }
                $(".permit_" + table + " tbody").html(str);
                $(".close_date").pickadate({
                    min: true,
                    max: 15,
                    format: 'd-mm-yyyy'
                 });
                //console.info(str);
        }

    });
    //$(".permit_tmp").show();
}

function deletePermit (table){
            if ($("."+table+"_item.active").attr("id")) {

            /**Установить режим работы формы*/
            $("."+table).attr("mode", "delete");
            /***/

            $.ajax({//Получает информацию о доме по id активного дома
                url: "lib.php",
                data: {
                    mode: $(".auto").attr('mode'),
                    table: table,
                    id: $("."+table+"_item.active").attr("id")
                },
                type: "post",
                success: function (res) {
                    if (res != 0){
                        alert('Запись удалена');
                        //closeForm('auto');
                        loadPermit(table);
                    }
                    else {
                        alert('Произошла ошибка!');
                    }

                }
            });
        } else
            alert("Элемент не выбран!");
}

$(document).ready(function () {


    $(".close_date").pickadate({
        min: true,
        max: 15,
        format: 'd-mm-yyyy'
     });
    //Сделать активным автомобиль
    /*$("body").on("click",".auto_item",function(){
        $(".auto_item").removeClass("active");
        $(this).addClass("active");
    });

    $("body").on("click",".guest_item",function(){
        $(".guest_item").removeClass("active");
        $(this).addClass("active");
    });*/
    //

    // Добавить автомобиль
    $("body").on("click",".add_auto",function (){
        cloneForm('auto');
        $(".auto_tmp").show();
        loadPermit('auto');
        $("body").addClass("body-fix");
        showOverlay();
    });
    // Добавить автомобиль

    // Добавить человека
    $("body").on("click",".add_guest",function (){
        cloneForm('guest');
        loadPermit('guest');
        $(".guest_tmp").show();
        $("body").addClass("body-fix");
        showOverlay();
    });
    // Добавить человека

    //Открыть вкладку автомобилей
    /*$("body").on("click",".permit_btn",function (){
        cloneForm('permit')
        loadPermit('auto');
        loadPermit('guest');
        $(".permit_tmp").show();
        $(".body-overlay").addClass("load");

        setTimeout(function() {
          $(".body-overlay").addClass("active-overlay");
        }, 100);
    });*/



    //Удаление автомобиля
    $("body").on("click",".delete_auto",function(){
        deletePermit('auto');
    });

    $("body").on("click",".delete_guest",function(){
        deletePermit('guest');
    });
    //

    $("body").on("click",".edit_auto",function(){
        arr = {};
        auto_id = $(this).parent().parent().attr('id');
            date = $('.auto_item#'+auto_id+' .close_date').val();
            date_arr = date.split('-');

        arr['close_date'] = date_arr[2] + '-' + date_arr[1] + '-' + date_arr[0];

        updateDate('auto',auto_id, arr);
    });

    $("body").on("click",".edit_guest",function(){
        arr = {};
        auto_id = $(this).parent().parent().attr('id');
            date = $('.guest_item#'+auto_id+' .close_date').val();
            date_arr = date.split('-');

        arr['close_date'] = date_arr[2] + '-' + date_arr[1] + '-' + date_arr[0];

        updateDate('guest',auto_id, arr);
    });


    $("body").on("click",".close_auto",function (){
        closeForm('auto');
        $("body").removeClass("body-fix");
        hideOverlay();
    });

    $("body").on("click",".close_guest",function (){
        closeForm('guest');
        $("body").removeClass("body-fix");
        hideOverlay();
    });

    $("body").on("click",".write_auto",function (){
       writePermit('auto');
       //loadPermit('auto');
       closeForm('auto');
       $("body").removeClass("body-fix");
       hideOverlay();
       //location.reload();
    });

    $("body").on("click",".write_guest",function (){
       writePermit('guest');
       //loadPermit('guest');
       closeForm('guest');
       $("body").removeClass("body-fix");
       hideOverlay();
       //location.reload();
    });
});
