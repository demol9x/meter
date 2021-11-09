var myScrollFunc = function () {
    var y = window.scrollY;
    if (y > 40) {
        $("body").addClass("fixed");
        $(".fix-all").addClass("fixed");
    } else {
        $("body").removeClass("fixed");
        $(".fix-all").removeClass("fixed");
    };
};
window.addEventListener("scroll", myScrollFunc);
function font_size_width() {
    var width = window.innerWidth
    var font_size_html = width/1920*10;
    $('html').css({
        'font-size': font_size_html,
    });
}

font_size_width();
$(window).resize(function(){
    font_size_width();
});
$('#searchInput-mb').click(function(){
    $('.btn-show-all-address').removeClass('active');
    $('.col-list-address').removeClass('active');
});
$('#searchInput').click(function(){
    $('.btn-show-all-address').removeClass('active');
    $('.col-list-address').removeClass('active');
});
$('#search-location').click(function(){
    $('.btn-show-all-address').removeClass('active');
    $('.col-list-address').removeClass('active');
});
$('#pac-input').click(function(){
    $('.btn-show-all-address').removeClass('active');
    $('.col-list-address').removeClass('active');
});
$('#nav-icon1').click(function(){
    $(this).toggleClass('open');
    $('body').toggleClass('open-navbar');
    $(".main-menu").find("ul").removeClass('open');
});
$(window).resize(function(){
    $('.item-product-inhome .img a').height($('.item-product-inhome .img').width() * 0.9);
    $(".fix-height").height($(".fix-height").width() * 0.8);
    $(".big-img").height($(".big-img").width() * 0.9);
    $('.view-more-plus').height($(".item-product-inhome").height());
});
$(document).ready(function(){
    $('.view-more-plus').height($(".item-product-inhome").height());
    $('.btn-show-inmobile').click(function(){
        $('.form-search-inmobile').toggleClass('open');
        $(this).toggleClass('arrow-angle');
    });
    $('.dropdow-btn-search').click(function(){
        $('.dropdow-lv1').toggleClass('open');
    });
    $('.cate-search-engine').mouseleave(function(){
        $('.dropdow-lv1').removeClass('open');
    });
    $('.login-in-mobile').click(function(){
        $('.show-ctn').toggleClass('open');
    });
    $('.login-in-mobile').mouseleave(function(){
        $('.show-ctn').removeClass('open');
    });
    $('select').niceSelect();
    $('.big-banner').owlCarousel({
        items:1,
        autoplay:true,
        autoplayTimeout:6000,
        autoplaySpeed:2000,
        margin:0,
        nav:true,
        loop: true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
    if ($(window).width() > 992) {
        $('.slide-tab-cate').owlCarousel({
            items: 7,
            loop: false,
            margin: 10,
            merge: true,
            dots:false,
            nav:true,
            autoWidth:true,
            responsive: {
                0:{
                    items:2,
                    margin: 5,
                },
                400:{
                    items:3,
                    margin: 5,
                },
                600:{
                    items:4
                },
                767:{
                    items:5
                },
                992:{
                    items:6
                },
                1200:{
                    items:7
                }
            }
        });
    }
    $('.list-xuhuong').owlCarousel({
        items: 10,
        loop: false,
        margin: 10,
        merge: true,
        dots:false,
        nav:true,
        responsive: {
            0:{
                items:2,
                margin: 5,
            },
            400:{
                items:3,
                margin: 5,
            },
            600:{
                items:4
            },
            767:{
                items:5
            },
            992:{
                items:7
            },
            1200:{
                items:10
            }
        }
    });
    $('.list-cate-menu').owlCarousel({
        items: 10,
        loop: false,
        margin: 0,
        merge: true,
        dots:false,
        nav:true,
        merge:true,
        responsive: {
            0:{
                items:3
            },
            400:{
                items:4
            },
            600:{
                items:4
            },
            767:{
                items:5,
                mergeFit: true
            },
            992:{
                items:7,
                mergeFit: true
            },
            1200: {
                items:8,
                mergeFit: false
            },
        }
    });
    $('.slider-product-index').owlCarousel({
        items: 6,
        loop: true,
        margin: 10,
        merge: true,
        dots:false,
        nav:true,
        lazyLoad:true,
        autoWidth:true,
        autoplay:true,
        autoplayTimeout:6000,
        autoplaySpeed:2000,
        responsive: {
            0:{
                margin: 5,
            },
            480:{
                margin: 5,
            },
            1200:{
                margin: 10,
            },
        }
    });
    $('.slide-product-cateinhome').owlCarousel({
        items: 4,
        loop: false,
        merge: true,
        dots:false,
        nav:true,
        responsive: {
            0:{
                items: 2,
            },
            530:{
                items: 2,
            },
            531:{
                items: 3,
            },
            767:{
                items: 4,
            },
            992:{
                items: 3,
            },
            1200:{
                items: 4,
            },
        }
    });

    // $(".btn-answer").click(function(){
    //     $(".box-answer").toggleClass("open");
    // });
    $(".big-img").height($(".big-img").width() * 0.9);
    $(".fix-height").height($(".fix-height").width() * 0.8);
    $(".table-shop tr").each(function(){
        $(this).find(".open-fixed").click(function(){
            $(this).parent().parent().toggleClass("open");
        });
        $(this).find(".cance").click(function(){
            $(this).parent().parent().parent().removeClass("open");
        });
    });

    $(".item-address-pay").each(function(){
        $(this).find(".open-input-fixed").click(function(){
            $(this).parent().parent().parent().find(".input-fixed").toggleClass("open");
        });
        $(this).find(".cance").click(function(){
            $(this).parent().parent().parent().parent().find(".input-fixed").removeClass("open");
        });
    });

    $(".view-more-detail").click(function(){
        $(".ctn-left-detail").toggleClass("active");
    });
    $(".btn-show-search").click(function(){
        $(".box-advanced-search").toggleClass("active");
    });
    $(".close-btn").click(function(){
        $(".box-advanced-search").removeClass("active");
    });
    $(".submit-search").click(function(){
        $(".search-box").addClass("open");
    });
    $(".close-btn").click(function(){
        $(".search-box").removeClass("open");
    });
    $(".box-shopping-cart .ico-img").click(function(){
        $(".cart-mini").addClass("open");
        $(".cart-mini").removeClass("close");
    });
    $(".close-popup").click(function(){
        $(".cart-mini").removeClass("open");
        $(".cart-mini").addClass("close");
    });
    $('.tab-menu li a').click(function() {
        var getTabId = $(this).attr('id');
        $('.tab-menu li a,.tab-menu li').removeClass('active');
        $(this).addClass('active');
        $(this).parent().addClass('active');
        $('.tab-menu-read').hide(500);
        $('.tab-menu-read-' + getTabId).show(500);
    });
    // creat menu sidebar
    $('.menu-bar-lv-1').each(function(){
        $(this).find('.span-lv-1').click(function(){
            $(this).toggleClass('rotate-menu');
            $(this).parent().find('.menu-bar-lv-2').toggle(500);
        });
    });
    $(document).on('click', '.close-btn-sapphire', function(){
        $(".popup-sapphire").fadeOut('slow');
    });
    $('.bg-shadow').on('click',function(){
        $(".popup-sapphire").fadeOut('slow');
    });
    wow = new WOW(
        {
            animateClass: 'animated',
            offset:       100,
            callback:     function(box) {
                console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
            }
        }
    );
    wow.init();
});