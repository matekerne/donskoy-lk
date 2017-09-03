$(document).ready(function () {
    function getData(reg) {
        var login = $("#login").val();
        var pass = $("#password").val();
        $.ajax({
            url: "login.php",
            data: {
                login: login,
                pass: pass,
                reg: reg
            },
            type: 'post',
            success: function (res) {

                if (res) {
                    location.reload();
                } else if (res == null) {
                    alert("Такого пользователя не существует.");
                }
            }
        });
    }

    function getOut() {
        $.ajax({
            url: "login.php",
            data: {
                out: true
            },
            type: 'post',
            success: function (res) {
                location.reload();
            }
        });
    }

    $("#send_login").click(function () {
        getData();
    });


    $("body").on("click", "#out", function () {
        getOut();
    });

});