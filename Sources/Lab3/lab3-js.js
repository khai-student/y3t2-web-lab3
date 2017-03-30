/**
 * Created by Yuriy Vlasov on 01.02.2017.
 */
data = [];
labels = [];

function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

function ConvertDegreesToRadians(degrees) {
    return (degrees * Math.PI)/180;
}
function ArraySum(array, lastIndex) {
    var sum = 0;
    if (lastIndex >= array.length || lastIndex <= 0) {
        lastIndex = data.length;
    }
    for (var index = 0; index < lastIndex; ++index) {
        sum += array[index];
    }
    return sum;
}

function DrawSegment(canvas, context, data_index) {
    context.save();
    var centerX = Math.floor(canvas.width / 2);
    var centerY = Math.floor(canvas.height / 2);
    radius = centerX;

    var startingAngle = ConvertDegreesToRadians(ArraySum(data, data_index));
    var arcSize = ConvertDegreesToRadians(data[data_index]);
    var endingAngle = startingAngle + arcSize;

    context.beginPath();
    context.moveTo(centerX, centerY);
    context.arc(centerX, centerY, radius,
        startingAngle, endingAngle, false);
    context.closePath();

    context.fillStyle = getRandomColor();
    context.fill();

    // context.strokeStyle = getRandomColor();
    // context.lineWidth = 3;
    // context.stroke();

    context.restore();

    DrawNextSegmentLabel(canvas, context, data_index);
}

function DrawNextSegmentLabel(canvas, context, data_index) {
    context.save();
    var x = Math.floor(canvas.width / 2);
    var y = Math.floor(canvas.height / 2);
    var angle = ConvertDegreesToRadians(ArraySum(data, data_index));

    context.translate(x, y);
    context.rotate(angle);
    var dx = Math.floor(canvas.width * 0.5) - 10;
    var dy = Math.floor(canvas.height * 0.05);

    context.textAlign = "right";
    var fontSize = Math.floor(canvas.height / 25);
    context.font = fontSize + "pt Helvetica";

    context.fillText(labels[data_index], dx, dy);

    context.restore();
}

function WindowOnLoad() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            try {
                var json_obj = JSON.parse(this.responseText);
                var sum = 0;
                for(var index in json_obj) {
                    data.push(json_obj[index]);
                    labels.push(json_obj[index]);
                    sum += json_obj[index];
                }

                for (var i = 0; i < data.length; ++i) {
                    data[i] *= 360;
                    data[i] /= sum;
                }
                data[data.length-1] += 360 - ArraySum(data, data.length);

                canvas = document.getElementById("piechart");
                var context = canvas.getContext("2d");
                for (i = 0; i < data.length; i++) {
                    DrawSegment(canvas, context, i);
                }
            }
            catch (parse_error) {
                data = null;
                alert("AJAX FAILED!\n" + this.responseText);
            }
        }
    };
    xhttp.open("GET", "./get_piechart_data.php", true);
    xhttp.send();
}

