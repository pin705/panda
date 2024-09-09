var CLASS$=Laya.class;
var STATICATTR$=Laya.static;
var View=laya.ui.View;
var Dialog=laya.ui.Dialog;
var GameUI=(function(_super){
		function GameUI(){
			
		    this.denglu_box=null;

			GameUI.__super.call(this);
		}

		CLASS$(GameUI,'ui.GameUI',_super);
		var __proto__=GameUI.prototype;
		__proto__.createChildren=function(){
		    			View.regComponent("Text",laya.display.Text);

			laya.ui.Component.prototype.createChildren.call(this);
			this.createView(GameUI.uiView);

		}

		GameUI.uiView={"type":"View","props":{"width":750,"height":1334},"child":[{"type":"Box","props":{"width":750,"visible":true,"var":"denglu_box","height":1334},"child":[{"type":"Image","props":{"skin":"comp/zhuce/bj.jpg"}},{"type":"Box","props":{"y":180,"x":18,"name":"注册"},"child":[{"type":"Image","props":{"y":0,"x":0,"skin":"comp/zhuce/zc.png"}},{"type":"Image","props":{"y":150,"x":55,"skin":"comp/zhuce/zi1.png"}},{"type":"Image","props":{"y":249,"x":55,"skin":"comp/zhuce/zi2.png"}},{"type":"Image","props":{"y":347,"x":55,"skin":"comp/zhuce/zi3.png"}},{"type":"Image","props":{"y":445,"x":55,"skin":"comp/zhuce/zi4.png"}},{"type":"Image","props":{"y":546,"x":55,"skin":"comp/zhuce/zi5.png"}},{"type":"Image","props":{"y":644,"x":55,"skin":"comp/zhuce/zi6.png"}},{"type":"Image","props":{"y":633,"x":313,"skin":"comp/zhuce/huoqu.png","name":"获取"}},{"type":"Image","props":{"y":779,"x":56,"skin":"comp/zhuce/fanhui.png","name":"返回"}},{"type":"Image","props":{"y":771,"x":480,"skin":"comp/zhuce/zhuce.png","name":"注册按钮"}},{"type":"Image","props":{"y":143,"x":316,"skin":"comp/zhuce/shuru.png"}},{"type":"Image","props":{"y":242,"x":316,"skin":"comp/zhuce/shuru.png"}},{"type":"Image","props":{"y":341,"x":316,"skin":"comp/zhuce/shuru.png"}},{"type":"Image","props":{"y":440,"x":316,"skin":"comp/zhuce/shuru.png"}},{"type":"Image","props":{"y":539,"x":316,"skin":"comp/zhuce/shuru.png"}},{"type":"Image","props":{"y":636,"x":462,"skin":"comp/zhuce/shuru2.png"}},{"type":"TextInput","props":{"y":145,"x":318,"width":346,"valign":"middle","type":"text","prompt":"请输入手机号","name":"手机账号","maxChars":11,"height":69,"fontSize":26,"font":"Arial","color":"#ffffff","align":"center"}},{"type":"TextInput","props":{"y":244,"x":318,"width":346,"valign":"middle","type":"text","prompt":"请输入真实姓名","name":"真实姓名","maxChars":10,"height":69,"fontSize":26,"font":"Arial","color":"#ffffff","align":"center"}},{"type":"TextInput","props":{"y":342,"x":318,"width":346,"valign":"middle","type":"text","prompt":"请输入昵称","name":"游戏昵称","maxChars":6,"height":69,"fontSize":26,"font":"Arial","color":"#ffffff","align":"center"}},{"type":"TextInput","props":{"y":441,"x":318,"width":346,"valign":"middle","type":"password","prompt":"请输入密码","name":"输入密码","maxChars":16,"height":69,"fontSize":26,"font":"Arial","color":"#ffffff","align":"center"}},{"type":"TextInput","props":{"y":541,"x":318,"width":346,"valign":"middle","type":"password","prompt":"请再次输入密码","name":"确认密码","maxChars":16,"height":69,"fontSize":26,"font":"Arial","color":"#ffffff","align":"center"}},{"type":"TextInput","props":{"y":638,"x":464,"width":188,"valign":"middle","type":"text","prompt":"请输入验证码","name":"验证码","maxChars":4,"height":69,"fontSize":22,"font":"Arial","color":"#ffffff","align":"center"}},{"type":"Box","props":{"y":633,"x":313,"visible":false,"name":"倒计时"},"child":[{"type":"Image","props":{"skin":"comp/333.png"}},{"type":"Text","props":{"y":11,"x":17,"width":105,"valign":"middle","text":"60s","height":48,"fontSize":28,"font":"Arial","color":"#975958","align":"center"}}]}]},{"type":"Box","props":{"width":750,"visible":false,"name":"提示框","height":1334},"child":[{"type":"Image","props":{"skin":"comp/peitao/hei.png"}},{"type":"Image","props":{"y":455,"x":39,"skin":"comp/peitao/tishikuang.png"}},{"type":"Image","props":{"y":443,"x":629,"skin":"comp/peitao/guanbi.png","name":"关闭"}},{"type":"Text","props":{"y":576,"x":123,"wordWrap":true,"width":504,"valign":"middle","name":"内容","height":181,"fontSize":36,"font":"Arial","color":"#000000","bold":true,"align":"center"}}]}]}]};
		return GameUI;
	})(View);