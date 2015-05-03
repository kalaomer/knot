$(document).ready(function() {
    $('[data-typer-targets]').typer();
    $.typer.options.highlightSpeed    = 20;
    $.typer.options.typeSpeed         = 40;
    $.typer.options.clearDelay        = 1000;
    $.typer.options.typeDelay         = 100;
    $.typer.options.clearOnHighlight  = true;
    $.typer.options.typerInterval     = 1000;

    var navigationTop = Math.floor($('#fix-navigation').offset().top);

    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= navigationTop) {
            $(".side-navigation").addClass("fixed");
        } else {
            $(".side-navigation").removeClass("fixed");
        }
    });
});
