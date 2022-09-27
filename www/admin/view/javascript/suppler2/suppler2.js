jQuery(document).ready(function ($) {
    $('.check_xml').click(function (e) {
        const link = $('[name=link]').val();
        const token = $('[name=token]').val();

        let id = $('[name=id]').val();
        const id_str = (id.length > 0 ? '&id=' + id : '');

        let authorization_string = '&need_authorization=0';
        if ($('.need_authorization').prop('checked')) {
            authorization_string = '&need_authorization=1&login=' + $('[name=login]').val() + '&password=' + $('[name=password]').val();
        }

        $.ajax({
            url: 'index.php?route=catalog/suppler2/check_xml_ajax&user_token=' + token,
            type: 'post',
            data: 'link=' + link + id_str + authorization_string,
            dataType: 'json',
            beforeSend: function () {
                $('.check_xml').hide().after('<img class="loader" src="/admin/view/image/suppler2/loader.gif"/>');
            },
            complete: function () {
                // $('.check_xml').show();
                $('.loader').remove();

            },
            success: function (json) {
                $('.ajax_upload').html('');

                if (json.status == 'ok') {
                    if (json.routes !== undefined) {
                        let html = '<ul class="text-left tree_of_routes">';
                        // $('.ajax_upload').append('<ul class="text-left">');
                        if (json.routes.length > 0) {
                            json.routes.forEach(function (route) {
                                html += '<li><a class=""  data-route="' + route.route + '"  href="#">' + route.text + '</a></li>';
                                // $('.ajax_upload').append('<li><a class="" href="#">' + route.text +'</a>');

                                if (route.children.length > 0) {
                                    // $('.ajax_upload').append('<ul>');
                                    html += '<ul class="text-left">';
                                    route.children.forEach(function (route_) {
                                        html += '<li><a class="" data-route="' + route_.route + '" href="#">' + route_.text + '</a></li>';
                                        // $('.ajax_upload').append('<li><a class="" href="#">' + route_.text +'</a>');

                                        if (route_.children.length > 0) {
                                            // $('.ajax_upload').append('<ul>');
                                            html += '<ul class="text-left">';
                                            route_.children.forEach(function (route__) {
                                                html += '<li><a class="" data-route="' + route__.route + '" href="#">' + route__.text + '</a></li>';
                                                // $('.ajax_upload').append('<li><a class="" href="#">' + route_.text +'</a>');
                                            });
                                            // $('.ajax_upload').append('</ul>');
                                            html += '</ul>';
                                        }

                                    });
                                    // $('.ajax_upload').append('</ul>');
                                    html += '</ul>';
                                }
                            });
                        }
                        // $('.ajax_upload').append('</ul>');
                        html += '</ul>';

                        show_log($('.ajax_upload'), json.message, 'info', false);

                        $('.ajax_upload').append(html);

                    }
                } else {
                    show_log($('.ajax_upload'), json.message, 'danger', false);
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    });

    $('.start_upload').click(function (e) {
        $('.ajax_upload').html('').append('<img class="loader" src="/admin/view/image/suppler2/loader.gif"/>');
        let ids = [];
        $('.supplers_checkbox').each(function () {
            if ($(this).prop('checked')) {
                ids.push($(this).attr('data-suppler_id'))
            }
        });
        const token = $('[name=token]').val();
        upload(ids, token, true);
    });

    $(document).on('click', '.tree_of_routes a', function (e) {
        e.preventDefault();
        const route = $(this).attr('data-route');
        $('[name=route]').val(route);
        get_xml_vars();
    });

    $(document).on('click', '.show_more', function (e) {
        e.preventDefault();
        $(this).next('span').removeClass('hidden');
        $(this).remove();
    });

    $(document).on('click', '.select_all', function (e) {
        if ($(this).prop('checked')) {
            $('.supplers_checkbox').each(function () {
                $(this).prop('checked', true);
            });
        } else {
            $('.supplers_checkbox').each(function () {
                $(this).prop('checked', false);
            });
        }
    });

    $(document).on('click', '.delete_btn', function (e) {
        const delete_link = $(this).attr('data-href');
        let list = [];
        $('.suppler_list_checkbox').each(function () {
            if ($(this).prop('checked')) {
                list.push($(this).val())
            }
        });

        if (list.length > 0) {
            $.ajax({
                url: delete_link,
                type: 'post',
                data: {
                    selected: list
                },
                dataType: 'json',
                success: function (json) {
                    console.log(json);
                    if (json.status === 'ok') {
                        location.reload();
                    } else {
                        console.log(json.message);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });
        }
    });

    $(document).on('click', '.get_next_product', function (e) {
        e.preventDefault();
        get_xml_vars()
    });

    $(document).on('click', '.need_authorization', function (e) {
        if ($(this).prop('checked')) {
            $('.can_be_hidden').removeClass('hidden');
        } else {
            $('.can_be_hidden').addClass('hidden');
        }
    });

    $(document).on('change', '.site_key', function (e) {
        const quantity_setting_url = $(this).attr('data-quantity_setting_url');
        const tr = $(this).parents('tr');
        if ($(this).val() === 'quantity') {
            $.ajax({
                url: quantity_setting_url,
                type: 'post',
                dataType: 'json',
                success: function (json) {
                    console.log(json);
                    if (json.status === 'ok') {
                        tr.after(json.html);
                    } else {
                        console.log(json.message);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                }
            });

        }
    });
});

function show_log(target, message, type = 'info', break_ = false) {
    let html = '<div class="alert alert-' + type + '" role="alert">' +
        message +
        '</div>';

    if (break_) {
        html += '<br/><br/>';
    }

    target.append(html);
    if ($('.list_end').length > 0) {
        $(document).scrollTop($('.list_end').offset().top);
    }
}

function upload(ids, token, is_first = false) {
    if (ids.length > 0) {
        const id = ids.shift();
        // console.log(id);
        $.ajax({
            url: 'index.php?route=catalog/suppler2/start_xml_ajax&user_token=' + token,
            type: 'post',
            data: 'id=' + id,
            dataType: 'json',
            success: function (json) {
                if (json.status === 'ok') {
                    if (is_first) {
                        $('.ajax_upload').html('');
                    }

                    if (json.logs.length > 0) {
                        json.logs.forEach(function (log) {
                            show_log($('.ajax_upload'), log.message, log.type, log.break || false);
                        })
                    }
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        });
    }
}

function get_xml_vars() {
    const route = $('[name=route]').val();
    const link = $('[name=link]').val();
    const product_number = $('[name="product_number_to_check"]').length > 0 ? $('[name="product_number_to_check"]').val() - 1 : $('[name=product_number]').val() - 1;
    const token = $('[name=token]').val();

    let id = $('[name=id]').val();
    const id_str = (id.length > 0 ? '&id=' + id : '')
    const route_str = (route !== undefined ? '&route=' + route : '')

    $.ajax({
        url: 'index.php?route=catalog/suppler2/get_xml_vars_ajax&user_token=' + token,
        type: 'post',
        data: 'link=' + link + id_str + route_str + '&product_number=' + product_number,
        dataType: 'json',
        beforeSend: function () {
            $('.ajax_upload').html('').append('<img class="loader" src="/admin/view/image/suppler2/loader.gif"/>');
        },
        complete: function () {
            $('.loader').remove();
        },
        success: function (json) {
            $('.ajax_upload').html('');
            if (json.status == 'ok') {
                $('[name=route]').val(route);
                if (json.rows !== undefined) {
                    $('.ajax_upload').html(json.html);
                }
            } else {
                show_log($('.ajax_upload'), json.message, 'danger', false);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}