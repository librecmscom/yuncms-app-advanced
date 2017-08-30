/*
* App Class
* Author: @xutongle
* Website: http://www.yuncms.net
*/
// var App = function () {
//     // We extend jQuery by method hasAttr
//     jQuery.fn.hasAttr = function (name) {
//         return this.attr(name) !== undefined;
//     };
//
//     jQuery.fn.modalAlert = function (content) {
//         var modal = jQuery('#modal');
//         modal.find('.modal-title, .modal-body p, .modal-footer').remove();
//         modal.find('.modal-header').append('<h2 class="modal-title">' + $.i18n._("friendly reminder") + '</h2>');
//         modal.find('.modal-body').html('<p>' + content + '</p>');
//         modal.find('.modal-body').append('<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">' + $.i18n._("OK") + '</button></div>');
//         modal.modal();
//         return modal;
//     };
//
//     // Bootstrap Tooltips and Popovers
//     function handleBootstrap() {
//         /* Tooltips */
//         jQuery('.tooltips').tooltip();
//
//         /* Popovers */
//         jQuery('.popovers').popover();
//     }
//
//     return {
//         init: function () {
//             handleBootstrap();
//         }
//     };
// }();

jQuery(document).ready(function () {
    /* 关注标签 */
    jQuery(document).on('click', '[data-target="follow-tag"]', function (e) {
        jQuery(this).button('loading');
        var follow_btn = jQuery(this);
        var source_id = jQuery(this).data('source_id');
        var show_num = jQuery(this).data('show_num');

        attentionTag(source_id, function (status) {
            follow_btn.removeClass('disabled');
            follow_btn.removeAttr('disabled');
            if (status == 'followed') {
                follow_btn.html('已关注');
                follow_btn.addClass('active');
            } else {
                follow_btn.html('关注');
                follow_btn.removeClass('active');
            }
            /*是否操作关注数*/
            if (Boolean(show_num)) {
                var follower_num = follow_btn.nextAll(".follows").html();
                console.log(follow_btn.nextAll());
                if (status == 'followed') {
                    follow_btn.nextAll(".follows").html(parseInt(follower_num) + 1);
                } else {
                    follow_btn.nextAll(".follows").html(parseInt(follower_num) - 1);
                }
            }
        });
    });

    /* 关注模块处理，关注问题，用户等 */
    jQuery(document).on('click', '[data-target="follow-button"]', function (e) {
        jQuery(this).button('loading');
        var follow_btn = jQuery(this);
        var source_type = jQuery(this).data('source_type');
        var source_id = jQuery(this).data('source_id');
        var show_num = jQuery(this).data('show_num');

        attention(source_type, source_id, function (status) {
            follow_btn.removeClass('disabled');
            follow_btn.removeAttr('disabled');
            if (status == 'followed') {
                follow_btn.html('已关注');
                follow_btn.addClass('active');
            } else {
                follow_btn.html('关注');
                follow_btn.removeClass('active');
            }

            /*是否操作关注数*/
            if (Boolean(show_num)) {
                var follower_num = follow_btn.nextAll("#follower-num").html();
                if (status == 'followed') {
                    follow_btn.nextAll("#follower-num").html(parseInt(follower_num) + 1);
                } else {
                    follow_btn.nextAll("#follower-num").html(parseInt(follower_num) - 1);
                }
            }
        })

    });

    /* 收藏模块处理，收藏问题，收藏代码，收藏笔记等 */
    jQuery(document).on('click', '[data-target="collect-button"]', function (e) {
        jQuery(this).button('loading');
        var collect_btn = jQuery(this);
        var source_type = jQuery(this).data('source_type');
        var source_id = jQuery(this).data('source_id');
        var show_num = jQuery(this).data('show_num');

        collection(source_type, source_id, function (status) {
            collect_btn.removeClass('disabled');
            collect_btn.removeAttr('disabled');
            if (status == 'collected') {
                collect_btn.html('已收藏');
                collect_btn.addClass('active');
            } else {
                collect_btn.html('收藏');
                collect_btn.removeClass('active');
            }

            /*是否操作收藏数*/
            if (Boolean(show_num)) {
                var collect_num = collect_btn.nextAll("#collection-num").html();
                if (status === 'collected') {
                    collect_btn.nextAll("#collection-num").html(parseInt(collect_num) + 1);
                } else {
                    collect_btn.nextAll("#collection-num").html(parseInt(collect_num) - 1);
                }
            }
        })

    });

    /* 推荐 */
    jQuery(document).on('click', '[data-target="support-button"]', function (e) {
        var btn_support = jQuery(this);
        var source_type = btn_support.data('source_type');
        var source_id = btn_support.data('source_id');
        var support_num = parseInt(btn_support.data('support_num'));
        support(source_type, source_id, function (status) {
            if (status == 'success') {
                support_num++
            }
            btn_support.html(support_num + ' 已推荐');
            btn_support.data('support_num', support_num);
        });
    });

    /* 关注直播间 */
    jQuery(document).on('click', '[data-target="follow-live"]', function (e) {
        jQuery(this).button('loading');
        var follow_btn = jQuery(this);
        var source_type = jQuery(this).data('source_type');
        var source_id = jQuery(this).data('source_id');
        var show_num = jQuery(this).data('show_num');

        attention(source_type, source_id, function (status) {
            follow_btn.removeClass('disabled');
            follow_btn.removeAttr('disabled');
            if (status == 'followed') {
                follow_btn.html('已关注');
                follow_btn.addClass('active');
            } else {
                follow_btn.html('关注');
                follow_btn.removeClass('active');
            }

            /*是否操作关注数*/
            if (Boolean(show_num)) {
                var follower_num = jQuery("#follower-num").html();
                if (status == 'followed') {
                    jQuery("#follower-num").html(parseInt(follower_num) + 1);
                } else {
                    jQuery("#follower-num").html(parseInt(follower_num) - 1);
                }
            }
        })

    });

    //检查未读通知
    refreshUnreadNotifications();
    //setInterval('refreshUnreadNotifications()',5000);
    //检查未读短消息
    refreshUnreadMessages();
    //setInterval('refreshUnreadMessages()',5000);

    //etc....
});