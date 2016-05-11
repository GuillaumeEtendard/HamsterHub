$(function () {
    $("form").submit(function () {
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();

        var modalWindow = $(".modalWindow");
        var loader = $(".loader");
        $('.error').html("");
        $.ajax({
            url: '/' + this.name,
            method: 'POST',
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,

            success: function (data) {
                location.reload();
                loader.css('display', 'block');
                modalWindow.css('visibility', 'hidden');
            },

            error: function (data, status, error) {
                $('form input, form select').removeClass('inputTxtError');
                $('label.error').remove();
                data = JSON.parse(data.responseText);

                $.each(data.errors, function(i, v) {
                    var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                });
            }
        });
        return false;
    });
});