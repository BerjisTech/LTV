// Line Charts
var line_chart_demo = $("#line-chart-demo");
var area_chart_demo = $("#area-chart-demo");

line_chart_demo.parent().show();
area_chart_demo.parent().show();

var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
var weekdays = ["SUN", "MON", "TUE", "WED", "THU", "FRI", "SAT"];

const drawLine = (line_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + line_chart_pane).parent().show()
    var line_chart = Morris.Line({
        element: line_chart_pane,
        data: graph_data,
        xkey: "y",
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

const drawShortLine = (line_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + line_chart_pane).parent().show()
    var line_chart = Morris.Line({
        element: line_chart_pane,
        data: graph_data,
        xkey: "y",
        ykeys: graph_keys,
        labels: graph_labels,
        lineColors: graph_colors,
        resize: true,
        xLabelFormat: function (x) {
            let shit = new Date(x);
            let date = x.getDate();
            let monthy = months[x.getMonth()];
            let hours = x.getHours();
            let minutes = x.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
            var douche = strTime;
            return douche;
        },
        dateFormat: function (x) {
            let shit = new Date(x);
            let date = shit.getDate();
            let monthy = months[shit.getMonth()];
            let hours = shit.getHours();
            let minutes = shit.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
            var douche = strTime;
            return douche;
        },
        smooth: true,
        redraw: true
    });
    $('#' + line_chart_pane).parent().attr('style', 'width: 100% !important;');
}

const drawLongLine = (line_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + line_chart_pane).parent().show()
    var line_chart = Morris.Line({
        element: line_chart_pane,
        data: graph_data,
        xkey: "y",
        ykeys: graph_keys,
        labels: graph_labels,
        lineColors: graph_colors,
        xLabelFormat: function (x) {
            return x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear();
        },
        dateFormat: function (x) {
            let d = new Date(x);
            var douche = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
            return douche;
        },
        resize: true,
        smooth: true,
        pointSize: 0,
        redraw: true
    });
    $('#' + line_chart_pane).parent().attr('style', 'width: 100% !important;');
}

const drawPercentLine = (line_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + line_chart_pane).parent().show()
    var line_chart = Morris.Line({
        element: line_chart_pane,
        data: graph_data,
        xkey: "y",
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
        redraw: true,
        formatter: function (value) { return (value) + '%' },
        hoverCallback: function (value) {
            return `Churn ${value} %`;
        }
    });
    $('#' + line_chart_pane).parent().attr('style', 'width: 100% !important;');
}


// Area Charts
const drawArea = (area_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + area_chart_pane).parent().show()
    var area_chart = Morris.Area({
        element: area_chart_pane,
        data: graph_data,
        xkey: "y",
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
const drawShortArea = (area_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + area_chart_pane).parent().show()
    var area_chart = Morris.Area({
        element: area_chart_pane,
        data: graph_data,
        xkey: "y",
        ykeys: graph_keys,
        labels: graph_labels,
        lineColors: graph_colors,
        resize: true,
        xLabelFormat: function (x) {
            let shit = new Date(x);
            let date = x.getDate();
            let monthy = months[x.getMonth()];
            let hours = x.getHours();
            let minutes = x.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
            var douche = strTime;
            return douche;
        },
        dateFormat: function (x) {
            let shit = new Date(x);
            let date = shit.getDate();
            let monthy = months[shit.getMonth()];
            let hours = shit.getHours();
            let minutes = shit.getMinutes();
            var ampm = hours >= 12 ? 'pm' : 'am';
            hours = hours % 12;
            hours = hours ? hours : 12; // the hour '0' should be '12'
            minutes = minutes < 10 ? '0' + minutes : minutes;
            var strTime = date + ' ' + monthy + ' ' + hours + ':' + minutes + ' ' + ampm;
            var douche = strTime;
            return douche;
        },
        smooth: true,
        redraw: true
    });
    $('#' + area_chart_pane).parent().attr('style', 'width: 100% !important;');
}
const drawLongArea = (area_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    $('#' + area_chart_pane).parent().show()
    var area_chart = Morris.Area({
        element: area_chart_pane,
        data: graph_data,
        xkey: "y",
        ykeys: graph_keys,
        labels: graph_labels,
        lineColors: graph_colors,
        xLabelFormat: function (x) {
            return x.getDate() + ' ' + months[x.getMonth()] + ' ' + x.getFullYear();
        },
        dateFormat: function (x) {
            let d = new Date(x);
            var douche = d.getDate() + ' ' + months[d.getMonth()] + ' ' + d.getFullYear();
            return douche;
        },
        resize: true,
        smooth: true,
        pointSize: 0,
        redraw: true
    });
    $('#' + area_chart_pane).parent().attr('style', 'width: 100% !important;');
}

const drawBar = (bar_chart_pane, graph_data, graph_keys, graph_labels, graph_colors) => {
    Morris.Bar({
        element: bar_chart_pane,
        axes: true,
        data: graph_data,
        xkey: "y",
        ykeys: graph_keys,
        labels: graph_labels,
        barColors: graph_colors
    });
}

const drawPie = (pie_chart_pane, graph_data, graph_colors) => {
    var donut_chart_demo = $("#" + pie_chart_pane);
    donut_chart_demo.parent().show();
    var donut_chart = Morris.Donut({
        element: pie_chart_pane,
        data: graph_data,
        colors: graph_colors
    });
    donut_chart_demo.parent().attr('style', 'width: 100% !important;');
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}