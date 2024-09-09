//菜单权限加载
$(function(){
	//模态框居中
	//modal_center();
	//清除模态框数据，解决只加载一次的问题
	$(".modal").on("hidden.bs.modal", function() {
	    $(this).removeData();
	});
	//加载权限

	checkMenu();

	var operate_tip_length = $('.alert-message').length;
	if(operate_tip_length > 0){
		setTimeout(function(){
			$('.alert-message').slideUp(300, function() {
				$('.alert-message').remove();
            });
		},3000);
	}

	$('.nav-second-level a').on('click', function() {
		var url = $(this).attr('href');

		if (localStorage) {
			localStorage.setItem('DataTables_clean', url);
		}
	});
});

function clearDataTablesState(tableName) {
	if (localStorage && localStorage.getItem('DataTables_clean') === window.location.pathname) {
		localStorage.removeItem('DataTables_' + tableName + '_' + window.location.pathname);
		localStorage.removeItem('DataTables_clean');
	}
}

//模态框居中
function modal_center(){
	/* center modal */
	function centerModals(){
	    $('.modal').each(function(i){
	        var $clone = $(this).clone().css('display', 'block').appendTo('body');    var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
	        top = top > 0 ? top : 0;
	        $clone.remove();
	        $(this).find('.modal-content').css("margin-top", top);
	    });
	}
	$('.modal').on('loaded.bs.modal', centerModals);
	$(window).on('resize', centerModals);
}

//选中当前操作的页面
function checkMenu(){
	var pathname = document.URL;//获取路径
    var arrUrl = pathname.split('//');
	pathname = arrUrl[1];
	pathname = $.trim(pathname.substring(pathname.indexOf('/')));
	 if(pathname.lastIndexOf('/') !== -1){
	 	 pathname = pathname.substring(0,pathname.lastIndexOf('/')+1)
	 }
	//移除所有的选中效果
	if(pathname == '/admin/index'){
		$('.metismenu .first-page').addClass('active');
	}
	else{
		$('.metismenu .nav-second-level>li>a').each(function(){
			var href = $.trim($(this).attr('href'));
			href = $.trim(href.substring(href.indexOf('/')));
			if(href.lastIndexOf('/') !== -1){
				href = href.substring(0,href.lastIndexOf('/')+1)
			}
			if(href == pathname){
				$(this).parent().addClass('active');
				var parent = $(this).parent().parent().parent();
				$(parent).find('ul.nav-second-level').addClass('collapse in')
				$(parent).addClass('active');

			}
		});
	}
	$('.navbar-default').show()
}


/**
 * 修改密码
 * @param url
 */
function editPassword(url){

	if($('.modal').length==0){
		$('body').append('<div class="modal fade"><div class="modal-dialog"><div class="modal-content"></div></div></div>')
		modal_center();
	}
	//使用模态框
	$('.modal').modal({
        remote: url,
        show:false
	})
	.on('loaded.bs.modal', function (e) {
		$(this).modal('show');
	});
}


