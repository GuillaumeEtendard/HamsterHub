$(function () {
    var subMenuHamburger = $('.subMenuHamburger');
    var hamburgerMenu = $('.hamburgerMenu');
    hamburgerMenu.click(function () {
        if(subMenuHamburger.css('display') == 'inline-block' || subMenuHamburger.css('display') == 'block'){
            subMenuHamburger.css('display', 'none');
        }else{
            subMenuHamburger.css('display', 'inline-block');
        }
    });

});