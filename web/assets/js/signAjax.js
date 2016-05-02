$(function () {
    $("form").submit(function () {
        var $form = $(this);
        var formdata = (window.FormData) ? new FormData($form[0]) : null;
        var data = (formdata !== null) ? formdata : $form.serialize();

        var signInWindow = $(".signInWindow");
        var signUpWindow = $(".signUpWindow");
        var addVideoWindow = $(".addVideoWindow");
        var editVideoWindow = $(".editVideoWindow");
        var deleteVideoWindow = $(".deleteVideoWindow");
        var loader = $(".loader");

        $.ajax({
            url: '/' + this.name,
            method: 'POST',
            data: data,
            dataType: 'json',
            contentType: false,
            processData: false,

            success: function (data) {
                document.location.href = "/";
                loader.css('display', 'block');
                signInWindow.css('visibility', 'hidden');
                signUpWindow.css('visibility', 'hidden');
                addVideoWindow.css('visibility', 'hidden');
                editVideoWindow.css('visibility', 'hidden');
                deleteVideoWindow.css('visibility', 'hidden');
            },

            error: function (data, status, error) {
                $('form input, form select').removeClass('inputTxtError');
                $('label.error').remove();
                data = JSON.parse(data.responseText);

                $.each(data.errors, function(i, v) {
                    var msg = '<label class="error" for="'+i+'">'+v+'</label>';
                    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('inputTxtError').after(msg);
                });
               // var keys = Object.keys(data.errors);
               // $('input[name="'+keys[0]+'"]').focus();
            }
        });
        return false;
    });
});