window.onload = function () {
    var button = $('button');
    button.click(function () {
        var window = document.querySelectorAll("." + this.name + "Window");
        var modal = document.querySelectorAll(".modal");

        var height = (document.body.clientHeight);
        height = height / 4;
        $('.aside').css({zIndex: -1});
        $('iframe').css({zIndex: -1});
        for (var i = 0; i < window.length; i++) {
            window[i].style.display = "block";
            window[i].style.pointerEvents = "auto";
        }
        return false;
    });
    var close = $('.close');
    close.click(function () {
        $('.modalWindow').css('display', 'none');
        $('iframe').css({zIndex: 1});
        $('.aside').css({zIndex: 1});
    });

};