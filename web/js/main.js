function checkUrl(url)
{
    var pattern = /^((https?):\/\/)?(www.)?[a-zа-я0-9]+\.[a-zа-я]+(\/[a-zа-яA-ZА-Я0-9#]+\/?)*$/i;

    return pattern.test(url);
}

$(document).ready(function(){
    $('#form-submit').on('click', function(){
        var alertContainer = $('.alert-container');
        var url = $('#url');
        var type = $('#search_type');

        if (checkUrl(url.val())) {
            alertContainer.removeClass('alert-danger').html('').hide();
            url.removeClass('is-invalid');

            $.ajax({
                type: 'post',
                url: '/site/getPage',
                data: 'url=' + url.val() + '&type=' + type.val(),
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                }
            });
        }
        else {
            url.addClass('is-invalid');
            alertContainer.addClass('alert-danger').html('Введите корректный адрес сайта').show();
        }
    })
});
