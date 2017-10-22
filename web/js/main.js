'use strict';

$(document).ready(function(){
    var types = ['link', 'image', 'text'];

    var alertContainer = $('.alert-container');
    var url = $('#url');
    var type = $('#search-type');
    var searchText = $('#search-text');

    if ($('#main-form').length !== 0) {
        $('#main-form')[0].reset();
    }

    $('.highslide').on('click', function(){
        $(this).hide();
        $('.values-container').hide();
    });

    $('.show-values').on('click', function(){
        $('.highslide').show();

        console.log(window.pageYOffset);

        $(this).siblings('.values-container').css({top: window.pageYOffset + 100}).show();
    });

    type.on('change', function(){
        if ($(this).val() === 'text') {
            $('#search-label').show();
        } else {
            $('#search-label').hide();
            searchText.val('');
        }
    });

    $('#form-submit').on('click', function(){
        resetErrors();

        var error = validateForm();

        if (error === '') {
            $.ajax({
                type: 'post',
                url: '/site/getPage',
                data: $('#main-form').serialize(),
                dataType: 'json',
                success: function(response) {
                    if (!response.error) {
                        alertContainer.addClass('alert-success').html('Перейти на <a href="/site/result">страницу результатов</a>').show();
                    } else {
                        alertContainer.addClass('alert-danger').html(response.description).show();
                    }
                }
            });
        } else {
            alertContainer.addClass('alert-danger').html(error).show();
        }
    });

    function checkUrl(url)
    {
        var pattern = /^((https?):\/\/)?(www.)?([a-zа-я0-9]+\.)+[a-zа-я]{2,}(:\d+)?\/?$/i;

        return pattern.test(url);
    }

    function validateForm()
    {
        var error = '';

        if ($.inArray(type.val(), types) === -1) {
            type.addClass('is-invalid');

            error += '<span>Укажите корректный тип поиска</span>';
        }

        if (!checkUrl(url.val())) {
            url.addClass('is-invalid');

            error += '<span>Укажите корректный адрес сайта</span>';
        }

        if (type.val() === 'text' && searchText.val() === '') {
            searchText.addClass('is-invalid');

            error += '<span>Укажите текст для поиска</span>';
        }

        return error;
    }

    function resetErrors()
    {
        alertContainer.removeClass('alert-success').removeClass('alert-danger').html('').hide();

        url.removeClass('is-invalid');
        type.removeClass('is-invalid');
        searchText.removeClass('is-invalid');
    }
});
