/**
 * Created by xutongle on 2017/7/11.
 */
jQuery(document).ready(function () {

    console.log("init live im.");
    jQuery(".live__chat").css("display", "none");
    jQuery(".live__discuss").css("display", "block");

    var sbgreen = jQuery(".live__publish-switch-btn");
    var pmgreen = jQuery(".live__publish-more");

    //tab却换部分开始
    jQuery(".live__menu li").click(function () {
        jQuery(this).addClass("active").siblings().removeClass("active");
    });

    jQuery(document).on('click', '#liveBtn', function (e) {
        jQuery(".three-item").css("display", "none");
        jQuery(".live__chat").css("display", "block");
        jQuery("#tabval").val("main");
    });

    jQuery(document).on('click', '#commonBtn', function (e) {
        jQuery(".three-item").css("display", "none");
        jQuery(".live__discuss").css("display", "block");
        jQuery("#tabval").val("discuss");

    });

    jQuery(document).on('click', '#summaryBtn', function (e) {
        jQuery(".three-item").css("display", "none");
        jQuery(".live__summary").css("display", "block");
        jQuery("#tabval").val("about");
    });
});