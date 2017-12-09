String.prototype.HttpHtml = function () {
    var reg = /(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/g;
    return this.replace(reg, '<a href="$1$2">$1$2</a>');
};

Date.prototype.format = function (format) {
    var o = {
        "M+": this.getMonth() + 1, //month
        "d+": this.getDate(),    //day
        "h+": this.getHours(),   //hour
        "m+": this.getMinutes(), //minute
        "s+": this.getSeconds(), //second
        "q+": Math.floor((this.getMonth() + 3) / 3),  //quarter
        "S": this.getMilliseconds() //millisecond
    };
    if (/(y+)/.test(format)) {
        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    }
    for (var k in o) {
        if (new RegExp("(" + k + ")").test(format)) {
            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
        }
    }
    return format;
};

var globalObj = new Object();
globalObj.chat_images = [];
var isAutoplay = false;
//录音相关变量
var recordTimer;
var clock_index = 0;
var START = 0;
var END = 0;
var startx, starty;
var current_voiclocalid;

/*分页获取信息课程*/
var sub_pages = 0;
var discuss_pages = 1;
var page_object = {
    sub_pindex: 1,
    sub_pages: sub_pages,
    com_pindex: 1,
    com_pages: discuss_pages,
    loaded: [],
    loadeddis: []
};

/**
 * 获得角度
 * @param angx
 * @param angy
 * @returns {number}
 */
function getAngle(angx, angy) {
    return Math.atan2(angy, angx) * 180 / Math.PI;
}

/**
 * 根据起点终点返回方向 1向上 2向下 3向左 4向右 0未滑动
 * @param startx
 * @param starty
 * @param endx
 * @param endy
 * @returns {number}
 */
function getDirection(startx, starty, endx, endy) {
    var angx = endx - startx;
    var angy = endy - starty;
    var result = 0;

    //如果滑动距离太短
    if (Math.abs(angx) < 2 && Math.abs(angy) < 2) {
        return result;
    }

    var angle = getAngle(angx, angy);
    if (angle >= -135 && angle <= -45) {
        result = 1;
    } else if (angle > 45 && angle < 135) {
        result = 2;
    } else if ((angle >= 135 && angle <= 180) || (angle >= -180 && angle < -135)) {
        result = 3;
    } else if (angle >= -45 && angle <= 45) {
        result = 4;
    }

    return result;
}

//初始化表情
var EmotionDic = {};

function initEmotionUL() {
    for (var index in webim.Emotions) {
        var emotions = jQuery('<img>').attr({
            "id": webim.Emotions[index][0],
            "src": webim.Emotions[index][1],
            "style": "cursor:pointer;"
        }).click(function () {
            selectEmotionImg(this);
        });
        jQuery('<li>').append(emotions).appendTo(jQuery('#emoj_list'));
        var dic_key = webim.Emotions[index][0];
        var dic_val = webim.Emotions[index][1];
        EmotionDic[dic_key] = dic_val;
    }

    jQuery("#emoj_list li").click(function () {
        if (globalObj.emojbox)
            jQuery("." + globalObj.emojbox).val(jQuery("." + globalObj.emojbox).val() + jQuery(this).find('img').attr('id'));
        jQuery(".live__publish-more").css("display", "none");
        jQuery(".live__publish-send-btn").css("display", "block");
    });
}

function showEmotionDialog(target) {
    jQuery(".control_emojbox").toggleClass('on')
    globalObj.emojbox = "speakInput";
}

function selectEmotionImg(selImg) {
    jQuery("#send_msg_text").val(jQuery("#send_msg_text").val() + selImg.id);
}

/**
 * 根据时间长度获取对应显示语音宽度
 * @param last_second
 * @returns {*}
 */
function getRecordClass(last_second) {
    if (last_second < 12)
        return "recordwid1";
    else if (last_second >= 12 && last_second < 24)
        return "recordwid2";
    else if (last_second >= 24 && last_second < 36)
        return "recordwid3";
    else if (last_second >= 36 && last_second < 48)
        return "recordwid4";
    else if (last_second > 48)
        return "recordwid5";
    else
        return "recordwid1";
}

function stopEventBubble(event) {
    var e = event || window.event;
    if (e && e.stopPropagation) {
        e.stopPropagation();
    }
    else {
        e.cancelBubble = true;
    }
}

/***
 * 声音播放完毕事件
 */
function voicePlayOver() {
    jQuery(".live__discuss-voice").removeClass("active");
    if (globalObj.voicePlaying) {
        globalObj.voicePlaying.removeClass("isPlaying");
        globalObj.voicePlaying.addClass("isReaded ");
        globalObj.isPlaying = false;
        var msg_id = globalObj.voicePlaying.parents('dd').attr('msg_id');
        jQuery(".recordingMsg").each(function () {
            if (parseInt(jQuery(this).parents('dd').attr('msg_id')) > parseInt(msg_id)) {
                jQuery(this).click();
                return false;
            }
        });
    }
}

/**
 * 滚动事件处理函数
 */
function scroll_func() {
    var scrollTop = jQuery(this).scrollTop();
    var scrollHeight = jQuery(this)[0].scrollHeight;
    var windowHeight = jQuery(this)[0].clientHeight;
    //滚动到底部执行事件
    if (scrollTop + windowHeight + 2 >= scrollHeight) {
        if (page_object.sub_pindex < sub_pages) {
            jQuery(".btnLoadSpeakEnd").addClass("on");
            page_object.sub_pindex = page_object.sub_pindex + 1;
            //ajax_content(page_object.sub_pindex, "down", 0);
        }
    }
}

/**
 * 上传语音接口
 * @param localId
 */
function uploadVoic(localId) {
    wx.uploadVoice({
        localId: localId, // 需要上传的音频的本地ID，由stopRecord接口获得
        isShowProgressTips: 1, // 默认为1，显示进度提示
        success: function (res) {
            var serverId = res.serverId; // 返回音频的服务器端ID
            var jsonObj = {
                type: "say",
                target: jQuery("#tabval").val(),
                msg_type: "voice",
                headimg: userInfo.headimgurl,
                last: clock_index,
                nick: userInfo.nickname,
                content: serverId
            };
            sentContent(jsonObj);
            clock_index = 0;
            current_voiclocalid = null;
        }
    });
}

/**
 * 声音播放事件
 */
function voicePlay() {
    jQuery(".live__discuss-voice").unbind();
    jQuery(".live__discuss-voice").click(function () {
        jQuery(".live__discuss-voice").removeClass("active");
        var recordMsg = jQuery(this);
        var voice_str = recordMsg.attr('attr-src');

        if (voice_str.indexOf('http') == 0) {
            var media = jQuery('#audioPlayer')[0];
            if (jQuery("#audioPlayer").attr('src') != voice_str)
                jQuery("#audioPlayer").attr('src', voice_str);
            if (media.paused) {
                media.play();
                recordMsg.addClass("active");
                globalObj.isPlaying = true;
            } else {
                media.pause();
                recordMsg.removeClass('active');
            }
            globalObj.voicePlaying = recordMsg;

            media.removeEventListener("ended", voicePlayOver, false);
            media.addEventListener("ended", voicePlayOver, false);
            return;
        }
        if (recordMsg.attr("localid")) {
            var localId = recordMsg.attr("localid");
            if (jQuery(this).hasClass('active')) {
                wx.pauseVoice({
                    localId: localId // 需要暂停的音频的本地ID，由stopRecord接口获得
                });
                jQuery(this).removeClass('active');
            } else {
                wx.playVoice({
                    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
                });
                jQuery(this).addClass("active");
                wx.onVoicePlayEnd({
                    success: function (res) {
                        jQuery(this).removeClass("active");
                    }
                });
            }
            return;
        }

        wx.downloadVoice({
            serverId: recordMsg.attr('attr-src'), // 需要下载的音频的服务器端ID，由uploadVoice接口获得
            isShowProgressTips: 0, // 默认为1，显示进度提示
            success: function (res) {
                var localId = res.localId; // 返回音频的本地ID
                recordMsg.addClass("active");
                recordMsg.attr('localid', localId);
                wx.playVoice({
                    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
                });
                wx.onVoicePlayEnd({
                    success: function (res) {
                        recordMsg.removeClass("active");
                    }
                });
            }
        });
    });
}

//当前正在播放语音信息
function startRec(){
    jQuery(".second_dd var").eq(0).text(clock_index);
    clock_index++;
    if(clock_index==59){
        clock_index=60;
        jQuery("#btnStopRec").click();
    }
}

/*下载语音事件*/
function voiceDown() {
    jQuery(".recordingMsg").unbind();
    jQuery(".recordingMsg").click(function (e) {
        stopEventBubble(e);
        var recordVoice = jQuery(this).children("i");
        var recordMsg = jQuery(this);
        jQuery(".isPlaying").removeClass('isPlaying');
        var attr_voice = recordVoice.attr('attr-src');

        if (attr_voice && attr_voice.indexOf('http') == 0) {
            if (jQuery("#audioPlayer").attr('src') != attr_voice)
                jQuery("#audioPlayer").attr('src', attr_voice);
            var media = jQuery('#audioPlayer')[0];
            if (media.paused) {
                media.play();
                recordMsg.addClass("isPlaying");
                globalObj.isPlaying = true;
            } else {
                media.pause();
                recordMsg.removeClass('isPlaying');
            }
            globalObj.voicePlaying = recordMsg;
            media.removeEventListener("ended", voicePlayOver, false);
            media.addEventListener("ended", voicePlayOver, false);
            //ppt2
            return;
        }

        if (recordVoice.attr("localid")) {
            var localId = recordVoice.attr("localid");
            if (recordMsg.hasClass('isPlaying')) {
                wx.pauseVoice({
                    localId: localId // 需要暂停的音频的本地ID，由stopRecord接口获得
                });
                recordMsg.removeClass('isPlaying');
            } else {
                wx.playVoice({
                    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
                });

                globalObj.isPlaying = true;
                recordMsg.addClass("isPlaying");
                wx.onVoicePlayEnd({
                    success: function (res) {
                        recordMsg.removeClass("isPlaying");
                        recordMsg.addClass("isReaded ");
                        globalObj.isPlaying = false;
                    }
                });
            }
            return;
        }

        wx.downloadVoice({
            serverId: recordVoice.attr('attr-src'), // 需要下载的音频的服务器端ID，由uploadVoice接口获得
            success: function (res) {
                var localId = res.localId; // 返回音频的本地ID
                recordMsg.addClass("isPlaying");
                recordVoice.attr('localid', localId);
                wx.playVoice({
                    localId: localId // 需要播放的音频的本地ID，由stopRecord接口获得
                });
                globalObj.isPlaying = true;

                wx.onVoicePlayEnd({
                    success: function (res) {
                        recordMsg.removeClass("isPlaying");
                        recordMsg.addClass("isReaded ");
                        globalObj.isPlaying = false;
                    }
                });
            }
        });
    });
}

/**
 * 保存信息
 * @param json_data
 */
function sentContent(json_data) {
    var posturl = '/live/chat/sent?stream_id=' + window.stream_id;
    jQuery.post(posturl, json_data, function (result) {
        if (result.success == false) {
            return;
        }
        json_data.msg_id = result.id;
        json_data.time = new Date().format('MM/dd hh:mm:ss');
        json_data.user_id = userInfo.user_id;
        onSendMsg(JSON.stringify(json_data));
        globalObj.reward = null;
        globalObj.reward_last = null;
        document.getElementById('live__menu-container').scrollTop = document.getElementById('live__menu-container').scrollHeight + 150;
    });
}

/**
 * 发言
 * @param tcpdata
 */
function say(tcpdata) {
    tcpdata.revoke = tcpdata.user_id == userInfo.user_id || userInfo.isManager ? 1 : 0;
    var text = "";
    if (tcpdata.msg_type == 'text') {
        text = '<dd class="left_bubble hasTime" msg_id="' + tcpdata.msg_id + '" id="msg_' + tcpdata.msg_id + '">';
        text += '<div class="live__discuss-item">';
        text += '<div class="live__discuss-container flex-2">';
        text += '<div class="live__discuss-info">';
        text += '<div class="avatar">';
        text += '<img src="' + tcpdata.headimg + '" width="100%" height="100%">';
        text += '</div>';
        text += '</div>';
        text += '<div class="live__discuss-info-main sub">';
        text += '<div class="live__discuss-name gray">';
        text += '<span class="pull-right fs-12">' + tcpdata.time + '</span>';
        text += tcpdata.nick;
        text += '</div>';
        text += '<div class="live__discuss-box">';
        text += '<p>' + convertEmotion(tcpdata.content) + '</p>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</dd>';
    } else if (tcpdata.msg_type == 'voice') {
        var voice_class = getRecordClass(tcpdata.last);
        text = '<dd class="left_bubble hasTime" msg_id="' + tcpdata.msg_id + '" id="msg_' + tcpdata.msg_id + '">';
        text += ' <div class="live__discuss-item">';
        text += '<div class="live__discuss-container flex-2">';
        text += '<div class="live__discuss-info">';
        text += '<div class="avatar">';
        text += '<img src="' + tcpdata.headimg + '" width="100%" height="100%">';
        text += '</div>';
        text += '</div>';
        text += '<div class="live__discuss-info-main sub">';
        text += '<div class="live__discuss-name gray">';
        text += '<span class="pull-right fs--12">' + tcpdata.time + '</span>';
        text += tcpdata.nick;
        text += '</div>';
//										text+='<div>';
//											text+='<audio style="width:200px;" src="'+tcpdata.content+'" controls="controls">您的浏览器不支持 audio 标签。</audio>';
//										text+='</div>';
        text += '<div class="live__discuss-box live__discuss-voice ' + voice_class + '" attr-src="' + tcpdata.content + '">';
        text += tcpdata.last;
        text += '</div>';

        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</dd>';
    } else if (tcpdata.msg_type == 'image') {
        text = '<dd class="left_bubble hasTime" msg_id="' + tcpdata.msg_id + '" id="msg_' + tcpdata.msg_id + '">';
        text += '<div class="live__discuss-item">';
        text += '<div class="live__discuss-container flex-2">';
        text += '<div class="live__discuss-info">';
        text += '<div class="avatar">';
        text += '<img src="' + tcpdata.headimg + '" width="100%" height="100%">';
        text += '</div>';
        text += '</div>';
        text += '<div class="live__discuss-info-main sub">';
        text += '<div class="live__discuss-name gray">';
        text += '<span class="pull-right f12">' + tcpdata.time + '</span>';
        text += tcpdata.nick;
        text += '</div>';
        text += '<div class="live__discuss-box album">';
        text += '<ul class="is-one flex clearfix">';
        text += '<li  mediaid="' + tcpdata.content + '">';
        text += '<img class="chat_img"  src="' + tcpdata.content + '" >';
        text += '</li>';
        text += '</ul>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</dd>';
    }

    jQuery("#speakBubbles").append(text);
    jQuery("#live__menu-container").scrollTop(jQuery("#live__menu-container")[0].scrollHeight + 100);
    if (tcpdata.msg_type == 'voice') {
        voiceDown();
        if (!globalObj.isPlaying || globalObj.isPlaying == false) {
            if (userInfo.isManager || userInfo.isGuest) {
                if (isAutoplay) {
                    jQuery(".recordingMsg").last().click();
                }
            } else {
                jQuery(".recordingMsg").last().click();
            }
        }
    }
    jQuery(".chat_img").unbind();
    jQuery(".chat_img").click(function () {
        if (jQuery.inArray(jQuery(this).attr('src'), globalObj.chat_images) == -1) {
            globalObj.chat_images.push(jQuery(this).attr('src'));
        }
        wx.previewImage({
            current: jQuery(this).attr('src'), // 当前显示图片的http链接
            urls: globalObj.chat_images // 需要预览的图片http链接列表
        });
    });
    voicePlay();
}

/**
 * 讨论
 * @param tcpdata
 */
function sayDiscuss(tcpdata) {
    var text = "";
    if (tcpdata.msg_type == 'text') {
        text = '<dd class="left_bubble hasTime" msg_id="' + tcpdata.msg_id + '" id="msg_' + tcpdata.msg_id + '">';
        text += '<div class="live__discuss-item">';
        text += '<div class="live__discuss-container flex-2">';
        text += '<div class="live__discuss-info">';
        text += '<div class="avatar">';
        text += '<img src="' + tcpdata.headimg + '" width="100%" height="100%">';
        text += '</div>';
        text += '</div>';
        text += '<div class="live__discuss-info-main sub">';
        text += '<div class="live__discuss-name gray">';
        text += '<span class="pull-right fs-12">' + tcpdata.time + '</span>';
        text += tcpdata.nick;
        text += '</div>';
        text += '<div class="live__discuss-box">';
        text += '<p>' + convertEmotion(tcpdata.content) + '</p>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</dd>';
    } else if (tcpdata.msg_type == 'voice') {
        var voice_class = getRecordClass(tcpdata.last);
        text = '<dd class="left_bubble hasTime" msg_id="' + tcpdata.msg_id + '" id="msg_' + tcpdata.msg_id + '">';
        text += ' <div class="live__discuss-item">';
        text += '<div class="live__discuss-container flex-2">';
        text += '<div class="live__discuss-info">';
        text += '<div class="avatar">';
        text += '<img src="' + tcpdata.headimg + '" width="100%" height="100%">';
        text += '</div>';
        text += '</div>';
        text += '<div class="live__discuss-info-main sub">';
        text += '<div class="live__discuss-name gray">';
        text += '<span class="pull-right fs-12">' + tcpdata.time + '</span>';
        text += tcpdata.nick;
        text += '</div>';
//										text+='<div>';
//											text+='<audio style="width:200px;" src="'+tcpdata.content+'" controls="controls">您的浏览器不支持 audio 标签。</audio>';
//										text+='</div>';
        text += '<div class="live__discuss-box live__discuss-voice ' + voice_class + '" attr-src="' + tcpdata.content + '">';
        text += tcpdata.last;
        text += '</div>';

        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</dd>';
    } else if (tcpdata.msg_type == 'image') {
        text = '<dd class="left_bubble hasTime" msg_id="' + tcpdata.msg_id + '" id="msg_' + tcpdata.msg_id + '">';
        text += '<div class="live__discuss-item">';
        text += '<div class="live__discuss-container flex-2">';
        text += '<div class="live__discuss-info">';
        text += '<div class="avatar">';
        text += '<img src="' + tcpdata.headimg + '" width="100%" height="100%">';
        text += '</div>';
        text += '</div>';
        text += '<div class="live__discuss-info-main sub">';
        text += '<div class="live__discuss-name gray">';
        text += '<span class="pull-right fs-12">' + tcpdata.time + '</span>';
        text += tcpdata.nick;
        text += '</div>';
        text += '<div class="live__discuss-box album">';
        text += '<ul class="is-one flex clearfix">';
        text += '<li  mediaid="' + tcpdata.content + '">';
        text += '<img class="chat_img"  src="' + tcpdata.content + '" >';
        text += '</li>';
        text += '</ul>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</div>';
        text += '</dd>';
    }

    jQuery("#commentDl").append(text);
    jQuery("#live__menu-container").scrollTop(jQuery("#live__menu-container")[0].scrollHeight + 100);

    if (tcpdata.msg_type == 'voice') {
        voiceDown();
    }
    jQuery(".chat_img").unbind();
    jQuery(".chat_img").click(function () {
        if (jQuery.inArray(jQuery(this).attr('src'), globalObj.chat_images) == -1) {
            globalObj.chat_images.push(jQuery(this).attr('src'));
        }
        wx.previewImage({
            current: jQuery(this).attr('src'), // 当前显示图片的http链接
            urls: globalObj.chat_images // 需要预览的图片http链接列表
        });
    });
    voicePlay();
}

/**
 * 服务端发来消息时
 * @param e
 */
function onMessage(e) {
    var data = JSON.parse(e.data);
    switch (data['type']) {
        case 'ping':
            onSendMsg('{"type":"pong"}');
            break;
        case 'login':
            if (tcpdata.revoke && (userInfo.isManager || userInfo.isGuest))
                jQuery(".qlOLPeople").text(data['users']);
            else
                jQuery(".qlOLPeople").text(parseInt(jQuery(".qlOLPeople").text()) + 1);
            break;
        case 'say':
            if (data.target == 'main') {
                var msg_last = jQuery("#speakBubbles").find('dd').last();
                if (msg_last.size() > 0 && data.msg_id) {
                    if (msg_last.attr('msg_id') < data.msg_id) {
                        say(data);
                    }
                } else {
                    say(data);
                }
                voicePlay();
            } else {
                sayDiscuss(data);
            }
            break;
        case 'logout':
            break;
        case 'tipmsg':
            if (tcpdata.revoke && (userInfo.isManager || userInfo.isGuest))
                jQuery(".qlOLPeople").text(data['users']);
    }
}

jQuery(document).ready(function () {

    console.log("init live im.");
    jQuery("#publishdiv").show();
    jQuery(".live__chat").css("display", "none");

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
        jQuery("#publishdiv").hide();
    });

    jQuery(document).on('click', '#commonBtn', function (e) {
        jQuery(".three-item").css("display", "none");
        jQuery(".live__discuss").css("display", "block");
        jQuery("#tabval").val("discuss");
        jQuery("#publishdiv").show();
    });

    jQuery(document).on('click', '#summaryBtn', function (e) {
        jQuery(".three-item").css("display", "none");
        jQuery(".live__summary").css("display", "block");
        jQuery("#tabval").val("about");
        jQuery("#publishdiv").hide();
    });
    //tab切换结束

    //发布区域控制
    jQuery(document).on('click', '.live__publish-voice', function (e) {
        sbgreen.removeClass("green");
        pmgreen.removeClass("green");
        jQuery(this).toggleClass("green");
        jQuery(".live__publish-more_box,.live__publish-emoji-box").removeClass("active");
        jQuery(".live__publish-enter,.live__publish-recording").toggleClass("active");
    });
    jQuery(document).on('click', '.live__publish-switch-btn', function (e) {
        pmgreen.removeClass("green");
        jQuery(this).toggleClass("green");
        jQuery(".live__publish-more-box").removeClass("active");
        jQuery(".live__publish-emoji-box").toggleClass("active");
    });
    jQuery(document).on('click', '.live__publish-more', function (e) {
        sbgreen.removeClass("green");
        jQuery(this).toggleClass("green");
        jQuery(".live__publish-emoji-box").removeClass("active");
        jQuery(".live__publish-more-box").toggleClass("active");
    });
    jQuery(document).on('click', '#enterfont', function (e) {
        sbgreen.removeClass("green");
        pmgreen.removeClass("green");
        jQuery(".live__publish-more-box,.live__publish-emoji-box").removeClass("active");
    });
    jQuery("#enterfont").keyup(function () {
        if (jQuery("#enterfont").val().length < 1) {
            jQuery(".live__publish-more").css("display", "block");
        } else {
            jQuery(".live__publish-more").css("display", "none");
            jQuery(".live__publish-send-btn").css("display", "block");
        }
    });
    //发布区域控制结束

    //按下开始录音
    jQuery(document).on('touchstart', '#talk_btn', function (e) {
        jQuery(".recording-tips").show();
        jQuery("#talk_btn").text("正在录音...");
        event.preventDefault();
        START = new Date().getTime();

        startx = event.touches[0].pageX;
        starty = event.touches[0].pageY;
        recordTimer = setTimeout(function () {
            wx.startRecord({
                success: function () {
                    localStorage.rainAllowRecord = 'true';
                },
                cancel: function () {
                    alert('用户拒绝授权录音');
                }
            });
        }, 300);
    });

    //松手结束录音
    jQuery(document).on('touchend', '#talk_btn', function (e) {
        jQuery(".recording-tips").hide();
        jQuery("#talk_btn").text("按住说话");
        event.preventDefault();
        END = new Date().getTime();
        clock_index = parseInt((END - START) / 1000);
        wx.stopRecord({
            success: function (res) {
                //voice.localId = res.localId;
                current_voiclocalid = res.localId;
                //uploadVoice();
                uploadVoic(current_voiclocalid);
            },
            fail: function (res) {
                alert("说话时间太短");
            }
        });
    });

    jQuery(".speakContentBox").scroll(scroll_func);

    //发图
    jQuery(document).on('click', '.btn_img', function (e) {
        wx.chooseImage({
            count: 1,
            sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
            sourceType: ['album', 'camera'], // 可以指定来源是相册还是相机，默认二者都有
            success: function (res) {
                var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                var i = 0, length = 1;
                globalObj.localIds = localIds;

                function upload() {
                    var firstId = globalObj.localIds[i].toString();
                    wx.uploadImage({
                        localId: firstId, // 需要上传的图片的本地ID，由chooseImage接口获得
                        isShowProgressTips: 1, // 默认为1，显示进度提示
                        success: function (res) {
                            var serverId = res.serverId; // 返回图片的服务器端ID
                            jQuery.post('/live/chat/download-media?stream_id=' + window.stream_id, {
                                'media_id': serverId,
                                "type": 'image'
                            }, function (result) {
                                var img_url = result.data;
                                var jsonObj = {
                                    type: "say",
                                    target: jQuery("#tabval").val(),
                                    msg_type: "image",
                                    nick: userInfo.nickname,
                                    headimg: userInfo.headimgurl,
                                    content: img_url
                                };
                                sentContent(jsonObj);
                            });
                            i++;
                            if (i < 1) {
                                upload();
                            }
                            jQuery(".live__publish-more-box").removeClass("active");
                            jQuery(".live__publish-more").removeClass("green");
                        }
                    });
                }

                upload();
            }
        });
        return false;
    });

    //发送信息
    jQuery(document).on('click', '#btn_send', function (e) {
        var inputText = jQuery(".speakInput").val();
        if (inputText == '') {
            return;
        }
        var jsonObj = {
            type: "say",
            target: jQuery("#tabval").val(),
            msg_type: "text",
            nick: userInfo.nickname,
            headimg: userInfo.headimgurl,
            content: inputText
        };

        sentContent(jsonObj);
        //$('.i-container').animate({scrollTop:$('.publish-panel').offset().top}, 800);

        jQuery(".speakInput").val('');
        jQuery(".live__publish-more").css("display", "block");
        jQuery(".control_emojbox").removeClass("active");
        var sbgreen = jQuery(".live__publish-switch-btn");
        var pmgreen = jQuery(".live__publish-more");
        sbgreen.removeClass("green");
        pmgreen.removeClass("green");
    });

    initEmotionUL();
});
