/**
 * Created by Yuriy Vlasov on 01.02.2017.
 */
function InfoHide() {
    document.getElementById("advanced-div").style.display = "none";
}

function InfoShow(image_name) {
    GetAdvancedInfo(image_name);
    document.getElementById("advanced-div").style.display = "flex";
}

function GetAdvancedInfo(image_name) {
    var return_status = true;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var json_obj = JSON.parse(this.responseText);
                var inner_html = '';
                // Getting main info.
                inner_html += '<b>Название:</b> ' + json_obj.title + '<br>';
                // Getting main info.
                inner_html += '<b>Цена:</b> ' + json_obj.price + '<br>';
                // Getting main info.
                inner_html += '<b>Количество:</b> ' + json_obj.quantity + '<br>';
                // Getting main info.
                inner_html += '<b>Код товара:</b> ' + json_obj.id + '<br>';
                // Getting other info.
                for(var title in json_obj.other_info) {
                    inner_html += '<b>' + title + '</b>: ' + json_obj.other_info[title] + '<br>';
                }
                document.getElementById("cloud-div-content-text").innerHTML = inner_html;
            }
            catch (parse_error) {
                document.getElementById("cloud-div-content").innerHTML = parse_error;
                alert(this.responseText);
            }
        }
    };
    xhttp.open("GET", "/Lab1/advanced-info.php?image-name=" + image_name, true);
    xhttp.send();
}

function WindowOnLoad() {
    $("a .image-item").on("click", function (e) {
        InfoShow($(this).attr("alt"));
        e.preventPropagation();
    })
}