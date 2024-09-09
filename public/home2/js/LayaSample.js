var Loader = laya.net.Loader;
var Handler = laya.utils.Handler;
var progressBar;
var Stat = Laya.Stat;
var vw = $(window).width();//游戏界面的宽
var vh = $(window).height();//游戏界面的高
var leixing_type;
dengluarr = getCookie("dengluarr");
isjizhu = 2;

jizhuzhanghao = 1;
jizhumima = 1;
token = getCookie("token");
if (dengluarr.length == 0) {
    dengluarr = [];
} else {
    dengluarr = JSON.parse(dengluarr);
}

// console.log(dengluarr);
yonghu_token = getCookie("yonghu_token");
var yonghu_id = GetQueryString('id');//token;
console.log("用户", yonghu_id);
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return decodeURI(r[2]); return null;
}
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
        { url: "res/bg.mp3" },
        { url: "res/shengji.mp3" },
        { url: "res/dianji.mp3" },
        { url: "comp/cangku/cangku.png" },
        { url: "comp/cangku/ck.png" },
        { url: "comp/cangku/ckk.png" },
        { url: "comp/cangku/shu.png" },
        { url: "comp/cangku/zhongzhi.png" },
        { url: "comp/peitao/+.png" },
        { url: "comp/peitao/-1.png" },
        { url: "comp/peitao/-2.png" },
        { url: "comp/peitao/111.png" },
        { url: "comp/peitao/222.png" },
        { url: "comp/peitao/bijiben.png" },
        { url: "comp/peitao/chang.png" },
        { url: "comp/peitao/chang1.png" },
        { url: "comp/peitao/chongzhi.png" },
        { url: "comp/peitao/dh.png" },
        { url: "comp/peitao/dh2.png" },
        { url: "comp/peitao/dianji.png" },
        { url: "comp/peitao/duihuan.png" },
        { url: "comp/peitao/er.png" },
        { url: "comp/peitao/er1.png" },
        { url: "comp/peitao/er2.png" },
        { url: "comp/peitao/geren.png" },
        { url: "comp/peitao/gm1.png" },
        { url: "comp/peitao/gm2.png" },
        { url: "comp/peitao/guanbi.png" },
        { url: "comp/peitao/guang.png" },
        { url: "comp/peitao/guanguang.png" },
        { url: "comp/peitao/hei.png" },
        { url: "comp/peitao/jiangli.png" },
        { url: "comp/peitao/jianglishuoming.png" },
        { url: "comp/peitao/jiaoyi.png" },
        { url: "comp/peitao/jilu.png" },
        { url: "comp/peitao/jinbi.png" },
        { url: "comp/peitao/jyk.png" },
        { url: "comp/peitao/k.png" },
        { url: "comp/peitao/k2.png" },
        { url: "comp/peitao/k3.png" },
        { url: "comp/peitao/kefu.png" },
        { url: "comp/peitao/kuang1.png" },
        { url: "comp/peitao/kuang2.png" },
        { url: "comp/peitao/kuang3.png" },
        { url: "comp/peitao/kuang4.png" },
        { url: "comp/peitao/kuang5.png" },
        { url: "comp/peitao/kuang6.png" },
        { url: "comp/peitao/libao.png" },
        { url: "comp/peitao/maichu.png" },
        { url: "comp/peitao/mairu.png" },
        { url: "comp/peitao/mc.png" },
        { url: "comp/peitao/mr.png" },
        { url: "comp/peitao/pai1.png" },
        { url: "comp/peitao/pai2.png" },
        { url: "comp/peitao/pai3.png" },
        { url: "comp/peitao/paimai.png" },
        { url: "comp/peitao/phb.png" },
        { url: "comp/peitao/qingjin.png" },
        { url: "comp/peitao/qq.png" },
        { url: "comp/peitao/que.png" },
        { url: "comp/peitao/queding.png" },
        { url: "comp/peitao/quxiao.png" },
        { url: "comp/peitao/s1.png" },
        { url: "comp/peitao/s2.png" },
        { url: "comp/peitao/sc.png" },
        { url: "comp/peitao/shichang.png" },
        { url: "comp/peitao/shouji.png" },
        { url: "comp/peitao/shouyi.png" },
        { url: "comp/peitao/shuru.png" },
        { url: "comp/peitao/shuru1.png" },
        { url: "comp/peitao/t1.png" },
        { url: "comp/peitao/taizi1.png" },
        { url: "comp/peitao/taizi2.png" },
        { url: "comp/peitao/tianxie.png" },
        { url: "comp/peitao/tishikuang.png" },
        { url: "comp/peitao/tttt.png" },
        { url: "comp/peitao/tuan1.png" },
        { url: "comp/peitao/tuan2.png" },
        { url: "comp/peitao/tuandui.png" },
        { url: "comp/peitao/tx1.png" },
        { url: "comp/peitao/tx2.png" },
        { url: "comp/peitao/tx3.png" },
        { url: "comp/peitao/xian.png" },
        { url: "comp/peitao/xiangqin.png" },
        { url: "comp/peitao/xianguo.png" },
        { url: "comp/peitao/z1.png" },
        { url: "comp/peitao/z2.png" },
        { url: "comp/peitao/z3.png" },
        { url: "comp/peitao/z4.png" },
        { url: "comp/peitao/zengsong.png" },
        { url: "comp/peitao/zhan1.png" },
        { url: "comp/peitao/zhan2.png" },
        { url: "comp/peitao/zi.png" },
        { url: "comp/peitao/zi1.png" },
        { url: "comp/peitao/zi2.png" },
        { url: "comp/peitao/zi3.png" },
        { url: "comp/peitao/zi4.png" },
        { url: "comp/peitao/zi5.png" },
        { url: "comp/peitao/zi6.png" },
        { url: "comp/peitao/zi7.png" },
        { url: "comp/peitao/zi8.png" },
        { url: "comp/qietu/bj.jpg" },
        { url: "comp/qietu/cz.png" },
        { url: "comp/qietu/dh.png" },
        { url: "comp/qietu/fx.png" },
        { url: "comp/qietu/geren.png" },
        { url: "comp/qietu/gg.png" },
        { url: "comp/qietu/gonggao.png" },
        { url: "comp/qietu/guoshu.png" },
        { url: "comp/qietu/he.png" },
        { url: "comp/qietu/id.png" },
        { url: "comp/qietu/jinbi.png" },
        { url: "comp/qietu/jl.png" },
        { url: "comp/qietu/kf.png" },
        { url: "comp/qietu/nc.png" },
        { url: "comp/qietu/nchang.png" },
        { url: "comp/qietu/ni.png" },
        { url: "comp/qietu/ph.png" },
        { url: "comp/qietu/pm.png" },
        { url: "comp/qietu/sc.png" },
        { url: "comp/qietu/schang.png" },
        { url: "comp/qietu/shang.png" },
        { url: "comp/qietu/shangc.png" },
        { url: "comp/qietu/shenzi.png" },
        { url: "comp/qietu/sy.png" },
        { url: "comp/qietu/td.png" },
        { url: "comp/qietu/tx1.png" },
        { url: "comp/qietu/tx2.png" },
        { url: "comp/qietu/xg.png" },
        { url: "comp/qietu/xguo.png" },
        { url: "comp/shu/1ji.png" },
        { url: "comp/shu/2ji.png" },
        { url: "comp/shu/333.png" },
        { url: "comp/shu/3ji.png" },
        { url: "comp/shu/4ji.png" },
        { url: "comp/shu/555.png" },
        { url: "comp/shu/5ji.png" },
        { url: "comp/shu/6ji.png" },
        { url: "comp/shu/7ji.png" },
        { url: "comp/shu/bai.png" },
        { url: "comp/shu/baijin.png" },
        { url: "comp/shu/cai.png" },
        { url: "comp/shu/duijin.png" },
        { url: "comp/shu/g1.png" },
        { url: "comp/shu/g10.png" },
        { url: "comp/shu/g11.png" },
        { url: "comp/shu/g2.png" },
        { url: "comp/shu/g3.png" },
        { url: "comp/shu/g4.png" },
        { url: "comp/shu/g5.png" },
        { url: "comp/shu/g6.png" },
        { url: "comp/shu/g7.png" },
        { url: "comp/shu/g8.png" },
        { url: "comp/shu/g9.png" },
        { url: "comp/shu/gongxi.png" },
        { url: "comp/shu/guang.png" },
        { url: "comp/shu/guang1.png" },
        { url: "comp/shu/huo.png" },
        { url: "comp/shu/jin.png" },
        { url: "comp/shu/kanshui.png" },
        { url: "comp/shu/kuntu.png" },
        { url: "comp/shu/lihuo.png" },
        { url: "comp/shu/mu.png" },
        { url: "comp/shu/paizi.png" },
        { url: "comp/shu/shengji.png" },
        { url: "comp/shu/shui.png" },
        { url: "comp/shu/tu.png" },
        { url: "comp/shu/tu1.png" },
        { url: "comp/shu/tu2.png" },
        { url: "comp/shu/tu3.png" },
        { url: "comp/shu/tu4.png" },
        { url: "comp/shu/tu5.png" },
        { url: "comp/shu/tu6.png" },
        { url: "comp/shu/tu7.png" },
        { url: "comp/shu/tu8.png" },
        { url: "comp/shu/xiaobai.png" },
        { url: "comp/shu/xiaocai.png" },
        { url: "comp/shu/xiaohuo.png" },
        { url: "comp/shu/xiaojin.png" },
        { url: "comp/shu/xiaomu.png" },
        { url: "comp/shu/xiaoshui.png" },
        { url: "comp/shu/xiaotu.png" },
        { url: "comp/shu/xiaozuan.png" },
        { url: "comp/shu/yun1.png" },
        { url: "comp/shu/yun2.png" },
        { url: "comp/shu/zhenmu.png" },
        { url: "comp/shu/zuan.png" },
        { url: "comp/shu/zuanshi.png" },
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
var img1;
function showProgress() {
    img1 = new Laya.Sprite();
    img1.loadImage("comp/zhuce/fanqie.png", 100, 200, 0, 0);
    img1.pos(10, 730);
    LogoLayer = new Laya.Sprite();
    Laya.stage.addChild(LogoLayer);
    Laya.stage.addChild(img1);
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
    //console.log("进度: " + Math.floor(value * 100) + "%");
    img1.x = value * 500;
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
    // if (token != "") {
    //     _this.denglu_box.visible = false;
    //     _this.shouye_box.visible = true;
    //     _this.reset();
    // } else {
    //     _this.denglu_box.visible = true;
    //     _this.shouye_box.visible = false;
    // };
    if (leixing_type == 2) {
        _this.denglu_box.visible = true;
        _this.shouye_box.visible = false;
        _this.denglu_box.getChildByName("绑定手机号").getChildByName("绑定").on(Laya.Event.MOUSE_DOWN, this, function () {
            if (!regTel.test(_this.denglu_box.getChildByName("绑定手机号").getChildByName("手机号").text)) {
                _this.tktishi2("手机号错误!");
            } else {
                if (_this.denglu_box.getChildByName("绑定手机号").getChildByName("手机号").text != "") {
                    $.ajax({
                        url: "/home2/bindingTelh5",
                        type: "POST",
                        data: {
                            tel: _this.denglu_box.getChildByName("绑定手机号").getChildByName("手机号").text,
                            password: _this.denglu_box.getChildByName("绑定手机号").getChildByName("密码").text,
                        },
                        success: function (data) {
                            console.log("绑定结果", data);
                            if (data.status == 1) {
                                window.location.href = window.location.href;
                                _this.reset();
                                _this.denglu_box.visible = false;
                                _this.shouye_box.visible = true;
                            } else {
                                _this.tktishi2(data.info)
                            }
                        }
                    })
                }else{
                    _this.tktishi2("请输入密码!");
                }
            }
        });
    }
    if (leixing_type == 1) {
        _this.denglu_box.visible = false;
        _this.shouye_box.visible = true;
        _this.reset();
    }
    console.log("类型11111", leixing_type);
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


