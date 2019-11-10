    $(document).ready(function() {

        $("#btn").click(function () {
            let que   = $('#ajax-form').serialize();
            //que = JSON.stringify(que);
            $.ajax({
                type: "POST",
                url: 'index.php?pg=getrows',
                data:que,
                success: (function (data) {
                    $('#filtered').html(data); //result output
                    document.getElementById('sended').innerHTML = "Данные отправлены.";
                }),
                error: (function (data) {
                    document.getElementById('sended').innerHTML = "Ошибка. Данные не отправлены.";
                })
            });
        });
    });

