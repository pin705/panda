<!DOCTYPE html>
<html>
<head>
	<meta charset='utf-8' />
	<title>富贵果园</title>
	<meta name='viewport' content='width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no'
	/>
	<meta name="renderer" content="webkit"/>
	<meta name='apple-mobile-web-app-capable' content='yes' />
	<meta name='full-screen' content='true' />
	<meta name='x5-fullscreen' content='true' />
	<meta name='360-fullscreen' content='true' />
	<meta name="laya" screenorientation ="landscape"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<meta http-equiv='expires' content='0' />
	<meta http-equiv="Cache-Control" content="no-siteapp"/>
	
</head>
<body>
	<textarea style="position:absolute;opacity:0;z-index:-1;width:56%;height:4%;left:2%;top:93%" cols="20" rows="10" id="biao1"></textarea>
	<input id="fuzhi2" class="anniu" style="position:absolute;left:73%;top:95%;opacity:0;z-index:-1" type="button" onClick="copyUrl2()" value="点击复制代码" />
<!--以下引用了常用类库，如果不使用，可以删除-->
	<input style="
	position: absolute;
    display:none;
    opacity:0;
    width: 20%;
    height: 10%;
    background: rgb(78, 78, 236);
    color: rgb(255, 255, 255);
    font-size: 16px;
    border-radius: 4px;
    text-decoration: none;
    text-indent: 0px;
    margin: 10px 0px;
    z-index: -1;
    left: 49%;
    top: 55%;" type="file" id="wx_skm" name="icon" onchange="selectFileImage(this)" class="file" placeholder="ICCID" accept="image/*">
    <input style="
	position: absolute;
    display:none;
    opacity:0;
    width: 20%;
    height: 10%;
    background: rgb(78, 78, 236);
    color: rgb(255, 255, 255);
    font-size: 16px;
    border-radius: 4px;
    text-decoration: none;
    text-indent: 0px;
    margin: 10px 0px;
    z-index: -1;
    left: 49%;
    top: 71%;" type="file" id="zfb_skm" name="icon2" onchange="selectFileImage2(this)" class="file" placeholder="ICCID" accept="image/*">
<img id="kf_ewm" src="" style="display:none; position:absolute;width:40%;height: 25%;top: 38%;left: 31%;z-index:999;">
<!--核心包，封装了显示对象渲染，事件，时间管理，时间轴动画，缓动，消息交互,socket，本地存储，鼠标触摸，声音，加载，颜色滤镜，位图字体等-->
<script type="text/javascript" src="libs/laya.core.js"></script>
<!--提供了微信小游戏的适配-->
<script type="text/javascript" src="libs/laya.wxmini.js"></script>
<!--提供了百度小游戏的适配-->
<script type="text/javascript" src="libs/laya.bdmini.js"></script>
<!--提供了小米小游戏的适配-->
<script type="text/javascript" src="libs/laya.xmmini.js"></script>
<!--提供了OPPO小游戏的适配-->
<script type="text/javascript" src="libs/laya.quickgamemini.js"></script>
<!--封装了webgl渲染管线，如果使用webgl渲染，可以在初始化时调用Laya.init(1000,800,laya.webgl.WebGL);-->
<script type="text/javascript" src="libs/laya.webgl.js"></script>
<!--提供了VIVO小游戏的适配-->
<script type="text/javascript" src="libs/laya.vvmini.js"></script>
<!--是动画模块，包含了swf动画，骨骼动画等-->
<script type="text/javascript" src="libs/laya.ani.js"></script>
<!--包含更多webgl滤镜，比如外发光，阴影，模糊以及更多-->
<script type="text/javascript" src="libs/laya.filter.js"></script>
<!--封装了html动态排版功能-->
<script type="text/javascript" src="libs/laya.html.js"></script>
<!--粒子类库-->
<script type="text/javascript" src="libs/laya.particle.js"></script>
<!--提供tileMap解析支持-->
<script type="text/javascript" src="libs/laya.tiledmap.js"></script>
<!--提供了制作UI的各种组件实现-->
<script type="text/javascript" src="libs/laya.ui.js"></script>
<!--自定义的js(src文件夹下)文件自动添加到下面jsfile模块标签里面里，js的顺序可以手动修改，修改后保留修改的顺序，新增加的js会默认依次追加到标签里-->
<!--删除标签，ide不会自动添加js文件，请谨慎操作-->
<!--jsfile--startTag-->
<script src="js/socket.io.min.js"></script>
<script src="js/exif.js"></script>
<script src="js/jquery-1.9.1.min.js"></script>
<script src="js/ui/layaUI.max.all.js?1201"></script>
<script src="js/LayaSample.js?1201"></script>
<script src="js/Game.js?1201"></script>
<!--jsfile--endTag-->
</body>
<script>
	 leixing_type = '{{$type}}';
	console.log(leixing_type);
</script>
<script type="text/javascript">
    var base64;
        var kuan;
		var gao;
		function selectFileImage(fileObj) {
			var file = fileObj.files['0'];
			//图片方向角 added by lzk
			var Orientation = null;
			if (file) {
				console.log("正在上传,请稍后...");
				var rFilter = /^(image\/jpeg|image\/png)$/i; // 检查图片格式
				if (!rFilter.test(file.type)) {
					//showMyTips("请选择jpeg、png格式的图片", false);
					return;
				}
				// var URL = URL || webkitURL;
				//获取照片方向角属性，用户旋转控制
				EXIF.getData(file, function () {
					// alert(EXIF.pretty(this));
					EXIF.getAllTags(this);
					//alert(EXIF.getTag(this, 'Orientation'));
					Orientation = EXIF.getTag(this, 'Orientation');
					//return;
				});
				var oReader = new FileReader();
				oReader.onload = function (e) {
					//var blob = URL.createObjectURL(file);
					//_compress(blob, file, basePath);
					var image = new Image();
					image.src = e.target.result;
					image.onload = function () {
						var expectWidth = this.naturalWidth;
						var expectHeight = this.naturalHeight;

						if (this.naturalWidth > this.naturalHeight && this.naturalWidth > 2700) {
							expectWidth = 2700;
							expectHeight = expectWidth * this.naturalHeight / this.naturalWidth;
						} else if (this.naturalHeight > this.naturalWidth && this.naturalHeight > 3000) {
							expectHeight = 3000;
							expectWidth = expectHeight * this.naturalWidth / this.naturalHeight;
						}
						if (this.naturalWidth > this.naturalHeight) {
							expectWidth = this.naturalWidth;
							expectHeight = expectWidth * this.naturalHeight / this.naturalWidth;
						} else if (this.naturalHeight > this.naturalWidth) {
							expectHeight = this.naturalHeight;
							expectWidth = expectHeight * this.naturalWidth / this.naturalHeight;
						}
						var canvas = document.createElement("canvas");
						var ctx = canvas.getContext("2d");
						canvas.width = expectWidth;
						canvas.height = expectHeight;
						ctx.drawImage(this, 0, 0, expectWidth, expectHeight);
						kuan = expectWidth;
						gao = expectHeight;
						base64 = null;
						//修复ios
						if (navigator.userAgent.match(/iphone/i)) {
							console.log('iphone');
							//alert(expectWidth + ',' + expectHeight);
							//如果方向角不为1，都需要进行旋转 added by lzk
							if (Orientation != "" && Orientation != 1) {
								// alert('旋转处理');
								switch (Orientation) {
									case 6://需要顺时针（向左）90度旋转
										// alert('需要顺时针（向左）90度旋转');
										rotateImg(this, 'left', canvas);
										break;
									case 8://需要逆时针（向右）90度旋转
										// alert('需要顺时针（向右）90度旋转');
										rotateImg(this, 'right', canvas);
										break;
									case 3://需要180度旋转
										// alert('需要180度旋转');
										rotateImg(this, 'right', canvas);//转两次
										rotateImg(this, 'right', canvas);
										break;
								}
							}

							/*var mpImg = new MegaPixImage(image);
							mpImg.render(canvas, {
								maxWidth: 800,
								maxHeight: 1200,
								quality: 0.8,
								orientation: 8
							});*/
							base64 = canvas.toDataURL("image/jpeg", 0.8);
						}else {
							//alert(Orientation);
							if (Orientation != "" && Orientation != 1) {
								//alert('旋转处理');
								switch (Orientation) {
									case 6://需要顺时针（向左）90度旋转
										// alert('需要顺时针（向左）90度旋转');
										rotateImg(this, 'left', canvas);
										break;
									case 8://需要逆时针（向右）90度旋转
										// alert('需要顺时针（向右）90度旋转');
										rotateImg(this, 'right', canvas);
										break;
									case 3://需要180度旋转
										// alert('需要180度旋转');
										rotateImg(this, 'right', canvas);//转两次
										rotateImg(this, 'right', canvas);
										break;
								}
							}

							base64 = canvas.toDataURL("image/jpeg", 0.8);
						}
						// $('#myImage').css('display', 'block');
						// $("#imgid").attr("src", base64);
                        // _this.hai2.getChildAt(0).skin=base64;
                        // _this.home3.getChildByName("图片").skin='comp/ceshi.jpg';
						//wx_image=base64;
						WX_image=base64;
						_this.shouye_box.getChildByName("个人中心页面").getChildByName("上传微信").skin=base64;
                        $('#exampleInputFile2').hide();
						$("#exampleInputFile2").attr('type','text');
						$("#exampleInputFile2").attr('type','file');
					};
				};
				oReader.readAsDataURL(file);
			}
		}
	function selectFileImage2(fileObj) {
			var file = fileObj.files['0'];
			//图片方向角 added by lzk
			var Orientation = null;
			if (file) {
				console.log("正在上传,请稍后...");
				var rFilter = /^(image\/jpeg|image\/png)$/i; // 检查图片格式
				if (!rFilter.test(file.type)) {
					//showMyTips("请选择jpeg、png格式的图片", false);
					return;
				}
				// var URL = URL || webkitURL;
				//获取照片方向角属性，用户旋转控制
				EXIF.getData(file, function () {
					// alert(EXIF.pretty(this));
					EXIF.getAllTags(this);
					//alert(EXIF.getTag(this, 'Orientation'));
					Orientation = EXIF.getTag(this, 'Orientation');
					//return;
				});
				var oReader = new FileReader();
				oReader.onload = function (e) {
					//var blob = URL.createObjectURL(file);
					//_compress(blob, file, basePath);
					var image = new Image();
					image.src = e.target.result;
					image.onload = function () {
						var expectWidth = this.naturalWidth;
						var expectHeight = this.naturalHeight;

						if (this.naturalWidth > this.naturalHeight && this.naturalWidth > 2700) {
							expectWidth = 2700;
							expectHeight = expectWidth * this.naturalHeight / this.naturalWidth;
						} else if (this.naturalHeight > this.naturalWidth && this.naturalHeight > 3000) {
							expectHeight = 3000;
							expectWidth = expectHeight * this.naturalWidth / this.naturalHeight;
						}
						if (this.naturalWidth > this.naturalHeight) {
							expectWidth = this.naturalWidth;
							expectHeight = expectWidth * this.naturalHeight / this.naturalWidth;
						} else if (this.naturalHeight > this.naturalWidth) {
							expectHeight = this.naturalHeight;
							expectWidth = expectHeight * this.naturalWidth / this.naturalHeight;
						}
						var canvas = document.createElement("canvas");
						var ctx = canvas.getContext("2d");
						canvas.width = expectWidth;
						canvas.height = expectHeight;
						ctx.drawImage(this, 0, 0, expectWidth, expectHeight);
						kuan = expectWidth;
						gao = expectHeight;
						base64 = null;
						//修复ios
						if (navigator.userAgent.match(/iphone/i)) {
							console.log('iphone');
							//alert(expectWidth + ',' + expectHeight);
							//如果方向角不为1，都需要进行旋转 added by lzk
							if (Orientation != "" && Orientation != 1) {
								// alert('旋转处理');
								switch (Orientation) {
									case 6://需要顺时针（向左）90度旋转
										// alert('需要顺时针（向左）90度旋转');
										rotateImg(this, 'left', canvas);
										break;
									case 8://需要逆时针（向右）90度旋转
										// alert('需要顺时针（向右）90度旋转');
										rotateImg(this, 'right', canvas);
										break;
									case 3://需要180度旋转
										// alert('需要180度旋转');
										rotateImg(this, 'right', canvas);//转两次
										rotateImg(this, 'right', canvas);
										break;
								}
							}

							/*var mpImg = new MegaPixImage(image);
							mpImg.render(canvas, {
								maxWidth: 800,
								maxHeight: 1200,
								quality: 0.8,
								orientation: 8
							});*/
							base64 = canvas.toDataURL("image/jpeg", 0.8);
						}else {
							//alert(Orientation);
							if (Orientation != "" && Orientation != 1) {
								//alert('旋转处理');
								switch (Orientation) {
									case 6://需要顺时针（向左）90度旋转
										// alert('需要顺时针（向左）90度旋转');
										rotateImg(this, 'left', canvas);
										break;
									case 8://需要逆时针（向右）90度旋转
										// alert('需要顺时针（向右）90度旋转');
										rotateImg(this, 'right', canvas);
										break;
									case 3://需要180度旋转
										// alert('需要180度旋转');
										rotateImg(this, 'right', canvas);//转两次
										rotateImg(this, 'right', canvas);
										break;
								}
							}

							base64 = canvas.toDataURL("image/jpeg", 0.8);
						}
						// $('#myImage').css('display', 'block');
						// $("#imgid").attr("src", base64);
                        // _this.hai2.getChildAt(0).skin=base64;
                        // _this.home3.getChildByName("图片").skin='comp/ceshi.jpg';
						//wx_image=base64;
						ZFB_image=base64;
						_this.shouye_box.getChildByName("个人中心页面").getChildByName("上传支付宝").skin=base64;
                        $('#exampleInputFile2').hide();
						$("#exampleInputFile2").attr('type','text');
						$("#exampleInputFile2").attr('type','file');
					};
				};
				oReader.readAsDataURL(file);
			}
		}
</script>
	<script>
		// 复制文字（不要隐藏input）
		function copyUrl2()
		{
		var Url2=document.getElementById("biao1");
		Url2.select(); // 选择对象
		document.execCommand("Copy"); // 执行浏览器复制命令
		alert("复制成功!");
		}
</script>

<script type="text/javascript">
    var base_url = '{{Config::get('custom.BasePath')}}';
    var member_id = '{{Session::get('mid')}}';
    console.log(member_id);
    console.log("AAAAAAAA");

    function zhifu(id) {
        window.location.href=base_url+"/home2/payh5?id="+id+"&mid="+member_id
    }
</script>

</html>