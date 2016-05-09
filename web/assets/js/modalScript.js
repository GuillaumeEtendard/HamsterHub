window.onload = function () {
    var button = $('button');
    button.click(function () {
        var window = document.querySelectorAll("." + this.name + "Window");
        var modal = document.querySelectorAll(".modal");

        var height = (document.body.clientHeight);
        height = height / 4;

        for (var i = 0; i < window.length; i++) {
            window[i].style.display = "block";
            window[i].style.pointerEvents = "auto";
           /* for (var a = 0; a < modal.length; a++) {
                modal[a].style.margin = height + "px auto";
            }*/
        }
        return false;
    });
    var close = $('.close');
    close.click(function () {
        $('.signUpWindow').css('display', 'none');
    });
    close.click(function () {
        $('.signInWindow').css('display', 'none');
    });
    close.click(function () {
        $('.addVideoWindow').css('display', 'none');
    });
    close.click(function () {
        $('.editVideoWindow').css('display', 'none');
    });
    close.click(function () {
        $('.deleteVideoWindow').css('display', 'none');
    });
    close.click(function () {
        $('.deleteCommentWindow').css('display', 'none');
    });
};