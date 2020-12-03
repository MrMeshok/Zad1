$(document).ready(function() {

    $("#table1_button").click(function() {
        $("#table1_table").remove()
        $("#table2_table").remove()
        $(".sum").remove()
        $(".table3_table").remove()
        $(".title").remove()
        var id = $(this).attr('id')
        $.ajax({
                url: "DataBase/Tables.php",
                type: "POST",
                data:{id: id}
            })
            .done(function(data) {
                var data = JSON.parse(data)
                var html = '<span class="sum">Общая сумма: '+data[2]+'</span>'+
                            `<table border=1 id='table1_table'>
                                <tr>
                                    <th></th>`
                for (key in data[1]) {
                    html += '<th>'+data[1][key].name+'</th>'
                }
                html += '</tr>'
                for (key in data[0]) {
                    html += '<tr>'
                    html += '<td class="table2_button" data-month="'+data[0][key].month+'" data-year="'+data[0][key].year+'">'+data[0][key].Date+'</td>'
                    html += '<td>'+data[0][key].Москва+'</td>'
                    html += '<td>'+data[0][key].Самара+'</td>'
                    html += '<td>'+data[0][key].Якутск+'</td>'
                    html += '</tr>'
                }
                html += `</table>`
                $("#table1").append(html)
            })
            .fail(function() {
                console.log("error");
            })
    });

    $(document).on("click", ".table2_button", function() {
        $("#table2_table").remove()
        $(".table3_table").remove()
        $(".title").remove()
        var id = $(this).attr('class')
        var month = $(this).attr('data-month')
        var year = $(this).attr('data-year')
        $.ajax({
            url: 'DataBase/Tables.php',
            type: 'POST',
            data: {id: id, month: month, year: year},
        })
        .done(function(data) {
            var data = JSON.parse(data)
            var html = `<table border=1 id='table2_table'>
                            <tr>
                                <th></th>`
            for (key in data[1]) {
                html += '<th>'+data[1][key].name+'</th>'
            }
            html += '</tr>'
            for (key in data[0]) {
                html += '<tr>'
                html += '<td class="table3_button" data-month="'+data[0][key].month+'" data-day="'+data[0][key].day+'" data-year="'+data[0][key].year+'">'+data[0][key].Date+'</td>'
                html += '<td>'+data[0][key].Москва+'</td>'
                html += '<td>'+data[0][key].Самара+'</td>'
                html += '<td>'+data[0][key].Якутск+'</td>'
                html += '</tr>'
            }
            $("#table2").append(html)

        })
        .fail(function() {
            console.log("error");
        })

    })
    $(document).on("click", ".table3_button", function() {
        $(".table3_table").remove()
        $(".title").remove()
        var id = $(this).attr('class')
        var day = $(this).attr('data-day')
        var month = $(this).attr('data-month')
        var year = $(this).attr('data-year')
        $.ajax({
            url: 'DataBase/Tables.php',
            type: 'POST',
            data: {id: id, day: day, month: month, year: year},
        })
        .done(function(data) {
            var data = JSON.parse(data)
            for (key in data) {
                var html = 
                '<span class="title">'+key+'</span>'+
                `<table border=1 class='table3_table'>
                    <tr>
                        <th>Номер чека</th>
                        <th>Дата и время (GMT+4)</th>
                        <th>Сумма чека</th>
                    </tr>`
                for (key2 in data[key]) {
                    html += '<tr>'
                    html += '<td>'+data[key][key2].id+'</td>'
                    html += '<td>'+data[key][key2].Date+'</td>'
                    html += '<td>'+data[key][key2].sum+'</td>'
                    html += '</tr>'
                }
                $("#table3").append(html)
            }

        })
        .fail(function() {
            console.log("error");
        })
    })
});