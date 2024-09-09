var _this;
var dianjinum = 0;
var isxiugai1 = true;
var isxiugai2 = true;
var WXnum;
var QQnum;
var WX_image = "";
var ZFB_image = "";
var isjizhu1 = 0;
var isjizhu2 = 0;
var isnum = 0;
var daojishinum = 60;
var daojishinum2 = 60;
var yonghu_token;
var isdian1 = false;
var isdian2 = false;
var isjzzhanghao = true;
var isjzmima = true;
var duihuannum = 1;
var mairunum = 0;
var maichunum = 0;
var jinbinum = 0;
var xianguonum = 0;
var duihuanid = 0;
var guoshu = 0;
var tudi_lv = 0;
var guoshu_lv = 0;
var duihuanjinbi = 0;
var guoshu_jinbi = 0;
var guoshu_id = 0;
var zhongzhi_id = 0;
var huishou_id = 0;
var mairu_jiage = 0;
var maichu_jiage = 0;
var regNum = /(^[\-0-9][0-9]*(.[0-9]+)?)$/;
var regWX = /^[a-zA-Z]([-_a-zA-Z0-9]{5,19})+$/;
var regTel = /^1(3|4|5|6|9|7|8)\d{9}$/;
var regName = /^[\u2E80-\u9FFF]+$/;
var Game = (function (_super) {
    function Game() {
        _this = this;
        Game.super(this);
        this.denglu_box.getChildByName("提示框").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.denglu_box.getChildByName("提示框").visible = false;
        });
        this.denglu_box.getChildByName("注册").getChildByName("返回").on(Laya.Event.MOUSE_DOWN, this, function () {
            window.location.href = "http://fg.wtwpdk.cn/home/index";
            this.denglu_box.getChildByName("注册").visible = false;
        });
        this.denglu_box.getChildByName("注册").getChildByName("获取").on(Laya.Event.MOUSE_DOWN, this, this.hqyanzhengma);
        this.denglu_box.getChildByName("注册").getChildByName("注册按钮").on(Laya.Event.MOUSE_DOWN, this, this.zhucefun);
        Laya.timer.frameLoop(1, this, this.timefun);
    }
    Laya.class(Game, "Game", _super)
    var _proto = Game.prototype;
    //初始化
    _proto.reset = function () {
        this.hqyonghu();
        this.hqjiage();
        this.hqgonggao();
        this.kfewm();
        this.list_shangcheng.vScrollBarSkin = "";
        Laya.SoundManager.playMusic("res/bg.mp3", 0)
        console.log("初始化……", dengluarr);
    }
    //时间轴
    _proto.timefun = function () {
        if (this.denglu_box.getChildByName("注册").visible) {
            isnum = 1;
        }
    }
    //倒计时
    _proto.daojishifun = function () {
        mytime = setInterval(function () {
            console.log("倒计时1", daojishinum, "倒计时2", daojishinum2)
            daojishinum--;
            _this.denglu_box.getChildByName("注册").getChildByName("倒计时").getChildAt(1).text = daojishinum + "s";
            if (daojishinum <= 0) {
                clearTimeout(mytime);
                _this.denglu_box.getChildByName("注册").getChildByName("获取").mouseEnabled = true;
                _this.denglu_box.getChildByName("注册").getChildByName("倒计时").getChildAt(1).text = "60s";
                _this.denglu_box.getChildByName("注册").getChildByName("倒计时").visible = false;
                _this.denglu_box.getChildByName("注册").getChildByName("获取").visible = true;
            }
        }, 1000)
    }
    _proto.daojishifun2 = function () {
        mytime2 = setInterval(function () {
            console.log("倒计时1", daojishinum, "倒计时2", daojishinum2)
            daojishinum2--;
            _this.denglu_box.getChildByName("忘记密码").getChildByName("倒计时").getChildAt(1).text = daojishinum2 + "s";
            if (daojishinum2 <= 0) {
                clearTimeout(mytime2);
                _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").mouseEnabled = true;
                _this.denglu_box.getChildByName("忘记密码").getChildByName("倒计时").getChildAt(1).text = "60s";
                _this.denglu_box.getChildByName("忘记密码").getChildByName("倒计时").visible = false;
                _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").visible = true;
            }
        }, 1000)
    }
    //注册方法
    _proto.zhucefun = function () {
        if (this.denglu_box.getChildByName("注册").getChildByName("手机账号").text.length == 11) {
            if (!regTel.test(this.denglu_box.getChildByName("注册").getChildByName("手机账号").text)) {
                _this.tktishi("请输入正确的手机号码!");
            } else {
                if (this.denglu_box.getChildByName("注册").getChildByName("真实姓名").text != "") {
                    if (!regName.test(this.denglu_box.getChildByName("注册").getChildByName("真实姓名").text)) {
                        _this.tktishi("请输入正确的真实姓名!");
                    } else {
                        if (this.denglu_box.getChildByName("注册").getChildByName("游戏昵称").text != "") {
                            if (this.denglu_box.getChildByName("注册").getChildByName("输入密码").text != "") {
                                if (this.denglu_box.getChildByName("注册").getChildByName("确认密码").text != "") {
                                    if (this.denglu_box.getChildByName("注册").getChildByName("验证码").text != "") {
                                        if (this.denglu_box.getChildByName("注册").getChildByName("输入密码").text == this.denglu_box.getChildByName("注册").getChildByName("确认密码").text) {
                                            if (isdian1) {
                                                $.ajax({
                                                    url: "/home/logon",
                                                    type: "POST",
                                                    data: {
                                                        up_id: yonghu_id,
                                                        tel: _this.denglu_box.getChildByName("注册").getChildByName("手机账号").text,
                                                        name: _this.denglu_box.getChildByName("注册").getChildByName("真实姓名").text,
                                                        nickname: _this.denglu_box.getChildByName("注册").getChildByName("游戏昵称").text,
                                                        pwd: _this.denglu_box.getChildByName("注册").getChildByName("输入密码").text,
                                                        r_pwd: _this.denglu_box.getChildByName("注册").getChildByName("确认密码").text,
                                                        code: _this.denglu_box.getChildByName("注册").getChildByName("验证码").text,
                                                    },
                                                    success: function (data) {
                                                        console.log("注册账号", data);
                                                        if (data.status == 1) {
                                                            _this.denglu_box.getChildByName("注册").visible = false;
                                                            window.location.href = "http://wwww.90175.com/home/index";
                                                        } else {
                                                            _this.tktishi(data.info)
                                                        }
                                                    }
                                                })
                                            } else {
                                                _this.tktishi("请点击获取验证码!")
                                            }
                                        } else {
                                            _this.tktishi("两次输入的密码不一致!")
                                        }
                                    } else {
                                        _this.tktishi("请输入验证码!")
                                    }
                                } else {
                                    _this.tktishi("请确认密码!")
                                }
                            } else {
                                _this.tktishi("请输入密码!")
                            }
                        } else {
                            _this.tktishi("请输入游戏昵称!")
                        }
                    }
                } else {
                    _this.tktishi("请输入真实姓名!")
                }
            }
        } else {
            _this.tktishi("请输入手机号码!")
        }
    }
    //获取验证码
    _proto.hqyanzhengma = function () {
        if (isnum == 1) {
            isdian1 = true;
            _this.denglu_box.getChildByName("注册").getChildByName("获取").mouseEnabled = false;
            if (this.denglu_box.getChildByName("注册").getChildByName("手机账号").text.length == 11) {
                $.ajax({
                    url: "/home/code",
                    type: "POST",
                    data: {
                        tel: _this.denglu_box.getChildByName('注册').getChildByName('手机账号').text,
                    },
                    success: function (data) {
                        console.log("获取验证码", data);
                        daojishinum = 60;
                        _this.daojishifun();
                        _this.denglu_box.getChildByName("注册").getChildByName("获取").visible = false;
                        _this.denglu_box.getChildByName("注册").getChildByName("倒计时").visible = true;
                    }
                })
            } else {
                _this.tktishi("请输入完整的手机号!")
                _this.denglu_box.getChildByName("注册").getChildByName("获取").mouseEnabled = true;
            }
        }
        if (isnum == 2) {
            isdian2 = true;
            _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").mouseEnabled = false;
            if (this.denglu_box.getChildByName("忘记密码").getChildByName("手机账号").text.length == 11) {
                $.ajax({
                    url: "/home/code",
                    type: "POST",
                    data: {
                        tel: _this.denglu_box.getChildByName('忘记密码').getChildByName('手机账号').text,
                    },
                    success: function (data) {
                        console.log("获取验证码", data);
                        daojishinum2 = 60;
                        _this.daojishifun2();
                        _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").visible = false;
                        _this.denglu_box.getChildByName("忘记密码").getChildByName("倒计时").visible = true;
                    }
                })
            } else {
                _this.tktishi("请输入完整的手机号!");
                _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").mouseEnabled = true;
            }
        }
    }
    //点击音效
    _proto.yinxiaofun = function () {
        Laya.SoundManager.playSound("res/dianji.mp3", 1)
    }
    //弹框提示 九零 一起 玩 www.90 1 75.com
    _proto.tktishi = function (txt) {
        _this.denglu_box.getChildByName("提示框").getChildByName("内容").text = txt;
        _this.denglu_box.getChildByName("提示框").visible = true;
    }
    return Game;
})(ui.GameUI);