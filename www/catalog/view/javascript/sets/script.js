  (function($) {
      $.fn.pop = function() {
          var top = this.get(-1);
          this.splice(this.length - 1, 1);
          return top;
      };
      $.fn.shift = function() {
          var bottom = this.get(0);
          this.splice(0, 1);
          return bottom;
      };
  })(jQuery);
  $(document).ready(function() {
      kjset.initEvent();
      startTimer();
  });

  function timeConverter(UNIX_timestamp) {
      var a = new Date(UNIX_timestamp * 1000);
      var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
      var year = a.getFullYear();
      var month = months[a.getMonth()];
      var date = a.getDate();
      var hour = a.getHours();
      var min = a.getMinutes();
      var sec = a.getSeconds();
      var time = date + ' ' + month + ' ' + year + ' ' + hour + ':' + min + ':' + sec;
      return time;
  }

  function startTimer() {
      var i = 1;
      $('.set').each(function() {
          var set=this;
          var timestamp = $(this).find("input[name='sp_timer']").val();
          if (timestamp == 0) 
          {
             $(this).find('.timer').hide();
              return;
          }
          var sel = $(this).find('.timer');
          var countDownDate = new Date(timeConverter(timestamp)).getTime();
          // Update the count down every 1 second
          var x = setInterval(function() {
              // Get todays date and time
              var now = new Date().getTime();
              // Find the distance between now and the count down date
              var distance = countDownDate - now;
              // Time calculations for days, hours, minutes and seconds
              var days = Math.floor(distance / (1000 * 60 * 60 * 24));
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);
              // Display the result in the element with id="demo"
              var text = "До конца акции: ";
              if (days !== 0) text += days + " д. ";
              if (hours !== 0 || days !== 0) text += hours + " ч. ";
              if (minutes !== 0 || hours !== 0 || days !== 0) text += minutes + " м. ";
              if (seconds !== 0 || minutes !== 0 || hours !== 0 || days !== 0) text += seconds + " с. ";
              $(sel).html(text);
              // If the count down is finished, write some text 
              if (distance <= 0) {
                  clearInterval(x);
                  $(set).find('.add-set-btn').hide( "slow");
                  $(sel).html('');
              }
          }, 1000);
      });
  }

  function kjsetInitCarousel(s) {
      $('.sets').show();
      
      var swipers = $(s);
      $(swipers).each(function(i, sw) {
          var myclass = "myswiper" + i;
          $(sw).addClass(myclass);
          var click = false;
          var swiper = new Swiper($("." + myclass), {
              mode: 'horizontal',
              slidesPerView: 1,
              nextButton: '.swiper-button-next',
              prevButton: '.swiper-button-prev',
              spaceBetween: 0,
              autoplay: 5000,
              autoplayDisableOnInteraction: true
          });
          $("." + myclass).hover(function() {
              swiper.stopAutoplay();
          }, function() {
              if (!click) swiper.startAutoplay();
          });
          $("." + myclass).find(".add-set-btn").click(function() {
              click = true;
              swiper.stopAutoplay();
          });
      });
  }
  //object kjset
 var kjset = {
      product_id: null,
      iset: null,
      gproducts: [],
      set_modal: false,
      current_set: null,
      initEvent: function() {
          var obj = this;
          $(".add-set-btn").click(function() {
              $(this).button('loading');

              $(this).parents('.sets-owl').trigger('autoplay.stop.owl');
              product_id = $(this).parents('.set').find("input[name='sp_product_id']").val();
              iset = $(this).parents('.set').find("input[name='sp_iset']").val();
              gproducts = $(this).parents('.set').find('.set-product').filter(function(index) {
                  return $(this).find("input[name='sp_include']").is(":checked");
              });
              products = $(this).parents('.set').find('.set-product').filter(function(index) {
                  return $(this).find("input[name='sp_include']").is(":checked");
              });

              obj.current_set = $(this).parents('.set');

              obj.recuesiveCheckSetOptions(products);
              $(".sets-owl").trigger("owl.stop");
          });
          $("input[name='sp_set_quantity']").change(function() {
              obj.current_set = $(this).parents('.set');
              obj.update_total();
          });
          $(".set input[name='sp_include']").change(function() {
              obj.current_set = $(this).parents('.set');
              obj.update_total();
          });
          $(".set-options").remove().appendTo('body');
          $('.apply-options').on('click', function() {
              var btn_id = $(this).parents('.modal').attr('id');
              $('button[data-target="#' + btn_id + '"]').parents('.set').find('.add-set-btn').first().trigger("click");
          });
          $(".set-options select,.set-options input[type='radio'],.set-options input[type='checkbox']").change(function() {
              var options = $(this).parents('.set-options').find("select option:selected,input[type='radio']:checked,input[type='checkbox']:checked");
              var btn_id = $(this).parents('.set-options').attr("id");
              var product = $("button[data-target='#" + btn_id + "'").parents('.set-product');
              obj.current_set = $(product).parents('.set');
              var cprice = parseFloat($(product).find("input[name='sp_cprice']").val());
              var eq_mod = false;
              var total = cprice;
              $(options).each(function() {
                  var pre = $(this).data('prefix');
                  var price = parseFloat($(this).data('price'));
                  if (pre.length != 0 && isNaN(price) == false) {
                      switch (pre) {
                          case '-':
                              total -= price;
                              break;
                          case '+':
                              total += price;
                              break;
                          case '=':
                              total = price;
                              break;
                          case '*':
                              total *= price;
                              break;
                          case '/':
                              total /= price;
                              break;
                          case 'u':
                              total = total + (($total * price) / 100);
                              break;
                          case 'd':
                              total = total - ((total * price) / 100);
                              break;
                          default:
                              break;
                      }
                  }
              });
              total -= cprice;
              $(product).find("input[name='sp_option_price']").val(total);
              obj.update_total();
          });
      },
      initCarousel: function() {
          kjsetInitCarousel(".sets-owl");
      },
      numberWithSpaces: function(number) {
          //return number;
          return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
      },
      roundNumber: function(number) {
          decimals = parseInt(getDecimal());
          var dec = Math.pow(10, decimals)
          var part1, part2;
          var nnumber;
          if (decimals) {
              nnumber = "" + Math.round(parseFloat(number) * dec + .0000000000001);
              if (number > 1) part1 = nnumber.slice(0, -1 * decimals);
              else part1 = "0";
              part2 = nnumber.slice(-1 * decimals);
              return this.numberWithSpaces(part1) + "." + part2;
          } else return this.numberWithSpaces(Math.round(number));
      },
      animateCounter: function(selector, oldp, newp) {
          var obj = this;
          if (oldp !== newp) $(selector).prop('Counter', oldp).animate({
              Counter: newp
          }, {
              duration: 500,
              easing: 'swing',
              step: function(now) {
                  $(this).text(Math.ceil(now));
              },
              complete: function() {
                  $(selector).html(obj.roundNumber(newp));
              }
          });
      },
      update_total: function() {
          var obj = this;
          var set = obj.current_set;
          var cprice;
          var option_price;
          var qty;
          var qqty;
          var actual_price;
          var total = 0;
          var start;
          var total_economy = 0;
          var economy;
          var qs = parseInt($(set).find("input[name='sp_set_quantity']").val());
          if (set.length > 1) set = $(set).last();
          $(set).find('.set-product').each(function(index) {
              if ($(this).find("input[name='sp_include']").length)
                  if ($(this).find("input[name='sp_include']").is(':checked') == false) return;
              qqty = qty = parseInt($(this).find("input[name='sp_quantity']").val());
              qty *= qs;

              if ($(this).find('input[name="sp_discounts_json"]').length) {
                  var discounts = JSON.parse($(this).find('input[name="sp_discounts_json"]').val());
                  $.each(discounts, function(index, value) {
                      if (qty >= parseInt(index)) cprice = value;
                  });
              } else cprice = parseFloat($(this).find("input[name='sp_cprice']").val());


              if($(this).find('input[name="sp_discount_from"]').val()=='old')
                  cprice_for_disc = parseFloat($(this).find("input[name='sp_oldcprice']").val());
              else
                  cprice_for_disc=cprice;

              option_price = parseFloat($(this).find("input[name='sp_option_price']").val());
              discount = $(this).find("input[name='sp_discount']").val();
              cprice += option_price;
              cprice_for_disc += option_price;

              if (discount.substring(discount.length - 1) == "%") 
                economy = (cprice_for_disc / 100) * parseFloat(discount.slice(0, -1));
              else 
                economy = discount / qqty;

              total_economy += economy * qty;
              total += (cprice * qty);
              cprice -= economy;
              start = parseFloat(($(this).find('.new_price .num').html()).replace(/\s/g, ''));
              obj.animateCounter($(this).find(".new_price .num"), start, cprice);
          });
          total_economy = getRoundEconomy(total_economy);
          total -= total_economy;
          if ($(set).find('.set-total .economy').length) {
              start = parseFloat(($(set).find('.set-total .economy .economy_val .num').html()).replace(/\s/g, ''));
              obj.animateCounter($(set).find('.set-total .economy .economy_val .num'), start, total_economy);
              if (total_economy != 0) $(set).find('.set-total .economy').fadeTo("slow", 1);
              else $(set).find('.set-total .economy').fadeTo("slow", 0);
          }
          start = parseFloat(($(set).find('.set-total .new_summ .num').html()).replace(/\s/g, ''));
          obj.animateCounter($(set).find('.set-total .new_summ .num'), start, total);
      },
        addSetToCart: function() {
          var products = {};
          var jsons = [];
          var obj = this;
          var qs = parseInt($(obj.current_set).find("input[name='sp_set_quantity']").val());
          var newproducts={};
          var lastprod;

          $.each(gproducts, function(key, value) {
            var options = obj.getOptions(value);
            var product_id = $(value).find('input[name="sp_product_id"]').val();
            var quantity = $(value).find('input[name="sp_quantity"]').val();
            var post_products = {};
            post_products.product_id = product_id;
            post_products.quantity = quantity*qs;

            post_products.option=$(options).filter('*[name^="sp_option["]').serialize();
            newproducts[key]=post_products;

          });

          $.ajax({
            url: 'index.php?route=extension/module/sets/addSetToCart',
            type: 'post',
            async: false,
            data: {products:newproducts},
            dataType: 'json',
            success: function(json) {
              $('.set-options').find('input[type=\'text\'], input[type=\'date\'], input[type=\'time\'], input[type=\'datetime\'],  select, textarea').val('');
              $('.set-options').find('input[type=\'radio\'], input[type=\'checkbox\']').removeAttr('checked');
              kjsetAddSetToCartSuccess(json);
              var btn = $(obj.current_set).find(".add-set-btn");
              $(btn).button('success');
              setTimeout(function() {
                obj.clearOptionPrice();
                obj.update_total();
                $(btn).button('reset');
              }, 2000);
            }
          });


        },
      addSetToCartSuccess: function(json) {
          kjsetAddSetToCartSuccess(json);
      },
      clearOptionPrice: function() {
          $("input[name='sp_option_price']").val(0);
      },
      addSetToTotal: function() {
          var obj = this;
          $.ajax({
              url: 'index.php?route=extension/module/sets/addSetToTotal',
              type: 'post',
              data: {
                  sp_product_id: product_id,
                  sp_iset: iset
              },
              dataType: 'json',
              success: function() {
                  obj.addSetToCart(iset);
              }
          });
      },
      getOptions: function(product) {
          var modal_selector = $($(product).find('.open-options').data('target'));
          var options = $(product).find('input[type="hidden"],input[type="checkbox"]');
          if (modal_selector.length) {
              var options_modal = $(modal_selector).find('input[type=\'text\'], input[type=\'hidden\'], input[type=\'date\'], input[type=\'time\'], input[type=\'datetime\'], input[type=\'radio\']:checked, input[type=\'checkbox\']:checked, select,  textarea');
              var options = $.merge(options_modal, options);
          }
          return options;
      },
      recuesiveCheckSetOptions: function(products) {
          var obj = this;
          var product = products.shift();
          var options = obj.getOptions(product);
          var modal_selector = $($(product).find('.open-options').data('target'));
          $.ajax({
              url: 'index.php?route=extension/module/sets/checkProductOption',
              type: 'post',
              data: options,
              dataType: 'json',
              success: function(json) {
                  $(modal_selector).find('.text-danger').parent().removeClass('has-error');
                  $(modal_selector).find('.text-danger').remove();
                  if (json['error']) {

                      var btn = $(obj.current_set).find(".add-set-btn");
                      $(btn).button('reset');

                      if (json['error']['option']) {
                          $(".modal").modal('hide');
                          if (modal_selector.length) setTimeout(function() {
                              $(modal_selector).modal('show')
                          }, 500);
                          for (i in json['error']['option']) {
                              var element = $(modal_selector).find('#set-input-option' + i.replace('_', '-'));
                              if (element.parent().hasClass('input-group')) {
                                  element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                              } else {
                                  element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
                              }
                          }
                      }
                      if (modal_selector.length) $(modal_selector).find('.text-danger').parent().addClass('has-error');
                  } else if (json['success']) {
                      if (products.length > 0) obj.recuesiveCheckSetOptions(products);
                      else {
                          $(".modal").modal('hide');
                          obj.addSetToTotal();
                      }
                  }
              },
              error: function(xhr, ajaxOptions, thrownError) {
                  alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
              }
          });
      }
  };