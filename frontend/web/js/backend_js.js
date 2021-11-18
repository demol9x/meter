$('.sapxep ').on('change', function () {
    var url = $(this).val(); // get selected value
    console.log(url);
    if (url) { // require a URL
        window.location = url; // redirect
    }
    return false;
});

function removeParam(key, sourceURL) {
    var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
    if (queryString !== "") {
        params_arr = queryString.split("&");
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + "?" + params_arr.join("&");
    }
    return rtn;
}
function insertParam(key, value)
{
    key = encodeURI(key);
    value = encodeURI(value);
    var kvp = document.location.search.substr(1).split('&');
    var i = kvp.length;
    var x;
    while (i--) {
        x = kvp[i].split('=');
        if (x[0] == key) {
            x[1] = value;
            kvp[i] = x.join('=');
            break;
        }
    }
    if (i < 0) {
        kvp[kvp.length] = [key, value].join('=');
    }
    document.location.search = kvp.join('&');
}
$('.p_provin').click(function () {
    var param = $(this).data('param');
    var manuId = [];

    $('.p_provin').each(function () {
        if ($(this).find('input').is(':checked')) {
            manuId.push($(this).find('input').val());
        }
    });
    if (manuId.length >= 1) {
        insertParam(param, manuId.join());
    } else {
        var url = location.href;
        url = removeParam(param, url);
        location.href = url;
    }
});
$('.lv_contact_de').click(function () {
    var param = $(this).data('param');
    var manuId = [];

    $('.lv_contact_de').each(function () {
        if ($(this).find('input').is(':checked')) {
            manuId.push($(this).find('input').val());
        }
    });
    if (manuId.length >= 1) {
        insertParam(param, manuId.join());
    } else {
        var url = location.href;
        url = removeParam(param, url);
        location.href = url;
    }
});
$('.lv_contact_sc').click(function () {
    var param = $(this).data('param');
    var manuId = [];

    $('.lv_contact_sc').each(function () {
        if ($(this).find('input').is(':checked')) {
            manuId.push($(this).find('input').val());
        }
    });
    if (manuId.length >= 1) {
        insertParam(param, manuId.join());
    } else {
        var url = location.href;
        url = removeParam(param, url);
        location.href = url;
    }
});
$('.flash-ok').click(function () {
    $('.set-flash').addClass('active');
});