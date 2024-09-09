<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//
//Route::any('/oAuth/index', 'Home\OAuthController@index');
//Route::any('/oAuth/getUserOpenid', 'Home\OAuthController@getUserOpenid');

Route::any('/home/notify','Home\IndexController@notify'); //回调
Route::any('/home/pay','Home\IndexController@pay'); //支付

#注册路由
Route::get('/home1/logonUrl','Home\IndexController@logonUrl');

#首页
Route::get('/home/index','Home\IndexController@index');
#登录
Route::post('/home/login','Home\IndexController@login');
//注册
Route::post('/home/logon','Home\IndexController@logon');
//短信验证码
Route::post('/home/code','Home\IndexController@code');
//找回密码
Route::post('/home/backPwd','Home\IndexController@backPwd');
//结算
Route::get('growUp','Home\IndexController@growUp'); //成长结算
Route::get('memberIsCarry','Home\IndexController@memberIsCarry'); //更改时间
Route::get('telStatus','Home\IndexController@telStatus'); //更改时间


Route::get('addMemberTel','Home\IndexController@addMemberTel');
Route::get('addMemberTreeInfo','Home\IndexController@addMemberTreeInfo');
Route::get('/home/delCommission','Home\IndexController@delCommission');


Route::group(array('prefix' => 'home'), function() {
    Route::group(['middleware' => ['home']],function () {
        Route::post('logout','Home\IndexController@logout'); //退出登录
        Route::post('getMember','Home\IndexController@getMember'); //用户信息
        Route::post('notice','Home\IndexController@notice'); //公告
        Route::post('customer','Home\IndexController@customer'); //客服
        Route::post('rank','Home\IndexController@rank'); //排行榜
        Route::post('explain','Home\IndexController@explain'); //收益说明
        Route::post('rechargeList','Home\IndexController@rechargeList'); //充值类型
        Route::post('rechargeLog','Home\IndexController@rechargeLog'); //充值记录
        Route::post('amendCenter','Home\IndexController@amendCenter'); //编辑个人中心
        Route::post('goods','Home\IndexController@goods'); //商城列表
        Route::post('exchangeList','Home\IndexController@exchangeList'); //兑换列表
        Route::post('exchangeOrder','Home\IndexController@exchangeOrder'); //兑换
        Route::post('buyFruit','Home\IndexController@buyFruit'); //买鲜果
        Route::post('sellFruit','Home\IndexController@sellFruit'); //出售鲜果
        Route::post('giveFruit','Home\IndexController@giveFruit'); //赠送确认
        Route::post('affirmGive','Home\IndexController@affirmGive'); //确认赠送
        Route::post('upgradeLand','Home\IndexController@upgradeLand'); //升级土地
        Route::post('upgradeFruitTree','Home\IndexController@upgradeFruitTree'); //升级果树
        Route::post('market','Home\IndexController@market'); //市场
        Route::post('myTask','Home\IndexController@myTask'); //任务奖励
        Route::post('fruitNum','Home\IndexController@fruitNum'); //鲜果数量
        Route::post('buyGoods','Home\IndexController@buyGoods'); //商城购买果树
        Route::post('warehouse','Home\IndexController@warehouse'); //仓库
        Route::post('plantingFruitTree','Home\IndexController@plantingFruitTree'); //仓库 种植
        Route::post('fruitPrice','Home\IndexController@fruitPrice'); //买卖鲜果价格
        Route::post('qrCode','Home\IndexController@qrCode'); //分享
        Route::post('tour','Home\IndexController@tour'); //观光团
        Route::post('myTeam','Home\IndexController@myTeam'); //团队
        Route::post('myDirectDetail','Home\IndexController@myDirectDetail'); //团队 直推 详情
        Route::post('myTeamDetail','Home\IndexController@myTeamDetail'); //团队 团队 详情
        Route::post('recycle','Home\IndexController@recycle'); //回收
        Route::post('headImgList','Home\IndexController@headImgList'); //头像列表
        Route::post('chooseHeadImg','Home\IndexController@chooseHeadImg'); //选择头像
        Route::post('exchangeListLog','Home\IndexController@exchangeListLog'); //兑换记录
        Route::post('personalDirectDetail','Home\IndexController@personalDirectDetail'); //团队 直推 个人详情
    });
});


//h5
Route::any('/oAuth/indexh5', 'Home\OAuthController@indexh5');
Route::any('/oAuth/getUserOpenidh5', 'Home\OAuthController@getUserOpenidh5');

Route::any('/home2/notifyh5','Home\Indexh5Controller@notifyh5'); //回调
Route::any('/home2/payh5','Home\Indexh5Controller@payh5'); //支付

Route::group(array('prefix' => 'home2'), function() {
    Route::group(['middleware' => ['homeh5']],function () {
        Route::get('indexh5','Home\Indexh5Controller@indexh5');
        Route::post('logouth5','Home\Indexh5Controller@logouth5'); //退出登录
        Route::post('getMemberh5','Home\Indexh5Controller@getMemberh5'); //用户信息
        Route::post('noticeh5','Home\Indexh5Controller@noticeh5'); //公告
        Route::post('customerh5','Home\Indexh5Controller@customerh5'); //客服
        Route::post('rankh5','Home\Indexh5Controller@rankh5'); //排行榜
        Route::post('explainh5','Home\Indexh5Controller@explainh5'); //收益说明
        Route::post('rechargeListh5','Home\Indexh5Controller@rechargeListh5'); //充值类型
        Route::post('rechargeLogh5','Home\Indexh5Controller@rechargeLogh5'); //充值记录
        Route::post('amendCenterh5','Home\Indexh5Controller@amendCenterh5'); //编辑个人中心
        Route::post('goodsh5','Home\Indexh5Controller@goodsh5'); //商城列表
        Route::post('exchangeListh5','Home\Indexh5Controller@exchangeListh5'); //兑换列表
        Route::post('exchangeOrderh5','Home\Indexh5Controller@exchangeOrderh5'); //兑换
        Route::post('buyFruith5','Home\Indexh5Controller@buyFruith5'); //买鲜果
        Route::post('sellFruith5','Home\Indexh5Controller@sellFruith5'); //出售鲜果
        Route::post('giveFruith5','Home\Indexh5Controller@giveFruith5'); //赠送确认
        Route::post('affirmGiveh5','Home\Indexh5Controller@affirmGiveh5'); //确认赠送
        Route::post('upgradeLandh5','Home\Indexh5Controller@upgradeLandh5'); //升级土地
        Route::post('upgradeFruitTreeh5','Home\Indexh5Controller@upgradeFruitTreeh5'); //升级果树
        Route::post('marketh5','Home\Indexh5Controller@marketh5'); //市场
        Route::post('myTaskh5','Home\Indexh5Controller@myTaskh5'); //任务奖励
        Route::post('fruitNumh5','Home\Indexh5Controller@fruitNumh5'); //鲜果数量
        Route::post('buyGoodsh5','Home\Indexh5Controller@buyGoodsh5'); //商城购买果树
        Route::post('warehouseh5','Home\Indexh5Controller@warehouseh5'); //仓库
        Route::post('plantingFruitTreeh5','Home\Indexh5Controller@plantingFruitTreeh5'); //仓库 种植
        Route::post('fruitPriceh5','Home\Indexh5Controller@fruitPriceh5'); //买卖鲜果价格
        Route::post('qrCodeh5','Home\Indexh5Controller@qrCodeh5'); //分享
        Route::post('tourh5','Home\Indexh5Controller@tourh5'); //观光团
        Route::post('myTeamh5','Home\Indexh5Controller@myTeamh5'); //团队
        Route::post('myDirectDetailh5','Home\Indexh5Controller@myDirectDetailh5'); //团队 直推 详情
        Route::post('myTeamDetailh5','Home\Indexh5Controller@myTeamDetailh5'); //团队 团队 详情
        Route::post('recycleh5','Home\Indexh5Controller@recycleh5'); //回收
        Route::post('headImgListh5','Home\Indexh5Controller@headImgListh5'); //头像列表
        Route::post('chooseHeadImgh5','Home\Indexh5Controller@chooseHeadImgh5'); //选择头像
        Route::post('bindingTelh5','Home\Indexh5Controller@bindingTelh5'); //绑定手机号
        Route::post('exchangeListLogh5','Home\Indexh5Controller@exchangeListLogh5'); //兑换记录
        Route::post('personalDirectDetailh5','Home\Indexh5Controller@personalDirectDetailh5'); //团队 直推 个人详情
    });
});

#后台通用路由配置
Route::group(array('prefix' => 'admin'), function () {
    #登录页面
    Route::get('/sign', 'Admin\Sign\SignController@index');
    #后台验证码
    Route::get('/sign/captcha/{tmp}','Admin\Sign\SignController@captcha');
    #登录
    Route::post('/signup', 'Admin\Sign\SignController@signup');
    Route::get('sign/logout', 'Admin\Sign\SignController@logout'); // 退出
    Route::get('index/index/clearSession', 'Admin\Index\IndexController@clearSession'); // 清楚会话
    Route::get('index/index/clearCache', 'Admin\Index\IndexController@clearCache'); // 清楚全部缓存

    Route::get('sign/forgotPassword', 'Admin\Sign\SignController@forgotPassword'); // 找回密码页
    Route::post('/sign/getcode', 'Admin\Sign\SignController@getcode'); // 获取验证码
    Route::post('/sign/updatePassword', 'Admin\Sign\SignController@updatePassword'); // 修改密码

    #注册中间件
    Route::group(['middleware' => ['admin']], function () {
        Route::get('index/index', 'Admin\Index\IndexController@index');

        /*--------------------------------------用户管理------------------------------------------------ */
        #帐号管理
        Route::get('auth/user/index', 'Admin\Auth\UserController@index');
        Route::get('auth/user/searchPage', 'Admin\Auth\UserController@searchPage');
        Route::post('auth/user/isOpen', 'Admin\Auth\UserController@isOpen');
        Route::get('auth/user/update', 'Admin\Auth\UserController@update');
        Route::post('auth/user/validataName', 'Admin\Auth\UserController@validataName');
        Route::post('auth/user/validataPhone', 'Admin\Auth\UserController@validataPhone');
        Route::post('auth/user/doEdit', 'Admin\Auth\UserController@doEdit');
        Route::get('auth/user/choose', 'Admin\Auth\UserController@choose');
        Route::post('auth/user/doChooseRole', 'Admin\Auth\UserController@doChooseRole');
        Route::post('auth/user/delete', 'Admin\Auth\UserController@delete');
        Route::get('auth/user/password', 'Admin\Auth\UserController@password');
        Route::post('auth/user/editPassword', 'Admin\Auth\UserController@editPassword');
        Route::post('auth/user/getInfo', 'Admin\Auth\UserController@getInfo');

        #用户组
        Route::get('auth/role/index', 'Admin\Auth\RoleController@index');
        Route::get('auth/role/searchPage', 'Admin\Auth\RoleController@searchPage');
        Route::post('auth/role/isOpen', 'Admin\Auth\RoleController@isOpen');
        Route::post('auth/role/delete', 'Admin\Auth\RoleController@delete');
        Route::get('auth/role/update', 'Admin\Auth\RoleController@update');
        Route::post('auth/role/doEdit', 'Admin\Auth\RoleController@doEdit');
        Route::get('auth/role/authorize', 'Admin\Auth\RoleController@authorize');
        Route::post('auth/role/doAuthorize', 'Admin\Auth\RoleController@doAuthorize');


        #后台菜单
        Route::get('auth/menu/index','Admin\Auth\MenuController@index');
        Route::get('auth/menu/searchPage','Admin\Auth\MenuController@searchPage');
        Route::post('auth/menu/isOpen','Admin\Auth\MenuController@isOpen');
        Route::get('auth/menu/update','Admin\Auth\MenuController@update');
        Route::post('auth/menu/doEdit','Admin\Auth\MenuController@doEdit');
        Route::post('auth/menu/del','Admin\Auth\MenuController@del');
        Route::post('auth/menu/sortUpdate','Admin\Auth\MenuController@sortUpdate');

        /*--------------------------------------用户管理 End------------------------------------------------ */
        #用户
        Route::group(array('prefix' => 'member'), function() {
            Route::get('index','Admin\Member\MemberController@index');
            Route::get('searchPage','Admin\Member\MemberController@searchPage');
            Route::get('update', 'Admin\Member\MemberController@update');
            Route::get('update1', 'Admin\Member\MemberController@update1');
            Route::get('update2', 'Admin\Member\MemberController@update2');
            Route::post('doEdit', 'Admin\Member\MemberController@doEdit');
            Route::post('balance','Admin\Member\MemberController@balance');
            Route::post('isOpen','Admin\Member\MemberController@isOpen');
            Route::get('getExcel','Admin\Member\MemberController@getExcel');
        });

        #客服设置
        Route::group(['prefix' => 'customer'],function(){
            Route::get('index','Admin\Customer\CustomerController@index');
            Route::post('doEdit','Admin\Customer\CustomerController@doEdit');
            Route::post('upload','Admin\Customer\CustomerController@upload');
        });

        #公告设置
        Route::group(['prefix' => 'notice'],function(){
            Route::get('index','Admin\Notice\NoticeController@index');
            Route::post('doEdit','Admin\Notice\NoticeController@doEdit');
            Route::post('upload','Admin\Notice\NoticeController@upload');
        });

        #头像
        Route::group(['prefix' => 'head'],function(){
            Route::get('index','Admin\Head\HeadController@index');
            Route::get('searchPage','Admin\Head\HeadController@searchPage');
            Route::get('update','Admin\Head\HeadController@update');
            Route::post('doEdit','Admin\Head\HeadController@doEdit');
            Route::post('delete','Admin\Head\HeadController@delete');
            Route::post('upload','Admin\Head\HeadController@upload');
        });

        #收益说明
        Route::group(['prefix' => 'explain'],function(){
            Route::get('index','Admin\Explain\ExplainController@index');
            Route::post('doEdit','Admin\Explain\ExplainController@doEdit');
            Route::post('upload','Admin\Explain\ExplainController@upload');
        });

        #充值类型
        Route::group(['prefix'=>'recharge'],function(){
            Route::get('index','Admin\Recharge\RechargeController@index');
            Route::get('searchPage','Admin\Recharge\RechargeController@searchPage');
            Route::get('update','Admin\Recharge\RechargeController@update');
            Route::post('doEdit','Admin\Recharge\RechargeController@doEdit');
            Route::post('delete','Admin\Recharge\RechargeController@delete');
        });

        #充值订单
        Route::group(['prefix'=>'order'],function(){
            Route::get('index','Admin\Order\OrderController@index');
            Route::get('searchPage','Admin\Order\OrderController@searchPage');
            Route::get('update','Admin\Order\OrderController@update');
            Route::post('doEdit','Admin\Order\OrderController@doEdit');
            Route::post('delete','Admin\Order\OrderController@delete');
        });

        #商城
        Route::group(['prefix' => 'goods'],function(){
            Route::get('index','Admin\Goods\GoodsController@index');
            Route::get('searchPage','Admin\Goods\GoodsController@searchPage');
            Route::get('update','Admin\Goods\GoodsController@update');
            Route::post('doEdit','Admin\Goods\GoodsController@doEdit');
            Route::post('delete','Admin\Goods\GoodsController@delete');
            Route::post('upload','Admin\Goods\GoodsController@upload');
        });

        #商城 兑换订单
        Route::group(['prefix' => 'gorder'],function(){
            Route::get('index','Admin\Gorder\GorderController@index');
            Route::get('searchPage','Admin\Gorder\GorderController@searchPage');
            Route::get('update','Admin\Gorder\GorderController@update');
            Route::post('doEdit','Admin\Gorder\GorderController@doEdit');
            Route::post('delete','Admin\Gorder\GorderController@delete');
        });

        #兑换
        Route::group(['prefix' => 'exchange'],function(){
            Route::get('index','Admin\Exchange\ExchangeController@index');
            Route::get('searchPage','Admin\Exchange\ExchangeController@searchPage');
            Route::get('update','Admin\Exchange\ExchangeController@update');
            Route::post('doEdit','Admin\Exchange\ExchangeController@doEdit');
            Route::post('delete','Admin\Exchange\ExchangeController@delete');
            Route::post('upload','Admin\Exchange\ExchangeController@upload');
        });

        #兑换  实物订单
        Route::group(['prefix' => 'sworder'],function(){
            Route::get('index','Admin\Sworder\SworderController@index');
            Route::get('searchPage','Admin\Sworder\SworderController@searchPage');
            Route::get('update','Admin\Sworder\SworderController@update');
            Route::post('doEdit','Admin\Sworder\SworderController@doEdit');
            Route::post('delete','Admin\Sworder\SworderController@delete');
            Route::post('isOpen','Admin\Sworder\SworderController@isOpen');
            Route::post('isRefuse','Admin\Sworder\SworderController@isRefuse');
        });

        #兑换  虚拟物订单
        Route::group(['prefix' => 'xnorder'],function(){
            Route::get('index','Admin\Xnorder\XnorderController@index');
            Route::get('searchPage','Admin\Xnorder\XnorderController@searchPage');
            Route::get('update','Admin\Xnorder\XnorderController@update');
            Route::post('doEdit','Admin\Xnorder\XnorderController@doEdit');
            Route::post('delete','Admin\Xnorder\XnorderController@delete');
            Route::post('isOpen','Admin\Xnorder\XnorderController@isOpen');
            Route::post('isRefuse','Admin\Xnorder\XnorderController@isRefuse');
        });

        #果树管理
        Route::group(['prefix' => 'tree'],function(){
            Route::get('index','Admin\Tree\TreeController@index');
            Route::get('searchPage','Admin\Tree\TreeController@searchPage');
            Route::get('update','Admin\Tree\TreeController@update');
            Route::post('doEdit','Admin\Tree\TreeController@doEdit');
        });

        #推广二维码底图
        Route::group(array('prefix' => 'code'), function() {
            Route::get('index','Admin\Code\CodeController@index');
            Route::post('doEdit','Admin\Code\CodeController@doEdit');
            Route::post('upload','Admin\Code\CodeController@upload');
        });

        #交易价格
        Route::group(array('prefix' => 'deal'), function() {
            Route::get('index','Admin\Deal\DealController@index');
            Route::post('doEdit','Admin\Deal\DealController@doEdit');
        });




    });


});
