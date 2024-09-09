var Loader = laya.net.Loader;
var Handler = laya.utils.Handler;
var progressBar;
var Stat = Laya.Stat;
var vw = $(window).width();//游戏界面的宽
var vh = $(window).height();//游戏界面的高

dengluarr = getCookie("dengluarr");
console.log(dengluarr.length, "+++++++++++++++");
isjizhu = 2;

jizhuzhanghao = 1;
jizhumima = 1;
token = getCookie("token");
console.log(token);
if (dengluarr.length == 0) {
    dengluarr = [];
} else {
    dengluarr = JSON.parse(dengluarr);
    console.log("获取cookie", dengluarr);
}
var yonghu_id = GetQueryString('id');//token;
console.log("用户", yonghu_id);
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]); return null;
}
// console.log(dengluarr);
yonghu_token = getCookie("yonghu_token");

// console.log(vw, wh)
(function () {
    (function (LayaSample) {
        B = Laya.Browser;
        Laya.MiniAdpter.init();
        Laya.init(750, 1334);
        Laya.stage.alignH = Laya.Stage.ALIGN_CENTER;
        Laya.stage.alignV = Laya.Stage.ALIGN_MIDDLE;
        //Laya.stage.scaleMode = Laya.Stage.SCALE_NOBORDER;//裁剪
        // Laya.stage.scaleMode = Laya.Stage.SCALE_NOBORDER;//适应高
        Laya.stage.scaleMode = Laya.Stage.SCALE_NOBORDER;//适应高
        Laya.stage.scaleMode = Laya.Stage.SCALE_EXACTFIT;//铺满全屏
        // Laya.stage.alignH = Laya.Stage.ALIGN_CENTER;
        // Laya.stage.alignV = Laya.Stage.ALIGN_MIDDLE;
        // Laya.stage.scaleMode = Laya.Stage.SCALE_FIXED_WIDTH;
        // Laya.stage.screenMode = Laya.Stage.SCREEN_HORIZONTAL;
        Laya.stage.bgColor = "#fff";
        Laya.stage.loadImage("comp/zhuce/bj.jpg");
        //预加载loading条资源
        var proArr = [{ url: "res/progress_time.png" },
        { url: "res/progress_time$bar.png" },
        ];

        Laya.loader.load(proArr, Laya.Handler.create(this, onProLoaded), null, Laya.Loader.ATLAS);
        // Stat.show(0,0);
    })();
})(window.LayaSample || (window.LayaSample = {}));
function onProLoaded() {


    // 将进度条显示到舞台
    showProgress();

    //开始预加载游戏资源

    var arr = new Array;
    arr = [
        // { url: "comp/qietu/bj.jpg" },
        // { url: "res/atlas/comp/cangku.png" },
        // { url: "res/atlas/comp/peitao.png" },
        // { url: "res/atlas/comp/qietu.png" },
        // { url: "res/atlas/comp/zhuce.png" },
        // { url: "res/atlas/comp/shu.png" },
        // { url: "res/atlas/comp.png" },
        { url: "comp/000.png" },
        { url: "comp/111.png" },
        { url: "comp/333.png" },
        { url: "comp/666.png" },
        { url: "comp/777.png" },
        { url: "comp/999.jpg" },
        { url: "comp/huishou.png" },
        { url: "comp/kuang.png" },
        { url: "comp/tuichu.png" },
        { url: "comp/zi.png" },
        { url: "comp/zi1.png" },
        { url: "comp/zi3.png" },
    ];

    //设置progress Handler的第4个参数为true，根据加载文件个数获取加载进度
    Laya.loader.load(arr, null, Laya.Handler.create(this, onProgress, null, false));
}
// 将进度条显示到舞台
function showProgress() {
    LogoLayer = new Laya.Sprite();
    Laya.stage.addChild(LogoLayer);
    progressBar = new Laya.ProgressBar("res/progress_time.png");
    progressBar.width = 500;
    progressBar.height = 36;
    progressBar.pos(120, 950);
    progressBar.sizeGrid = "5,5,5,5";
    //当progressBar的value值改变时触发
    progressBar.changeHandler = new Laya.Handler(this, onChange);
    LogoLayer.addChild(progressBar);
}
function onChange(value) {
    // console.log("进度: "+Math.floor(value*100)+"%");
    if (value == 1) {
        progressBar.value = 1;
        console.log("加载完成");
        LogoLayer.visible = false;
        onAssetLoaded();
    }
}
//游戏资源加载进度函数
function onProgress(pro) {
    // console.log("加载了总文件的:"+Math.floor(pro*100)+"%");
    progressBar.value = Math.floor(pro * 100) / 100;
}

function onAssetLoaded() {
    var game = new Game();
    Laya.stage.addChild(game);
}

//设置cookie
function setCookie(cname, cvalue, exdays) {
    console.log(111)
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/";
}
//获取cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}
//清除cookie
function clearCookie(name) {
    setCookie(name, "", -1);
}


