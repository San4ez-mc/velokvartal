$(document).ready(function () {
   if ($('.ns-smv .pagination li.active').next('li').length > 0) {
        $('.pagination').before('<div id="showmore" class="box-showmore"><span onclick="showmore();" class="box-ajax-load"><img src="catalog/view/theme/cyberstore/image/showmore.svg" alt=""></span></div>');
    }
});

function showmore() {
    var $next = $('.ns-smv .pagination li.active').next('li');
	$('#showmore span').addClass('active-load');
    if ($next.length == 0) {
        return;
    }

     $.get($next.find('a').attr('href'), function (data) {

        $data = $(data);
        var $container = $('.row-price');
		var $products = $data.find('.row-price > div');
		var $product_img = $products.find('a > img');
		var $product_div_height = $products.find('.product-thumb .option.productpage-opt');

		setTimeout(function () {
		max_height_div($product_div_height);
		},350);
		$product_img.each(function () {
			if ($(this).attr('data-status')) {
				var status = $(this).attr('data-status');
				$(this).after('<div class="product_status">'+status+'</div>');
			}
			if ($(this).attr('data-additional-hover')) {
				var img_src = $(this).attr('data-additional-hover');
				$(this).addClass('main-img');
				$(this).after('<img src="'+img_src+'" class="additional-img-hover img-responsive" title="'+$(this).attr('alt')+'" />');
			}
		});

		if(localStorage.getItem('display') == 'grid'){
			cols = $('#column-right, #column-left').length;
			$('#content .row-price > .clearfix').remove();
			if (cols == 2) {
				$products.attr('class', 'product-layout product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
			} else if (cols == 1) {
				$products.attr('class', 'product-layout product-grid col-lg-4 col-md-6 col-sm-6 col-xs-12');
			} else {
				$products.attr('class', 'product-layout product-grid col-lg-3 col-md-4 col-sm-6 col-xs-12');
			}
			$container.append($products);
			if (cols == 2) {
				$('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
			} else if (cols == 1) {
				$('#content .product-layout:nth-child(3n+3)').after('<div class="clearfix visible-lg"></div>');
			} else {
				$('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix visible-lg"></div>');
			}

		}
		if(localStorage.getItem('display') == 'grid4'){
			cols = $('#column-right, #column-left').length;
			$('#content .row-price > .clearfix').remove();
			if (cols == 2) {
				$products.attr('class', 'product-layout product-grid grid4 col-lg-6 col-md-6 col-sm-12 col-xs-12');
			} else if (cols == 1) {
				$products.attr('class', 'product-layout product-grid grid4 col-1 col-lg-3 col-md-4 col-sm-6 col-xs-12');
			} else {
				$products.attr('class', 'product-layout product-grid grid4 col-lg-1-5 col-md-3 col-sm-6 col-xs-12');
			}
			$container.append($products);
			if (cols == 2) {
				$('#content .product-layout:nth-child(2n+2)').after('<div class="clearfix visible-md visible-sm"></div>');
			} else if (cols == 1) {
				$('#content .product-layout:nth-child(4n+4)').after('<div class="clearfix visible-lg"></div>');
			} else {
				$('#content .product-layout:nth-child(5n+5)').after('<div class="clearfix visible-lg"></div>');
			}
		}
		if(localStorage.getItem('display') == 'list'){
			$('#content .row-price > .clearfix').remove();
			$products.attr('class', 'product-layout product-list col-xs-12');
			$('#content .row-price').css('margin-left', '-15px').css('margin-right', '-15px');
			$container.append($products);
		}
		if(localStorage.getItem('display') == 'price'){
			$('#content .row-price > .clearfix').remove();
			$('#content .row-price').css('margin-left', '0').css('margin-right', '0');
			$products.attr('class', 'product-layout product-price col-xs-12');
			$container.append($products);
		}
		$('.col-sm-12.text-right').html($data.find('.col-sm-12.text-right'));
        $('.pagination').html($data.find('.pagination > *'));
        if ($('.ns-smv .pagination li.active').next('li').length == 0) {
            $('#showmore').hide();
        }
		setTimeout(function () {
			if (localStorage.getItem('display') != 'price'){
				$(".image-carousel-category").each(function() {
				 var items = $(this);
					for (var i = 0; i < items.length; i++) {
						if($(items).data('owlCarousel')){
							$(items).data('owlCarousel').destroy();
						}
						$(".additional-image").removeClass('hidden');
							$(items).owlCarousel({
								navigation : true,
								pagination:false,
								navigationText: ['<div class="btn btn-carousel-image-additional list next-prod"><i class="fa fa-angle-left arrow"></i></div>', '<div class="btn btn-carousel-image-additional prev-prod"><i class="fa fa-angle-right arrow"></i></div>'],
								singleItem:true,
								transitionStyle: 'fade'
							});
					}
				});
			}
		}, 200);
		$('#showmore span').removeClass('active-load');
        $data.filter('script').each(function () {
            if ((this.text || this.textContent || this.innerHTML).indexOf("document.write") >= 0) {
                return;
            }
            $.globalEval(this.text || this.textContent || this.innerHTML || '');
        });
		if (typeof loadEditorplus === 'function') {
			setTimeout ('loadEditorplus()', 1500);
		}


    }, "html");
    return false;
}