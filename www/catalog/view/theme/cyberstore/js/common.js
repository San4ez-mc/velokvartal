function getURLVar(key) {
	var value = [];

	var query = String(document.location).split('?');

	if (query[1]) {
		var part = query[1].split('&');

		for (i = 0; i < part.length; i++) {
			var data = part[i].split('=');

			if (data[0] && data[1]) {
				value[data[0]] = data[1];
			}
		}

		if (value[key]) {
			return value[key];
		} else {
			return '';
		}
	}
}
function addStyleHeader(styles) {
    var css = document.createElement('style');
    if (css.styleSheet) {
        css.styleSheet.cssText = styles;
    } else {
        css.appendChild(document.createTextNode(styles));
    }
    document.getElementsByTagName("head")[0].appendChild(css);
}
function heightblockauto() {
	max_height_div('.product-thumb .option.featured-opt');
	max_height_div('.product-thumb .option.latest-opt');
	max_height_div('.product-thumb .option.latest-gv-opt');
	max_height_div('.product-thumb .option.bestseller-opt');
	max_height_div('.product-thumb .option.special-opt');
	max_height_div('.product-thumb .option.productany-opt');
	max_height_div('.product-thumb .option.productviewed-opt');
	max_height_div('.product-thumb .option.tablatest-opt');
	max_height_div('.product-thumb .option.tabspecial-opt');
	max_height_div('.product-thumb .option.tabfeatured-opt');
	max_height_div('.product-thumb .option.tabbestseller-opt');
	max_height_div('.product-thumb .option.tabpopular-opt');
	max_height_div('.product-grid .product-thumb .option.productpage-opt');
}
function max_height_div(div) {
var maxheight = 0;
$(div).each(function(){
$(this).removeAttr('style');
	if($(this).height() > maxheight) {
		maxheight = $(this).height();
	}
});
$(div).height(maxheight);
}
function list_view(){
	$('.product-thumb .option').removeAttr('style');
	//$('#list-view').trigger('click');

	$('#content .product-layout > .clearfix').remove();
	$('#content .row > .product-layout').attr('class', 'product-layout product-list col-xs-12');
	$('#list-view').addClass('active');
    $('#grid-view').removeClass('active');
    $('#grid-view4').removeClass('active');
	$('#price-view').removeClass('active');
	localStorage.setItem('display', 'list');
}
function grid_view() {
	$('#content .product-layout > .clearfix').remove();
	$('#content .row-price > .clearfix').remove();
	// What a shame bootstrap does not take into account dynamically loaded columns
	cols = $('#column-right, #column-left').length;
	if (cols == 2) {
		$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12');
	} else if (cols == 1) {
		$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-4 col-md-6 col-sm-6');
	} else {
		$('#content .product-layout').attr('class', 'product-layout product-grid col-lg-3 col-md-4 col-sm-6');
	}

	if (cols == 2) {
		$('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
	} else if (cols == 1) {
		$('#content .product-layout:nth-child(3n+3)').after('<div class="clearfix visible-lg"></div>');
	} else {
		$('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix visible-lg"></div>');
	}
	$('#grid-view').addClass('active');
    $('#grid-view4').removeClass('active');
    $('#list-view').removeClass('active');
	$('#price-view').removeClass('active');
	 localStorage.setItem('display', 'grid');
	 max_height_div('.product-grid .product-thumb .option.productpage-opt');
}
function grid_view4() {
	$('#content .product-layout > .clearfix').remove();
	$('#content .row-price > .clearfix').remove();
	// What a shame bootstrap does not take into account dynamically loaded columns
	cols = $('#column-right, #column-left').length;
	if (cols == 2) {
		$('#content .product-layout').attr('class', 'product-layout product-grid grid4 col-1 col-lg-6 col-md-6 col-sm-12 col-xs-12');
	} else if (cols == 1) {
		$('#content .product-layout').attr('class', 'product-layout product-grid grid4 col-1 col-lg-3 col-md-4 col-sm-6 col-xs-12');
	} else {
		$('#content .product-layout').attr('class', 'product-layout product-grid grid4 col-lg-1-5 col-md-3 col-sm-6 col-xs-12');
	}

	if (cols == 2) {
		$('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
	} else if (cols == 1) {
		$('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix visible-lg"></div>');
	} else {
		$('#content .product-layout:nth-child(5n+5)').after('<div class="clearfix visible-lg"></div>');
	}
    $('#grid-view').removeClass('active');
    $('#list-view').removeClass('active');
	$('#price-view').removeClass('active');
	$('#grid-view4').addClass('active');
	 localStorage.setItem('display', 'grid4');
	 max_height_div('.product-grid .product-thumb .option.productpage-opt');
}
function price_view() {
	$('#content .product-layout > .clearfix').remove();
	$('#content .row-price > .clearfix').remove();
	$('#content .product-layout').attr('class', 'product-layout product-price col-xs-12');

	localStorage.setItem('display', 'price');
	$('#price-view').addClass('active');
	$('#list-view').removeClass('active');
	$('#grid-view').removeClass('active');
	$('#grid-view4').removeClass('active');
}

$(function() {
	if (localStorage.getItem('display') == 'list') {
		list_view();
	} else if (localStorage.getItem('display') == 'grid') {
		grid_view();
	} else if (localStorage.getItem('display') == 'grid4') {
		grid_view4();
	} else if (localStorage.getItem('display') == 'price'){
		price_view();
	} else {
		grid_view();
	}
});

function loading_masked(action) {
	if (action) {
	$('.loading_masked').html(loading_masked_img);
	$('.loading_masked').show();
	} else {
	$('.loading_masked').html('');
	$('.loading_masked').hide();
	}
}
function creatOverlayLoadPage(action) {
	if (action) {
	$('#messageLoadPage').html(loading_masked_img);
	$('#messageLoadPage').show();
	} else {
	$('#messageLoadPage').html('');
	$('#messageLoadPage').hide();
	}
}
function popupFormReviewStore() {
	$.magnificPopup.open({
		tLoading: loading_masked_img,
		items: {
		  src: 'index.php?route=product/cyber_reviews_store/popupFormReviewStore',
		  type: 'ajax'
		},
	  });
}
function viewport() {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
}
function quickview_open(id,all_prod) {
	$('body').prepend('<div id="messageLoadPage"></div><div class="mfp-bg-quickview"></div>');
	$.ajax({
		type:'post',
		data:'quickview29=1&all_prod='+all_prod,
		url:'index.php?route=product/product&product_id='+id,
		beforeSend: function() {
			creatOverlayLoadPage(true);
		},
		complete: function() {
			$('.mfp-bg-quickview').hide();
			$('#messageLoadPage').hide();
			creatOverlayLoadPage(false);
		},
		success:function (data) {
			$('.mfp-bg-quickview').hide();
			$data = $(data);
			var new_data = $data.find('#quickview-container').html();
			$.magnificPopup.open({
				tLoading: loading_masked_img,
				items: {
					src: new_data,
				},
				type: 'inline'
			});
		}
});
}
function getNextPrevProduct(id,all_prod) {
	$.ajax({
		type:'post',
		data:'quickview29=1&all_prod='+all_prod,
		url:'index.php?route=product/product&product_id='+id,
		beforeSend: function() {
		$('#popup-quickview').append('<span class="loading_quick_order"><img src="catalog/view/theme/cyberstore/image/check-ajax-ns.gif" ></span>');
		},

		success:function (data) {
			$data = $(data);
			var new_data = $data.find('#quickview-container').html();
			var magnificPopup = $.magnificPopup.instance;
            magnificPopup.items[0].type = "inline";
            magnificPopup.items[0].src = new_data;
            magnificPopup.updateItemHTML();
		}
});
}

function banner_link_open(link) {
$('body').prepend('<div id="messageLoadPage"></div>');
creatOverlayLoadPage(true);
$('body').append('<div class="popup_banner"></div>');
	$('.popup_banner').popup({
		transition: 'all 0.3s',
		closetransitionend: function () {
			$(this).remove();
			$('.popup_background').remove();
			$('.popup_wrapper').remove();
		}
	});
	$('.popup_banner').load(link+' #content', function() {
	creatOverlayLoadPage(false);
	$('#messageLoadPage').remove();
		$('.popup_banner').append('<i class="fa fa-times close" onclick="$(\'.popup_banner\').popup(\'hide\');"></i>');
		$('.popup_banner').popup('show');
	});
}
function validate_quantity(input, minval){
	setTimeout(function () {
		input.value = input.value.replace(/[^\d]/g, '');
		if (input.value == '') input.value = minval;
		if (input.value == '0') input.value = minval;
	}, 10);
}
function recalc_quantity(product_id,minval,price,special, mod, mod_page_name) {
	var quantity = $(mod +' .quantity_plus_minus .input-number-quantity'+product_id).val();
	if(isNaN(quantity)){
		quantity = '1';
	}
	quantity = quantity.replace(/[^\d]/g, '');
	if (quantity == '') quantity = minval;
	if (quantity == '0') quantity = minval;

	var main_price = parseFloat(price);
	var special_price = parseFloat(special);
	special_coefficient = parseFloat(price)/parseFloat(special);


	var options_price = 0;
	$('#option_'+ mod_page_name +'_'+product_id+' option:selected,#option_'+ mod_page_name +'_'+product_id+' input:checked').each(function() {
      if ($(this).data('option-prefix') == '=') {
        options_price += Number($(this).data('option-price'));
        main_price = 0;
        special_price = 0;
      }
    });

	$('#option_'+ mod_page_name +'_'+product_id+' option:selected,#option_'+ mod_page_name +'_'+product_id+' input:checked').each(function() {
		if ($(this).data('option-prefix') == '+') {
			options_price += Number($(this).data('option-price'));
		}
		if ($(this).data('option-prefix') == '-') {
			options_price -= Number($(this).data('option-price'));
		}

	});

	main_price += options_price;

	if(!isNaN(special_price)){
		special_price += options_price;
		special_price = main_price / special_coefficient;
		special_price *= quantity;
	}

	main_price *= quantity;

	var start_price = parseFloat($(mod +' .price_no_format_' + product_id).html().replace(/\s*/g,''));
	$(mod +' .price_no_format_'+product_id).html(price_format(main_price));

	if(!isNaN(special_price)){
		var start_price = parseFloat($(mod +' .special_no_format_' + product_id).html().replace(/\s*/g,''));
		$(mod +' .special_no_format_'+product_id).html(price_format(special_price));
	}
}

function get_cart_quantity(product_id,mod) {
	input_val = $(mod +' .quantity_plus_minus .input-number-quantity'+product_id).val();
	var input_val = typeof(input_val) != 'undefined' ? input_val : 1;
	quantity  = parseInt(input_val);
	return quantity;
}
function nsmenu_menu(){
	if ($(".menu-header-box").hasClass('cont-mw') == true) {
		$(".nsmenu-bigblock").css('width',$(".menu-header-box").outerWidth());
		var menu_offset = $('.menu-header-box').offset();
		var menu_ow = $('.menu-header-box').outerWidth();
	} else {
		$(".nsmenu-bigblock").css('width',$(".full-mw .container").outerWidth() - 20);
		var menu_offset = $('.full-mw .container').offset();
		var menu_ow = $('.full-mw .container').outerWidth() - 10;
	}
	$('#horizontal-menu .dropdown-menu').each(function() {
		var dropdown = $(this).parent().offset();
		var i = (dropdown.left + $(this).outerWidth()) - (menu_offset.left + menu_ow);

		if (i > 0) {
			$(this).css('margin-left', '-' + i + 'px');
		}
		var l=$(this).outerWidth();
		$(this).find(".nsmenu-ischild-simple").css('left',l);

	});
}
function additional_menu(){
	$(".nsmenu-bigblock-additional").css('width',$(".menu-header-box .container").outerWidth()-20);

	$('#additional-menu .dropdown-menu').each(function() {
		if ($(".dop-menu-header").hasClass('dopmenu-center') == true) {

			var menu = $('#additional-menu').offset();
			var dropdown = $(this).parent().offset();
			drop_mc = (dropdown.left - 10) - menu.left / 2;
			if($(this).hasClass('nsmenu-bigblock-additional') == true){
				$(this).css('margin-left', '-' + (drop_mc + 1) + 'px');
			}
		} else if($('.menu-header-box .row.dflex').hasClass('h-type-2-st') == true) {
			var menu = $('#additional-menu').offset();
			var dropdown = $(this).parent().offset();
			var menu_offset = $('.menu-header-box .container ').offset();
			drop_mc = (dropdown.left - 20) - menu_offset.left + 10;
			if($(this).hasClass('nsmenu-bigblock-additional') == true){
				$(this).css('left', '-' + (drop_mc + 1) + 'px');
			}
			var l=$(this).outerWidth()-2;
			$(this).find(".nsmenu-type-category-simple").css('left',l);
		} else {

			var menu = $('#additional-menu').offset();
			var dropdown = $(this).parent().offset();

			var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#additional-menu').outerWidth());
			if (i > 0) {
				$(this).css('margin-left', '-' + (i) + 'px');
			}
			var l=$(this).outerWidth()-2;
			$(this).find(".nsmenu-ischild-simple").css('left',l);
		}
	});
}
function cs_menu_aim(){
	$('#menu #menu-list').menuAim({
		activateCallback: activateSubmenu,
		deactivateCallback: deactivateSubmenu,
	});
	function activateSubmenu(row) {
		if($(row).hasClass('dropdown')){
			$(row).addClass('menu-open');
		}
	}
	function deactivateSubmenu(row) {$(row).removeClass('menu-open');}
	function exitMenu(row) {return true;}
	$('.dropdown-menu-simple .nsmenu-haschild').menuAim({
		activateCallback: activateSubmenu2level,
		deactivateCallback: deactivateSubmenu2level,
	});
	function activateSubmenu2level(row) {
		if($(row).hasClass('nsmenu-issubchild')){
			$(row).addClass('menu-open-2level');
		}
	}
	function deactivateSubmenu2level(row) {$(row).removeClass('menu-open-2level');}
	function exitMenu2level(row) {return true;}
	$('.dropdown-menu-simple .nsmenu-ischild-simple').menuAim({
		activateCallback: activateSubmenu4level,
		deactivateCallback: deactivateSubmenu4level,
	});
	function activateSubmenu4level(row) {

	$(row).addClass('menu-open-4level');}
	function deactivateSubmenu4level(row) {$(row).removeClass('menu-open-4level');}
	function exitMenu4level(row) {return true;}
	$('#additional-menu li.dropdown').hover(function() {
		additional_menu();
		$(this).find('.dropdown-menu').stop(true, true).delay(10);
		$(this).addClass('open');
		$('#maskMenuDop').addClass('open');
		$(this).find('.dropdown-toggle').attr('aria-expanded', 'true');
	}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(10);
		$(this).removeClass('open');
		$('#maskMenuDop').removeClass('open');
		$(this).find('.dropdown-toggle').attr('aria-expanded', 'false')
	});
	if($( document ).width()>991){
	$('#horizontal-menu li.dropdown').hover(function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(10);
		$(this).addClass('open');
		$('#maskMenuHor').addClass('open');
		$(this).find('.dropdown-toggle').attr('aria-expanded', 'true');
	}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(10);
		$(this).removeClass('open');
		$('#maskMenuHor').removeClass('open');
		$(this).find('.dropdown-toggle').attr('aria-expanded', 'false')
	});
	}
}
$(document).ready(function () {

	$("#back-top").hide();
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
		});
	});
	$('.nsmenu-type-manufacturer a[data-toggle="tooltip"]').tooltip({
		animated: 'fade',
		placement: 'top',
		template: '<div class="tooltip tooltip-manufacturer" role="tooltip"><div class="arrow"></div><div class="tooltip-inner tooltip-manufacturer-inner"></div></div>',
		html: true
	});


	$(".ns-dd").hover(function() {$(this).parent().find('.parent-link').toggleClass('hover');});
	$(".nsmenu-issubchild").hover(function() {
		$(this).parent().parent().toggleClass('hide-border-radius-top-right');
	});
	$(".ischild_4level_simple").hover(function() {
		$(this).parent().toggleClass('hide-border-radius-top-right');
	});
	$(".child-box").hover(function() {$(this).parent().find('.with-child').toggleClass('hover');});
	$(".nsmenu-ischild.nsmenu-ischild-simple").hover(function() {$(this).parent().find('> a').toggleClass('hover');});
	$(".child_4level_simple").hover(function() {$(this).parent().find('> a').toggleClass('hover');});

	$('#menu #menu-list .toggle-child').on('click', function(e) {
		e.stopPropagation();
		$(this).toggleClass('open');
		$(this).next().next().slideToggle(0);
	});

	cs_menu_aim();

	$(document).on("click.bs.dropdown.data-api", "#cart", function (e) { e.stopPropagation() });
	setTimeout(function () {
		heightblockauto();
	}, 150);
	$(window).resize(function(){
		setTimeout(function () {
			heightblockauto();
		}, 150);
	});
	var width_doc = viewport().width;
	if (width_doc >= 992) {
	$('#phone .contact-header').hover(function() {
	  $(this).find('.drop-contacts').stop(true, true).delay(10).fadeIn(10);
	  $(this).addClass('open');
	}, function() {
	   $(this).find('.drop-contacts').stop(true, true).delay(10).fadeOut(10);
	    $(this).removeClass('open');
	});
	}
	$(document).on('click', '#phone .drop-icon-info', function () {
		 $(this).parent().parent().toggleClass('open');
	});
	// Highlight any found errors
	$('.text-danger').each(function() {
		var element = $(this).parent().parent();

		if (element.hasClass('form-group')) {
			element.addClass('has-error');
		}
	});

	// Currency
	$('#currency .currency-select').on('click', function(e) {
		e.preventDefault();

		$('#currency input[name=\'code\']').attr('value', $(this).attr('name'));

		$('#currency').submit();
	});

	// Language
	$('#language a').on('click', function(e) {
		e.preventDefault();

		$('#language input[name=\'code\']').attr('value', $(this).attr('href'));

		$('#language').submit();
	});

	/* Search */

	$('.btn-search').on('click', function() {
		url = $('base').attr('href') + 'index.php?route=product/search';

		var value = $('input[name=\'search\']').val();

		if (value) {
			url += '&search=' + encodeURIComponent(value);
		} else {
			url += '&search=';
		}

		var category_id = $('input[name=\'category_id\']').prop('value');
		if (category_id > 0) {
			url += '&category_id=' + encodeURIComponent(category_id) + '&sub_category=true';
		}
		location = url;
	});
	$('#search_word a').on('click', function() {
		$(this).parent().prev().find('.form-control.input-lg').val($(this).text());
		$(this).parent().prev().find('button.btn.btn-search').trigger('click');
	});
	$('#search input[name=\'search\']').on('keydown', function(e) {
		if (e.keyCode == 13) {
			$('input[name=\'search\']').parent().find('button.btn.btn-search').trigger('click');
		}
	});
	// Menu
	$('#menu-ocp .dropdown-menu').each(function() {
		var menu = $('#menu-ocp').offset();
		var dropdown = $(this).parent().offset();

		var i = (dropdown.left + $(this).outerWidth()) - (menu.left + $('#menu-ocp').outerWidth());

		if (i > 0) {
			$(this).css('margin-left', '-' + (i + 5) + 'px');
		}
	});
	//MENU 2
	nsmenu_menu();
	additional_menu();
	$( window ).resize(function() {
		setTimeout(function () {
			nsmenu_menu();
			additional_menu();
		}, 300);
	});
	$( "#additional-menu a.dropdown-toggle" ).bind( "click", function() {
		if(($(this).attr('href')!="javascript:void(0);")&&($( document ).width()>767))
		{
		window.document.location=$(this).attr('href');
		}
	});
	$( "#menu a.dropdown-toggle" ).bind( "click", function() {
		if(($(this).attr('href')!="javascript:void(0);")&&($( document ).width()>767))
		{
		window.document.location=$(this).attr('href');
		}
	});
	$( "#horizontal-menu a.dropdown-toggle" ).bind( "click", function(e) {
		if($(this).attr('href') !='javascript:void(0);'){
			window.document.location=$(this).attr('href');
		} else {
			e.stopPropagation();
			e.preventDefault();
		}

	});
	$('#horizontal-menu a .toggle-child').bind('click', function(e) {
		e.stopPropagation();
		e.preventDefault();
		$(this).parent().parent().toggleClass('open');
	});
	$('#horizontal-menu li.dropdown').hover(function() {
		nsmenu_menu();
	});

	// Product List
	$('#list-view').click(function() {
		list_view();
		if (typeof ProStickerLoad === 'function') {
		  setTimeout ('ProStickerLoad()', 1500);
		}
	});
	// Product Grid 3
	$('#grid-view').click(function() {
		grid_view();
		if (typeof ProStickerLoad === 'function') {
		  setTimeout ('ProStickerLoad()', 1500);
		}
	});
	// Product Grid 4
	$('#grid-view4').click(function() {
		grid_view4();
		if (typeof ProStickerLoad === 'function') {
		  setTimeout ('ProStickerLoad()', 1500);
		}
	});

	$('#price-view').click(function() {
		price_view();
		if (typeof ProStickerLoad === 'function') {
		  setTimeout ('ProStickerLoad()', 1500);
		}
	});

	// tooltips on hover
	setTimeout(function () {
	$('a > img').each(function () {
		if ($(this).attr('data-status')) {
			var status = $(this).attr('data-status');
			$(this).after('<div class="product_status">'+status+'</div>');
		}
		if ($( document ).width()>767) {
			if ($(this).attr('data-additional-hover')) {
				var img_src = $(this).attr('data-additional-hover');
				$(this).addClass('main-img');
				$(this).after('<img src="'+img_src+'" class="additional-img-hover img-responsive" title="'+$(this).attr('alt')+'" />');
			}
		}
	});
	},3000);

	$('[data-toggle=\'tooltip\']').tooltip({container: 'body',trigger: 'hover'});
	// Makes tooltips work on ajax generated content
	$(document).ajaxStop(function() {
		$('[data-toggle=\'tooltip\']').tooltip({container: 'body',trigger: 'hover'});
	});
	if(viewport().width > 768){
		$('body').click(function(){
		  $('[data-toggle="tooltip"]').tooltip('hide');
		});
	}
});

// Cart add remove functions
var cart = {
	'add': function(product_id, mod_page_name, quantity) {
		if (mod_page_name === undefined) {
			if ($('#option_'+product_id).length != 0) {
				var options = $('#option_'+product_id+' input[type=\'radio\']:checked, #option_'+product_id+' input[type=\'checkbox\']:checked, #option_'+product_id+' select');
				var data = options.serialize() + '&product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1);
			} else {
				var data = 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1);
			}
		} else {
			if ($('#option_'+ mod_page_name +'_'+product_id).length != 0) {
				var options = $('#option_'+ mod_page_name +'_'+product_id+' input[type=\'radio\']:checked, #option_'+ mod_page_name +'_'+product_id+' input[type=\'checkbox\']:checked,#option_'+ mod_page_name +'_'+product_id+' select');
				var data = options.serialize() + '&product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1);
			} else {
				var data = 'product_id=' + product_id + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1);
			}
		}

		$.ajax({
			url: 'index.php?route=checkout/cart/add',
			type: 'post',
			data: data,
			dataType: 'json',
			success: function(json) {
				$('.option-danger, .add_product_alert, .alert, .text-danger').remove();

				if (json['redirect'] && !options) {
					location = json['redirect'];
				} else {

				}
				if (json['error']) {
					if (json['error']['option']) {
						for (i in json['error']['option']) {
							if (mod_page_name === undefined || mod_page_name === null) {
								var element = $('#input-option' + i.replace('_', '-'));
							} else {
								var element = $('#input-option-'+ mod_page_name + i.replace('_', '-'));
							}
							if (element.parent().hasClass('input-group')) {
								element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
							} else {
								element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
							}
								setTimeout(function () {
								  $('.option-danger, .alert, .text-danger').remove();
								}, 7000);
								$('#top').before('<div class="alert option-danger"><img class="success-icon" alt="success-icon" src="catalog/view/theme/cyberstore/image/warning-icon.svg"><div class="text-modal-block">' + json['error']['option'][i] + '</div><button type="button" class="close" data-dismiss="alert">&times;</button></div>');

						}
					}
				}

				if (json['success']) {
					if(json['popup_design']=='1'){
						fastorder_open_cart();
					} else if(json['popup_design']=='0') {
						html  = '<div id="modal-addcart" class="modal fade" role="dialog">';
						html += '  <div class="modal-dialog" style="overflow:hidden">';
						html += '    <div class="modal-content">';
						if(json['show_onepcheckout']=='1'){
						html += '      	<div class="modal-body"><div class="text-center">' + json['success'] + '<br><img style="margin:10px 0px;" src="'+ json['image_cart'] +'"  /><br></div><div><a href=' + link_onepcheckout + ' class="btn-checkout">'+ button_checkout +'</a><button data-dismiss="modal" class="btn-shopping">'+ button_shopping +'</button></div></div>';
						} else {
						html += '      	<div class="modal-body"><div class="text-center">' + json['success'] + '<br><img style="margin:10px 0px;" src="'+ json['image_cart'] +'"  /><br></div><div><a href=' + link_checkout + ' class="btn-checkout">'+ button_checkout +'</a><button data-dismiss="modal" class="btn-shopping">'+ button_shopping +'</button></div></div>';
						}
						html += '    </div>';
						html += '  </div>';
						html += '</div>';
						$('body').append(html);
						$('#modal-addcart').modal('show');
					} else {
						$('#top').before('<div class="alert add_product_alert"><img class="success-icon" alt="success-icon" src="catalog/view/theme/cyberstore/image/success-icon.svg"><div class="text-modal-block">' + json['success'] + '</div><button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
					 setTimeout(function () {
						$('.option-danger, .alert, .text-danger,.add_product_alert').remove();
					  }, 7000);
					setTimeout(function () {
						$('.cart-total').html(json['total']);
					}, 100);

					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
				$('#modal-addcart').on('hide.bs.modal', function (e) {
					$('#modal-addcart').remove();
				});
			}
		});
	},
	'update': function(key, quantity) {
		$.ajax({
			url: 'index.php?route=checkout/cart/edit',
			type: 'post',
			data: 'key=' + key + '&quantity=' + (typeof(quantity) != 'undefined' ? quantity : 1),
			dataType: 'json',
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('.cart-total').html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout' || location.pathname == '/cart/' || location.pathname == '/checkout/') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('.cart-total').html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout' || location.pathname == '/cart/' || location.pathname == '/checkout/') {
					location = 'index.php?route=checkout/cart';
				} else if (getURLVar('route') == 'checkout/onepcheckout') {
					update_checkout();
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}

var voucher = {
	'add': function() {

	},
	'remove': function(key) {
		$.ajax({
			url: 'index.php?route=checkout/cart/remove',
			type: 'post',
			data: 'key=' + key,
			dataType: 'json',
			beforeSend: function() {
				$('#cart > button').button('loading');
			},
			complete: function() {
				$('#cart > button').button('reset');
			},
			success: function(json) {
				// Need to set timeout otherwise it wont update the total
				setTimeout(function () {
					$('.cart-total').html(json['total']);
				}, 100);

				if (getURLVar('route') == 'checkout/cart' || getURLVar('route') == 'checkout/checkout' || location.pathname == '/cart/' || location.pathname == '/checkout/') {
					location = 'index.php?route=checkout/cart';
				} else {
					$('#cart > ul').load('index.php?route=common/cart/info ul li');
				}
			}
		});
	}
}
var wishlist = {
	'add': function(product_id) {
		$('#modal-wishlist').remove();
		$.ajax({
			url: 'index.php?route=account/wishlist/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$.magnificPopup.close();
				html  = '<div id="modal-wishlist" class="modal fade">';
				html += '  <div class="modal-dialog">';
				html += '    <div class="modal-content cs-modal-success">';
				html += '      <div class="modal-body"><img class="success-icon" alt="success-icon" src="catalog/view/theme/cyberstore/image/success-icon.svg"> <div class="text-modal-block">' + json['success'] + '</div><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>';
				html += '    </div>';
				html += '  </div>';
				html += '</div>';

				$('body').append(html);

				$('#modal-wishlist').modal('show');
				if($(".wishlist-h a span").length==0) {
					$('.wishlist-h a').append('<span>'+ json['total_wishlist']+ '</span>');
				} else {
					$('.wishlist-h a span').html(json['total_wishlist']);
				}

			}

		});
	},
	'remove': function() {

	}
}
var compare = {
	'add': function(product_id) {
		$('#modal-compare').remove();
		$.ajax({
			url: 'index.php?route=product/compare/add',
			type: 'post',
			data: 'product_id=' + product_id,
			dataType: 'json',
			success: function(json) {
				$.magnificPopup.close();
				html  = '<div id="modal-compare" class="modal fade">';
				html += '  <div class="modal-dialog">';
				html += '    <div class="modal-content cs-modal-success">';
				html += '      <div class="modal-body"><img class="success-icon" alt="success-icon" src="catalog/view/theme/cyberstore/image/success-icon.svg"> <div class="text-modal-block"> ' + json['success'] + '</div><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>';
				html += '    </div>';
				html += '  </div>';
				html += '</div>';

				$('body').append(html);
				$('#modal-compare').modal('show');
				if($(".compare-h a span").length==0) {
					$('.compare-h a').append('<span>'+ json['total_compare']+ '</span>');
				} else {
					$('.compare-h a span').html(json['total_compare']);
				}

			}

		});
	},
	'remove': function() {

	}
}

/* Agree to Terms */
$(document).delegate('.agree', 'click', function(e) {
	e.preventDefault();

	$('#modal-agree').remove();

	var element = this;

	$.ajax({
		url: $(element).attr('href'),
		type: 'get',
		dataType: 'html',
		success: function(data) {
			html  = '<div id="modal-agree" class="modal">';
			html += '  <div class="modal-dialog">';
			html += '    <div class="modal-content">';
			html += '      <div class="modal-header">';
			html += '        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
			html += '        <h4 class="modal-title">' + $(element).text() + '</h4>';
			html += '      </div>';
			html += '      <div class="modal-body">' + data + '</div>';
			html += '    </div>';
			html += '  </div>';
			html += '</div>';

			$('body').append(html);

			$('#modal-agree').modal('show');
		}
	});
});

// Autocomplete */
(function($) {
	$.fn.autocomplete = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {
				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {
						if (!json[i]['category']) {
							html += '<li data-value="' + json[i]['value'] + '"><a href="#">' + json[i]['label'] + '</a></li>';
						}
					}

					// Get all the ones with a categories
					var category = new Array();

					for (i = 0; i < json.length; i++) {
						if (json[i]['category']) {
							if (!category[json[i]['category']]) {
								category[json[i]['category']] = new Array();
								category[json[i]['category']]['name'] = json[i]['category'];
								category[json[i]['category']]['item'] = new Array();
							}

							category[json[i]['category']]['item'].push(json[i]);
						}
					}

					for (i in category) {
						html += '<li class="dropdown-header">' + category[i]['name'] + '</li>';

						for (j = 0; j < category[i]['item'].length; j++) {
							html += '<li data-value="' + category[i]['item'][j]['value'] + '"><a href="#">&nbsp;&nbsp;&nbsp;' + category[i]['item'][j]['label'] + '</a></li>';
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			$(this).after('<ul class="dropdown-menu"></ul>');
			$(this).siblings('ul.dropdown-menu').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);
// autocompleteSerach */
(function($) {
	$.fn.autocompleteSerach = function(option) {
		return this.each(function() {
			this.timer = null;
			this.items = new Array();

			$.extend(this, option);

			$(this).attr('autocomplete', 'off');

			// Focus
			$(this).on('focus', function() {
				this.request();
			});

			// Blur
			$(this).on('blur', function() {
				setTimeout(function(object) {
					object.hide();
				}, 200, this);
			});

			// Keydown
			$(this).on('keydown', function(event) {
				switch(event.keyCode) {
					case 27: // escape
						this.hide();
						break;
					default:
						this.request();
						break;
				}
			});

			// Click
			this.click = function(event) {
				event.preventDefault();

				value = $(event.target).parent().attr('data-value');

				if (value && this.items[value]) {
					this.select(this.items[value]);
				}
			}

			// Show
			this.show = function() {
				var pos = $(this).position();

				$(this).siblings('ul.dropdown-menu').css({
					top: pos.top + $(this).outerHeight(),
					left: pos.left
				});

				$(this).siblings('ul.dropdown-menu').show();
			}

			// Hide
			this.hide = function() {
				$(this).siblings('ul.dropdown-menu').hide();
			}

			// Request
			this.request = function() {
				clearTimeout(this.timer);

				this.timer = setTimeout(function(object) {
					object.source($(object).val(), $.proxy(object.response, object));
				}, 200, this);
			}

			// Response
			this.response = function(json) {

				html = '';

				if (json.length) {
					for (i = 0; i < json.length; i++) {
						this.items[json[i]['value']] = json[i];
					}

					for (i = 0; i < json.length; i++) {

						if(json[i].product_id!=0){
							html += '<li><a href="'+ json[i].href +'" class="autosearch_link">';
							html += '<div class="ajaxadvance">';
							html += '<div class="image">';
							if(json[i].image){
							html += '<img title="'+json[i].name+'" src="'+json[i].image+'"/>';
							}
							html += '</div>';
							html += '<div class="content">';
							html += 	'<h3 class="name">'+json[i].label+'</h3>';
							if(json[i].model){
							html += 	'<div class="model">' + json[i].model +'</div>';
							}
							if(json[i].manufacturer){
							html += 	'<div class="manufacturer">'+ json[i].manufacturer +'</div>';
							}
							if(json[i].stock_status){
							html += 	'<div class="stock_status">'+ json[i].stock_status +'</div>';
							}
							if(json[i].price){
							html += 	'<div class="price"> ';
							if (!json[i].special) {
							html +=			 json[i].price;
							} else {
							html +=			'<span class="price-old">'+ json[i].price +'</span> <span class="price-new">'+ json[i].special +'</span>';
							}
							html +=		'</div>';
							}

							if (json[i].rating) {
								html +=		'<div class="ratings"> ';
									for (var k = 1; k <= 5; k++) {
										if (json[i].rating < k) {
											html +='<span class="product-rating-star"><svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 8.75L3.47287 9.81573C2.73924 10.2014 1.88181 9.57846 2.02192 8.76155L2.40907 6.50431L0.769082 4.90572C0.175565 4.32718 0.503075 3.31921 1.3233 3.20002L3.5897 2.87069L4.60326 0.816985C4.97008 0.0737394 6.02992 0.0737402 6.39674 0.816986L7.4103 2.87069L9.67671 3.20002C10.4969 3.31921 10.8244 4.32718 10.2309 4.90572L8.59093 6.50431L8.97808 8.76155C9.11819 9.57846 8.26076 10.2014 7.52713 9.81573L5.5 8.75Z" fill="#EFEFEF"/></svg></span>';
										} else {
											html +='<span class="product-rating-star"><svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.5 8.75L3.47287 9.81573C2.73924 10.2014 1.88181 9.57846 2.02192 8.76155L2.40907 6.50431L0.769082 4.90572C0.175565 4.32718 0.503075 3.31921 1.3233 3.20002L3.5897 2.87069L4.60326 0.816985C4.97008 0.0737394 6.02992 0.0737402 6.39674 0.816986L7.4103 2.87069L9.67671 3.20002C10.4969 3.31921 10.8244 4.32718 10.2309 4.90572L8.59093 6.50431L8.97808 8.76155C9.11819 9.57846 8.26076 10.2014 7.52713 9.81573L5.5 8.75Z" fill="#E5DB77"/></svg></span>';
										}
									}
								html +=		'</div>';
							}
							html +='</div>';
							html += '</div></a></li>'
						}
					}
				}

				if (html) {
					this.show();
				} else {
					this.hide();
				}

				$(this).siblings('ul.dropdown-menu').html(html);
			}

			if(!$(this).next().hasClass('autosearch')){
				$(this).after('<ul class="dropdown-menu autosearch"></ul>');
			}
			$(this).siblings('ul.dropdown-menu autosearch').delegate('a', 'click', $.proxy(this.click, this));

		});
	}
})(window.jQuery);

$(document).on('click', '#login-popup', function (e) {
	e.preventDefault();
	var href = $(e.target).attr('data-load-url');
	$.get(href, function(data) {
		$('<div id="login-form-popup" class="modal fade" role="dialog">' + data + '</div>').modal('show');
	});

});
$(document).on('hide.bs.modal', '#login-form-popup', function (e) {
	$('#login-form-popup').remove();
});