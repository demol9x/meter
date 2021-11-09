// các function dùng cho toàn site
AOS.init();

// check elm in page
function isInPage(_elm) {
    return ($(_elm).length > 0) ? true : false;
}

// check elm in viewport
function isInViewport(_select) {
    var el = document.querySelector(_select);
    if (isInPage(_select)) {
        var top = el.offsetTop;
        var left = el.offsetLeft;
        var width = el.offsetWidth;
        var height = el.offsetHeight;

        while (el.offsetParent) {
            el = el.offsetParent;
            top += el.offsetTop;
            left += el.offsetLeft;
        }

        return (
            top < (window.pageYOffset + window.innerHeight) &&
            left < (window.pageXOffset + window.innerWidth) &&
            (top + height) > window.pageYOffset &&
            (left + width) > window.pageXOffset
        );
    }
    return false;
}