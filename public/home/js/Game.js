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
var zongyeshu = 0;
var mairu_jiage = 0;
var maichu_jiage = 0;
var weixinhao = false;
var qqhao = false;
var isyinxiao = false;
var isyinyue = false;
var isshengji1 = false;
var isshengji2 = false;
var touxiangid = 0;
var isxgweixin = false;
var isxgqq = false;
var dijige = 0;
var downtime = 10;
var yeshunum = 1;
var bianhuanum = 0;
var isduihuan2 = false;
var isbianhua = false;
var regNum = /(^[\-0-9][0-9]*(.[0-9]+)?)$/;
var regWX = /^[a-zA-Z]([-_a-zA-Z0-9]{5,19})+$/;
var regTel = /^1(3|4|5|7|6|9|8)\d{9}$/;
var regName = /^[\u2E80-\u9FFF]+$/;
var isduihuan = false;
var Game = (function (_super) {
    function Game() {
        _this = this;
        Game.super(this);
        this.shouye_box.getChildByName("市场").on(Laya.Event.MOUSE_DOWN, this, this.shichangfun);
        this.shouye_box.getChildByName("交易").on(Laya.Event.MOUSE_DOWN, this, this.jiaoyifun);
        this.shouye_box.getChildByName("收益说明").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").visible = true;
        });
        this.shouye_box.getChildByName("观光团").on(Laya.Event.MOUSE_DOWN, this, this.guanguangfun);
        this.shouye_box.getChildByName("团队").on(Laya.Event.MOUSE_DOWN, this, this.tuanduifun);
        this.shouye_box.getChildByName("兑换").on(Laya.Event.MOUSE_DOWN, this, this.duihuanfun);
        this.shouye_box.getChildByName("分享").on(Laya.Event.MOUSE_DOWN, this, this.fenxiangfun);
        this.shouye_box.getChildByName("排行榜").on(Laya.Event.MOUSE_DOWN, this, this.paihangfun);
        this.shouye_box.getChildByName("商城").on(Laya.Event.MOUSE_DOWN, this, this.shangchengfun);
        this.shouye_box.getChildByName("鲜果数量").on(Laya.Event.MOUSE_DOWN, this, this.xianguofun);
        this.shouye_box.getChildByName("仓库按钮").on(Laya.Event.MOUSE_DOWN, this, this.cangkufun);
        this.shouye_box.getChildByName("选项").getChildAt(0).on(Laya.Event.MOUSE_DOWN, this, this.xuanxiangfun);
        this.shouye_box.getChildByName("个人中心").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.hqyonghu();
            $("#wx_skm").show();
            $("#zfb_skm").show();
            $("#wx_skm").css("z-index", "9999999999");
            $("#zfb_skm").css("z-index", "9999999999")
            this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text = "";
            this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text = "";
            this.shouye_box.getChildByName("个人中心页面").visible = true;
        });
        this.shouye_box.getChildByName("个人中心页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $("#wx_skm").hide();
            $("#zfb_skm").hide();
            $("#wx_skm").css("z-index", "-1");
            $("#zfb_skm").css("z-index", "-1");
            this.shouye_box.getChildByName("个人中心页面").visible = false;
        });
        this.shouye_box.getChildByName("市场页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("市场页面").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("买入鲜果").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").visible = true;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("卖出鲜果").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").visible = true;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("赠送").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").visible = true;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").visible = false;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("收益页面").visible = false;
        });
        this.shouye_box.getChildByName("观光页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("观光页面").visible = false;
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("团队页面").visible = false;
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("详情页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("详情页面").visible = false;
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("直推").getChildByName("详情").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            yeshunum = 1;
            _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = 1;
            console.log("000000000000")
            $.ajax({
                url: "/home/myDirectDetail",
                type: "POST",
                data: {
                    token: yonghu_token,
                },
                success: function (data) {
                    if (data.length != 0) {
                        arr_zhitui = [];
                        for (var i = 0; i < data.length; i++) {
                            arr_zhitui.push({
                                头像: data[i].head,
                                id: data[i].id,
                                农场等级: data[i].lv_land,
                                果树等级: data[i].lv,
                                收益: data[i].commission_num,
                                团队人数: data[i].person_num,
                            })
                        }
                        //_this.list_zhitui.vScrollBarSkin = "";
                        _this.list_zhitui.array = arr_zhitui;
                        _this.list_zhitui.visible = true;
                        _this.list_zhitui.mouseHandler = new Laya.Handler(this, onMouse_zhitui);
                        function onMouse_zhitui(e, index) {
                            if (e.type == "click") {
                                if (e.target.name == "详情") {
                                    $.ajax({
                                        url: "/home/personalDirectDetail",
                                        type: "POST",
                                        data: {
                                            token: yonghu_token,
                                            id: arr_zhitui[index].id,
                                        },
                                        success: function (data) {
                                            console.log(data);
                                            _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("详情页面").visible = true;
                                            _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("详情页面").getChildByName("收益").text = data.commission_num;
                                            _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("详情页面").getChildByName("团队人数").text = data.person_num;
                                        }
                                    })
                                }
                            }
                        }
                    } else {
                        _this.list_zhitui.visible = false;
                    }
                }
            })
            this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").visible = true;
            this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").visible = false;
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("团队").getChildByName("详情").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $.ajax({
                url: "/home/myTeamDetail",
                type: "POST",
                data: {
                    token: yonghu_token,
                },
                success: function (data) {
                    if (data.length != 0) {
                        arr_tuandui = [];
                        for (var i = 0; i < data.length; i++) {
                            arr_tuandui.push({
                                代数: data[i].lv_num,
                                人数: data[i].person_num,
                                收益: data[i].commission_num,
                            })
                        }
                        _this.list_tuandui.vScrollBarSkin = "";
                        _this.list_tuandui.array = arr_tuandui;
                        _this.list_tuandui.visible = true;
                    } else {
                        _this.list_tuandui.visible = false;
                    }
                }
            })
            this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").visible = false;
            this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").visible = true;
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").visible = false;
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("兑换页面").visible = false;
        });
        this.shouye_box.getChildByName("排行榜页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("排行榜页面").visible = false;
        });
        this.shouye_box.getChildByName("商城页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("商城页面").visible = false;
        });
        this.shouye_box.getChildByName("鲜果数量页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("鲜果数量页面").visible = false;
        });
        this.shouye_box.getChildByName("仓库页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("仓库页面").visible = false;
        });
        this.shouye_box.getChildByName("选项").getChildByName("拍卖").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("拍卖页面").visible = true;
        });
        this.shouye_box.getChildByName("拍卖页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("拍卖页面").visible = false;
        });
        this.shouye_box.getChildByName("选项").getChildByName("客服").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $("#kf_ewm").show();
            this.shouye_box.getChildByName("客服页面").visible = true;
        });
        this.shouye_box.getChildByName("客服页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $("#kf_ewm").hide();
            this.shouye_box.getChildByName("客服页面").visible = false;
        });
        this.shouye_box.getChildByName("选项").getChildByName("充值").on(Laya.Event.MOUSE_DOWN, this, this.chongzhifun);
        this.shouye_box.getChildByName("充值页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("充值页面").visible = false;
        });
        this.shouye_box.getChildByName("充值页面").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, function () {
            if (chongzhi_id != undefined) {
                zhifu(chongzhi_id, user_id);
            } else {
                this.tktishi("请选择充值金额!")
            }
        });
        this.shouye_box.getChildByName("选项").getChildByName("奖励任务").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $.ajax({
                url: "/home/myTask",
                type: "POST",
                data: {
                    token: yonghu_token,
                },
                success: function (data) {
                    if (data.length != 0) {
                        _this.list_renwu.vScrollBarSkin = "";
                        arr_renwu = [];
                        for (var i = 0; i < data.length; i++) {
                            arr_renwu.push({
                                阶段: data[i].lv,
                                阶段人数: data[i].lv_person,
                                完成人数: data[i].com_person,
                                奖励: data[i].rewards,
                                领取数: data[i].get_num,
                                状态: data[i].status,
                            })
                        }
                        _this.list_renwu.visible = true;
                        _this.list_renwu.array = arr_renwu;
                    } else {
                        _this.list_renwu.visible = false;
                    }
                }
            })
            this.shouye_box.getChildByName("奖励任务页面").visible = true;
        });
        this.shouye_box.getChildByName("奖励任务页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("奖励任务页面").visible = false;
        });
        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").focus = true;
            this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").visible = false;
            this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").visible = true;
        });
        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").focus = true;
            this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").visible = false;
            this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").visible = true;
        });
        this.shouye_box.getChildByName("充值页面").getChildByName("充值记录").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("充值页面").getChildByName("比例").visible = true;
            this.shouye_box.getChildByName("充值页面").getChildByName("充值记录").visible = false;
        });
        this.denglu_box.getChildByName("登录").getChildByName("记住账号").on(Laya.Event.MOUSE_DOWN, this, function () {
            if (isjizhu1 % 2 == 0) {
                isjzzhanghao = false;
                jizhuzhanghao = 2;
                isjzmima = false;
                jizhumima = 2;
                this.denglu_box.getChildByName("登录").getChildByName("勾选2").visible = false;
                this.denglu_box.getChildByName("登录").getChildByName("勾选1").visible = false;
            } else {
                isjzzhanghao = true;
                jizhuzhanghao = 1;
                this.denglu_box.getChildByName("登录").getChildByName("勾选1").visible = true;
            }
            isjizhu1 += 1;
        });
        this.denglu_box.getChildByName("登录").getChildByName("记住密码").on(Laya.Event.MOUSE_DOWN, this, function () {
            if (isjizhu2 % 2 == 0) {
                isjzmima = false;
                jizhumima = 2;
                this.denglu_box.getChildByName("登录").getChildByName("勾选2").visible = false;
            } else {
                isjzmima = true;
                jizhumima = 1;
                jizhuzhanghao = 1;
                this.denglu_box.getChildByName("登录").getChildByName("勾选1").visible = true;
                this.denglu_box.getChildByName("登录").getChildByName("勾选2").visible = true;
            }
            isjizhu2 += 1;
        });
        this.denglu_box.getChildByName("登录").getChildByName("注册按钮").on(Laya.Event.MOUSE_DOWN, this, function () {
            window.location.href = "http://www.90175.com/home1/";
        });
        this.denglu_box.getChildByName("注册").getChildByName("返回").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.denglu_box.getChildByName("登录").visible = true;
            this.denglu_box.getChildByName("注册").visible = false;
        });
        this.denglu_box.getChildByName("登录").getChildByName("忘记密码").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.denglu_box.getChildByName("登录").visible = false;
            this.denglu_box.getChildByName("忘记密码").visible = true;
        });
        this.denglu_box.getChildByName("忘记密码").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.denglu_box.getChildByName("登录").visible = true;
            this.denglu_box.getChildByName("忘记密码").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("数量").on(Laya.Event.INPUT, this, function () {
            if (this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("数量").text != "") {
                if (!regNum.test(this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("数量").text)) {
                    mairunum = 0;
                } else {
                    mairunum = parseInt(this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("数量").text);
                }
            } else {
                mairunum = 0;
            }
            this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("信息").text = "消耗金币" + mairunum * mairu_jiage + "个";
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("数量").on(Laya.Event.INPUT, this, function () {
            if (this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("数量").text != "") {
                if (!regNum.test(this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("数量").text)) {
                    maichunum = 0;
                } else {
                    maichunum = parseInt(this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("数量").text);
                }
            } else {
                maichunum = 0;
            }
            this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("信息").text = "获得金币" + maichunum * maichu_jiage + "个";
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("兑换页面").getChildByName("资料").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("兑换页面").getChildByName("资料").visible = false;
        });
        this.shouye_box.getChildByName("个人中心页面").getChildByName("退出登录").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $("#wx_skm").hide();
            $("#zfb_skm").hide();
            $("#wx_skm").css("z-index", "-1");
            $("#zfb_skm").css("z-index", "-1")
            this.shouye_box.getChildByName("是否退出").visible = true;
        });
        this.shouye_box.getChildByName("是否退出").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $("#wx_skm").show();
            $("#zfb_skm").show();
            $("#wx_skm").css("z-index", "9999999999");
            $("#zfb_skm").css("z-index", "9999999999")
            this.shouye_box.getChildByName("是否退出").visible = false;
        });
        this.shouye_box.getChildByName("是否退出").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("是否退出").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").visible = false;
        });
        this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("昵称").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("昵称").visible = false;
        });
        this.shouye_box.getChildByName("恭喜").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("恭喜").visible = false;
        });
        this.shouye_box.getChildByName("商城页面").getChildByName("是否购买").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("商城页面").getChildByName("是否购买").visible = false;
        })
        this.shouye_box.getChildByName("商城页面").getChildByName("成功").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("商城页面").getChildByName("成功").visible = false;
        });
        this.shouye_box.getChildByName("仓库页面").getChildByName("提示页面").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("仓库页面").getChildByName("提示页面").visible = false;
        });
        this.shouye_box.getChildByName("分享页面").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            $("#fuzhi2").css("z-index", "-1");
            $("#biao1").css("z-index", "-1");
            $("#biao1").css("display", "none");
            this.shouye_box.getChildByName("分享页面").visible = false;
        });
        this.shouye_box.getChildByName("回收按钮").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("回收提示").visible = true;
        });
        this.shouye_box.getChildByName("回收提示").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            _this.yinxiaofun();
            this.shouye_box.getChildByName("回收提示").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("成功").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
            this.shouye_box.getChildByName("兑换页面").getChildByName("成功").visible = false;
            this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
        });
        this.shouye_box.getChildByName("分享页面").getChildByName("点击放大").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("分享页面").getChildByName("全屏").visible = true;
        });
        this.shouye_box.getChildByName("分享页面").getChildByName("全屏").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("分享页面").getChildByName("全屏").visible = false;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("收益对比").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("对比详情").visible = true;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("对比详情").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("对比详情").visible = false;
        });
        this.shouye_box.getChildByName("回收提示").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.huishoufun);
        this.shouye_box.getChildByName("仓库页面").getChildByName("提示页面").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.zhongzhifun);
        this.shouye_box.getChildByName("商城页面").getChildByName("是否购买").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.goumaifun);
        this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("昵称").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.zengsongfun2);
        this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.zengsongfun);
        this.shouye_box.getChildByName("果树").getChildByName("升级土地").on(Laya.Event.MOUSE_DOWN, this, this.sjtudi);
        this.shouye_box.getChildByName("果树").getChildByName("升级果树").on(Laya.Event.MOUSE_DOWN, this, this.sjguoshu);
        this.shouye_box.getChildByName("是否退出").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.tuichufun);
        this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, function () {
            if (!isduihuan2) {
                _this.duihuanfun2();
                isduihuan2 = true;
            }
        });
        this.shouye_box.getChildByName("提示框").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.yinxiaofun();
            this.shouye_box.getChildByName("提示框").visible = false;
        });
        this.shouye_box.getChildByName("设置按钮").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("设置").visible = true;
        });
        this.shouye_box.getChildByName("设置").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("设置").visible = false;
        });
        this.shouye_box.getChildByName("设置").getChildByName("音乐").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            isyinyue = false;
            Laya.SoundManager.stopMusic();
            this.shouye_box.getChildByName("设置").getChildByName("音乐").getChildByName("关闭").visible = false;
            this.shouye_box.getChildByName("设置").getChildByName("音乐").getChildByName("开启").visible = true;
        });
        this.shouye_box.getChildByName("设置").getChildByName("音乐").getChildByName("开启").on(Laya.Event.MOUSE_DOWN, this, function () {
            isyinyue = true;
            Laya.SoundManager.playMusic("res/bg.mp3", 0)
            this.shouye_box.getChildByName("设置").getChildByName("音乐").getChildByName("关闭").visible = true;
            this.shouye_box.getChildByName("设置").getChildByName("音乐").getChildByName("开启").visible = false;
        });
        this.shouye_box.getChildByName("设置").getChildByName("音效").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            isyinxiao = false;
            this.shouye_box.getChildByName("设置").getChildByName("音效").getChildByName("关闭").visible = false;
            this.shouye_box.getChildByName("设置").getChildByName("音效").getChildByName("开启").visible = true;
        });
        this.shouye_box.getChildByName("设置").getChildByName("音效").getChildByName("开启").on(Laya.Event.MOUSE_DOWN, this, function () {
            isyinxiao = true;
            this.shouye_box.getChildByName("设置").getChildByName("音效").getChildByName("关闭").visible = true;
            this.shouye_box.getChildByName("设置").getChildByName("音效").getChildByName("开启").visible = false;
        });
        this.shouye_box.getChildByName("头像列表").getChildByName("取消").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("头像列表").visible = false;
        });
        this.denglu_box.getChildByName("提示框").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.denglu_box.getChildByName("提示框").visible = false;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("个人收益").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("个人详情").visible = true;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("个人详情").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("个人详情").visible = false;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("直推收益").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("直推详情").visible = true;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("直推详情").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("直推详情").visible = false;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("团队收益").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("团队详情").visible = true;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("团队详情").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("团队详情").visible = false;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("分红收益").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("分红详情").visible = true;
        });
        this.shouye_box.getChildByName("收益页面").getChildByName("分红详情").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("收益页面").getChildByName("分红详情").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("兑换记录").getChildByName("关闭").on(Laya.Event.MOUSE_DOWN, this, function () {
            this.shouye_box.getChildByName("兑换页面").getChildByName("兑换记录").visible = false;
        });
        this.shouye_box.getChildByName("兑换页面").getChildByName("记录按钮").on(Laya.Event.MOUSE_DOWN, this, this.dhjilu);
        this.shouye_box.getChildByName("头像列表").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.touxiangfun);
        this.shouye_box.getChildByName("头像").on(Laya.Event.MOUSE_DOWN, this, this.touxianglist);
        this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, function () {
            if (!isduihuan) {
                this.tianxiefun();
                isduihuan = true;
            }
        });
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("上一页").on(Laya.Event.MOUSE_DOWN, this, this.shangyifun);
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("下一页").on(Laya.Event.MOUSE_DOWN, this, this.xiayifun);
        this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.mairufun);
        this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").getChildByName("确定").on(Laya.Event.MOUSE_DOWN, this, this.maichufun);
        this.denglu_box.getChildByName("忘记密码").getChildByName("提交").on(Laya.Event.MOUSE_DOWN, this, this.wangjifun);
        this.denglu_box.getChildByName("忘记密码").getChildByName("获取").on(Laya.Event.MOUSE_DOWN, this, this.hqyanzhengma);
        this.denglu_box.getChildByName("注册").getChildByName("获取").on(Laya.Event.MOUSE_DOWN, this, this.hqyanzhengma);
        this.denglu_box.getChildByName("注册").getChildByName("注册按钮").on(Laya.Event.MOUSE_DOWN, this, this.zhucefun);
        this.denglu_box.getChildByName("登录").getChildByName("登录按钮").on(Laya.Event.MOUSE_DOWN, this, this.denglufun);
        this.shouye_box.getChildByName("充值页面").getChildByName("记录查询").on(Laya.Event.MOUSE_DOWN, this, this.jilufun);
        this.shouye_box.getChildByName("个人中心页面").getChildByName("保存").on(Laya.Event.MOUSE_DOWN, this, this.baocunfun);
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
        this.shouyifun();
        $("#wx_skm").hide();
        $("#zfb_skm").hide();
        this.shouye_box.getChildByName("个人中心页面").visible = false;
        if (dengluarr.length != 0) {
            if (dengluarr[dengluarr.length - 1].jizhu1) {
                this.denglu_box.getChildByName("登录").getChildByName("账号").text = dengluarr[dengluarr.length - 1].jizhu1;
            } else {
                this.denglu_box.getChildByName("登录").getChildByName("账号").text = "";
            }
            if (dengluarr[dengluarr.length - 1].jizhu2) {
                this.denglu_box.getChildByName("登录").getChildByName("密码").text = dengluarr[dengluarr.length - 1].jizhu2;
            } else {
                this.denglu_box.getChildByName("登录").getChildByName("密码").text = "";
            }
        }
        this.list_shangcheng.vScrollBarSkin = "";
        Laya.SoundManager.playMusic("res/bg.mp3", 0)
        console.log("初始化……");
    }
    //时间轴
    _proto.timefun = function () {
        this.shouye_box.getChildByName("公告").x -= 1;
        if (this.shouye_box.getChildByName("公告").x <= -_this.shouye_box.getChildByName("公告").width) {
            this.shouye_box.getChildByName("公告").x = 750;
        }
        if (this.denglu_box.getChildByName("注册").visible) {
            isnum = 1;
        }
        if (this.denglu_box.getChildByName("忘记密码").visible) {
            isnum = 2;
        }
        this.shouye_box.getChildByName("果树").getChildByName("光效").rotation += 1;
        this.shouye_box.getChildByName("恭喜").getChildAt(1).rotation += 1;
        //this.testWx();
        //this.testQQ();
    }
    //倒计时
    _proto.daojishifun = function () {
        mytime = setInterval(function () {
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
    //登录方法
    _proto.denglufun = function () {
        if (this.denglu_box.getChildByName("登录").getChildByName("账号").text.length == 11 && _this.denglu_box.getChildByName("登录").getChildByName("密码").text.length > 5) {
            if (!regTel.test(this.denglu_box.getChildByName("登录").getChildByName("账号").text)) {
                _this.tktishi2("请输入正确的手机号!")
            } else {
                $.ajax({
                    url: "/home/login",
                    type: "POST",
                    data: {
                        tel: _this.denglu_box.getChildByName("登录").getChildByName("账号").text,
                        pwd: _this.denglu_box.getChildByName("登录").getChildByName("密码").text,
                    },
                    success: function (data) {
                        console.log("登录", data);
                        if (data.status != 1) {
                            _this.tktishi2(data.info)
                        } else {
                            yonghu_token = data.token;
                            setCookie("yonghu_token", yonghu_token);
                            var ishave = false;//账号是否相同
                            var ishave1 = false;//密码是否相同
                            var ishave2 = false;//是否记住密码，isjizhu是否一样
                            for (var i = 0; i < dengluarr.length; i++) {
                                if (_this.denglu_box.getChildByName("登录").getChildByName("账号").text == dengluarr[i].u) {
                                    ishave = true;
                                }
                                if (_this.denglu_box.getChildByName("登录").getChildByName("密码").text == dengluarr[i].p) {
                                    ishave1 = true;
                                }
                                if (isjizhu == dengluarr[i].isjizhu) {
                                    ishave2 = true;
                                }
                            }
                            dengluarr.push({
                                jizhu1: jizhuzhanghao == 1 ? _this.denglu_box.getChildByName("登录").getChildByName("账号").text : "",
                                jizhu2: jizhumima == 1 ? _this.denglu_box.getChildByName("登录").getChildByName("密码").text : "",
                            })
                            if (ishave && !ishave1 || ishave && !ishave2) {
                                for (var i = 0; i < dengluarr.length; i++) {
                                    if (_this.denglu_box.getChildByName("登录").getChildByName("账号").text == dengluarr[i].u) {
                                        dengluarr[i].u = _this.denglu_box.getChildByName("登录").getChildByName("账号").text;
                                        dengluarr[i].p = isjizhu == 1 ? _this.denglu_box.getChildByName("登录").getChildByName("密码").text : "";
                                        dengluarr[i].isjizhu = isjizhu;
                                    }
                                }
                            }
                            setCookie("dengluarr", JSON.stringify(dengluarr));
                            _this.reset();
                            _this.denglu_box.visible = false;
                            _this.shouye_box.visible = true;
                        }
                    }
                })
            }
        } else {
            _this.tktishi2("请填写完整的账号密码!")
        }
    }
    //注册方法
    _proto.zhucefun = function () {
        if (this.denglu_box.getChildByName("注册").getChildByName("手机账号").text.length == 11) {
            if (!regTel.test(this.denglu_box.getChildByName("注册").getChildByName("手机账号").text)) {
                _this.tktishi2("请输入正确的手机号码!")
            } else {
                if (this.denglu_box.getChildByName("注册").getChildByName("真实姓名").text != "") {
                    if (!regName.test(this.denglu_box.getChildByName("注册").getChildByName("真实姓名").text)) {
                        _this.tktishi2("请输入正确的真实姓名!")
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
                                                        if (data.status == 1) {
                                                            _this.tktishi2("注册成功!")
                                                            _this.denglu_box.getChildByName("注册").visible = false;
                                                            _this.denglu_box.getChildByName("登录").visible = true;
                                                        } else {
                                                            _this.tktishi2(data.info)
                                                        }
                                                    }
                                                })
                                            } else {
                                                _this.tktishi2("请点击获取验证码!");
                                            }
                                        } else {
                                            _this.tktishi2("两次输入的密码不一致!");
                                        }
                                    } else {
                                        _this.tktishi2("请输入验证码!");
                                    }
                                } else {
                                    _this.tktishi2("请确认密码!");
                                }
                            } else {
                                _this.tktishi2("请输入密码!");
                            }
                        } else {
                            _this.tktishi2("请输入游戏昵称!");
                        }
                    }
                } else {
                    _this.tktishi2("请输入真实姓名!");
                }
            }
        } else {
            _this.tktishi2("请输入手机号码!");
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
                        daojishinum = 60;
                        _this.daojishifun();
                        _this.denglu_box.getChildByName("注册").getChildByName("获取").visible = false;
                        _this.denglu_box.getChildByName("注册").getChildByName("倒计时").visible = true;
                    }
                })
            } else {
                _this.tktishi2("请输入完整的手机号!")
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
                        daojishinum2 = 60;
                        _this.daojishifun2();
                        _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").visible = false;
                        _this.denglu_box.getChildByName("忘记密码").getChildByName("倒计时").visible = true;
                    }
                })
            } else {
                _this.tktishi2("请输入完整的手机号!");
                _this.denglu_box.getChildByName("忘记密码").getChildByName("获取").mouseEnabled = true;
            }
        }
    }
    //忘记密码提交
    _proto.wangjifun = function () {
        if (this.denglu_box.getChildByName("忘记密码").getChildByName("手机账号").text.length == 11) {
            if (this.denglu_box.getChildByName("忘记密码").getChildByName("验证码").text != "") {
                if (this.denglu_box.getChildByName("忘记密码").getChildByName("新密码").text != "") {
                    if (this.denglu_box.getChildByName("忘记密码").getChildByName("确认密码").text != "") {
                        if (this.denglu_box.getChildByName("忘记密码").getChildByName("新密码").text == this.denglu_box.getChildByName("忘记密码").getChildByName("确认密码").text) {
                            if (isdian2) {
                                $.ajax({
                                    url: "/home/backPwd",
                                    type: "POST",
                                    data: {
                                        tel: _this.denglu_box.getChildByName("忘记密码").getChildByName("手机账号").text,
                                        code: _this.denglu_box.getChildByName("忘记密码").getChildByName("验证码").text,
                                        pwd: _this.denglu_box.getChildByName("忘记密码").getChildByName("新密码").text,
                                        r_pwd: _this.denglu_box.getChildByName("忘记密码").getChildByName("确认密码").text,
                                    },
                                    success: function (data) {
                                        if (data.status == 1) {
                                            _this.tktishi2("修改成功!")
                                            _this.denglu_box.getChildByName("忘记密码").visible = false;
                                            _this.denglu_box.getChildByName("登录").visible = true;
                                        }
                                        if (data.status == 2) {
                                            _this.tktishi2(data.info)
                                        }
                                        if (data.status == 3) {
                                            _this.tktishi2(data.info)
                                        }
                                    }
                                })
                            } else {
                                _this.tktishi2("请点击获取验证码!");
                            }
                        } else {
                            _this.tktishi2("两次输入的密码不一致!");
                        }
                    } else {
                        _this.tktishi2("请确认密码!");
                    }
                } else {
                    _this.tktishi2("请输入新密码!");
                }
            } else {
                _this.tktishi2("请输入验证码!");
            }
        } else {
            _this.tktishi2("请输入完整的手机号!");
        }
    }
    //退出登录
    _proto.tuichufun = function () {
        $.ajax({
            url: "/home/logout",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                if (data.status == 1) {
                    _this.reset();
                    _this.yinxiaofun();
                    _this.shouye_box.getChildByName("是否退出").visible = false;
                    _this.shouye_box.visible = false;
                    _this.denglu_box.visible = true;
                }
            }
        })
    }
    //升级土地
    _proto.sjtudi = function () {
        if (!isshengji1) {
            isshengji1 = true;
            $.ajax({
                url: "/home/upgradeLand",
                type: "POST",
                data: {
                    token: yonghu_token,
                },
                success: function (data) {
                    Laya.timer.once(800, this, function () {
                        _this.shouye_box.getChildByName("果树").getChildAt(5).visible = false;
                        _this.shouye_box.getChildByName("果树").getChildAt(5).autoPlay = false;
                        _this.shouye_box.getChildByName("果树").getChildAt(5).index = 1;
                    })
                    if (data.status == 1) {
                        if (isyinxiao) {
                            Laya.SoundManager.playSound("res/shengji.mp3", 1)
                        }
                        Laya.timer.once(800, this, function () {
                            isshengji1 = false;
                            _this.shouye_box.getChildByName("恭喜").visible = true;
                            _this.shouye_box.getChildByName("恭喜").getChildAt(3).text = "恭喜您升到" + tudi_lv + "级土地";
                        })
                        _this.shouye_box.getChildByName("果树").getChildAt(5).visible = true;
                        _this.shouye_box.getChildByName("果树").getChildAt(5).autoPlay = true;
                        _this.hqyonghu();
                    } else {
                        _this.tktishi(data.info);
                    }
                }
            })
        }
    }
    //升级果树 www.zgymw.com
    _proto.sjguoshu = function () {
        if (!isshengji2) {
            isshengji2 = true;
            $.ajax({
                url: "/home/upgradeFruitTree",
                type: "POST",
                data: {
                    token: yonghu_token,
                },
                success: function (data) {
                    Laya.timer.once(800, this, function () {
                        _this.shouye_box.getChildByName("果树").getChildAt(5).visible = false;
                        _this.shouye_box.getChildByName("果树").getChildAt(5).autoPlay = false;
                        _this.shouye_box.getChildByName("果树").getChildAt(5).index = 1;
                    })
                    if (data.status == 1) {
                        if (isyinxiao) {
                            Laya.SoundManager.playSound("res/shengji.mp3", 1)
                        }
                        Laya.timer.once(800, this, function () {
                            isshengji2 = false;
                            _this.shouye_box.getChildByName("恭喜").visible = true;
                            _this.shouye_box.getChildByName("恭喜").getChildAt(3).text = "恭喜您升到" + guoshu_lv + "级果树";
                        })
                        _this.shouye_box.getChildByName("果树").getChildAt(5).visible = true;
                        _this.shouye_box.getChildByName("果树").getChildAt(5).autoPlay = true;
                        _this.hqyonghu();
                    } else {
                        _this.tktishi(data.info);
                    }
                }
            })
        }
    }
    //获取公告
    _proto.hqgonggao = function () {
        $.ajax({
            url: "/home/notice",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                _this.shouye_box.getChildByName("公告").text = data.notice;
                _this.shouye_box.getChildByName("充值页面").getChildByName("比例").text = data.recharge_ratio;
            }
        })
    }
    //客服二维码
    _proto.kfewm = function () {
        $.ajax({
            url: "/home/customer",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                $("#kf_ewm").attr("src", data.img)
            }
        })
    }
    //获取鲜果价格
    _proto.hqjiage = function () {
        $.ajax({
            url: "/home/fruitPrice",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                mairu_jiage = data.buy;
                maichu_jiage = data.sell;
                _this.shouye_box.getChildByName("交易页面").getChildByName("买入价格").text = "当前买入价格:" + data.buy;
                _this.shouye_box.getChildByName("交易页面").getChildByName("卖出价格").text = "当前卖出价格:" + data.sell;
            }
        })
    }
    var user_id;
    //获取用户信息
    _proto.hqyonghu = function () {
        $.ajax({
            url: "/home/getMember",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                qqhao = false;
                weixinhao = false;
                console.log("获取用户信息", data);
                if (data.errcode) {
                    _this.denglu_box.visible = true;
                    _this.shouye_box.visible = false;
                } else {
                    user_id = data.id;
                    WXnum = data.wx_num;
                    QQnum = data.qq_num;
                    jinbinum = data.gold;
                    xianguonum = data.fruit_num;
                    tudi_lv = data.lv_land;
                    guoshu_lv = data.lv;
                    huishou_id = data.t_id;
                    _this.shouye_box.getChildByName("团队页面").getChildByName("分红").text = "当前" + data.deirect_per + " " + data.team_per + " " + data.market_per;
                    _this.shouye_box.getChildByName("回收提示").getChildByName("提示").text = data.recycle;
                    //一级土地
                    if (data.lv_land == 1) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu1.png";
                    }
                    //二级土地
                    if (data.lv_land == 2) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu2.png";
                    }
                    //三级土地
                    if (data.lv_land == 3) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu3.png";
                    }
                    //四级土地
                    if (data.lv_land == 4) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu4.png";
                    }
                    //五级土地
                    if (data.lv_land == 5) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu5.png";
                    }
                    //六级土地
                    if (data.lv_land == 6) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu6.png";
                    }
                    //七级土地
                    if (data.lv_land == 7) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/tu7.png";
                    }
                    //八级土地
                    if (data.lv_land == 8) {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").pos(52, 376);
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").skin = "comp/shu/333.png";
                    } else {
                        _this.shouye_box.getChildByName("果树").getChildByName("土地").pos(88, 376);
                    }
                    //一级果树
                    if (data.lv == 1) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/1ji.png";
                    }
                    //二级果树
                    if (data.lv == 2) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/2ji.png";
                    }
                    //三级果树
                    if (data.lv == 3) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/3ji.png";
                    }
                    //四级果树
                    if (data.lv == 4) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/4ji.png";
                    }
                    //五级果树
                    if (data.lv == 5) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/5ji.png";
                    }
                    //六级果树
                    if (data.lv == 6) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/6ji.png";
                    }
                    //七级果树
                    if (data.lv == 7) {
                        _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/7ji.png";
                    }
                    //八级果树
                    if (data.lv == 8) {
                        iszuigao = true;
                        if (data.t_id == 8) {
                            guoshu = "cai";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = false;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = false;
                            _this.shouye_box.getChildByName("果树").getChildByName("光效").visible = true;
                            _this.shouye_box.getChildByName("果树").getChildByName("云1").visible = true;
                            _this.shouye_box.getChildByName("果树").getChildByName("云2").visible = true;
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/cai.png";
                            Laya.timer.once(2000, this, function () {
                                $.ajax({
                                    url: "/home/recycle",
                                    type: "POST",
                                    data: {
                                        token: yonghu_token,
                                        t_id: 8,
                                    },
                                    success: function (data) {
                                        if (data.status == 1) {
                                            _this.tktishi("回收成功!")
                                            _this.shouye_box.getChildByName("回收按钮").visible = false;
                                            _this.shouye_box.getChildByName("果树").getChildByName("光效").visible = false;
                                            _this.shouye_box.getChildByName("果树").getChildByName("云1").visible = false;
                                            _this.shouye_box.getChildByName("果树").getChildByName("云2").visible = false;
                                            _this.hqyonghu();
                                        } else {
                                            _this.tktishi(data.info);
                                        }
                                    }
                                })
                            })
                        } else {
                            _this.shouye_box.getChildByName("回收按钮").visible = true;
                            _this.shouye_box.getChildByName("果树").getChildByName("光效").visible = false;
                            _this.shouye_box.getChildByName("果树").getChildByName("云1").visible = false;
                            _this.shouye_box.getChildByName("果树").getChildByName("云2").visible = false;
                        }
                        if (data.t_id == 9) {
                            guoshu = "jin";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/duijin.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/jin.png";
                        }
                        if (data.t_id == 10) {
                            guoshu = "mu";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/zhenmu.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/mu.png";
                        }
                        if (data.t_id == 11) {
                            guoshu = "shui";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/kanshui.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/shui.png";
                        }
                        if (data.t_id == 12) {
                            guoshu = "huo";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/lihuo.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/huo.png";
                        }
                        if (data.t_id == 13) {
                            guoshu = "tu";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/kuntu.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/tu.png";
                        }
                        if (data.t_id == 14) {
                            guoshu = "bai";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/baijin.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/bai.png";
                        }
                        if (data.t_id == 15) {
                            guoshu = "zuan";
                            _this.shouye_box.getChildByName("果树").getChildAt(6).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).visible = true;
                            _this.shouye_box.getChildByName("果树").getChildAt(7).skin = "comp/shu/zuanshi.png";
                            _this.shouye_box.getChildByName("果树").getChildByName("树苗").skin = "comp/shu/zuan.png";
                        }
                    } else {
                        _this.shouye_box.getChildByName("回收按钮").visible = false;
                        _this.shouye_box.getChildByName("果树").getChildAt(6).visible = false;
                        _this.shouye_box.getChildByName("果树").getChildAt(7).visible = false;
                    }
                    if (data.upgrade_land == 1) {
                        _this.shouye_box.getChildByName("果树").getChildByName("升级土地").visible = true;
                    } else {
                        _this.shouye_box.getChildByName("果树").getChildByName("升级土地").visible = false;
                    }
                    if (data.upgrade_fruit_tree == 1) {
                        _this.shouye_box.getChildByName("果树").getChildByName("升级果树").visible = true;
                    } else {
                        _this.shouye_box.getChildByName("果树").getChildByName("升级果树").visible = false;
                    }
                    if (data.wx_num != null) {
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").visible = false;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").visible = true;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").text = data.wx_num;
                    } else {
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").visible = true;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").visible = false;
                    }
                    if (data.qq_num != null) {
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").visible = false;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").visible = true;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").text = data.qq_num;
                    } else {
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").visible = true;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").visible = false;
                    }
                    if (data.wx == null || data.wx == "") {
                        WX_image = null;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("上传微信").skin = "comp/peitao/dianji.png";
                    } else {
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("上传微信").skin = data.wx;
                    }
                    if (data.zfb == null || data.zfb == "") {
                        ZFB_image = null;
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("上传支付宝").skin = "comp/peitao/dianji.png";
                    } else {
                        _this.shouye_box.getChildByName("个人中心页面").getChildByName("上传支付宝").skin = data.zfb;
                    }
                    _this.shouye_box.getChildByName("头像").skin = data.head;
                    _this.shouye_box.getChildByName("昵称").text = data.nickname;
                    _this.shouye_box.getChildByName("id").text = data.id;
                    _this.shouye_box.getChildByName("金币数量").text = data.gold;
                    _this.shouye_box.getChildByName("市场鲜果").text = data.fruit_count;
                    _this.shouye_box.getChildByName("鲜果").text = data.fruit_num;
                    if (data.lv != 8) {
                        _this.shouye_box.getChildByName("果树等级").text = data.lv + "级";
                    } else {
                        _this.shouye_box.getChildByName("果树等级").text = "特殊";
                    }
                    if (data.lv_land != 8) {
                        _this.shouye_box.getChildByName("农场等级").text = data.lv_land + "级";
                    } else {
                        _this.shouye_box.getChildByName("农场等级").text = "特殊";
                    }
                    _this.shouye_box.getChildByName("个人中心页面").getChildByName("头像").skin = data.head;
                    _this.shouye_box.getChildByName("个人中心页面").getChildByName("昵称").text = data.nickname;
                    _this.shouye_box.getChildByName("个人中心页面").getChildByName("id").text = data.id;
                }
            }
        })
    }
    //头像列表
    _proto.touxianglist = function () {
        arr_touxiang = [];
        this.list_touxiang.array = arr_touxiang;
        $.ajax({
            url: "/home/headImgList",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                for (var i = 0; i < data.length; i++) {
                    arr_touxiang.push({
                        id: data[i].id,
                        头像: data[i].head,
                        选中: "",
                    })
                }
                _this.list_touxiang.array = arr_touxiang;
                _this.list_touxiang.vScrollBarSkin = "";
                _this.list_touxiang.mouseHandler = new Laya.Handler(this, onMouse_touxiang);
                function onMouse_touxiang(e, index) {
                    if (e.type == "click") {
                        touxiangid = arr_touxiang[index].id;
                        for (var j = 0; j < data.length; j++) {
                            arr_touxiang[j].选中 = "";
                        }
                        arr_touxiang[index].选中 = "comp/touxiang/xuanzhong.png";
                        _this.list_touxiang.array = arr_touxiang;
                    }
                }
            }
        })
        this.shouye_box.getChildByName("头像列表").visible = true;
    }
    //更换头像
    _proto.touxiangfun = function () {
        $.ajax({
            url: "/home/chooseHeadImg",
            type: "POST",
            data: {
                token: yonghu_token,
                id: touxiangid,
            },
            success: function (data) {
                if (data.status == 1) {
                    _this.shouye_box.getChildByName("头像列表").visible = false;
                    _this.tktishi("修改头像成功!");
                    _this.hqyonghu();
                } else {
                    _this.tktishi(data.info)
                }
            }
        })
    }
    //市场页面
    _proto.shichangfun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/market",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                _this.hqyonghu();
                _this.shouye_box.getChildByName("市场页面").getChildByName("市场总鲜果数").text = data.shichang_all_num
                _this.shouye_box.getChildByName("市场页面").getChildByName("今日鲜果数目").text = data.today_num;
                _this.shouye_box.getChildByName("市场页面").getChildByName("已分红鲜果数").text = data.profit_num;
                _this.shouye_box.getChildByName("市场页面").getChildByName("剩余果实数目").text = data.surplus
                _this.shouye_box.getChildByName("市场页面").getChildByName("累计鲜果总数").text = data.all_num;
                _this.shouye_box.getChildByName("市场页面").getChildByName("发放鲜果总数").text = data.issue;
            }
        })
        this.shouye_box.getChildByName("市场页面").visible = true;
    }
    //交易页面
    _proto.jiaoyifun = function () {
        _this.yinxiaofun();
        this.shouye_box.getChildByName("交易页面").visible = true;
    }
    //买入水果
    _proto.mairufun = function () {
        if (jinbinum >= mairunum * mairu_jiage) {
            $.ajax({
                url: "/home/buyFruit",
                type: "POST",
                data: {
                    token: yonghu_token,
                    num: mairunum,
                },
                success: function (data) {
                    if (data.status == 1) {
                        _this.tktishi("买入成功!")
                        _this.hqyonghu();
                        _this.shouye_box.getChildByName("交易页面").getChildByName("买入页面").visible = false;
                    }
                }
            })
        } else {
            _this.tktishi("金币不足!")
        }
    }
    //卖出水果
    _proto.maichufun = function () {
        if (xianguonum >= maichunum * maichu_jiage) {
            $.ajax({
                url: "/home/sellFruit",
                type: "POST",
                data: {
                    token: yonghu_token,
                    num: maichunum,
                },
                success: function (data) {
                    if (data.status == 1) {
                        _this.tktishi("卖出成功!")
                        _this.hqyonghu();
                        _this.shouye_box.getChildByName("交易页面").getChildByName("卖出页面").visible = false;
                    }
                }
            })
        } else {
            _this.tktishi("鲜果数量不足!")
        }
    }
    //赠送水果
    _proto.zengsongfun = function () {
        if (this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("id").text != "" && this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("数量").text != "") {
            if (this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("id").text.length > 4) {
                if (!regNum.test(this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("id").text)) {
                    _this.tktishi("请输入正确的ID!")
                } else {
                    if (!regNum.test(this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("数量").text)) {
                        _this.tktishi("请输入正确的鲜果数量!")
                    } else {
                        if (parseInt(this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("数量").text) != 0) {
                            if (parseInt(this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("数量").text) <= xianguonum) {
                                $.ajax({
                                    url: "/home/giveFruit",
                                    type: "POST",
                                    data: {
                                        token: yonghu_token,
                                        id: _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("id").text,
                                        num: _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("数量").text,
                                    },
                                    success: function (data) {
                                        if (data.status == 1) {
                                            _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("昵称").getChildByName("昵称").text = data.nickname;
                                            _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("昵称").visible = true;
                                        } else {
                                            _this.tktishi(data.info)
                                        }
                                    }
                                })
                            } else {
                                _this.tktishi("鲜果数量不足!")
                            }
                        } else {
                            _this.tktishi("数量不能为0!")
                        }
                    }
                }
            } else {
                _this.tktishi("请输入正确的ID")
            }
        } else {
            _this.tktishi("请输入完整的信息!")
        }
    }
    _proto.zengsongfun2 = function () {
        $.ajax({
            url: "/home/affirmGive",
            type: "POST",
            data: {
                token: yonghu_token,
                id: _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("id").text,
                num: _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("数量").text,
            },
            success: function (data) {
                if (data.status == 1) {
                    _this.tktishi("赠送成功!")
                    _this.hqyonghu();
                    _this.shouye_box.getChildByName("交易页面").getChildByName("赠送页面").getChildByName("昵称").visible = false;
                } else {
                    _this.tktishi(data.info)
                }
            }
        })
    }
    //收益页面
    _proto.shouyifun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/explain",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                _this.shouye_box.getChildByName("收益页面").getChildByName("个人详情").getChildByName("图片").skin = data.person_img;
                _this.shouye_box.getChildByName("收益页面").getChildByName("直推详情").getChildByName("图片").skin = data.direct_img;
                _this.shouye_box.getChildByName("收益页面").getChildByName("团队详情").getChildByName("图片").skin = data.team_img;
                _this.shouye_box.getChildByName("收益页面").getChildByName("分红详情").getChildByName("图片").skin = data.profit_img;
                _this.shouye_box.getChildByName("收益页面").getChildByName("对比详情").getChildAt(0).skin = data.other_img;
            }
        })
    }
    //观光页面
    _proto.guanguangfun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/tour",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                _this.shouye_box.getChildByName("观光页面").getChildByName("钻石果树").getChildAt(1).text = data.zs.z_shi;
                _this.shouye_box.getChildByName("观光页面").getChildByName("钻石果树").getChildAt(2).text = data.zs.z_fou;
                _this.shouye_box.getChildByName("观光页面").getChildByName("钻石果树").getChildAt(3).text = data.zs.z_per;
                _this.shouye_box.getChildByName("观光页面").getChildByName("白金果树").getChildAt(1).text = data.bj.b_shi;
                _this.shouye_box.getChildByName("观光页面").getChildByName("白金果树").getChildAt(2).text = data.bj.b_fou;
                _this.shouye_box.getChildByName("观光页面").getChildByName("白金果树").getChildAt(3).text = data.bj.b_per;
                _this.shouye_box.getChildByName("观光页面").getChildByName("五行果树").getChildAt(1).text = data.wx.w_shi;
                _this.shouye_box.getChildByName("观光页面").getChildByName("五行果树").getChildAt(2).text = data.wx.w_fou;
                _this.shouye_box.getChildByName("观光页面").getChildByName("五行果树").getChildAt(3).text = data.wx.w_per;
            }
        })
        this.shouye_box.getChildByName("观光页面").visible = true;
    }
    //团队页面
    _proto.tuanduifun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/myTeam",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                zongyeshu = data.direct.page_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("人数").text = data.direct.person_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("比例").text = data.direct.lv_rewards;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("收益").text = data.direct.get_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").getChildByName("人数").text = data.team.person_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").getChildByName("比例").text = data.team.lv_rewards;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队详情").getChildByName("收益").text = data.team.get_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推").getChildByName("人数").text = data.direct.person_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推").getChildByName("收益").text = data.direct.commission_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推").getChildByName("奖励等级").text = data.direct.lv_rewards;
                _this.shouye_box.getChildByName("团队页面").getChildByName("直推").getChildByName("收获").text = data.direct.get_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队").getChildByName("人数").text = data.team.person_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队").getChildByName("收益").text = data.team.commission_num;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队").getChildByName("奖励等级").text = data.team.lv_rewards;
                _this.shouye_box.getChildByName("团队页面").getChildByName("团队").getChildByName("收获").text = data.team.get_num;
            }
        })
        this.shouye_box.getChildByName("团队页面").visible = true;
    }
    //上一页
    _proto.shangyifun = function () {
        if (yeshunum > 1) {
            yeshunum -= 1;
        }
        downtime2 = 10;
        Laya.timer.frameLoop(2, this, function () {
            downtime2--;
            if (downtime2 <= 0) {
                if (yeshunum > 1) {
                    yeshunum -= 1;
                    _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = yeshunum;
                }
            }
        });
        $.ajax({
            url: "/home/myDirectDetail",
            type: "POST",
            data: {
                token: yonghu_token,
                page: yeshunum,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_zhitui = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_zhitui.push({
                            头像: data[i].head,
                            id: data[i].id,
                            农场等级: data[i].lv_land,
                            果树等级: data[i].lv,
                            收益: data[i].commission_num,
                            团队人数: data[i].person_num,
                        })
                    }
                    //_this.list_zhitui.vScrollBarSkin = "";
                    _this.list_zhitui.array = arr_zhitui;
                    _this.list_zhitui.visible = true;
                    console.log(yeshunum)
                    _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = yeshunum;
                } else {
                    _this.list_zhitui.visible = false;
                }
            }
        })
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("上一页").on(Laya.Event.MOUSE_UP, this, this.likaifun);
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("上一页").on(Laya.Event.MOUSE_OUT, this, this.likaifun2);
    }
    //下一页
    _proto.xiayifun = function () {
        if (yeshunum < zongyeshu) {
            yeshunum += 1;
        };
        downtime2 = 10;
        Laya.timer.frameLoop(2, this, function () {
            downtime2--;
            if (downtime2 <= 0) {
                if (yeshunum < zongyeshu) {
                    yeshunum += 1;
                    _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = yeshunum;
                }
            }
        });
        $.ajax({
            url: "/home/myDirectDetail",
            type: "POST",
            data: {
                token: yonghu_token,
                page: yeshunum,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_zhitui = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_zhitui.push({
                            头像: data[i].head,
                            id: data[i].id,
                            农场等级: data[i].lv_land,
                            果树等级: data[i].lv,
                            收益: data[i].commission_num,
                            团队人数: data[i].person_num,
                        })
                    }
                    //_this.list_zhitui.vScrollBarSkin = "";
                    _this.list_zhitui.array = arr_zhitui;
                    _this.list_zhitui.visible = true;
                    console.log(yeshunum)
                    _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = yeshunum;
                } else {
                    _this.list_zhitui.visible = false;
                }
            }
        })
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("下一页").on(Laya.Event.MOUSE_UP, this, this.likaifun);
        this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("下一页").on(Laya.Event.MOUSE_OUT, this, this.likaifun2);
    }
    _proto.likaifun = function () {
        $.ajax({
            url: "/home/myDirectDetail",
            type: "POST",
            data: {
                token: yonghu_token,
                page: yeshunum,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_zhitui = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_zhitui.push({
                            头像: data[i].head,
                            id: data[i].id,
                            农场等级: data[i].lv_land,
                            果树等级: data[i].lv,
                            收益: data[i].commission_num,
                            团队人数: data[i].person_num,
                        })
                    }
                    //_this.list_zhitui.vScrollBarSkin = "";
                    _this.list_zhitui.array = arr_zhitui;
                    _this.list_zhitui.visible = true;
                    console.log(yeshunum)
                    _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = yeshunum;
                } else {
                    _this.list_zhitui.visible = false;
                }
            }
        })
        downtime2 = 10;
        Laya.timer.clearAll(this);
    }
    _proto.likaifun2 = function () {
        $.ajax({
            url: "/home/myDirectDetail",
            type: "POST",
            data: {
                token: yonghu_token,
                page: yeshunum,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_zhitui = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_zhitui.push({
                            头像: data[i].head,
                            id: data[i].id,
                            农场等级: data[i].lv_land,
                            果树等级: data[i].lv,
                            收益: data[i].commission_num,
                            团队人数: data[i].person_num,
                        })
                    }
                    //_this.list_zhitui.vScrollBarSkin = "";
                    _this.list_zhitui.array = arr_zhitui;
                    _this.list_zhitui.visible = true;
                    console.log(yeshunum)
                    _this.shouye_box.getChildByName("团队页面").getChildByName("直推详情").getChildByName("页数").text = yeshunum;
                } else {
                    _this.list_zhitui.visible = false;
                }
            }
        })
        downtime2 = 10;
        Laya.timer.clearAll(this);
    }
    //兑换页面
    var ttttt = 0;
    var duihuan_zt;
    _proto.duihuanfun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/exchangeList",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_duihuan = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_duihuan.push({
                            id: data[i].id,
                            图片: data[i].img,
                            名字: data[i].title,
                            注释: data[i].desc,
                            金币: data[i].price,
                            状态: data[i].status,
                            库存: data[i].stock,
                            数量: 1,
                        })
                    }
                    for (var i = 0; i < arr_duihuan.length; i++) {
                        if (arr_duihuan[i].库存 > 0) {
                            // _this.list_duihuan._childs[0]._childs[i].disabled=false;
                            _this.list_duihuan._cells[i].disabled = false;
                        } else {
                            // _this.list_duihuan._childs[0]._childs[i].disabled=true;
                            _this.list_duihuan._cells[i].disabled = true;
                        }
                    }
                    _this.list_duihuan.array = arr_duihuan;
                    _this.list_duihuan.mouseHandler = new Laya.Handler(this, onMouse_duihuan);
                    function onMouse_duihuan(e, index) {
                        if (e.type == "click") {
                            if (e.target.name == "兑换") {
                                duihuanid = arr_duihuan[index].id;
                                duihuanjinbi = arr_duihuan[index].金币;
                                duihuan_zt = arr_duihuan[index].状态;
                                dijige = index;
                                _this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = true;
                                _this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").getChildByName("内容").text = "是否花费金币" + arr_duihuan[index].金币 * _this.list_duihuan._childs[0]._childs[index]._childs[8]._childs[0].text + "兑换" + arr_duihuan[index].名字 + "吗?";
                            }
                            if (e.target.name == "增加") {
                                if (!isbianhua) {
                                    if (arr_duihuan[index].数量 < arr_duihuan[index].库存) {
                                        arr_duihuan[index].数量 += 1;
                                    }
                                    _this.list_duihuan.array = arr_duihuan;
                                }
                            }
                            if (e.target.name == "减少") {
                                if (!isbianhua) {
                                    if (arr_duihuan[index].数量 > 1) {
                                        arr_duihuan[index].数量 -= 1;
                                    }
                                    _this.list_duihuan.array = arr_duihuan;
                                }
                            }
                        }
                        if (e.type == "mousedown") {
                            if (e.target.name == "增加") {
                                downtime = 10;
                                Laya.timer.frameLoop(2, this, function () {
                                    downtime--;
                                    if (downtime <= 0) {
                                        if (bianhuanum < arr_duihuan[index].库存) {
                                            bianhuanum = arr_duihuan[index].数量;
                                            bianhuanum++;
                                            isbianhua = true;
                                        }
                                        arr_duihuan[index].数量 = bianhuanum;
                                        _this.list_duihuan.array = arr_duihuan;
                                    }
                                });
                            }
                            if (e.target.name == "减少") {
                                downtime = 10;
                                Laya.timer.frameLoop(2, this, function () {
                                    downtime--;
                                    if (downtime <= 0) {
                                        if (bianhuanum > 1) {
                                            bianhuanum = arr_duihuan[index].数量;
                                            bianhuanum--;
                                            isbianhua = true;
                                        }
                                        arr_duihuan[index].数量 = bianhuanum;
                                        _this.list_duihuan.array = arr_duihuan;
                                    }
                                })
                            }
                        }
                        if (e.type == "mouseout") {
                            Laya.timer.clearAll(this);
                            downtime = 10;
                            isbianhua = false;
                            _this.list_duihuan.array = arr_duihuan;
                        }
                        if (e.type == "mouseup") {
                            Laya.timer.clearAll(this);
                            downtime = 10;
                            isbianhua = false;
                            _this.list_duihuan.array = arr_duihuan;
                        }
                    }
                    _this.list_duihuan.visible = true;
                } else {
                    _this.list_duihuan.visible = false;
                }
            }
        })
        this.shouye_box.getChildByName("兑换页面").visible = true;
    }
    //长按
    _proto.jishifun = function () {

    }
    //兑换记录
    _proto.dhjilu = function () {
        $.ajax({
            url: "/home/exchangeListLog",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                arr_dljl = [];
                for (var i = 0; i < data.length; i++) {
                    arr_dljl.push({
                        name: data[i].title,
                        num: data[i].num,
                        time: data[i].create_date,
                        status: data[i].status,
                    })
                }
                _this.list_dhjl.array = arr_dljl;
                _this.list_dhjl.vScrollBarSkin = "";
                _this.shouye_box.getChildByName("兑换页面").getChildByName("兑换记录").visible = true;
            }
        })
    }
    //兑换方法
    _proto.duihuanfun2 = function () {
        if (jinbinum >= duihuanjinbi) {
            $.ajax({
                url: "/home/exchangeOrder",
                type: "POST",
                data: {
                    token: yonghu_token,
                    id: duihuanid,
                    num: _this.list_duihuan._childs[0]._childs[dijige]._childs[8]._childs[0].text,
                },
                success: function (data) {
                    isduihuan2 = false;
                    if (duihuan_zt == 2) {
                        if (data.status == 3) {
                            _this.tktishi("请填写个人信息!")
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
                            _this.shouye_box.getChildByName("兑换页面").visible = false;
                            _this.shouye_box.getChildByName("个人中心页面").visible = true;
                            $("#wx_skm").show();
                            $("#zfb_skm").show();
                            $("#wx_skm").css("z-index", "9999999999");
                            $("#zfb_skm").css("z-index", "9999999999")
                        } else if (data.status == 1) {
                            _this.hqyonghu();
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("成功").visible = true;
                        } else {
                            _this.tktishi(data.info)
                        }
                    }
                    if (duihuan_zt == 1) {
                        if (data.status == 3) {
                            _this.tktishi(data.info)
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("资料").visible = true;
                        } else if (data.status == 1) {
                            _this.tktishi("兑换成功!")
                            _this.hqyonghu();
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("是否兑换").visible = false;
                            _this.shouye_box.getChildByName("兑换页面").getChildByName("成功").visible = true;
                        } else {
                            _this.tktishi(data.info)
                        }
                    }
                }
            })
        } else {
            _this.tktishi("金币不足!")
        }
    }
    //填写资料
    _proto.tianxiefun = function () {
        if (this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("姓名").text != "") {
            if (this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("电话").text.length == 11) {
                if (this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("地址").text != "") {
                    if (!regTel.test(this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("电话").text)) {
                        _this.tktishi("请填写正确的电话号码!");
                    } else {
                        $.ajax({
                            url: "/home/exchangeOrder",
                            type: "POST",
                            data: {
                                token: yonghu_token,
                                id: duihuanid,
                                num: duihuannum,
                                name: _this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("姓名").text,
                                tel: _this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("电话").text,
                                address: _this.shouye_box.getChildByName("兑换页面").getChildByName("资料").getChildByName("地址").text,
                            },
                            success: function (data) {
                                isduihuan = false;
                                if (data.status == 1) {
                                    _this.shouye_box.getChildByName("兑换页面").getChildByName("成功").visible = true;
                                    _this.shouye_box.getChildByName("兑换页面").getChildByName("资料").visible = false;
                                } else {
                                    _this.tktishi(data.info)
                                }
                            }
                        })
                    }
                } else {
                    _this.tktishi("请填写地址!");
                }
            } else {
                _this.tktishi("请填写电话!");
            }
        } else {
            _this.tktishi("请填写姓名!");
        }
    }
    //排行榜页面
    _proto.paihangfun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/rank",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_paihang = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_paihang.push({
                            名次: i + 1,
                            奖牌: i == 0 ? "comp/peitao/pai1.png" : i == 1 ? "comp/peitao/pai2.png" : i == 2 ? "comp/peitao/pai3.png" : "",
                            头像: data[i].head,
                            昵称: data[i].nickname,
                            id: data[i].id,
                            果树: data[i].name,
                            数量: data[i].num,
                        })
                    }
                    _this.list_paihangbang.vScrollBarSkin = "";
                    _this.list_paihangbang.array = arr_paihang;
                    _this.list_paihangbang.visible = true;
                } else {
                    _this.list_paihangbang.visible = false;
                }
            }
        });
        this.shouye_box.getChildByName("排行榜页面").visible = true;
    }
    //商城页面
    _proto.shangchengfun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/goods",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                arr_shangpin = [];
                for (var i = 0; i < data.length; i++) {
                    arr_shangpin.push({
                        id: data[i].id,
                        图片: data[i].img,
                        名字: data[i].title,
                        描述: data[i].desc,
                        数量: data[i].stock,
                        金币: data[i].price,
                        背景: i % 2 == 0 ? "comp/peitao/taizi1.png" : "",
                    })
                }
                _this.list_shangcheng.array = arr_shangpin;
                _this.list_shangcheng.mouseHandler = new Laya.Handler(this, onMouse_goumai);
                function onMouse_goumai(e, index) {
                    if (e.type == "click") {
                        if (e.target.name == "购买") {
                            guoshu_jinbi = arr_shangpin[index].金币;
                            guoshu_id = arr_shangpin[index].id;
                            _this.shouye_box.getChildByName("商城页面").getChildByName("是否购买").getChildByName("内容").text = "您是否花费金币" + arr_shangpin[index].金币 + "购买" + arr_shangpin[index].名字 + "吗?"
                            _this.shouye_box.getChildByName("商城页面").getChildByName("是否购买").visible = true;
                        }
                    }
                }
            }
        })
        this.shouye_box.getChildByName("商城页面").visible = true;
    }
    //购买方法
    _proto.goumaifun = function () {
        if (jinbinum >= guoshu_jinbi) {
            $.ajax({
                url: "/home/buyGoods",
                type: "POST",
                data: {
                    token: yonghu_token,
                    id: guoshu_id,
                },
                success: function (data) {
                    if (data.status == 1) {
                        _this.shangchengfun();
                        _this.hqyonghu();
                        _this.shouye_box.getChildByName("商城页面").getChildByName("是否购买").visible = false;
                        _this.shouye_box.getChildByName("商城页面").getChildByName("成功").visible = true;
                    } else {
                        _this.tktishi(data.info)
                    }
                }
            })
        } else {
            _this.tktishi("金币不足!")
        }
    }
    var chongzhi_id;
    //充值页面
    _proto.chongzhifun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/rechargeList",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                arr_czleixing = [];
                for (var i = 0; i < data.length; i++) {
                    arr_czleixing.push({
                        id: data[i].id,
                        金额: data[i].price,
                    })
                }
                _this.list_chongzhi.array = arr_czleixing;
                _this.list_chongzhi.vScrollBarSkin = "";
                _this.list_chongzhi.mouseHandler = new Laya.Handler(this, onMouse_chongzhi);
                function onMouse_chongzhi(e, index) {
                    if (e.type == "click") {
                        for (var i = 0; i < arr_czleixing.length; i++) {
                            _this.list_chongzhi._childs[0]._childs[i]._childs[2].visible = false;
                        }
                        chongzhi_id = arr_czleixing[index].id;
                        _this.list_chongzhi._childs[0]._childs[index]._childs[2].visible = true;
                    }
                }

            }
        })
        this.shouye_box.getChildByName("充值页面").visible = true;
    }
    //记录查询
    _proto.jilufun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/rechargeLog",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                arr_czjilu = [];
                for (var i = 0; i < data.length; i++) {
                    arr_czjilu.push({
                        id: data[i].id,
                        金额: data[i].price,
                        时间: data[i].update_date,
                        状态: data[i].status,
                    })
                }
                _this.list_czjilu.vScrollBarSkin = "";
                _this.list_czjilu.array = arr_czjilu;
            }
        })
        this.shouye_box.getChildByName("充值页面").getChildByName("比例").visible = false;
        this.shouye_box.getChildByName("充值页面").getChildByName("充值记录").visible = true;
    }
    //鲜果数量页面
    _proto.xianguofun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/fruitNum",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("总鲜果数量").text = data[0].all_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("现有鲜果数量").text = data[0].now_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("今日总收益").text = data[0].now_all_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("团队收益").text = data[0].team_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("会员收益").text = data[0].members_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("分红收益").text = data[0].profit_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("个人收益").text = data[0].my_num;
                _this.shouye_box.getChildByName("鲜果数量页面").getChildByName("其他收益").text = data[0].other_num;
            }
        })
        this.shouye_box.getChildByName("鲜果数量页面").visible = true;
    }
    //仓库页面
    _proto.cangkufun = function () {
        _this.yinxiaofun();
        $.ajax({
            url: "/home/warehouse",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                if (data.length != 0) {
                    arr_cangku = [];
                    for (var i = 0; i < data.length; i++) {
                        arr_cangku.push({
                            id: data[i].id,
                            图片: data[i].g_img,
                            名字: data[i].g_title,
                        })
                    }
                    _this.list_cangku.vScrollBarSkin = "";
                    _this.list_cangku.array = arr_cangku;
                    _this.list_cangku.visible = true;
                    _this.list_cangku.mouseHandler = new Laya.Handler(this, onMouse_cangku);
                    function onMouse_cangku(e, index) {
                        if (e.type == "click") {
                            if (e.target.name == "种植") {
                                zhongzhi_id = arr_cangku[index].id;
                                _this.shouye_box.getChildByName("仓库页面").getChildByName("提示页面").visible = true;
                            }
                        }
                    }
                } else {
                    _this.list_cangku.visible = false;
                }
            }
        })
        this.shouye_box.getChildByName("仓库页面").visible = true;
    }
    //种植果树
    _proto.zhongzhifun = function () {
        $.ajax({
            url: "/home/plantingFruitTree",
            type: "POST",
            data: {
                token: yonghu_token,
                id: zhongzhi_id,
            },
            success: function (data) {
                if (data.status == 1) {
                    _this.tktishi("种植成功!")
                    _this.shouye_box.getChildByName("仓库页面").getChildByName("提示页面").visible = false;
                    _this.cangkufun();
                    _this.hqyonghu();
                } else {
                    _this.tktishi(data.info)
                }
            }
        })
    }
    //回收方法
    _proto.huishoufun = function () {
        $.ajax({
            url: "/home/recycle",
            type: "POST",
            data: {
                token: yonghu_token,
                t_id: huishou_id,
            },
            success: function (data) {
                if (data.status == 1) {
                    _this.tktishi("回收成功!")
                    _this.shouye_box.getChildByName("回收提示").visible = false;
                    _this.hqyonghu();
                } else {
                    _this.tktishi(data.info)
                }
            }
        })
    }
    //分享方法
    _proto.fenxiangfun = function () {
        $("#fuzhi2").css("z-index", "1");
        $("#biao1").css("z-index", "1");
        $.ajax({
            url: "/home/qrCode",
            type: "POST",
            data: {
                token: yonghu_token,
            },
            success: function (data) {
                _this.shouye_box.getChildByName("分享页面").visible = true;
                $("#biao1").val(data.url);
                _this.shouye_box.getChildByName("分享页面").getChildByName("链接").text = data.url;
                _this.shouye_box.getChildByName("分享页面").getChildByName("二维码").skin = data.qr_code;
                _this.shouye_box.getChildByName("分享页面").getChildByName("全屏").getChildByName("二维码").skin = data.qr_code;
            }
        })
    }
    //弹出选项
    _proto.xuanxiangfun = function () {
        if (dianjinum % 2 == 0) {
            for (var i = 1; i < 5; i++) {
                this.shouye_box.getChildByName("选项").getChildAt(i).visible = true;
                this.shouye_box.getChildByName("选项").getChildAt(i).mouseEnabled = false;
                this.shouye_box.getChildByName("选项").mouseEnabled = false;
            }
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(1), { x: -157, y: 85 }, 800, Laya.Ease.backOut);
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(2), { x: -152, y: -41 }, 800, Laya.Ease.backOut);
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(3), { x: -66, y: -140 }, 800, Laya.Ease.backOut);
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(4), { x: 62, y: -161 }, 800, Laya.Ease.backOut);
            Laya.timer.once(800, this, function () {
                dianjinum += 1;
                for (var i = 1; i < 5; i++) {
                    this.shouye_box.getChildByName("选项").getChildAt(i).mouseEnabled = true;
                    this.shouye_box.getChildByName("选项").mouseEnabled = true;
                }
            });
        } else {
            this.shouye_box.getChildByName("选项").mouseEnabled = false;
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(1), { x: 29, y: 29 }, 800, Laya.Ease.backIn);
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(2), { x: 29, y: 29 }, 800, Laya.Ease.backIn);
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(3), { x: 29, y: 29 }, 800, Laya.Ease.backIn);
            Laya.Tween.to(this.shouye_box.getChildByName("选项").getChildAt(4), { x: 29, y: 29 }, 800, Laya.Ease.backIn);
            Laya.timer.once(700, this, function () {
                dianjinum += 1;
                this.shouye_box.getChildByName("选项").mouseEnabled = true;
                for (var i = 1; i < 5; i++) {
                    this.shouye_box.getChildByName("选项").getChildAt(i).visible = false;
                }
            });
        }
    }
    //判断微信号
    _proto.testWx = function () {
        if (this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").focus) {
            isxiugai1 = true;
        } else {
            if (isxiugai1) {
                isxiugai1 = false;
                if (this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text == "") {
                    if (WXnum != null) {
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").visible = false;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").visible = true;
                    } else {
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").visible = true;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").visible = false;
                    }
                } else {
                    if (!regWX.test(this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text)) {
                        _this.tktishi("微信号输入错误!");
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text = WXnum;
                    } else {
                        weixinhao = true;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").visible = false;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").visible = true;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号显示").text = this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text;
                    }
                }
            }
        }
    }
    //判断QQ号
    _proto.testQQ = function () {
        if (this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").focus) {
            isxiugai2 = true;
        } else {
            if (isxiugai2) {
                isxiugai2 = false;
                if (this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text == "") {
                    if (QQnum != null) {
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").visible = false;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").visible = true;
                    } else {
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").visible = true;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").visible = false;
                    }
                } else {
                    if (this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text.length < 5 || this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text.length > 11) {
                        _this.tktishi("QQ号输入错误!", QQnum)
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text = QQnum;
                    } else {
                        qqhao = true;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").visible = false;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").visible = true;
                        this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号显示").text = this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text;
                    }
                }
            }
        }
    }
    //点击音效
    _proto.yinxiaofun = function () {
        if (isyinxiao) {
            Laya.SoundManager.playSound("res/dianji.mp3", 1)
        }
    }
    //弹框提示
    _proto.tktishi = function (txt) {
        _this.shouye_box.getChildByName("提示框").getChildByName("内容").text = txt;
        _this.shouye_box.getChildByName("提示框").visible = true;
    }
    //弹框提示2
    _proto.tktishi2 = function (txt) {
        _this.denglu_box.getChildByName("提示框").getChildByName("内容").text = txt;
        _this.denglu_box.getChildByName("提示框").visible = true;
    }
    //保存个人信息
    _proto.baocunfun = function () {
        if (this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text == "" && this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text == "") {
            $.ajax({
                url: "/home/amendCenter",
                type: "POST",
                data: {
                    token: yonghu_token,
                    wx_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text,
                    qq_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text,
                    wx: WX_image,
                    zfb: ZFB_image,
                },
                success: function (data) {
                    if (data.status == 1) {
                        _this.tktishi("保存成功!");
                    }
                }
            })
        } else if (this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text != "" && this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text == "") {
            if (!regWX.test(this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text)) {
                _this.tktishi("微信号错误!")
            } else {
                $.ajax({
                    url: "/home/amendCenter",
                    type: "POST",
                    data: {
                        token: yonghu_token,
                        wx_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text,
                        qq_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text,
                        wx: WX_image,
                        zfb: ZFB_image,
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            _this.tktishi("保存成功!");
                        }
                    }
                })
            }
        } else if (this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text == "" && this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text != "") {
            if (!regNum.test(this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text)) {
                _this.tktishi("QQ号错误")
            } else {
                $.ajax({
                    url: "/home/amendCenter",
                    type: "POST",
                    data: {
                        token: yonghu_token,
                        wx_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text,
                        qq_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text,
                        wx: WX_image,
                        zfb: ZFB_image,
                    },
                    success: function (data) {
                        if (data.status == 1) {
                            _this.tktishi("保存成功!");
                        }
                    }
                })
            }
        } else {
            if (!regWX.test(this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text)) {
                _this.tktishi("微信号错误!")
            } else {
                if (!regNum.test(this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text)) {
                    _this.tktishi("QQ号错误!")
                } else {
                    $.ajax({
                        url: "/home/amendCenter",
                        type: "POST",
                        data: {
                            token: yonghu_token,
                            wx_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("微信号").text,
                            qq_num: _this.shouye_box.getChildByName("个人中心页面").getChildByName("QQ号").text,
                            wx: WX_image,
                            zfb: ZFB_image,
                        },
                        success: function (data) {
                            if (data.status == 1) {
                                _this.tktishi("保存成功!");
                            }
                        }
                    })
                }
            }
        }
    }
    return Game;
})(ui.GameUI);