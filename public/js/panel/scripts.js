window.jssor_1_slider_init = function () {
    var jssor_1_SlideshowTransitions = [
        { $Duration: 800, x: 0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: -0.3, $SlideOut: true, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: -0.3, $During: { $Left: [0.3, 0.7] }, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: 0.3, $SlideOut: true, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: 0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: -0.3, $SlideOut: true, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: -0.3, $During: { $Top: [0.3, 0.7] }, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: 0.3, $SlideOut: true, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: 0.3, $Cols: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Column: 3 }, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: 0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 3 }, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: 0.3, $Rows: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Row: 12 }, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: 0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 12 }, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: 0.3, $Cols: 2, $During: { $Top: [0.3, 0.7] }, $ChessMode: { $Column: 12 }, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, y: -0.3, $Cols: 2, $SlideOut: true, $ChessMode: { $Column: 12 }, $Easing: { $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: 0.3, $Rows: 2, $During: { $Left: [0.3, 0.7] }, $ChessMode: { $Row: 3 }, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, x: -0.3, $Rows: 2, $SlideOut: true, $ChessMode: { $Row: 3 }, $Easing: { $Left: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        {
            $Duration: 800,
            x: 0.3,
            y: 0.3,
            $Cols: 2,
            $Rows: 2,
            $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] },
            $ChessMode: { $Column: 3, $Row: 12 },
            $Easing: { $Left: $Jease$.$InCubic, $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear },
            $Opacity: 2,
        },
        {
            $Duration: 800,
            x: 0.3,
            y: 0.3,
            $Cols: 2,
            $Rows: 2,
            $During: { $Left: [0.3, 0.7], $Top: [0.3, 0.7] },
            $SlideOut: true,
            $ChessMode: { $Column: 3, $Row: 12 },
            $Easing: { $Left: $Jease$.$InCubic, $Top: $Jease$.$InCubic, $Opacity: $Jease$.$Linear },
            $Opacity: 2,
        },
        { $Duration: 800, $Delay: 20, $Clip: 3, $Assembly: 260, $Easing: { $Clip: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, $Delay: 20, $Clip: 3, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $Jease$.$OutCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, $Delay: 20, $Clip: 12, $Assembly: 260, $Easing: { $Clip: $Jease$.$InCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
        { $Duration: 800, $Delay: 20, $Clip: 12, $SlideOut: true, $Assembly: 260, $Easing: { $Clip: $Jease$.$OutCubic, $Opacity: $Jease$.$Linear }, $Opacity: 2 },
    ];

    var jssor_1_options = {
        $AutoPlay: 1,
        $SlideshowOptions: {
            $Class: $JssorSlideshowRunner$,
            $Transitions: jssor_1_SlideshowTransitions,
            $TransitionsOrder: 1,
        },
        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$,
        },
        $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,
            $SpacingX: 5,
            $SpacingY: 5,
        },
    };

    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

    /*#region responsive code begin*/

    var MAX_WIDTH = 820;

    function ScaleSlider() {
        var containerElement = jssor_1_slider.$Elmt.parentNode;
        var containerWidth = containerElement.clientWidth;

        if (containerWidth) {
            var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);

            jssor_1_slider.$ScaleWidth(expectedWidth);
        } else {
            window.setTimeout(ScaleSlider, 30);
        }
    }

    ScaleSlider();

    $Jssor$.$AddEvent(window, "load", ScaleSlider);
    $Jssor$.$AddEvent(window, "resize", ScaleSlider);
    $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
    /*#endregion responsive code end*/
};
//jssor_1_slider_init();

$(document).on("ready", function () {
    $(".regular").slick({
        dots: false,
        infinite: true,
        arrows: true,
        prevArrow: '<button type="button" class="slick-prev"></button>',
        nextArrow: '<button type="button" class="slick-next"></button>',
        centerMode: false,
        slidesToShow: 4,
        slidesToScroll: 2,
        autoplay: true,
        autoplaySpeed: 4000,

        pauseOnHover: true,

        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 2,
                },
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    centerMode: false,
                },
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                },
            },
        ],
    });
});

var closebtns = document.getElementsByClassName("close2");
var i;

for (i = 0; i < closebtns.length; i++) {
    closebtns[i].addEventListener("click", function () {
        this.parentElement.style.display = "none";
    });
}

function myFunction() {
    var x = document.getElementById("myDIVI");
    if (x.style.display === "none") {
        x.style.display = "flex";
    } else {
        x.style.display = "none";
    }
}

var botController = (function () {})();

var uiController = (function () {})();

var controller = (function (botCntr, uiCntr) {
    var $chatCircle, $chatBox, $chatBoxClose, $chatBoxWelcome, $chatWraper, $submitBtn, $chatInput, $msg;

    /*toggle*/
    function hideCircle(evt) {
        evt.preventDefault();
        $chatCircle.hide("scale");
        $chatBox.show("scale");
        $chatBoxWelcome.show("scale");
    }

    function chatBoxCl(evt) {
        evt.preventDefault();
        $chatCircle.show("scale");
        $chatBox.hide("scale");
        $chatBoxWelcome.hide("scale");
        $chatWraper.hide("scale");
    }

    function chatOpenMessage(evt) {
        evt.preventDefault();
        $chatBoxWelcome.hide();
        $chatWraper.show();
    }

    //generate messages on submit click
    function submitMsg(evt) {
        evt.preventDefault();

        //1. get input message data
        msg = $chatSubmitBtn.val();

        //2.if there is no string button send shoudn't work
        if (msg.trim() == "") {
            return false;
        }
        //3. add message to bot controller
        callbot(msg);
        //4. display message to ui controller
        generate_message(msg, "self");
    }

    function chatSbmBtn(evt) {
        if (evt.keyCode === 13 || evt.which === 13) {
            console.log("btn pushed");
        }
    }
    /* var input = uiCntr.getInput();*/
    /* $chatSubmitBtn.on("click", hideCircle);*/

    function init() {
        $chatCircle = $("#chat-circle");
        $chatBox = $(".chat-box");
        $chatBoxClose = $(".chat-box-toggle");
        $chatBoxWelcome = $(".chat-box-welcome__header");
        $chatWraper = $("#chat-box__wraper");
        $chatInput = $("#chat-input__text");
        $submitBtn = $("#chat-submit");

        //1. call toggle
        $chatCircle.on("click", hideCircle);
        $chatBoxClose.on("click", chatBoxCl);
        $chatInput.on("click", chatOpenMessage);

        //2. call wait message from CRM-human

        $submitBtn.on("click", chatSbmBtn);
        $chatInput.on("keypress", chatSbmBtn);

        //6. get message from bot controller-back end
        //7. display bot message to ui controller
    }

    return {
        init: init,
    };
})(botController, uiController);

$(".chat-input__form").on("submit", function (e) {
    e.preventDefault();
    msg = $(".chat-input__text").val();

    $(".chat-logs").append(
        '<div id="cm-msg-0" class="chat-msg background-warning push-right bot"><div class="cm-msg-text">' + msg + '</div><span class="msg-avatar"><img class="chat-box-overlay_robot" src="imagenes/visitante-chat.png"></span></div>'
    );
    $(".chat-input__text").val("");
});

$(document).ready(controller.init);

let know = {
    hello: "hi",
    "how are you?": "good",
    ok: ":)",
};
function talk() {
    var user = document.getElementById("userBox").value;
    document.getElementById("userBox").value = "";
    document.getElementById("chatLog").innerHTML += user + "<br>";
    if (user in know) {
        document.getElementById("chatLog").innerHTML += know[user] + "<br>";
    } else {
        document.getElementById("chatLog").innerHTML += "I don't understand...<br>";
    }
}

$(document).ready(function () {
    $("#caja").popup({
        transition: "all 0.3s",
        closebutton: true,
    });
});

$(document).ready(function () {
    $("#caja_3").popup({
        transition: "all 0.3s",
        closebutton: true,
    });
});

$(document).ready(function () {
    $("#caja_4").popup({
        transition: "all 0.3s",
        closebutton: true,
    });
});

$(document).ready(function () {
    $("#caja_5").popup({
        transition: "all 0.3s",
        closebutton: true,
    });
});

$(document).ready(function () {
    $("#caja_6").popup({
        transition: "all 0.3s",
        closebutton: true,
    });
});

var acc = document.getElementsByClassName("accordion");

var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function () {
        this.classList.toggle("active");

        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}

function openCity(evt, cityName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(cityName).style.display = "block";
    evt.currentTarget.className += " active";
}

jQuery(document).ready(function () {
    var offset = 220;
    var duration = 500;
    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > offset) {
            jQuery(".back-to-top").fadeIn(duration);
        } else {
            jQuery(".back-to-top").fadeOut(duration);
        }
    });

    jQuery(".back-to-top").click(function (event) {
        event.preventDefault();
        jQuery("html, body").animate({ scrollTop: 0 }, duration);
        return false;
    });
});

$(document).ready(function () {
    $(".vid-slider .vid").on("click", function () {
        // get required DOM Elements
        var iframe_src = $(this).children("iframe").attr("src"),
            iframe = $(".video-popup"),
            iframe_video = $(".video-popup iframe"),
            close_btn = $(".close-video");
        iframe_src = iframe_src + "?autoplay=1&rel=0"; // for autoplaying the popup video

        // change the video source with the clicked one
        $(iframe_video).attr("src", iframe_src);
        $(iframe).fadeIn().addClass("show-video");

        // remove the video overlay when clicking outside the video
        $(document).on("click", function (e) {
            if ($(iframe).is(e.target) || $(close_btn).is(e.target)) {
                $(iframe).removeClass("show-video");
                $(iframe_video).attr("src", "");
            }
        });
    });
});

$(document).ready(function () {
    $(".slectOne").on("change", function () {
        $(".slectOne").not(this).prop("checked", false);
        $("#result").html($(this).data("id"));
        if ($(this).is(":checked")) $("#result").html($(this).data("id"));
        else $("#result").html("Empty...!");
    });
});

$(document).ready(function () {
    $("#txtbusca").keyup(function () {
        var parametros = "txtbusca=" + $(this).val();
        $.ajax({
            data: parametros,
            url: "salida_1.php",
            type: "post",
            beforeSend: function () {},
            success: function (response) {
                $(".salida").html(response);
            },
            error: function () {
                alert("error");
            },
        });
    });
});

/*!
 * Based on articles on
 * https://gomakethings.com
 */

var drawer = function () {
    /**
     * Element.closest() polyfill
     * https://developer.mozilla.org/en-US/docs/Web/API/Element/closest#Polyfill
     */
    if (!Element.prototype.closest) {
        if (!Element.prototype.matches) {
            Element.prototype.matches = Element.prototype.msMatchesSelector || Element.prototype.webkitMatchesSelector;
        }
        Element.prototype.closest = function (s) {
            var el = this;
            var ancestor = this;
            if (!document.documentElement.contains(el)) return null;
            do {
                if (ancestor.matches(s)) return ancestor;
                ancestor = ancestor.parentElement;
            } while (ancestor !== null);
            return null;
        };
    }

    //
    // Settings
    //
    var settings = {
        speedOpen: 50,
        speedClose: 350,
        activeClass: "is-active",
        visibleClass: "is-visible",
        selectorTarget: "[data-drawer-target]",
        selectorTrigger: "[data-drawer-trigger]",
        selectorClose: "[data-drawer-close]",
    };

    //
    // Methods
    //

    // Toggle accessibility
    var toggleAccessibility = function (event) {
        if (event.getAttribute("aria-expanded") === "true") {
            event.setAttribute("aria-expanded", false);
        } else {
            event.setAttribute("aria-expanded", true);
        }
    };

    // Open Drawer
    var openDrawer = function (trigger) {
        // Find target
        var target = document.getElementById(trigger.getAttribute("aria-controls"));

        // Make it active
        target.classList.add(settings.activeClass);

        // Make body overflow hidden so it's not scrollable
        document.documentElement.style.overflow = "hidden";

        // Toggle accessibility
        toggleAccessibility(trigger);

        // Make it visible
        setTimeout(function () {
            target.classList.add(settings.visibleClass);
        }, settings.speedOpen);
    };

    // Close Drawer
    var closeDrawer = function (event) {
        // Find target
        var closestParent = event.closest(settings.selectorTarget),
            childrenTrigger = document.querySelector('[aria-controls="' + closestParent.id + '"');

        // Make it not visible
        closestParent.classList.remove(settings.visibleClass);

        // Remove body overflow hidden
        document.documentElement.style.overflow = "";

        // Toggle accessibility
        toggleAccessibility(childrenTrigger);

        // Make it not active
        setTimeout(function () {
            closestParent.classList.remove(settings.activeClass);
        }, settings.speedClose);
    };

    // Click Handler
    var clickHandler = function (event) {
        // Find elements
        var toggle = event.target,
            open = toggle.closest(settings.selectorTrigger),
            close = toggle.closest(settings.selectorClose);

        // Open drawer when the open button is clicked
        if (open) {
            openDrawer(open);
        }

        // Close drawer when the close button (or overlay area) is clicked
        if (close) {
            closeDrawer(close);
        }

        // Prevent default link behavior
        if (open || close) {
            event.preventDefault();
        }
    };

    // Keydown Handler, handle Escape button
    var keydownHandler = function (event) {
        if (event.key === "Escape" || event.keyCode === 27) {
            // Find all possible drawers
            var drawers = document.querySelectorAll(settings.selectorTarget),
                i;

            // Find active drawers and close them when escape is clicked
            for (i = 0; i < drawers.length; ++i) {
                if (drawers[i].classList.contains(settings.activeClass)) {
                    closeDrawer(drawers[i]);
                }
            }
        }
    };

    //
    // Inits & Event Listeners
    //
    document.addEventListener("click", clickHandler, false);
    document.addEventListener("keydown", keydownHandler, false);
};

drawer();

$(document).ready(function () {
    $("#ingresar").popup({
        transition: "all 0.3s",
        closebutton: true,
    });
});

function smooth() {
    if ($("#show").is(":visible")) {
        $("#show").hide("1000");
    } else {
        $("#show").show("1000");
    }
}