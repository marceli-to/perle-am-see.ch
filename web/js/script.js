$(document).ready(function(){
    function sticky_navbar() {
        var scrollDown = 180;
        if ($(window).width() < 992) {
            scrollDown = 85;
        }

        if ($(this).scrollTop() > scrollDown) {
            $('#navbar').addClass('navbar-fixed');
        } else {
            $('#navbar').removeClass('navbar-fixed');
        }
    }

    function hash_to_scroll(hash = '') {
        if($(hash).length > 0) {
            var navbar_gap = 80;
            if ($(window).width() < 992) {
                navbar_gap = 65;
            }

            $('html, body').animate({
                scrollTop: ($(hash).offset().top - navbar_gap)
            }, 10, 'swing');
        }
    }

	$('.nav-subnav').each(function(){
		$(this).closest('.nav-item').addClass('nav-has-subnav');
		var subnav_toggler = '<span class="nav-subnav-toggler"></span>';
		$(subnav_toggler).insertBefore($(this));
	});

    sticky_navbar();
	$(window).scroll(function () {
		sticky_navbar();
    });

    $('#navbar .navbar-nav a[href*=\\#], .smooth-scroll-to').click(function(e){
        if(this.pathname === window.location.pathname){
            e.preventDefault();
            var hash = $(this).attr('href');
            hash = hash.split("#").pop();
            hash = '#' + hash;
            console.log(hash);
            hash_to_scroll(hash);
        }
    });

    var hash = window.location.hash;
    hash_to_scroll(hash);

    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });

    $(document).on('click', '.nav-subnav-toggler', function(e){
        e.preventDefault();
        $(this).next().slideToggle();
    });

    $('#kontakt-forms-toggler').on('change', function(){
        var form = "#kontakt-form-" + $(this).val();
        $('#kontakt-forms').find('form:not(' + form + ')').hide();
        $(form).show();
    });
});