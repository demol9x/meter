$(".icon_menu").click(function () {
  $(".icon_menu").toggleClass("active");
  $(".menu").toggleClass("active");
});
$(".search_icon").click(function () {
  $(".toggle_search").toggleClass("active");
});
$(document).ready(function () {
  $(function () {
    new WOW().init();
  });
});
$(".slide_home").slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  autoplay: true,
  dots: true,
  arrows: false,
  infinite: true,
  speed: 900,
  fade: false,
  responsive: [
    {
      breakpoint: 768,
      settings: {
        dots: false,
        arrows: false,
      },
    },
  ],
});

$(document).ready(function () {
  $(window).scroll(function (event) {
    var pos_body = $("html,body").scrollTop();
    if (pos_body > 300) {
      $(".backtotop").addClass("show");
    } else {
      $(".backtotop").removeClass("show");
    }
  });
  $(".backtotop").click(function () {
    $("html, body").animate({ scrollTop: 0 }, 1600);
    return false;
  });
});

// slide tin tuc mobile
$(window).ready(function () {
  var width = $(window).width();
  if (width <= 1200) {
    $(".slide-tin").slick({
      cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
      slidesToShow: 3,
      speed: 1000,
      autoplay: true,
      slidesToScroll: 3,
      dots: false,
      arrows: false,
      infinite: true,
      adaptiveWight:true,
      // centerMode: false,

      // rtl: false,
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 460,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
      ],
    });
  } else {
    // location.reload();
  }
});

// tab đăng ký

jQuery(document).ready(function ($) {
  $(".nav-tab").pwstabs({
    effect: "slidedown",
    defaultTab: 1,
    containerWidth: "100%",
  });
});
$(document).ready(function () {
  $(".slide_detail_on").slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: false,
    adaptiveHeight: true,
    infinite: true,
    useTransform: true,
    speed: 1000,
    cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
    asNavFor: ".slide_detail_in",
    fade: true,
    cssEase: "linear",
  });

  $(document).ready(function () {
    $(".slide_detail_on").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      autoplay: true,
      dots: false,
      adaptiveHeight: true,
      infinite: true,
      useTransform: true,
      speed: 1000,
      cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
      asNavFor: ".slide_detail_in",
      fade: true,
      cssEase: "linear",
    });
  });

  $(".item-list-sp").slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: false,
    adaptiveHeight: true,
    infinite: true,
    useTransform: true,
    speed: 1000,

    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 1000,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 767,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
    ],
  });

  $(".item-list-hot-deal").slick({
    slidesToShow: 8,
    slidesToScroll: 1,
    arrows: false,
    autoplay: true,
    dots: false,
    adaptiveHeight: true,
    infinite: true,
    useTransform: true,
    speed: 1000,
    vertical: true,
    focusOnSelect: true,

    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 4,
          vertical: false,
          focusOnSelect: false,
        },
      },
      {
        breakpoint: 1000,
        settings: {
          slidesToShow: 3,
          vertical: false,
          focusOnSelect: false,
        },
      },
      {
        breakpoint: 550,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          vertical: false,
          focusOnSelect: false,
        },
      },
    ],
  });

  $(".slide_detail_in").slick({
    cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
    slidesToShow: 6,
    speed: 1000,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    focusOnSelect: true,
    infinite: true,
    asNavFor: ".slide_detail_on",
    responsive: [
      {
        breakpoint: 1199,
        settings: {
          slidesToShow: 6,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 460,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 300,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
    ],
  });
  $(".slide_pro_active").slick({
    cssEase: "cubic-bezier(0.77, 0, 0.18, 1)",
    slidesToShow: 5,
    speed: 1000,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    infinite: true,
    variableWidth: true,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 6,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 460,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 300,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        },
      },
    ],
  });
});
// tab tin tức

$(document).ready(function () {
  $('[data-fancybox="gallery"]').fancybox({
    buttons: ["slideShow", "thumbs", "zoom", "fullScreen", "share", "close"],
    loop: false,
    protect: true,
  });
});

// $(document).ready(function () {
//   // Get the modal
//   var modal = document.getElementById("kiemtradonhang");
//
//   // Get the button that opens the modal
//   var btn = document.getElementById("btn_kiemtradonhang");
//
//   // Get the <span> element that closes the modal
//   var span = document.getElementsByClassName("close")[0];
//
//   // When the user clicks the button, open the modal
//   btn.onclick = function () {
//     modal.style.display = "block";
//   };
//
//   // When the user clicks on <span> (x), close the modal
//   span.onclick = function () {
//     modal.style.display = "none";
//   };
//
//   // When the user clicks anywhere outside of the modal, close it
//   window.onclick = function (event) {
//     if (event.target == modal) {
//       modal.style.display = "none";
//     }
//   };
// });
$('.menu-bar-lv-1').each(function () {
  $(this).find('.span-lv-1').click(function () {
    $(this).toggleClass('rotate-menu');
    $(this).parent().find('.menu-bar-lv-2').toggle(500);
  });
});


$(document).ready(function() {
  $('.fix-img-bg') .click(function () {
    $('#avatar_form_avatar1').find('input').first().click();
  });
  $('.fix-img-avatar').click(function () {
    $('#avatar_form_avatar2').find('input').first().click();
  });
});



$("#scroll_load_1").click(function () {
  $("html, body").animate(
      {
        scrollTop: $("#pro_desc_list").offset().top,
      },
      1500
  );
});
$("#scroll_load_2").click(function () {
  $("html, body").animate(
      {
        scrollTop: $("#pro_desc_list_1").offset().top,
      },
      1500
  );
});
$("#scroll_load_3").click(function () {
  $("html, body").animate(
      {
        scrollTop: $("#pro_desc_list_2").offset().top,
      },
      1500
  );
});
$(".button_position").click(function () {
  $(".pro_description").addClass("active");
  $(".pro_description_2").addClass("active");
  $(".button_position").addClass("active");
  $(".button_position_view").removeClass("active");
});
$(".button_position_view").click(function () {
  $(".pro_description").removeClass("active");
  $(".button_position").removeClass("active");
  $(".button_position_view").addClass("active");
});

$(document).ready(function () {
  // if ($(window).width() < 1200) {
  //     var table = $('table');
  //     $('table').parent().css('overflow-y', 'auto');
  // }
  $(".video-youtube").each(function () {
    $(this).height($(this).width() * 0.564);
  });
  $(".card_img").each(function () {
    $(this).height(
        $(this).closest(".pro_img").find(".pro_card").first().width()
    );
  });
});

$(".detail_button").click(function () {
  $("#popup_goithau").addClass("active");
});
$("#popup_close_goithau").click(function () {
  $("#popup_goithau").removeClass("active");
});

// $( document ).ready(function() {
//   // Get the modal
//   var modal = document.getElementById("kiemtradonhang");
//
//   // Get the button that opens the modal
//   var btn = document.getElementById("btn_kiemtradonhang");
//
//   // Get the <span> element that closes the modal
//   var span = document.getElementsByClassName("close")[0];
//
//   // When the user clicks the button, open the modal
//   btn.onclick = function () {
//     modal.style.display = "block";
//   };
//   // When the user clicks on <span> (x), close the modal
//   span.onclick = function () {
//     modal.style.display = "none";
//   };
//
//   // When the user clicks anywhere outside of the modal, close it
//   window.onclick = function (event) {
//     if (event.target == modal) {
//       modal.style.display = "none";
//     }
//   }
// });



// popup gioithieu

const showModal = (openButton, modalContent) => {
  const openBtn = document.getElementById(openButton),
      modalContainer = document.getElementById(modalContent);

  if (openBtn && modalContainer) {
    openBtn.addEventListener("click", () => {
      modalContainer.classList.add("show-modal");
    });
  }
};
showModal("open-modal", "modal-container");

/*=============== CLOSE MODAL ===============*/
const closeBtn = document.querySelectorAll(".close-modal");

function closeModal() {
  const modalContainer = document.getElementById("modal-container");
  modalContainer.classList.remove("show-modal");
}
closeBtn.forEach((c) => c.addEventListener("click", closeModal));

/*=============== tab tintuc ===============*/
$(document).ready(function () {
  $(function () {
    var w = $(window).width();
    var h = $(window).height();

    var duration = 2000,
        el = $(".content"),
        elem = $(".content");

    elem.eq(0).addClass("z-index");

    contentl = elem.length;

    $(".van-tabs blockquote").click(function () {
      var index = $(this).index();
      var d = index * (360 / contentl);

      $(".van-tabs blockquote").removeClass("active");
      $(this).addClass("active");

      elem.removeClass("z-index");
      elem.eq(index).addClass("z-index");

    })

  });
});

$(document).ready(function () {
  $(function () {
    var w = $(window).width();
    var h = $(window).height();

    var duration = 2000,
        el = $(".content-tab"),
        elem = $(".content-tab");

    elem.eq(0).addClass("z-index");

    contentl = elem.length;

    $(".van-tabs label").click(function () {
      var index = $(this).index();
      var d = index * (360 / contentl);

      $(".van-tabs label").removeClass("active");
      $(this).addClass("active");

      elem.removeClass("z-index");
      elem.eq(index).addClass("z-index");

    })

  });

  $(".table-shop tr").each(function () {
    $(this).find(".open-fixed").click(function () {
      $(this).parent().parent().toggleClass("open");
    });
    $(this).find(".cance").click(function () {
      $(this).parent().parent().parent().removeClass("open");
    });
  });
});


$(document).ready(function () {
  $(function () {
    var w = $(window).width();
    var h = $(window).height();

    var duration = 2000,
        el = $(".pro_flex_left"),
        elem = $(".pro_flex_left");

    elem.eq(0).addClass("z-index");

    contentl = elem.length;

    $(".nav_menu blockquote").click(function () {
      var index = $(this).index();
      var d = index * (360 / contentl);

      $(".nav_menu blockquote").removeClass("active");
      $(this).addClass("active");

      elem.removeClass("z-index");
      elem.eq(index).addClass("z-index");

    })
  });

  $('.continue').click(function () {
    $('.nav_menu > .active').next('blockquote').find('a').trigger('click');
  });
  $('.back').click(function () {
    $('.nav_menu > .active').prev('blockquote').find('a').trigger('click');
  });

});

$(document).ready(function () {
  var wrapper = document.getElementById("wrapper");

  document.addEventListener("click", function (event) {
    if (!event.target.matches(".grid")) return;

    // List view
    event.preventDefault();
    wrapper.classList.add("grid");
  });

  document.addEventListener("click", function (event) {
    if (!event.target.matches(".list")) return;
    // List view
    event.preventDefault();
    wrapper.classList.remove("grid");
  });



  $(function () {
    $(".buttons div").click(function () {
      var index = $(this).index();

      $(".buttons div").removeClass("active");
      $(this).addClass("active");
    })
  });

});


$(document).ready(function () {
  var width = $(window).width();
  if (width <= 769) {
    $('.icon_slide').addClass('arcontactus-slide');
    $('.arcontactus-slide').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      autoplay: true,
      dots: false,
      arrows: false,
      infinite: true,
      speed: 700,
    });
  }
  $(window).resize(function () {
    console.log(width)
  });
});


$(function () {
  var INDEX = 0;
  $("#chat-submit").click(function (e) {
    e.preventDefault();
    var msg = $("#chat-input").val();
    if (msg.trim() == '') {
      return false;
    }
    generate_message(msg, 'self');
    var buttons = [{
      name: 'Existing User',
      value: 'existing'
    },
      {
        name: 'New User',
        value: 'new'
      }
    ];
    setTimeout(function () {
      generate_message(msg, 'user');
    }, 1000)

  })

  function generate_message(msg, type) {
    INDEX++;
    var str = "";
    str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg " + type + "\">";
    str += "          <span class=\"msg-avatar\">";
    str += "            <img src='asset/img/img_detail.png' alt=''>";
    str += "          <\/span>";
    str += "          <div class=\"cm-msg-text\">";
    str += msg;
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-" + INDEX).hide().fadeIn(300);
    if (type == 'self') {
      $("#chat-input").val('');
    }
    $(".chat-logs").stop().animate({
      scrollTop: $(".chat-logs")[0].scrollHeight
    }, 1000);
  }

  function generate_button_message(msg, buttons) {
    /* Buttons should be object array
      [
        {
          name: 'Existing User',
          value: 'existing'
        },
        {
          name: 'New User',
          value: 'new'
        }
      ]
    */
    INDEX++;
    var btn_obj = buttons.map(function (button) {
      return "              <li class=\"button\"><a href=\"javascript:;\" class=\"btn btn-primary chat-btn\" chat-value=\"" + button.value + "\">" + button.name + "<\/a><\/li>";
    }).join('');
    var str = "";
    str += "<div id='cm-msg-" + INDEX + "' class=\"chat-msg user\">";
    str += "          <span class=\"msg-avatar\">";
    str += "            <img src=\"https:\/\/image.crisp.im\/avatar\/operator\/196af8cc-f6ad-4ef7-afd1-c45d5231387c\/240\/?1483361727745\">";
    str += "          <\/span>";
    str += "          <div class=\"cm-msg-text\">";
    str += msg;
    str += "          <\/div>";
    str += "          <div class=\"cm-msg-button\">";
    str += "            <ul>";
    str += btn_obj;
    str += "            <\/ul>";
    str += "          <\/div>";
    str += "        <\/div>";
    $(".chat-logs").append(str);
    $("#cm-msg-" + INDEX).hide().fadeIn(300);
    $(".chat-logs").stop().animate({
      scrollTop: $(".chat-logs")[0].scrollHeight
    }, 1000);
    $("#chat-input").attr("disabled", true);
  }

  $(document).delegate(".chat-btn", "click", function () {
    var value = $(this).attr("chat-value");
    var name = $(this).html();
    $("#chat-input").attr("disabled", false);
    generate_message(name, 'self');
  })

  $("#chat-circle").click(function () {
    $(".chat-box").toggle('scale');
  })

  $(".chat-box-toggle").click(function () {
    $(".chat-box").toggle('scale');
  })

})