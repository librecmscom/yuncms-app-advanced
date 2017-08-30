/*通知异步加载*/
var refreshUnreadNotifications = function () {
    getUnreadNotifications(function (total) {
        if (total > 0) {
            if (total > 99) total = '99+';
            jQuery("#unread_notifications").html('<span class="fa fa-bell-o fa-lg"></span><span class="label label-danger"">' + total + '</span>');
        } else {
            jQuery("#unread_notifications").html('<span class="fa fa-bell-o fa-lg"></span>');
        }
    });
};

/*异步加载私信*/
var refreshUnreadMessages = function () {
    getUnreadMessages(function (total) {
        if (total > 0) {
            if (total > 99) total = '99+';
            jQuery("#unread_messages").html('<span class="fa fa-envelope-o fa-lg"></span><span class="label label-danger"">' + total + '</span>');
        } else {
            jQuery("#unread_messages").html('<span class="fa fa-envelope-o fa-lg"></span>');
        }
    });
};

/**
 * 扩展jQuery
 */
jQuery(document).ready(function () {
    //加载语言包
    if (typeof(language) != "undefined") {
        jQuery.i18n.load(languages);
    }

    /*全局启用bootstrap tooltip*/
    jQuery('[data-toggle="tooltip"]').tooltip();

    /**
     * jQuery扩展
     * <?=Modal::widget();?>
     */
    jQuery.extend({
        modalAlert: function (content) {
            var modal = jQuery('#modal');
            modal.find('.modal-title, .modal-body p, .modal-footer').remove();
            modal.find('.modal-header').append('<h2 class="modal-title">' + jQuery.i18n._("friendly reminder") + '</h2>');
            modal.find('.modal-body').html('<p>' + content + '</p>');
            modal.find('.modal-body').append('<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' + jQuery.i18n._("OK") + '</button></div>');
            modal.modal();
        },
        modalLogin: function () {
            var modal = jQuery('#modal');
            modal.find('.modal-title, .modal-body p, .modal-footer').remove();
            modal.find('.modal-header').append('<h2 class="modal-title">' + jQuery.i18n._("friendly reminder") + '</h2>');
            modal.find('.modal-content').load('/user/security/login');
            modal.modal();
        },
        modalLoad: function (url, data, callback) {
            var modal = jQuery('#modal');
            modal.find('.modal-title, .modal-body p, .modal-footer').remove();
            modal.find('.modal-content').load(url, data, callback);
            modal.modal();
        },
        modalConfirm: function (object) {
            var modal = jQuery('#modal');
            modal.find('.modal-title, .modal-body p, .modal-footer').remove();
            modal.find('.modal-header').append('<h2 class="modal-title">' + jQuery.i18n._("Please confirm") + '</h2>');
            modal.find('.modal-body').html('<p>' + object.attr('data-confirm') + '</p>');
            modal.find('.modal-content').append('<div class="modal-footer"><a class="btn btn-primary" href="' + object.attr('href') + '" data-method="post">' + jQuery.i18n._("OK") + '</a><button type="button" class="btn btn-default" data-dismiss="modal">' + jQuery.i18n._("Clean") + '</button></div>');
            modal.modal();
        }
    });

    window.alert = jQuery.modalAlert;
    window.login = jQuery.modalLogin;
    jQuery("[data-confirm]").click(function () {
        jQuery.modalConfirm(jQuery(this));
        return false;
    });
    jQuery('#modal').on("hidden.bs.modal", function (event) {
        var modal = jQuery(this);
        modal.removeData("bs.modal");
    });
});