let allSwipers = [];
jQuery(document).ready(function ($) {
	initComponentOnReady($);
});

function initComponentOnReady($) {
console.log("Inicio");
    allSwipers.forEach(swiper => swiper.destroy());
    allSwipers = [];

    initSwiperImages('.swiper-images', true, 1, 1, true);
}

jQuery(window).on('resize', function () {
    allSwipers.forEach(swiper => swiper.destroy());
    allSwipers = [];

    initSwiperImages('.swiper-images', true, 1, 1, true);
});

function initSwiperImages(className, loop = true, slidesPerView = 'auto', slidesPerGroup = 1, center = true, forceSlider = false, initialSlide = 0) {
    let screenWidth = jQuery(window).outerWidth();

    if(typeof allSwipers[className] != 'undefined')
    {
        jQuery(className + ' .swiper-wrapper').removeAttr('style');
        jQuery(className + ' .swiper-slide').removeAttr('style');
        allSwipers[className].destroy();
        allSwipers[className] = undefined;
    }

    if (screenWidth <= 767)
    {
        try {
            jQuery(className).each(function () {
                allSwipers[className] = new Swiper(jQuery(this), {
                    direction: 'horizontal',
                    loop: loop,
                    slidesPerView: 1,
                    spaceBetween: 10,
                    centeredSlides: center,
                    slidesPerGroup: slidesPerGroup,
                    initialSlide: initialSlide,

                    navigation: {
                        nextEl: className + '-button-next',
                        prevEl: className + '-button-prev',
                    }

                });
            });
            jQuery(className + '-navigation').show();
        } catch (e) {}
    } 
    else if (screenWidth > 767)
    {
        if(typeof allSwipers[className] === 'undefined')
        {
            try {
                jQuery(className).each(function () {
                    allSwipers[className] = new Swiper(jQuery(this), {
                        direction: 'horizontal',
                        loop: loop,
                        slidesPerView: 3,
                        spaceBetween: 30,
                        centeredSlides: center,
                        slidesPerGroup: slidesPerGroup,
                        initialSlide: 1,

                        navigation: {
                            nextEl: className + '-button-next',
                            prevEl: className + '-button-prev',
                        },
                    });
                });

                if(jQuery(className).attr('data-size') <= 3)
                {
                    jQuery(className + '-navigation').hide();

                    jQuery(className + ' .swiper-wrapper').removeAttr('style');
                    jQuery(className + ' .swiper-slide').removeAttr('style');
                    allSwipers[className].destroy();
                    allSwipers[className] = undefined;
                }
                else
                {
                    jQuery(className + '-navigation').show();
                }
            } catch (e) {}
        }
    }
}