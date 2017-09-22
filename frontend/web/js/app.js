/*
* App Class
* Author: @xutongle
* Website: http://www.yuncms.net
*/
var App = function () {
    // We extend jQuery by method hasAttr
    jQuery.fn.hasAttr = function (name) {
        return this.attr(name) !== undefined;
    };

    jQuery.fn.modalAlert = function (content) {
        var modal = jQuery('#modal');
        modal.find('.modal-title, .modal-body p, .modal-footer').remove();
        modal.find('.modal-header').append('<h2 class="modal-title">友情提示</h2>');
        modal.find('.modal-body').html('<p>' + content + '</p>');
        modal.find('.modal-body').append('<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">确定</button></div>');
        modal.modal();
    };

    jQuery.fn.modalConfirm = function (object) {
        var modal = jQuery('#modal');
        modal.find('.modal-title, .modal-body p, .modal-footer').remove();
        modal.find('.modal-header').append('<h2 class="modal-title">请您确认</h2>');
        modal.find('.modal-body').html('<p>' + object.attr('data-confirm') + '</p>');
        modal.find('.modal-content').append('<div class="modal-footer"><a class="btn btn-primary" href="' + object.attr('href') + '" data-method="post">确定</a><button type="button" class="btn btn-default" data-dismiss="modal">取消</button></div>');
        modal.modal();
    };

    // Bootstrap Tooltips and Popovers
    function handleBootstrap() {
        /* Tooltips */
        jQuery('.tooltips').tooltip();
        jQuery('.tooltips-show').tooltip('show');
        jQuery('.tooltips-hide').tooltip('hide');
        jQuery('.tooltips-toggle').tooltip('toggle');
        jQuery('.tooltips-destroy').tooltip('destroy');

        /* Popovers */
        jQuery('.popovers').popover();
        jQuery('.popovers-show').popover('show');
        jQuery('.popovers-hide').popover('hide');
        jQuery('.popovers-toggle').popover('toggle');
        jQuery('.popovers-destroy').popover('destroy');

        /* Modal */
        jQuery('#modal').on("hidden.bs.modal", function (event) {
            jQuery(this).removeData("bs.modal");
        });
        jQuery("[data-confirm]").click(function () {
            jQuery.modalConfirm(jQuery(this));
            return false;
        });
        window.alert = jQuery.modalAlert;
    }

    function handleFollow() {
        /* 关注模块处理，关注问题，用户等 */
        jQuery(document).on('click', '[data-target="follow-button"]', function (e) {
            jQuery(this).button('loading');
            var follow_btn = jQuery(this);
            var source_type = jQuery(this).data('source_type');
            var source_id = jQuery(this).data('source_id');
            var show_num = jQuery(this).data('show_num');

            jQuery.post("/attention/attention/store", {model: source_type, model_id: source_id}, function (result) {
                follow_btn.removeClass('disabled');
                follow_btn.removeAttr('disabled');
                if (result.status == 'followed') {
                    follow_btn.html('已关注');
                    follow_btn.addClass('active');
                } else {
                    follow_btn.html('关注');
                    follow_btn.removeClass('active');
                }

                /*是否操作关注数*/
                if (Boolean(show_num)) {
                    var follower_num = follow_btn.nextAll("#follower-num").html();
                    if (result.status == 'followed') {
                        follow_btn.nextAll("#follower-num").html(parseInt(follower_num) + 1);
                    } else {
                        follow_btn.nextAll("#follower-num").html(parseInt(follower_num) - 1);
                    }
                }
                return callback(result.status);
            });
        });
    }

    function handleCollect() {
        /* 收藏模块处理，收藏问题，收藏代码，收藏笔记等 */
        jQuery(document).on('click', '[data-target="collect-button"]', function (e) {
            jQuery(this).button('loading');
            var collect_btn = jQuery(this);
            var source_type = jQuery(this).data('source_type');
            var source_id = jQuery(this).data('source_id');
            var show_num = jQuery(this).data('show_num');
            jQuery.post("/collection/collection/store", {model: source_type, model_id: source_id}, function (result) {
                collect_btn.removeClass('disabled');
                collect_btn.removeAttr('disabled');
                if (result.status == 'collected') {
                    collect_btn.html('已收藏');
                    collect_btn.addClass('active');
                } else {
                    collect_btn.html('收藏');
                    collect_btn.removeClass('active');
                }

                /*是否操作收藏数*/
                if (Boolean(show_num)) {
                    var collect_num = collect_btn.nextAll("#collection-num").html();
                    if (result.status === 'collected') {
                        collect_btn.nextAll("#collection-num").html(parseInt(collect_num) + 1);
                    } else {
                        collect_btn.nextAll("#collection-num").html(parseInt(collect_num) - 1);
                    }
                }
                return callback(result.status);
            });
        });
    }

    function handleSupport() {
        /* 推荐 */
        jQuery(document).on('click', '[data-target="support-button"]', function (e) {
            var btn_support = jQuery(this);
            var source_type = btn_support.data('source_type');
            var source_id = btn_support.data('source_id');
            var support_num = parseInt(btn_support.data('support_num'));
            jQuery.post("/support/support/store", {model: source_type, model_id: source_id}, function (result) {
                return callback(result.status);
                if (result.status == 'success') {
                    support_num++
                }
                btn_support.html(support_num + ' 已推荐');
                btn_support.data('support_num', support_num);
            });
        });
    }

    function handleFollowTag() {
        jQuery(document).on('click', '[data-target="follow-tag"]', function (e) {
            jQuery(this).button('loading');
            var follow_btn = jQuery(this);
            var source_id = jQuery(this).data('source_id');
            var show_num = jQuery(this).data('show_num');
            jQuery.post("/user/space/tag", {model_id: source_id}, function (result) {
                follow_btn.removeClass('disabled');
                follow_btn.removeAttr('disabled');
                if (result.status == 'followed') {
                    follow_btn.html('已关注');
                    follow_btn.addClass('active');
                } else {
                    follow_btn.html('关注');
                    follow_btn.removeClass('active');
                }
                /*是否操作关注数*/
                if (Boolean(show_num)) {
                    var follower_num = follow_btn.nextAll(".follows").html();
                    if (result.status == 'followed') {
                        follow_btn.nextAll(".follows").html(parseInt(follower_num) + 1);
                    } else {
                        follow_btn.nextAll(".follows").html(parseInt(follower_num) - 1);
                    }
                }
            });
        });
    }

    function handleMessages() {
        jQuery.getJSON("/message/message/unread-messages", function (result) {
            if (result.total > 0) {
                if (result.total > 99) result.total = '99+';
                jQuery("#unread_messages").html('<span class="fa fa-envelope-o fa-lg"></span><span class="label label-danger"">' + result.total + '</span>');
            } else {
                jQuery("#unread_messages").html('<span class="fa fa-envelope-o fa-lg"></span>');
            }
        });
    }

    function handleNotifications() {
        jQuery.getJSON("/notification/notification/unread-notifications", function (result) {
            if (result.total > 0) {
                if (result.total > 99) result.total = '99+';
                jQuery("#unread_notifications").html('<span class="fa fa-bell-o fa-lg"></span><span class="label label-danger"">' + result.total + '</span>');
            } else {
                jQuery("#unread_notifications").html('<span class="fa fa-bell-o fa-lg"></span>');
            }
        });
    }

    function handleTrack() {
        //百度统计的点击事件监听
        /* 指定要响应JS-API调用的帐号的站点id */
        //_hmt.push([ '_setAccount', '6378bee553854c4dfe858f16245fa66c' ]);
        // 用于发送某个指定URL的PV统计请求，通常用于AJAX页面的PV统计。
        // _hmt.push(['_trackPageview', pageURL]);
        // 用于触发某个事件，如某个按钮的点击，或播放器的播放/停止，以及游戏的开始/暂停等。
        // _hmt.push(['_trackEvent', category, action, opt_label, opt_value]);
        // 用户访问一个安装了百度统计代码的页面时，代码会自动发送该页面的PV统计请求，如果不希望自动统计该页面的PV，就可以使用本接口。主要用于iframe嵌套页面等情况。
        // _hmt.push(['_setAutoPageview', false]);
        //
        jQuery(document).on('click', '[data-track]', function (event) {
            var _track = jQuery(this).data('track');//dom
            if (typeof (_hmt) != "undefined" && _track != '') {
                if (_track.indexOf("_hmt.push") > -1) {
                    eval(_track);
                } else {
                    var _trackArr = _track.split('.');
                    if (_trackArr.length < 2) return;
                    var category = 'Click';// 必填项，参数为字符串
                    var action = '';// 必填项，参数为字符串
                    var label = '';// 可选，参数为字符串

                    /**当只有一个分割字符，
                     * 例如 data-track="index.10001"，执行函数 _hmt.push(['_trackEvent', 'Click', 'index', '10001‘])
                     */
                    if (_trackArr.length == 2) {
                        category = 'Click';
                        action = _trackArr[0];// 必填项，参数为字符串
                        label = _trackArr[1];// 可选，参数为字符串
                    }
                    /**当有超过两个或两个以上分割字符，
                     * 如 data-track="songli.BTN.担保交易"，执行_hmt.push(['_trackEvent', 'songli', 'BTN', '担保交易‘]);
                     * 如 data-track="songli.BTN.担保交易.1002" ，执行_hmt.push(['_trackEvent', 'songli', 'BTN', '担保交易.1002‘]);
                     */
                    else {
                        category = _trackArr.shift();// 必填项，参数为字符串
                        action = _trackArr.shift();// 必填项，参数为字符串
                        label = _trackArr.join('.');// 可选，参数为字符串
                    }
                    _hmt.push(['_trackEvent', category, action, label]);
                }
            }
        });
    }

    return {
        init: function () {
            handleBootstrap();
            handleFollow();
            handleCollect();
            handleSupport();
            handleFollowTag();
            handleMessages();
            handleNotifications();
            handleTrack();
        }
    };
}();