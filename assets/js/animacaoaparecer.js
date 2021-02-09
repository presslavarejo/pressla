var root = document.documentElement;
root.className += ' js';

function boxTop(idBox) {
    var boxOffset = $(idBox).offset().top;
    return boxOffset;
}

$(document).ready(function() {
    var $target3 = $('.deBaixo'),
            animationClass3 = 'deBaixo-init',
            windowHeight = $(window).height(),
            offset = windowHeight - (windowHeight / 5);

    function animeScroll3() {
        var documentTop = $(document).scrollTop();
        $target3.each(function() {
            if (documentTop > boxTop(this) - offset) {
                $(this).addClass(animationClass3);
                if(documentTop > $('#contatos').offset().top){
                    $('.home').removeClass("ativo");
                    $('.contato').addClass("ativo");
                } else {
                    $('.home').addClass("ativo");
                    $('.contato').removeClass("ativo");
                }
            } else {
                $(this).removeClass(animationClass3);
            }
        });
    }
    animeScroll3();

    $(document).scroll(function() {
        setTimeout(function() {animeScroll3();}, 150);
    });
});