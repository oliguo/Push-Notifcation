var pushNotification;
var push_devices = (navigator.userAgent.match(/iPad/i)) == "iPad" ? "iPad" : (navigator.userAgent.match(/iPhone/i)) == "iPhone" ? "iPhone" : (navigator.userAgent.match(/Android/i)) == "Android" ? "Android" : (navigator.userAgent.match(/BlackBerry/i)) == "BlackBerry" ? "BlackBerry" : "null"; //get devices info



function onDeviceReady() {
    $("#app-status-ul").append("<li>deviceready event received</li>");

    try {
        pushNotification = window.plugins.pushNotification;
        consumer_devices = device.platform;
        $("#app-status-ul").append("<li>registering " + device.platform + ",</li>");
        if (device.platform == "android" || device.platform == "Android" || device.platform == "amazon-fireos") {
            pushNotification.register(successHandler, errorHandler, {
                "senderID": "your google project ID",
                "ecb": "onNotification"
            })
        } else {
            pushNotification.register(tokenHandler, errorHandler, {
                "badge": "true",
                "sound": "true",
                "alert": "true",
                "ecb": "onNotificationAPN"
            })
        }
    } catch (err) {
        txt = "There was an error on this page.\n\n";
        txt += "Error description: " + err.message + "\n\n";
        alert(txt)
    }
}

function onNotificationAPN(e) {
    if (e.alert) {
        $("#app-status-ul").append("<li>push-notification: " + e.alert + ",</li>");
        alert(e.alert); //popup message apns
    }
    if (e.sound) {
        var snd = new Media(e.sound);
        snd.play()
    }
    if (e.badge) {
        pushNotification.setApplicationIconBadgeNumber(successHandler, e.badge)
    }
}

function onNotification(e) {
    $("#app-status-ul").append("<li>EVENT -> RECEIVED:" + e.event + ",</li>");
    switch (e.event) {
        case "registered":
            if (e.regid.length > 0) {
                $.post("http://xxxxx.xxxx.xxxx/registerIDInsert.php", {
                    device: push_devices,
                    registerID: e.regid,
                    submit: "olisubmit"
                }, function(data) {
                    alert(data)
                });
                $("#app-status-ul").append("<li>REGISTERED -> REGID:" + e.regid + ",</li>");
                console.log("regID = " + e.regid)
            }
            break;
        case "message":
            if (e.foreground) {
                $("#app-status-ul").append("<li>--INLINE NOTIFICATION--" + ",</li>");

                var soundfile = e.soundname || e.payload.sound;
                var my_media = new Media("/android_asset/www/" + soundfile);
                my_media.play()
            } else {
                if (e.coldstart) {
                    $("#app-status-ul").append("<li>--COLDSTART NOTIFICATION--" + ",</li>");
                    navigator.notification.confirm('有最新消息', pushGoMessage, 'Piggyrebates', ["瀏覽", "取消"]);
                } else {
                    $("#app-status-ul").append("<li>--BACKGROUND NOTIFICATION--" + ",</li>");
                    navigator.notification.confirm('有最新消息', pushGoMessage, 'Piggyrebates', ["瀏覽", "取消"]);
                }
            }
            $("#app-status-ul").append("<li>MESSAGE -> MSG: " + e.payload.message + ",</li>");
            $("#app-status-ul").append("<li>MESSAGE -> MSGCNT: " + e.payload.msgcnt + ",</li>");
            $("#app-status-ul").append("<li>MESSAGE -> TIMESTAMP: " + e.payload.timeStamp + ",</li>");
            break;
        case "error":
            $("#app-status-ul").append("<li>ERROR -> MSG:" + e.msg + ",</li>");
            break;
        default:
            $("#app-status-ul").append("<li>EVENT -> Unknown, an event was received and we do not know what it is,</li>");
            break
    }
}

function tokenHandler(result) {
    $.post("http://xxxxx.xxxx.xxx/registerIDInsert.php", {
        device: push_devices,
        registerID: result,
        submit: "olisubmit"
    }, function(data) {
        alert(data)
    });
    $("#app-status-ul").append("<li>token: " + result + ",</li>")
}

function successHandler(result) {
    $("#app-status-ul").append("<li>success:" + result + ",</li>")
}

function errorHandler(error) {
    $("#app-status-ul").append("<li>error:" + error + ",</li>")
}
document.addEventListener("deviceready", onDeviceReady, true);