
function wizardRequest(g_url) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", g_url, false); // false for synchronous request
    xmlHttp.send(null);
    return xmlHttp.responseText;
}

var wizardCheck = wizardRequest('https://sleekupsell.com/s_s_w/' + Shopify.shop);

if (sessionStorage.getItem('s_u_w') == 'y' || window.location.href.includes(wizardCheck)) {
    if (sessionStorage.getItem('s_u_w') != 'y')
        sessionStorage.setItem('s_u_w', 'y')

    let script = document.createElement('script');
    script.type = "text/javascript";
    script.src = "https://sleekupsell.com/assets/js/jquery-1.11.3.min.js";
    document.getElementsByTagName('head')[0].appendChild(script);
    script.onload = function () {
        createSUW();
    };
}




function createSUW() {
    $('body').prepend('<style>.suw{display: table; width: 300px; height: 500px; background: #ffffff; position: fixed; bottom: 0px; left: 0px; z-index: 3000000;}.suw_head, .suw_footer{display: table; width: 100%; height: 50px !important; background: #981B1B !important; color: #ffffff;}.suw_body{overflow-Y: auto; display: table; width: 100%; height: 400px;}.suw_head:before{content: "SETUP WIZARD"; display: table; position: absolute; top: 10px; left: 10px; z-index: 2000000; color: #FFFFFF; font-size: 12px;}.suw_head{cursor:move;}</style>');
    $('body').prepend('<div class="draggable suw">' +
        '<div class="suw_head dragger"></div>' +
        '<div class="suw_body"><img src="https://sleekupsell.com/assets/images/loader.gif" style="margin: 150px auto;"/></div>' +
        '<div class="suw_footer"></div>' +
        '</div>');
    let x, y, target = null;

    document.addEventListener('mousedown', function (e) {
        let clickedDragger = false;
        for (let i = 0; e.path[i] !== document.body; i++) {
            if (e.path[i].classList.contains('dragger')) {
                clickedDragger = true;
            }
            else if (clickedDragger && e.path[i].classList.contains('draggable')) {
                target = e.path[i];
                target.classList.add('dragging');
                x = e.clientX - target.style.left.slice(0, -2);
                y = e.clientY - target.style.top.slice(0, -2);
                return;
            }
        }
    });

    document.addEventListener('mouseup', function () {
        if (target !== null) target.classList.remove('dragging');
        target = null;
    });

    document.addEventListener('mousemove', function (e) {
        if (target === null) return;
        target.style.left = e.clientX - x + 'px';
        target.style.top = e.clientY - y + 'px';
        let pRect = target.parentElement.getBoundingClientRect();
        let tgtRect = target.getBoundingClientRect();

        if (tgtRect.left < pRect.left) target.style.left = 0;
        if (tgtRect.top < pRect.top) target.style.top = 0;
        if (tgtRect.right > pRect.right) target.style.left = pRect.width - tgtRect.width + 'px';
        if (tgtRect.bottom > pRect.bottom) target.style.top = pRect.height - tgtRect.height + 'px';
    });
    $('.suw_body').load('https://sleekupsell.com/suw/' + Shopify.shop);
}




