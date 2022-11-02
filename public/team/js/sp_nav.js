//sp nav
$('.sp_nav').on('click', function () {
    if ($(this).hasClass('active')) {
        $(this).removeClass('active');
        //$('main').removeClass('open');
        $('nav').removeClass('open');
        $('.overlay').removeClass('on');
    } else {
        $(this).addClass('active');
        //$('main').addClass('open');
        $('nav').addClass('open');
        $('.overlay').addClass('on');
    }
});
$('.overlay').on('click', function () {
    if ($(this).hasClass('on')) {
        $(this).removeClass('on');
        $('.sp_nav').removeClass('active');
        //$('main').removeClass('open');
        $('nav').removeClass('open');
    }
});
