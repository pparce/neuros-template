'use strict';

function animateHeading($scope) {
    if( $scope.data('settings') && $scope.data('settings')._animation && $scope.data('settings')._animation == 'neuros_heading_animation') {
        $scope.find('.neuros-heading-content').html($scope.find('.neuros-heading-content').html().replace(/(^|<\/?[^>]+>|\s+)([^\s<]+)/g, '$1<span class="word">$2</span>'));
        // $scope.find('.neuros-heading-content').contents().each(function() {
        //     if(this.nodeType === 3) {
        //         jQuery(this).wrap('<span></span>');
        //     }
        // });
        $scope.find('.neuros-heading-content .word').contents().each(function() {
            if(this.nodeType === 3) {
                jQuery(this).parent().html(jQuery(this).text().replace(/\S/g, '<span class="letter">$&</span>'));
            }
        });
        $scope.find('.neuros-heading-content .letter').each(function(index) {
            jQuery(this).css('animation-delay', index / 50 + 's');
        });
    }
}

function initModernProjects($el) {
    $el.find('.project-modern-listing .project-item-wrapper').first().addClass('active');
    $el.find('.project-modern-listing .project-item-modern-header').on('click', function() {
        var $projectItem = jQuery(this).closest('.project-item-wrapper');
        $projectItem.addClass('active');
        $projectItem.find('.project-item-modern-content').slideDown(400);
        $projectItem.siblings().removeClass('active');
        $projectItem.siblings().find('.project-item-modern-content').slideUp(400);
    });
}

function playProjectsSliderAudio($el) {
    $el.find('.project-listing-wrapper.project-slider-listing.content-type-audio').on('click', '.play-audio', function() {
        jQuery(this).closest('.owl-item').siblings().find('.project-audio-wrapper audio').each(function() {
            jQuery(this)[0].pause();
            jQuery(this)[0].currentTime = 0;
            jQuery(this).siblings('.play-audio').removeClass('active');
        });
        var audioElement = jQuery(this).siblings('audio')[0];
        if(audioElement.paused) {
            jQuery(this).addClass('active');
            audioElement.play();
        } else {
            audioElement.pause();
            audioElement.currentTime = 0;
            jQuery(this).removeClass('active');
        }
    });
}

function playListingAudio($el) {
    $el.find('.neuros-audio-listing').on('click', '.audio-item', function() {
        jQuery(this).closest('.audio-item-wrapper').siblings().find('.audio-item').each(function() {
            jQuery(this).removeClass('active');
            jQuery(this).find('audio')[0].pause();
            jQuery(this).find('audio')[0].currentTime = 0;
        });
        var audioElement = jQuery(this).find('audio')[0];
        if(audioElement.paused) {
            jQuery(this).addClass('active');
            audioElement.play();
        } else {
            audioElement.pause();
            audioElement.currentTime = 0;
            jQuery(this).removeClass('active');
        }
    });
}

function handleProjectsExcerptHeight() {
    jQuery('.project-listing-wrapper.project-slider-listing:not(.content-type-audio) .project-item').each(function() {
        const item = jQuery(this);
        const excerpt = jQuery(this).find('.post-excerpt-wrapper');
        excerpt.hide();
        item.on('mouseenter', function() {
            excerpt.delay(300).slideDown(300);
        });
        item.on('mouseleave', function() {
            excerpt.slideUp(300);
        });
   });
}

function initCardsProjects($scope) {
    jQuery('.body-container').css({
        overflow: 'visible'
    });
    const { ScrollObserver, valueAtPercentage } = aat;
    const cardsContainer = $scope.find('.project-cards-listing');
    const cards = $scope.find('.project-cards-listing .project-item-wrapper');
    cards.each(function(index) {
        if (index === cards.length - 1) {
            return;
        }
        const card = jQuery(this);                
        const toScale = 1 - (cards.length - 1 - index) * 0.05;
        const nextCard = cards[index + 1];
        const cardInner = card.find('.project-item');
        ScrollObserver.Element(nextCard, {
          offsetTop: 0,
          offsetBottom: window.innerHeight - card.height()
        }).onScroll(({ percentageY }) => {
            const scale = valueAtPercentage({
                from: 1,
                to: toScale,
                percentage: percentageY
            });
            cardInner.css('scale', scale);
            const filter = `brightness(${valueAtPercentage({
                from: 1,
                to: 0.6,
                percentage: percentageY
            })})`;
            cardInner.css('filter', filter);
            // jQuery(nextCard).css('padding-top', ((index + 1) * 20) + 'px');
        });
    });
}

function initMovingList($scope) {
    gsap.defaults({overwrite: "auto"});
    gsap.registerPlugin(ScrollTrigger);
    gsap.config({nullTargetWarn: false});
    $scope.find('.neuros-moving-list-widget').each(function(index) {
        const movingList = jQuery(this).find('.moving-list');
        // Calculate the x and xEnd values and divide them by 2
        const [x, xEnd] = (index % 2) ? 
        [(jQuery(this)[0].offsetWidth - movingList[0].scrollWidth) / 3, 5 / 2] : 
        [5 / 2, (jQuery(this)[0].offsetWidth - movingList[0].scrollWidth) / 3];
        gsap.fromTo(movingList[0], { x }, {
            x: xEnd,
            scrollTrigger: {
                trigger: jQuery(this)[0],
                scrub: 0.5, // Adjust this value to control the speed
            }
        });
    });
}

function initServicesButton($scope) {
    const items = $scope.find('.service-item');
    items.each(function() {
        const item = jQuery(this);
        item.on('mouseenter', function() {
            item.find('.button-container').slideDown(300);
        });
        item.on('mouseleave', function() {
            item.find('.button-container').slideUp(300);
        });
    });
}

jQuery(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_audio_listing.default', function ($scope) {
        playListingAudio($scope);
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_blog_listing.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 300);
            setTimeout(fix_responsive_iframe, 600);
            setTimeout(custom_video_play_button, 800);
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_gallery.default', function ($scope) {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 300);
            setTimeout(isotope_init, 2500);
        }
        if(jQuery('.cursor_drag', $scope).length > 0 && jQuery(window).width() >= 992) {
            const $slider = $scope.find('.gallery-wrapper');
            const cursor = jQuery('.cursor_drag', $scope);
            function showCustomCursor(event) {
                cursor.css('left', event.clientX-5).css('top', event.clientY-5);
            }
            $slider.mousemove(showCustomCursor);

            $slider.mouseleave(function(e) {
                if(!jQuery('body').hasClass('elementor-editor-active')) {
                    jQuery('.owl-stage', $scope).css({cursor: 'auto'});
                    jQuery('.gallery-item-link', $scope).css({cursor: 'auto'});
                    cursor.removeClass('active');
                    setTimeout(function() {
                        if(!cursor.hasClass('active')) {
                            cursor.hide();
                        }
                    }, 300); 
                }    
            });

            $slider.mouseenter(function(e) {
                if(!jQuery('body').hasClass('elementor-editor-active')) {
                    jQuery('.owl-stage', $scope).css({cursor: 'none'});
                    jQuery('.gallery-item-link', $scope).css({cursor: 'none'});
                    cursor.show();
                    setTimeout(function() {
                        cursor.addClass('active');
                    }, 10);  
                } 
            });
        }

    });    
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_projects_listing.default', function ($scope) {
        animateHeading($scope);
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
            setTimeout(isotope_init, 2500);
        }
        setTimeout(handleProjectsExcerptHeight, 500);
        if ( $scope.find('.project-modern-listing').length > 0 ) {
            var scopeID = $scope.attr('data-id');
            initModernProjects($scope);         
            jQuery('body').on('genre_get_posts_success', function(e, classes, id) {
                if(classes.indexOf('project-modern-listing') !== -1 && id === scopeID) {
                    initModernProjects($scope);
                }
            });
        }
        if ( $scope.find('.content-type-audio').length > 0 ) {
            playProjectsSliderAudio($scope);
        }
        if( $scope.find('.project-cards-listing').length > 0 ) {
            initCardsProjects($scope);
            var scopeID = $scope.attr('data-id');
            jQuery('body').on('genre_get_posts_success', function(e, classes, id) {
                if(classes.indexOf('project-cards-listing') !== -1 && id === scopeID) {
                    initCardsProjects($scope);
                }
            });
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_services_listing.default', function ($scope) {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
        }
        animateHeading($scope);
        initServicesButton($scope);
        var scopeID = $scope.attr('data-id');
        jQuery('body').on('genre_get_posts_success', function(e, classes, id) {
            if(classes.indexOf('service-grid-listing') !== -1 && id === scopeID) {
                initServicesButton($scope);
            }
        });
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_testimonial_carousel.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_image_carousel.default', function ($scope) {
        animateHeading($scope);
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_content_slider.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_wpforms.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            initFloatPlaceholderInput();
            initWPFormsSubmitButton();
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_mailchimp.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            initFloatPlaceholderInput();
            initWPFormsSubmitButton();
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/section.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            background_image_parallax(jQuery('[data-parallax="scroll"]'), 0.7);
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_heading.default', function ($scope) {
        animateHeading($scope);
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_step_carousel.default', function ($scope) {
        animateHeading($scope);
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
        }
    });
    elementorFrontend.hooks.addAction('frontend/element_ready/image.default', function ($scope) {
        if ( jQuery(window).width() >= 1025 ) {
            const cursor = jQuery('.hovered-text', $scope);

            function showCustomCursor(event) {
                cursor.css('left', event.clientX).css('top', event.clientY);
            }
            if ( cursor.length > 0 ) {
                $scope.mousemove(showCustomCursor);

                $scope.mouseleave(function (e) {
                    if (!jQuery('body').hasClass('elementor-editor-active')) {
                        jQuery('a', $scope).css({cursor: 'auto'});
                        $scope.css({cursor: 'auto'});
                        cursor.removeClass('active');
                    }
                });

                $scope.mouseenter(function (e) {
                    if (!jQuery('body').hasClass('elementor-editor-active')) {
                        jQuery('a', $scope).css({cursor: 'none'});
                        $scope.css({cursor: 'none'});
                        cursor.addClass('active');
                    }
                });
            }
        }
        if ( $scope.hasClass('elementor-image-scroll-animation-on') ) {
        	const { ScrollObserver, valueAtPercentage } = aat;
		    const image = $scope.find('img');
		    image.each(function(index) {
		        ScrollObserver.Element(jQuery(this)[0], {
		          offsetTop: 250,
		          offsetBottom: 0
		        }).onScroll(({ percentageY }) => {
		            const transform = `perspective(1200px) rotateX(${valueAtPercentage({
		                from: 15,
		                to: 0,
		                percentage: percentageY
		            })}deg)`;
		            jQuery(this).css('transform', transform);
		        });
		    });
        }
    });
    elementorFrontend.hooks.addAction("frontend/element_ready/neuros_tabs.default", function (e) {
        let d = e.find(".neuros_tabs_titles_container"),
            s = e.find(".neuros_tabs_content_container");
        jQuery(d).find(".neuros_tab_title_item").first().addClass("active");
        if( jQuery('body').hasClass('elementor-editor-active') ) {
            return;
        }
        var tab_content_first_class = jQuery(d).find(".neuros_tab_title_item").first().attr("data-id");        
        jQuery(d).find(".neuros_tab_title_item").each(function() {
            let e = jQuery(this).attr("data-id");
            if(e) {
                jQuery('.elementor #' + e).removeClass("active").addClass("hidden");
            }            
        });
        if(tab_content_first_class) {
            jQuery('.elementor #' + tab_content_first_class).addClass("active").removeClass("hidden");
        }        
        jQuery(s).find(".neuros_tab_content_item").first().addClass("active");
        e.find(".neuros_tab_title_item a").on("click", function () {
            let e = jQuery(this).parent().attr("data-id");
            if(!jQuery(this).parent().is(".active")) {
                d.find(".active").removeClass("active");
                s.find(".active").removeClass("active");
                if(e) {
                    var all_ids = [];
                    jQuery(d).find(".neuros_tab_title_item").each(function() {
                        let e = jQuery(this).attr("data-id");
                        if(e) {
                            all_ids.push('.elementor #' + e);
                            var swiper = jQuery('.elementor #' + e).find('.swiper-container');
                            if(swiper.length) {
                                setTimeout(function(){ 
                                    window.dispatchEvent(new Event('resize')); 
                                }, 500);
                            }
                        }
                    });
                    var all_ids_str = all_ids.join();
                    jQuery(all_ids_str).removeClass("active").addClass("hidden");
                }
                jQuery(this).parent().addClass("active"); 
                if(e) {
                    jQuery('.elementor #' + e).addClass("active").removeClass("hidden"); 
                    s.find("#" + e).addClass("active");
                }
            }
        });
    });

    elementorFrontend.hooks.addAction("frontend/element_ready/neuros_moving_list.default", function (e) {
        initMovingList(e);
    });

    elementorFrontend.hooks.addAction('frontend/element_ready/neuros_case_study_listing.default', function () {
        if ( jQuery('body').hasClass('elementor-editor-active') ) {
            setTimeout(elements_slider_init, 500);
            setTimeout(isotope_init, 500);
        }
    });
});