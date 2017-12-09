var liveTimeLeft = 0;

(function ($) {
    $.fn.extend({
        minTipsBox: function (b) {
            b = $.extend({
                tipsContent: "",
                tipsTime: 1
            }, b);
            var c = 1E3 * parseFloat(b.tipsTime);
            0 < $(".min_tips_box").length ? $(".min_tips_box").show() : $('<div class="min_tips_box"><b class="bg"></b><span class="tips_content"></span></div>').appendTo("body");
            (function () {
                $(".min_tips_box .tips_content").html(b.tipsContent);
                var c = $(".min_tips_box .tips_content").width() / 2 + 10;
                $(".min_tips_box .tips_content").css("margin-left", "-" + c + "px");
            })();
            setTimeout(function () {
                $(".min_tips_box").hide();
            }, c);
        }
    });
})(jQuery);

function showTips(text, seconds) {
    jQuery(".textTip").show();
    jQuery(".textTip").children("p").text(text);
    setTimeout(function () {
        jQuery(".textTip").hide();
    }, seconds);
}

/**
 * 获取支付状态
 * @param callback
 */
function getPayStatus(payId, callback) {
    callback = callback || $.noop;
    jQuery.getJSON("/payment/default/query?id=" + payId, function (result) {
        return callback(result);
    });
}

/**
 * 计算倒计时
 * @returns {number}
 */
function countDown() {
    var countDown = jQuery(".count-down");
    if (countDown.length != 0) {
        var serverTime = window.serverTime,
            startTime = window.startTime,
            timeLeft = startTime - serverTime;
        liveTimeLeft = timeLeft;
        if (timeLeft <= 0 || !serverTime) {
            countDown.remove();
            return timeLeft = 0;
        }
        var calculationDHMS = function (ms) {
                //计算天
                var day = Math.floor(ms / 864e5);
                var tl = ms - 864e5 * day;
                //计算小时
                var hour = Math.floor(tl / 36e5);
                tl -= 36e5 * hour;
                //计算分钟
                var minute = Math.floor(tl / 6e4);
                tl -= 6e4 * minute;
                //计算秒
                var second = Math.floor(tl / 1e3);
                return {
                    day: day,
                    hour: hour,
                    minute: minute,
                    second: second
                };
            },
            dhms = calculationDHMS(timeLeft);

        for (var v in dhms) {
            countDown.find("[data-unit=" + v + "]").text(dhms[v]);
        }
        var setDom = function (ms) {
                var newDHMS = calculationDHMS(ms);
                for (var v in newDHMS) {
                    dhms[v] != newDHMS[v] && countDown.find("[data-unit=" + v + "]").text(newDHMS[v]);
                }
                dhms = newDHMS;
            },
            countDownInterval = setInterval(function () {
                if (timeLeft > 0) {
                    setDom(timeLeft);
                    timeLeft -= 1e3;
                } else {
                    clearInterval(countDownInterval);
                    location.reload();
                }
            }, 1e3);
    }
}

/**
 * 获取支付情况
 * @returns {Promise|*}
 */
function getPlayInfo() {
    return new Promise(function (resolve, reject) {
        if (window.stream_id != undefined && window.stream_id != 0) {
            jQuery.get("/live/api/play?id=" + window.stream_id, function (result) {
                if (!result.success) {
                    reject(result);
                } else {
                    resolve(result.data);
                }
            });
        } else {
            resolve({});
        }
    });
}

function initPlay() {
    getPlayInfo().then(function (result) {//成功的
        console.log("init palyer.");
        if (result.status == 2) {//直播已经结束
            console.log("直播已经结束.");
            if (!result.isRecord) {//没有回放
                jQuery(".live__heading-content h1").html("视频正在转码中");
                return;
            }
        } else if (liveTimeLeft > 0) {//直播未开始
            console.log("直播还未开始.");
            if (result.status != 1) {//如果这时候有推流，那么就加载播放器
                return;
            }
        }
        if (result.status === 1) {//如果是直播中
            if (!result.isPush) {
                jQuery(".alert-danger").removeClass("hide");
            } else {
                jQuery(".alert-success").removeClass("hide");
            }
        }
        player();
    }, function (result) {
        console.log("初始化播放失败: " + result.message);
    });
}

/**
 * 激活播放器
 * @returns {TcPlayer}
 */
function player() {
    var playerContainer = 'tcplayer_' + window.stream_id;
    jQuery(".live__heading").remove();
    jQuery(".live__player").removeClass("hide");
    return new TcPlayer(playerContainer, window.tcPlayerOptions);
}

wx.ready(function () {
    jQuery(document).on('click', '[data-target="live-join"]', function (e) {
        var follow_btn = jQuery(this);
        var uuid = jQuery(this).data('uuid');
        showTips("支付请求中..", 3000);
        follow_btn.attr("disabled", true);
        jQuery.getJSON("/live/stream/pay?uuid=" + uuid, function (result) {
            WeixinJSBridge.invoke('getBrandWCPayRequest', result.pay, function (res) {
                WeixinJSBridge.log(res.err_msg);
                if (res.err_msg == "get_brand_wcpay_request:ok") {
                    showTips("正在确认..", 6000);
                    PayStatusInterval = setInterval(function () {
                        getPayStatus(result.payId, function (res) {
                            if (res.status == 'success') {
                                pub.showTips("支付成功..", 3000);
                                clearInterval(PayStatusInterval);
                                location.href = result.returnUrl;
                            }
                        });
                    }, 1000);
                } else if (res.err_msg == "get_brand_wcpay_request:cancel") {
                    showTips("支付已取消..", 1000);
                    follow_btn.attr("disabled", false);
                } else {
                    console.log(res);
                    follow_btn.attr("disabled", false);
                }
            });
        });
    });
});
