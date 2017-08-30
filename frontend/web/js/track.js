/**
 * 百度跟踪代码
 */

var _hmt = _hmt || [];

jQuery(document).ready(function () {

    //加载百度的统计代码
    var hm = document.createElement("script");
    hm.src = "//hm.baidu.com/hm.js?bf47deea983a706e9337b53f94d44cfb";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);

    /* 指定要响应JS-API调用的帐号的站点id */
    //_hmt.push([ '_setAccount', '6378bee553854c4dfe858f16245fa66c' ]);
    // 用于发送某个指定URL的PV统计请求，通常用于AJAX页面的PV统计。
    // _hmt.push(['_trackPageview', pageURL]);
    // 用于触发某个事件，如某个按钮的点击，或播放器的播放/停止，以及游戏的开始/暂停等。
    // _hmt.push(['_trackEvent', category, action, opt_label, opt_value]);
    // 用户访问一个安装了百度统计代码的页面时，代码会自动发送该页面的PV统计请求，如果不希望自动统计该页面的PV，就可以使用本接口。主要用于iframe嵌套页面等情况。
    // _hmt.push(['_setAutoPageview', false]);
    //

    //百度统计的点击事件监听
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
    
    //百度链接自动推送
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);


    //etc....
});

//Google 分析代码
(function (i, s, o, g, r, a, m) {
    i['GoogleAnalyticsObject'] = r;
    i[r] = i[r] || function () {
            (i[r].q = i[r].q || []).push(arguments)
        }, i[r].l = 1 * new Date();
    a = s.createElement(o),
        m = s.getElementsByTagName(o)[0];
    a.async = 1;
    a.src = g;
    m.parentNode.insertBefore(a, m)
})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

ga('create', 'UA-46365350-2', 'auto');
ga('send', 'pageview');