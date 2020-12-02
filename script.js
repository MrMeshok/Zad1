$(document).ready(function() {
    $(document).on("click", ".reply_button", function() {
        var id = $(this).attr('id')
        // $("#reply_form_"+id).toggle(400)
        $($(this).next()).toggle(400)
    });

    $("#table1").click(function() {
        var id = $(this).attr('id')
        var arr = ["Яблоко", "Апельсин", "Груша"];

        $.ajax({
                url: "DataBase/tables.php",
                data:{"id": id},
                type: "POST",
                success:function(data){
                    var data = JSON.parse(data)
                    // console.log(data)
                    for (key in data[1]) {
                        console.log(data[1][key].name)
                    }
                    var html = `
                        <table border=1>
                            <tr>
                                <th></th>`
                    for (key in data[1]) {
                        html += '<th>'+data[1][key].name+'</th>'
                    }
                        
                    //                 echo "<th>".$value['name']."</th>"
                    //         </tr>
                    //         <?foreach ($table1 as $key => $value) {
                    //             echo "<tr>";
                    //             echo "<td>".EnMonthsToRu($value['Date'])."</td>";
                    //             echo "<td>".$value['Москва']."</td>";
                    //             echo "<td>".$value['Самара']."</td>";
                    //             echo "<td>".$value['Якутск']."</td>";
                    //             echo "</tr>";
                    //         }?>
                    //     </table>
                                
                    //             Общая сумма:`+data[2]+`
                    // `
                    $("#table1").after(html)
                    // // console.log(data.table[0])
                    // data.forEach(function(item, index, array) {
                    //     console.log(item, index);
                    // });
                },
                error:function (){
                }
            })
    });


    $("#all_comments").click(function() {
        var id = $(this).attr('data')
        $("#all_comments").remove()
        jQuery.ajax({
            url: 'all_comments/'+id,
            success:function(data){
                $(".card-body-comments").append(data)
            },
            error:function (){
                console.log('Ошибка')
            }
        })
    });
    $("#add_book").click(function() {
        $($(this).next().next()).toggle(400)
    });
    $(".edit_book").click(function() {
        $($(this).next().next()).toggle(400)
    });
});