/**
 * This code will fix some element (div, table, etc) on top after scrolling down
 */

var fixmeTop = $('.fixme').offset().top;       // get initial position of the element

$(window).scroll(function() {                  // assign scroll event listener

    var currentScroll = $(window).scrollTop(); // get current position

    if (currentScroll >= fixmeTop) {           // apply position: fixed if you
        $('.fixme').css({                      // scroll to that element or below it
            position: 'fixed',
            top: '0',
            left: '0'
        });
    } else {                                   // apply position: static
        $('.fixme').css({                      // if you scroll above it
            position: 'static'
        });
    }

});