// Line Charts
var line_chart_demo = $("#line-chart-demo");
var area_chart_demo = $("#area-chart-demo");

line_chart_demo.parent().show();
area_chart_demo.parent().show();

var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
var weekdays = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

const drawLines = (line_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + line_chart_pane).parent().show()
    var line_chart = Morris.Line({
        element: line_chart_pane,
        data: graph_data,
        xkey: 'y',
        ykeys: graph_keys,
        labels: graph_labels,
        lineColors: graph_colors,
        xLabelFormat: function (d) {
            return d.getDate() + ' ' + months[d.getMonth()];
        },
        dateFormat: function (x) {
            let shit = new Date(x);
            var douche = shit.getDate() + ' ' + months[shit.getMonth()];
            return douche;
        },
        resize: true,
        smooth: true,
        pointSize: 0,
        redraw: true
    });
    $('#' + line_chart_pane).parent().attr('style', 'width: 100% !important;');
}


// Area Charts
const drawAreas = (area_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + area_chart_pane).parent().show()
    var area_chart = Morris.Area({
        element: area_chart_pane,
        data: graph_data,
        xkey: 'y',
        ykeys: graph_keys,
        labels: graph_labels,
        lineColors: graph_colors,
        xLabelFormat: function (d) {
            return d.getDate() + ' ' + months[d.getMonth()];
        },
        dateFormat: function (x) {
            let shit = new Date(x);
            var douche = shit.getDate() + ' ' + months[shit.getMonth()];
            return douche;
        },
        resize: true,
        smooth: true,
        pointSize: 0,
        redraw: true
    });
    $('#' + area_chart_pane).parent().attr('style', 'width: 100% !important;');
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}