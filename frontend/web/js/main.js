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
$(document).ready(function () {
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

// tab đăng ký

jQuery(document).ready(function ($) {
  $(".nav-tab").pwstabs({
    effect: "slidedown",
    defaultTab: 1,
    containerWidth: "100%",
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

    $('.slide_detail_in').slick({
      cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
      slidesToShow: 6,
      speed: 1000,
      slidesToScroll: 1,
      dots: false,
      arrows: false,
      focusOnSelect: true,
      infinite: true,
      asNavFor: '.slide_detail_on',
      responsive: [{
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
        }
      }]
    });
    $('.slide_pro_active').slick({
      cssEase: 'cubic-bezier(0.77, 0, 0.18, 1)',
      slidesToShow: 5,
      speed: 1000,
      slidesToScroll: 1,
      dots: false,
      arrows: true,
      infinite: true,
      variableWidth: true,
      responsive: [{
        breakpoint: 1199,
        settings: {
          slidesToShow: 6,
          slidesToScroll: 1,
        }
      }, {
        breakpoint: 460,
        settings: {
          slidesToShow: 4,
          slidesToScroll: 1,
        }
      }, {
        breakpoint: 300,
        settings: {
          slidesToShow: 3,
          slidesToScroll: 1,
        }
      }, {
        breakpoint: 200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
        }
      }]
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

  $("#scroll_load_1").click(function () {
    $('html, body').animate({
      scrollTop: $("#pro_desc_list").offset().top
    }, 1500);
  });
  $("#scroll_load_2").click(function () {
    $('html, body').animate({
      scrollTop: $("#pro_desc_list_1").offset().top
    }, 1500);
  });
  $("#scroll_load_3").click(function () {
    $('html, body').animate({
      scrollTop: $("#pro_desc_list_2").offset().top
    }, 1500);
  });
  $('.button_position').click(function () {
    $('.pro_description').addClass('active');
    $('.pro_description_2').addClass('active');
    $('.button_position').addClass('active');
    $('.button_position_view').removeClass('active');
  });
  $('.button_position_view').click(function () {
    $('.pro_description').removeClass('active');
    $('.button_position').removeClass('active');
    $('.button_position_view').addClass('active');
  });
  $('.add_tim').click(function () {
    $('.add_tim_1').addClass('active');
    $('.add_tim').removeClass('active');
  });
  $('.add_tim_1').click(function () {
    $('.add_tim').addClass('active');
    $('.add_tim_1').removeClass('active');
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
});

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
$(function () {
  var elem = $(".content-tab");

  elem.eq(0).addClass("z-index");

  contentl = elem.length;

  $("nav label").click(function () {
    var index = $(this).index();
    var d = index * (360 / contentl);

    $("nav label").removeClass("active");
    $(this).addClass("active");


    elem.removeClass("z-index");
    elem.eq(index).addClass("z-index");

  });
});

$('.continue').click(function () {
  $('.van-tabs > .active').next('blockquote').find('a').trigger('click');
});
$('.back').click(function () {
  $('.van-tabs > .active').prev('blockquote').find('a').trigger('click');
});


$(document).ready(function () {
  class InteractiveChatbox {
    constructor(a, b, c) {
      this.args = {
        button: a,
        chatbox: b
      }
      this.icons = c;
      this.state = false;
    }

    display() {
      const {
        button,
        chatbox
      } = this.args;

      button.addEventListener('click', () => this.toggleState(chatbox))
    }

    toggleState(chatbox) {
      this.state = !this.state;
      this.showOrHideChatBox(chatbox, this.args.button);
    }

    showOrHideChatBox(chatbox, button) {
      if (this.state) {
        chatbox.classList.add('chatbox--active')
        this.toggleIcon(true, button);
      } else if (!this.state) {
        chatbox.classList.remove('chatbox--active')
        this.toggleIcon(false, button);
      }
    }

    toggleIcon(state, button) {
      const {
        isClicked,
        isNotClicked
      } = this.icons;
      let b = button.children[0].innerHTML;

      if (state) {
        button.children[0].innerHTML = isClicked;
      } else if (!state) {
        button.children[0].innerHTML = isNotClicked;
      }
    }
  }


  const chatButton = document.querySelector('.chatbox__button');
  const chatContent = document.querySelector('.chatbox__support');
  const icons = {
    isClicked: '<img src="./images/icons/chatbox-icon.svg" />',
    isNotClicked: '<img src="./images/icons/chatbox-icon.svg" />'
  }
  const chatbox = new InteractiveChatbox(chatButton, chatContent, icons);
  chatbox.display();
  chatbox.toggleIcon(false, chatButton);
});